<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WeatherController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_API_KEY', 'your_openweathermap_api_key_here');
    }

    public function index()
    {
        $user = auth()->user();
        $location = $user->weather_location ?? 'Batangas, PH';
        
        // Cache weather data for 30 minutes
        $cacheKey = 'weather_' . md5($location . '_' . $user->id);
        $weatherData = Cache::remember($cacheKey, 1800, function () use ($location, $user) {
            return $this->fetchWeatherData($location, $user);
        });
        
        return view('weather', compact('weatherData', 'location'));
    }

    public function refresh()
    {
        $user = auth()->user();
        $location = $user->weather_location ?? 'Batangas, PH';
        
        // Clear cache and fetch fresh data
        Cache::forget('weather_' . md5($location . '_' . $user->id));
        
        return redirect()->route('weather.index')->with('success', 'Weather data refreshed!');
    }

    private function fetchWeatherData($location, $user)
    {
        // Check if API key is configured
        if ($this->apiKey === 'your_openweathermap_api_key_here') {
            return $this->getMockWeatherData();
        }

        try {
            // Step 1: Get coordinates from location name
            $geoResponse = Http::get("http://api.openweathermap.org/geo/1.0/direct", [
                'q' => $location,
                'limit' => 1,
                'appid' => $this->apiKey,
            ]);

            if (!$geoResponse->successful() || empty($geoResponse->json())) {
                \Log::warning('Geocoding failed for location: ' . $location);
                return $this->getMockWeatherData();
            }

            $geoData = $geoResponse->json()[0];
            $lat = $geoData['lat'];
            $lon = $geoData['lon'];

            // Step 2: Convert user's temperature preference to API unit
            // User settings: "Celsius (°C)" or "Fahrenheit (°F)"
            // API expects: "metric" or "imperial"
            $userTempUnit = $user->temperature_unit ?? 'Celsius (°C)';
            $unit = (strpos($userTempUnit, 'Fahrenheit') !== false) ? 'imperial' : 'metric';
            
            $weatherResponse = Http::get("https://api.openweathermap.org/data/3.0/onecall", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => $unit,
                'exclude' => 'minutely,alerts',
            ]);

            if (!$weatherResponse->successful()) {
                \Log::error('Weather API Error: ' . $weatherResponse->body());
                
                // Try the free 2.5 API as fallback
                return $this->fetchWeatherDataFallback($lat, $lon, $unit);
            }

            $data = $weatherResponse->json();

            return $this->formatWeatherData($data, $unit);

        } catch (\Exception $e) {
            \Log::error('Weather fetch error: ' . $e->getMessage());
            return $this->getMockWeatherData();
        }
    }

    private function fetchWeatherDataFallback($lat, $lon, $unit)
    {
        try {
            // Use free 2.5 API endpoints
            $currentResponse = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => $unit,
            ]);

            $forecastResponse = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => $unit,
            ]);

            if ($currentResponse->successful() && $forecastResponse->successful()) {
                return $this->formatFallbackWeatherData(
                    $currentResponse->json(),
                    $forecastResponse->json(),
                    $unit
                );
            }

        } catch (\Exception $e) {
            \Log::error('Fallback weather fetch error: ' . $e->getMessage());
        }

        return $this->getMockWeatherData();
    }

    private function formatWeatherData($data, $unit)
    {
        $tempUnit = $unit === 'imperial' ? 'F' : 'C';
        
        // Current weather
        $current = $data['current'];
        $currentData = [
            'temp' => round($current['temp']),
            'feels_like' => round($current['feels_like']),
            'condition' => ucfirst($current['weather'][0]['description']),
            'icon' => $this->getWeatherIcon($current['weather'][0]['main'], $current['weather'][0]['icon']),
            'humidity' => $current['humidity'],
            'wind_speed' => round($current['wind_speed'] * 3.6), // m/s to km/h
            'visibility' => round(($current['visibility'] ?? 10000) / 1000),
            'pressure' => $current['pressure'],
            'sunrise' => Carbon::createFromTimestamp($current['sunrise'])->format('g:i A'),
            'sunset' => Carbon::createFromTimestamp($current['sunset'])->format('g:i A'),
            'uv_index' => round($current['uvi'] ?? 0),
            'uv_level' => $this->getUVLevel($current['uvi'] ?? 0),
        ];

        // Hourly forecast (next 24 hours, every 3 hours)
        $hourly = [];
        $hourlyData = array_slice($data['hourly'], 0, 24);
        foreach ($hourlyData as $index => $hour) {
            if ($index % 3 === 0) { // Every 3 hours
                $time = Carbon::createFromTimestamp($hour['dt']);
                $hourly[] = [
                    'time' => $index === 0 ? 'Now' : $time->format('g A'),
                    'temp' => round($hour['temp']),
                    'icon' => $this->getWeatherIcon($hour['weather'][0]['main'], $hour['weather'][0]['icon']),
                ];
            }
        }

        // Daily forecast (next 7 days)
        $daily = [];
        foreach (array_slice($data['daily'], 0, 7) as $index => $day) {
            $date = Carbon::createFromTimestamp($day['dt']);
            $daily[] = [
                'day' => $index === 0 ? 'Today' : ($index === 1 ? 'Tomorrow' : $date->format('l')),
                'date' => $date->format('M d'),
                'condition' => ucfirst($day['weather'][0]['description']),
                'icon' => $this->getWeatherIcon($day['weather'][0]['main'], $day['weather'][0]['icon']),
                'rain_chance' => round(($day['pop'] ?? 0) * 100),
                'high' => round($day['temp']['max']),
                'low' => round($day['temp']['min']),
            ];
        }

        return [
            'current' => $currentData,
            'hourly' => $hourly,
            'daily' => $daily,
        ];
    }

    private function formatFallbackWeatherData($currentData, $forecastData, $unit)
    {
        $tempUnit = $unit === 'imperial' ? 'F' : 'C';
        
        // Format current weather
        $current = [
            'temp' => round($currentData['main']['temp']),
            'feels_like' => round($currentData['main']['feels_like']),
            'condition' => ucfirst($currentData['weather'][0]['description']),
            'icon' => $this->getWeatherIcon($currentData['weather'][0]['main'], $currentData['weather'][0]['icon']),
            'humidity' => $currentData['main']['humidity'],
            'wind_speed' => round($currentData['wind']['speed'] * 3.6), // m/s to km/h
            'visibility' => round($currentData['visibility'] / 1000),
            'pressure' => $currentData['main']['pressure'],
            'sunrise' => Carbon::createFromTimestamp($currentData['sys']['sunrise'])->format('g:i A'),
            'sunset' => Carbon::createFromTimestamp($currentData['sys']['sunset'])->format('g:i A'),
            'uv_index' => 0,
            'uv_level' => 'N/A',
        ];

        // Format hourly forecast
        $hourly = [];
        foreach (array_slice($forecastData['list'], 0, 8) as $index => $item) {
            $time = Carbon::createFromTimestamp($item['dt']);
            $hourly[] = [
                'time' => $index === 0 ? 'Now' : $time->format('g A'),
                'temp' => round($item['main']['temp']),
                'icon' => $this->getWeatherIcon($item['weather'][0]['main'], $item['weather'][0]['icon']),
            ];
        }

        // Format daily forecast (group by day)
        $daily = [];
        $dailyGroups = [];
        
        foreach ($forecastData['list'] as $item) {
            $date = Carbon::createFromTimestamp($item['dt']);
            $dayKey = $date->format('Y-m-d');
            
            if (!isset($dailyGroups[$dayKey])) {
                $dailyGroups[$dayKey] = [
                    'temps' => [],
                    'conditions' => [],
                    'icons' => [],
                    'rain' => [],
                    'date' => $date,
                ];
            }
            
            $dailyGroups[$dayKey]['temps'][] = $item['main']['temp'];
            $dailyGroups[$dayKey]['conditions'][] = $item['weather'][0]['description'];
            $dailyGroups[$dayKey]['icons'][] = $item['weather'][0];
            $dailyGroups[$dayKey]['rain'][] = ($item['pop'] ?? 0) * 100;
        }

        $dayIndex = 0;
        foreach (array_slice($dailyGroups, 0, 7) as $dayKey => $dayData) {
            $daily[] = [
                'day' => $dayIndex === 0 ? 'Today' : ($dayIndex === 1 ? 'Tomorrow' : $dayData['date']->format('l')),
                'date' => $dayData['date']->format('M d'),
                'condition' => ucfirst($dayData['conditions'][0]),
                'icon' => $this->getWeatherIcon($dayData['icons'][0]['main'], $dayData['icons'][0]['icon']),
                'rain_chance' => round(max($dayData['rain'])),
                'high' => round(max($dayData['temps'])),
                'low' => round(min($dayData['temps'])),
            ];
            $dayIndex++;
        }

        return [
            'current' => $current,
            'hourly' => $hourly,
            'daily' => $daily,
        ];
    }

    private function getWeatherIcon($condition, $icon = null)
    {
        // Use icon code if available for better accuracy
        if ($icon) {
            $iconMap = [
                '01d' => '☀️', // clear sky day
                '01n' => '🌙', // clear sky night
                '02d' => '⛅', // few clouds day
                '02n' => '☁️', // few clouds night
                '03d' => '☁️', // scattered clouds
                '03n' => '☁️',
                '04d' => '☁️', // broken clouds
                '04n' => '☁️',
                '09d' => '🌧️', // shower rain
                '09n' => '🌧️',
                '10d' => '🌦️', // rain day
                '10n' => '🌧️', // rain night
                '11d' => '⛈️', // thunderstorm
                '11n' => '⛈️',
                '13d' => '❄️', // snow
                '13n' => '❄️',
                '50d' => '🌫️', // mist
                '50n' => '🌫️',
            ];
            
            if (isset($iconMap[$icon])) {
                return $iconMap[$icon];
            }
        }

        // Fallback to condition-based icons
        $icons = [
            'Clear' => '☀️',
            'Clouds' => '☁️',
            'Rain' => '🌧️',
            'Drizzle' => '🌦️',
            'Thunderstorm' => '⛈️',
            'Snow' => '❄️',
            'Mist' => '🌫️',
            'Smoke' => '🌫️',
            'Haze' => '🌫️',
            'Dust' => '🌫️',
            'Fog' => '🌫️',
            'Sand' => '🌫️',
            'Ash' => '🌫️',
            'Squall' => '💨',
            'Tornado' => '🌪️',
        ];

        return $icons[$condition] ?? '☁️';
    }

    private function getUVLevel($uvIndex)
    {
        if ($uvIndex < 3) return 'Low';
        if ($uvIndex < 6) return 'Moderate';
        if ($uvIndex < 8) return 'High';
        if ($uvIndex < 11) return 'Very High';
        return 'Extreme';
    }

    private function getMockWeatherData()
    {
        $currentDate = now();
        
        return [
            'current' => [
                'temp' => 25,
                'feels_like' => 26,
                'condition' => 'Overcast clouds',
                'icon' => '☁️',
                'humidity' => 89,
                'wind_speed' => 17,
                'visibility' => 10,
                'pressure' => 1012,
                'sunrise' => '5:48 AM',
                'sunset' => '5:32 PM',
                'uv_index' => 0,
                'uv_level' => 'Low',
            ],
            'hourly' => [
                ['time' => 'Now', 'temp' => 25, 'icon' => '☁️'],
                ['time' => '9 PM', 'temp' => 25, 'icon' => '🌧️'],
                ['time' => '12 AM', 'temp' => 26, 'icon' => '🌧️'],
                ['time' => '3 AM', 'temp' => 29, 'icon' => '🌧️'],
                ['time' => '6 AM', 'temp' => 30, 'icon' => '🌧️'],
                ['time' => '9 AM', 'temp' => 28, 'icon' => '🌧️'],
                ['time' => '12 PM', 'temp' => 25, 'icon' => '🌧️'],
                ['time' => '3 PM', 'temp' => 24, 'icon' => '🌧️'],
            ],
            'daily' => [
                ['day' => 'Today', 'date' => $currentDate->format('M d'), 'condition' => 'Overcast clouds', 'icon' => '☁️', 'rain_chance' => 21, 'high' => 25, 'low' => 25],
                ['day' => 'Tomorrow', 'date' => $currentDate->copy()->addDay()->format('M d'), 'condition' => 'Light rain', 'icon' => '🌧️', 'rain_chance' => 84, 'high' => 30, 'low' => 24],
                ['day' => 'Wednesday', 'date' => $currentDate->copy()->addDays(2)->format('M d'), 'condition' => 'Light rain', 'icon' => '🌧️', 'rain_chance' => 79, 'high' => 26, 'low' => 24],
                ['day' => 'Thursday', 'date' => $currentDate->copy()->addDays(3)->format('M d'), 'condition' => 'Light rain', 'icon' => '🌧️', 'rain_chance' => 47, 'high' => 26, 'low' => 24],
                ['day' => 'Friday', 'date' => $currentDate->copy()->addDays(4)->format('M d'), 'condition' => 'Partly cloudy', 'icon' => '⛅', 'rain_chance' => 30, 'high' => 27, 'low' => 23],
                ['day' => 'Saturday', 'date' => $currentDate->copy()->addDays(5)->format('M d'), 'condition' => 'Sunny', 'icon' => '☀️', 'rain_chance' => 10, 'high' => 28, 'low' => 24],
                ['day' => 'Sunday', 'date' => $currentDate->copy()->addDays(6)->format('M d'), 'condition' => 'Light rain', 'icon' => '🌧️', 'rain_chance' => 65, 'high' => 26, 'low' => 23],
            ],
        ];
    }
}
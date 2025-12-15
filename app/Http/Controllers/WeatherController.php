<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.weather.key');
    }

    public function index()
    {
        try {
            $city = 'Batangas City';
            $country = 'PH';
            
            // Fetch current weather (SSL verification disabled for localhost)
            $currentResponse = Http::withoutVerifying()->timeout(10)->get("{$this->baseUrl}/weather", [
                'q' => "{$city},{$country}",
                'units' => 'metric',
                'appid' => $this->apiKey,
            ]);

            // Fetch forecast (5 day / 3 hour)
            $forecastResponse = Http::withoutVerifying()->timeout(10)->get("{$this->baseUrl}/forecast", [
                'q' => "{$city},{$country}",
                'units' => 'metric',
                'appid' => $this->apiKey,
            ]);

            if ($currentResponse->successful() && $forecastResponse->successful()) {
                $current = $currentResponse->json();
                $forecast = $forecastResponse->json();
                
                $weatherData = [
                    'location' => ($current['name'] ?? $city) . ', ' . $country,
                    'current' => [
                        'temp' => round($current['main']['temp']),
                        'temp_f' => round(($current['main']['temp'] * 9/5) + 32),
                        'condition' => ucfirst($current['weather'][0]['description'] ?? 'Clear'),
                        'icon' => $this->getWeatherEmoji($current['weather'][0]['main'] ?? 'Clear'),
                        'feelsLike' => round($current['main']['feels_like']),
                        'feelsLike_f' => round(($current['main']['feels_like'] * 9/5) + 32),
                    ],
                    'details' => [
                        'humidity' => $current['main']['humidity'],
                        'windSpeed' => round($current['wind']['speed'] * 3.6), // m/s to km/h
                        'windSpeed_mph' => round($current['wind']['speed'] * 2.237), // m/s to mph
                        'visibility' => round(($current['visibility'] ?? 10000) / 1000), // meters to km
                        'visibility_mi' => round(($current['visibility'] ?? 10000) / 1609.34), // meters to miles
                        'pressure' => round($current['main']['pressure']),
                        'uvIndex' => 0, // OpenWeatherMap free tier doesn't include UV
                    ],
                    'sun' => [
                        'sunrise' => date('g:i A', $current['sys']['sunrise']),
                        'sunset' => date('g:i A', $current['sys']['sunset']),
                    ],
                    'hourly' => $this->formatHourlyForecast($forecast['list']),
                    'forecast' => $this->formatDailyForecast($forecast['list']),
                    'lastUpdated' => date('M d, Y g:i A'),
                ];

                return view('weather', compact('weatherData'));
            }

            throw new \Exception('Weather API request failed');

        } catch (\Exception $e) {
            Log::error('Weather API Error: ' . $e->getMessage());
            
            return view('weather', [
                'error' => 'Unable to fetch weather data. Error: ' . $e->getMessage(),
                'weatherData' => null
            ]);
        }
    }

    private function formatHourlyForecast($forecastList)
    {
        $now = now();
        $hourlyData = [];
        
        foreach ($forecastList as $item) {
            if (count($hourlyData) >= 8) break;
            
            $itemTime = strtotime($item['dt_txt']);
            
            // Only show current and future hours
            if ($itemTime >= $now->timestamp) {
                $isNow = count($hourlyData) === 0;
                
                $hourlyData[] = [
                    'time' => $isNow ? 'Now' : date('g A', $itemTime),
                    'temp' => round($item['main']['temp']),
                    'temp_f' => round(($item['main']['temp'] * 9/5) + 32),
                    'icon' => $this->getWeatherEmoji($item['weather'][0]['main'] ?? 'Clear'),
                ];
            }
        }
        
        return $hourlyData;
    }

    private function formatDailyForecast($forecastList)
    {
        $dailyData = [];
        $processedDays = [];
        
        foreach ($forecastList as $item) {
            $date = date('Y-m-d', strtotime($item['dt_txt']));
            
            // Skip if we already have this day
            if (in_array($date, $processedDays)) {
                continue;
            }
            
            // Stop if we have 7 days
            if (count($dailyData) >= 7) {
                break;
            }
            
            $processedDays[] = $date;
            $timestamp = strtotime($date);
            $dayIndex = count($dailyData);
            
            $dayName = $dayIndex === 0 ? 'Today' : 
                      ($dayIndex === 1 ? 'Tomorrow' : date('l', $timestamp));
            
            // Get all items for this day to calculate high/low
            $dayItems = array_filter($forecastList, function($i) use ($date) {
                return date('Y-m-d', strtotime($i['dt_txt'])) === $date;
            });
            
            $temps = array_map(function($i) { return $i['main']['temp']; }, $dayItems);
            $high = !empty($temps) ? round(max($temps)) : round($item['main']['temp_max']);
            $low = !empty($temps) ? round(min($temps)) : round($item['main']['temp_min']);
            
            // Get midday weather for condition
            $middayItem = $item;
            foreach ($dayItems as $i) {
                $hour = (int)date('H', strtotime($i['dt_txt']));
                if ($hour >= 12 && $hour <= 15) {
                    $middayItem = $i;
                    break;
                }
            }
            
            $dailyData[] = [
                'day' => $dayName,
                'date' => date('M d', $timestamp),
                'high' => $high,
                'high_f' => round(($high * 9/5) + 32),
                'low' => $low,
                'low_f' => round(($low * 9/5) + 32),
                'condition' => ucfirst($middayItem['weather'][0]['description'] ?? 'Clear'),
                'icon' => $this->getWeatherEmoji($middayItem['weather'][0]['main'] ?? 'Clear'),
                'precipitation' => isset($middayItem['pop']) ? round($middayItem['pop'] * 100) : 0,
            ];
        }
        
        return $dailyData;
    }

    private function getWeatherEmoji($condition)
    {
        $weatherIcons = [
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

        return $weatherIcons[$condition] ?? '🌍';
    }
}
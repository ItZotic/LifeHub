<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Habit;
use App\Models\Transaction;
use App\Models\HealthMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Tasks statistics
        $todayTasks = Task::where('user_id', $user->id)->today()->get();
        $completedToday = $todayTasks->where('completed', true)->count();
        $totalToday = $todayTasks->count();
        
        // Yesterday's task count for percentage calculation
        $yesterdayCompleted = Task::where('user_id', $user->id)
            ->whereDate('due_date', Carbon::yesterday())
            ->where('completed', true)
            ->count();
        
        $taskPercentageChange = $yesterdayCompleted > 0 
            ? (($completedToday - $yesterdayCompleted) / $yesterdayCompleted) * 100 
            : 0;
        
        // Habit streak
        $longestStreak = Habit::where('user_id', $user->id)
            ->max('current_streak') ?? 0;
        
        // Health Goals Completion
        $todayMetric = HealthMetric::getTodayMetric($user->id);
        
        // Define goals
        $stepsGoal = 10000;
        $waterGoal = 8;
        $sleepGoal = 8;
        $caloriesGoal = 2500;
        
        // Calculate completed goals (now includes water)
        $goalsCompleted = 0;
        $totalGoals = 4;
        
        if ($todayMetric->steps >= $stepsGoal) $goalsCompleted++;
        if ($todayMetric->water_glasses >= $waterGoal) $goalsCompleted++;
        if ($todayMetric->sleep_hours >= $sleepGoal) $goalsCompleted++;
        if ($todayMetric->calories >= $caloriesGoal) $goalsCompleted++;
        
        $goalsCompletionRate = $totalGoals > 0 ? ($goalsCompleted / $totalGoals) * 100 : 0;
        
        // Goal status badges
        $stepsStatus = $todayMetric->steps >= $stepsGoal ? 'Goal Met!' : 'In Progress';
        $caloriesStatus = $todayMetric->calories >= $caloriesGoal ? 'Goal Met!' : 'In Progress';
        $waterStatus = $todayMetric->water_glasses >= $waterGoal ? 'Goal Met!' : 'In Progress';
        $sleepStatus = $todayMetric->sleep_hours >= $sleepGoal ? 'Well Rested' : 'In Progress';
        
        // Weekly expenses
        $weekExpenses = Transaction::where('user_id', $user->id)
            ->expenses()
            ->thisWeek()
            ->sum('amount');
        
        // Last week expenses for percentage
        $lastWeekExpenses = Transaction::where('user_id', $user->id)
            ->expenses()
            ->whereBetween('transaction_date', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ])
            ->sum('amount');
        
        $expensePercentageChange = $lastWeekExpenses > 0 
            ? (($weekExpenses - $lastWeekExpenses) / $lastWeekExpenses) * 100 
            : 0;
        
        // Recent habits for dashboard display
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('current_streak', 'desc')
            ->take(4)
            ->get();
        
        // Weekly expense breakdown by category
        $expensesByCategory = Transaction::where('user_id', $user->id)
            ->expenses()
            ->thisWeek()
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();
        
        // Motivation quote
        $quotes = [
            ['text' => 'The secret of getting ahead is getting started.', 'author' => 'Mark Twain'],
            ['text' => 'Success is not final, failure is not fatal.', 'author' => 'Winston Churchill'],
            ['text' => 'Don\'t watch the clock; do what it does. Keep going.', 'author' => 'Sam Levenson'],
            ['text' => 'The future depends on what you do today.', 'author' => 'Mahatma Gandhi'],
        ];
        $dailyQuote = $quotes[Carbon::now()->dayOfYear % count($quotes)];
        
        // Get weather data for dashboard widget
        $location = $user->weather_location ?? 'Batangas, PH';
        $cacheKey = 'weather_' . md5($location . '_' . $user->id);
        $weatherData = Cache::remember($cacheKey, 1800, function () use ($location, $user) {
            return $this->getWeatherData($location, $user);
        });
        
        return view('dashboard', compact(
            'completedToday', 
            'totalToday', 
            'taskPercentageChange',
            'longestStreak',
            'weekExpenses',
            'expensePercentageChange',
            'goalsCompleted',
            'totalGoals',
            'goalsCompletionRate',
            'todayTasks',
            'habits',
            'expensesByCategory',
            'dailyQuote',
            'weatherData',
            'todayMetric',
            'stepsGoal',
            'caloriesGoal',
            'waterGoal',
            'sleepGoal',
            'stepsStatus',
            'caloriesStatus',
            'waterStatus',
            'sleepStatus'
        ));
    }

    private function getWeatherData($location, $user)
    {
        $apiKey = env('WEATHER_API_KEY', 'your_openweathermap_api_key_here');
        
        // If no API key configured, return mock data
        if ($apiKey === 'your_openweathermap_api_key_here') {
            return $this->getMockWeatherData();
        }
        
        try {
            // Step 1: Get coordinates from location name
            $geoResponse = Http::get("http://api.openweathermap.org/geo/1.0/direct", [
                'q' => $location,
                'limit' => 1,
                'appid' => $apiKey,
            ]);
            
            if (!$geoResponse->successful() || empty($geoResponse->json())) {
                \Log::warning('Dashboard geocoding failed for location: ' . $location);
                return $this->getMockWeatherData();
            }
            
            $geoData = $geoResponse->json()[0];
            
            // Step 2: Convert user's temperature preference
            $userTempUnit = $user->temperature_unit ?? 'Celsius (°C)';
            $unit = (strpos($userTempUnit, 'Fahrenheit') !== false) ? 'imperial' : 'metric';
            
            // Step 3: Get current weather
            $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $geoData['lat'],
                'lon' => $geoData['lon'],
                'appid' => $apiKey,
                'units' => $unit,
            ]);
            
            if (!$weatherResponse->successful()) {
                \Log::error('Dashboard weather API error: ' . $weatherResponse->body());
                return $this->getMockWeatherData();
            }
            
            $data = $weatherResponse->json();
            
            return [
                'current' => [
                    'temp' => round($data['main']['temp']),
                    'condition' => ucfirst($data['weather'][0]['description']),
                    'icon' => $this->getWeatherIcon($data['weather'][0]['main'], $data['weather'][0]['icon']),
                ]
            ];
            
        } catch (\Exception $e) {
            \Log::error('Dashboard weather error: ' . $e->getMessage());
            return $this->getMockWeatherData();
        }
    }
    
    private function getMockWeatherData()
    {
        // Fallback mock weather data
        return [
            'current' => [
                'temp' => 25,
                'condition' => 'Overcast clouds',
                'icon' => '☁️',
            ]
        ];
    }
    
    private function getWeatherIcon($condition, $icon = null)
    {
        // Use icon code if available for better accuracy
        if ($icon) {
            $iconMap = [
                '01d' => '☀️', '01n' => '🌙',
                '02d' => '⛅', '02n' => '☁️',
                '03d' => '☁️', '03n' => '☁️',
                '04d' => '☁️', '04n' => '☁️',
                '09d' => '🌧️', '09n' => '🌧️',
                '10d' => '🌦️', '10n' => '🌧️',
                '11d' => '⛈️', '11n' => '⛈️',
                '13d' => '❄️', '13n' => '❄️',
                '50d' => '🌫️', '50n' => '🌫️',
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
            'Fog' => '🌫️',
        ];
        
        return $icons[$condition] ?? '☁️';
    }
}
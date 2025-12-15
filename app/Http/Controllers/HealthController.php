<?php

namespace App\Http\Controllers;

use App\Models\HealthMetric;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HealthController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Get or create today's metrics
        $todayMetrics = HealthMetric::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'steps' => 0,
                'calories' => 0,
                'water_glasses' => 0,
                'sleep_hours' => 0,
                'heart_rate' => null,
                'active_minutes' => 0,
            ]
        );

        // Goals
        $goals = [
            'steps' => 10000,
            'calories' => 2500,
            'water' => 8,
            'sleep' => 8,
            'activeMinutes' => 60,
        ];

        // Today's stats
        $todayStats = [
            'steps' => $todayMetrics->steps,
            'stepsGoal' => $goals['steps'],
            'calories' => $todayMetrics->calories,
            'caloriesGoal' => $goals['calories'],
            'water' => $todayMetrics->water_glasses,
            'waterGoal' => $goals['water'],
            'sleep' => $todayMetrics->sleep_hours,
            'sleepGoal' => $goals['sleep'],
            'heartRate' => $todayMetrics->heart_rate ?? 0,
            'activeMinutes' => $todayMetrics->active_minutes,
            'activeMinutesGoal' => $goals['activeMinutes'],
        ];

        // Calculate progress
        $stepsProgress = ($todayStats['steps'] / $todayStats['stepsGoal']) * 100;
        $caloriesProgress = ($todayStats['calories'] / $todayStats['caloriesGoal']) * 100;
        $waterProgress = ($todayStats['water'] / $todayStats['waterGoal']) * 100;
        $sleepProgress = ($todayStats['sleep'] / $todayStats['sleepGoal']) * 100;
        $activeProgress = ($todayStats['activeMinutes'] / $todayStats['activeMinutesGoal']) * 100;

        // Weekly data (FULL WEEK - Monday to Sunday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weeklyMetrics = HealthMetric::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $startOfWeek->copy()->addDays(6)])
            ->orderBy('date')
            ->get();

        // Fill all 7 days (Monday to Sunday)
        $weeklySteps = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $metric = $weeklyMetrics->firstWhere('date', $date->toDateString());
            
            $weeklySteps[] = [
                'day' => $date->format('D'),
                'steps' => $metric ? $metric->steps : 0,
                'calories' => $metric ? $metric->calories : 0,
            ];
        }

        // Mock heart rate data (you can implement real tracking later)
        $heartRateData = [
            ['time' => '6 AM', 'rate' => 58],
            ['time' => '9 AM', 'rate' => 65],
            ['time' => '12 PM', 'rate' => 78],
            ['time' => '3 PM', 'rate' => 72],
            ['time' => '6 PM', 'rate' => 85],
            ['time' => '9 PM', 'rate' => 68],
            ['time' => 'Now', 'rate' => $todayStats['heartRate'] ?: 72],
        ];

        // Weekly sleep data (FULL WEEK - Monday to Sunday)
        $sleepData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $metric = $weeklyMetrics->firstWhere('date', $date->toDateString());
            $totalSleep = $metric ? $metric->sleep_hours : 0;
            
            // Break down sleep phases (roughly)
            $sleepData[] = [
                'day' => $date->format('D'),
                'deep' => round($totalSleep * 0.37, 1),
                'light' => round($totalSleep * 0.43, 1),
                'rem' => round($totalSleep * 0.20, 1),
            ];
        }

        // Sleep analysis
        $avgSleep = $weeklyMetrics->avg('sleep_hours') ?: 0;
        $sleepAnalysis = [
            'total' => $todayStats['sleep'],
            'deep' => round($todayStats['sleep'] * 0.37, 1),
            'light' => round($todayStats['sleep'] * 0.43, 1),
            'rem' => round($todayStats['sleep'] * 0.20, 1),
            'deepPercent' => 37,
            'lightPercent' => 43,
            'remPercent' => 20,
            'vsAverage' => $todayStats['sleep'] - $avgSleep > 0 ? '+' . round($todayStats['sleep'] - $avgSleep, 1) : round($todayStats['sleep'] - $avgSleep, 1),
        ];

        return view('health', compact(
            'todayStats',
            'stepsProgress',
            'caloriesProgress',
            'waterProgress',
            'sleepProgress',
            'activeProgress',
            'weeklySteps',
            'heartRateData',
            'sleepData',
            'sleepAnalysis'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'steps' => 'nullable|integer|min:0',
            'calories' => 'nullable|integer|min:0',
            'water_glasses' => 'nullable|integer|min:0|max:20',
            'sleep_hours' => 'nullable|numeric|min:0|max:24',
            'heart_rate' => 'nullable|integer|min:30|max:200',
            'active_minutes' => 'nullable|integer|min:0',
        ]);

        $today = Carbon::today();

        $metric = HealthMetric::updateOrCreate(
            ['user_id' => auth()->id(), 'date' => $today],
            array_filter($validated) // Only update non-null values
        );

        return redirect()->back()->with('success', 'Activity logged successfully!');
    }
}
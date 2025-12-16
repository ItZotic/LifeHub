<?php

namespace App\Http\Controllers;

use App\Models\HealthMetric;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get or create today's metric
        $todayMetric = HealthMetric::getTodayMetric($user->id);
        
        // Get weekly metrics for charts - ensure we have all 7 days
        $startOfWeek = Carbon::now()->startOfWeek();
        $weeklyMetricsData = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $metric = HealthMetric::where('user_id', $user->id)
                ->where('date', $date->format('Y-m-d'))
                ->first();
            
            if ($metric) {
                $weeklyMetricsData[] = [
                    'date' => $date->format('Y-m-d'),
                    'day_name' => $date->format('D'),
                    'steps' => $metric->steps,
                    'calories' => $metric->calories,
                    'water_glasses' => $metric->water_glasses,
                    'sleep_hours' => $metric->sleep_hours,
                    'heart_rate' => $metric->heart_rate,
                    'active_minutes' => $metric->active_minutes,
                ];
            } else {
                // Create empty metric for days without data
                $weeklyMetricsData[] = [
                    'date' => $date->format('Y-m-d'),
                    'day_name' => $date->format('D'),
                    'steps' => 0,
                    'calories' => 0,
                    'water_glasses' => 0,
                    'sleep_hours' => 0,
                    'heart_rate' => 0,
                    'active_minutes' => 0,
                ];
            }
        }
        
        $weeklyMetrics = collect($weeklyMetricsData);
        
        // Calculate weekly averages
        $weeklySteps = $weeklyMetrics->avg('steps');
        $weeklyCalories = $weeklyMetrics->avg('calories');
        $weeklySleep = $weeklyMetrics->avg('sleep_hours');
        $weeklyHeartRate = $weeklyMetrics->avg('heart_rate');
        
        // Sleep analysis data
        $sleepBreakdown = $todayMetric->getSleepBreakdown();
        
        // Goals
        $stepsGoal = 10000;
        $caloriesGoal = 2500;
        $waterGoal = 8;
        $sleepGoal = 8;
        
        $stepsProgress = $todayMetric->steps > 0 ? min(100, ($todayMetric->steps / $stepsGoal) * 100) : 0;
        $caloriesProgress = $todayMetric->calories > 0 ? min(100, ($todayMetric->calories / $caloriesGoal) * 100) : 0;
        $waterProgress = $todayMetric->water_glasses > 0 ? min(100, ($todayMetric->water_glasses / $waterGoal) * 100) : 0;
        $sleepProgress = $todayMetric->sleep_hours > 0 ? min(100, ($todayMetric->sleep_hours / $sleepGoal) * 100) : 0;
        
        // Health status badges
        $stepsStatus = $todayMetric->steps >= $stepsGoal ? 'Goal Met!' : 'In Progress';
        $caloriesStatus = $todayMetric->calories >= $caloriesGoal ? 'Goal Met!' : 'In Progress';
        $waterStatus = $todayMetric->water_glasses >= $waterGoal ? 'Goal Met!' : 'Normal';
        $sleepStatus = $todayMetric->sleep_hours >= 7 ? 'Well Rested' : 'Normal';
        $heartRateStatus = 'Resting';
        
        // Calculate steps remaining
        $stepsRemaining = max(0, $stepsGoal - $todayMetric->steps);
        
        return view('health', compact(
            'todayMetric',
            'weeklyMetrics',
            'weeklySteps',
            'weeklyCalories',
            'weeklySleep',
            'weeklyHeartRate',
            'sleepBreakdown',
            'stepsGoal',
            'caloriesGoal',
            'waterGoal',
            'sleepGoal',
            'stepsProgress',
            'caloriesProgress',
            'waterProgress',
            'sleepProgress',
            'stepsStatus',
            'caloriesStatus',
            'waterStatus',
            'sleepStatus',
            'heartRateStatus',
            'stepsRemaining'
        ));
    }

    public function logActivity(Request $request)
    {
        $validated = $request->validate([
            'steps' => 'nullable|integer|min:0',
            'calories' => 'nullable|integer|min:0',
            'water_glasses' => 'nullable|integer|min:0|max:20',
            'sleep_hours' => 'nullable|numeric|min:0|max:24',
            'heart_rate' => 'nullable|integer|min:0|max:250',
            'active_minutes' => 'nullable|integer|min:0',
        ]);

        $metric = HealthMetric::getTodayMetric(auth()->id());
        $metric->update($validated);

        return redirect()->route('health.index')->with('success', 'Activity logged successfully!');
    }

    public function updateMetric(Request $request, $field)
    {
        $validated = $request->validate([
            'value' => 'required|numeric|min:0',
        ]);

        $metric = HealthMetric::getTodayMetric(auth()->id());
        
        if (in_array($field, ['steps', 'calories', 'water_glasses', 'sleep_hours', 'heart_rate', 'active_minutes'])) {
            $metric->$field = $validated['value'];
            $metric->save();
            
            return response()->json(['success' => true, 'metric' => $metric]);
        }

        return response()->json(['success' => false], 400);
    }
}
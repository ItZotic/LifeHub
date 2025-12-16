<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HabitController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $habits = Habit::where('user_id', auth()->id())->get();
        
        $longestStreak = $habits->max('current_streak') ?? 0;
        $completedToday = $habits->filter(function($habit) {
            return $habit->isCompletedToday();
        })->count();
        $totalHabits = $habits->count();
        $completionRate = $totalHabits > 0 ? ($completedToday / $totalHabits) * 100 : 0;
        
        // Weekly overview data - using today as reference
        $weekData = [];
        $maxValue = 0;
        
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $isToday = $date->isToday();
            $isFuture = $date->isFuture() && !$isToday;
            
            $completedCount = 0;
            if (!$isFuture) {
                foreach ($habits as $habit) {
                    if ($habit->completions()->whereDate('completed_date', $date)->exists()) {
                        $completedCount++;
                    }
                }
            }
            
            $maxValue = max($maxValue, $totalHabits);
            
            $weekData[] = [
                'day' => $date->format('D'),
                'completed' => $completedCount,
                'total' => $totalHabits,
                'date' => $date,
                'isToday' => $isToday,
                'isFuture' => $isFuture
            ];
        }
        
        // Calculate percentage heights for bars
        foreach ($weekData as &$day) {
            if ($maxValue > 0 && !$day['isFuture']) {
                $day['completedHeight'] = ($day['completed'] / $maxValue) * 100;
                $day['totalHeight'] = ($day['total'] / $maxValue) * 100;
            } else {
                $day['completedHeight'] = 0;
                $day['totalHeight'] = 0;
            }
        }
        
        return view('habits.index', compact('habits', 'longestStreak', 'completedToday', 'totalHabits', 'completionRate', 'weekData'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:20',
        ]);
        
        Habit::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?? '🎯',
            'color' => $validated['color'] ?? '#4F46E5',
        ]);
        
        return redirect()->route('habits.index')->with('success', 'Habit created successfully!');
    }
    
    public function markComplete(Habit $habit)
    {
        $this->authorize('update', $habit);
        
        $habit->markComplete();
        
        return back();
    }
    
    public function markIncomplete(Habit $habit)
    {
        $this->authorize('update', $habit);
        
        $habit->markIncomplete();
        
        return back();
    }
    
    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);
        
        $habit->delete();
        
        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully!');
    }
}
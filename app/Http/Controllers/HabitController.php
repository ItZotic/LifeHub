<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all habits and update today status
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Update completed_today status for all habits
        foreach ($habits as $habit) {
            $habit->updateTodayStatus();
        }
        
        // Calculate stats
        $completedToday = $habits->where('completed_today', true)->count();
        $totalHabits = $habits->count();
        $longestStreak = $habits->max('streak') ?? 0;
        $completionRate = $totalHabits > 0 ? ($completedToday / $totalHabits) * 100 : 0;
        
        // Weekly data for chart
        $weeklyData = [];
        $today = Carbon::today();
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dayName = $days[($date->dayOfWeek + 6) % 7]; // Adjust to Mon-Sun
            
            $completed = 0;
            foreach ($habits as $habit) {
                if ($habit->completions()->whereDate('completed_date', $date)->exists()) {
                    $completed++;
                }
            }
            
            $weeklyData[] = [
                'day' => $dayName,
                'completed' => $completed
            ];
        }
        
        return view('habits.index', compact(
            'habits',
            'completedToday',
            'totalHabits',
            'longestStreak',
            'completionRate',
            'weeklyData'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|in:' . implode(',', Habit::getColors())
        ]);

        $validated['user_id'] = Auth::id();
        $validated['streak'] = 0;
        $validated['completed_today'] = false;

        Habit::create($validated);

        return redirect()->route('habits.index')
            ->with('success', 'Habit created successfully!');
    }

    public function toggle(Habit $habit)
    {
        // Authorization check
        if ($habit->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $habit->toggleToday();

        return redirect()->back()
            ->with('success', 'Habit updated!');
    }

    public function destroy(Habit $habit)
    {
        // Authorization check
        if ($habit->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $habit->delete();

        return redirect()->route('habits.index')
            ->with('success', 'Habit deleted successfully!');
    }
}
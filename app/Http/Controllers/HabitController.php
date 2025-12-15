<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitCompletion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Add weekly progress for each habit (last 7 days)
        foreach ($habits as $habit) {
            $weeklyProgress = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->toDateString();
                $weeklyProgress[] = HabitCompletion::where('habit_id', $habit->id)
                    ->where('completed_date', $date)
                    ->exists();
            }
            $habit->weekly_progress = $weeklyProgress;
        }

        // Calculate stats
        $totalHabits = $habits->count();
        $completedToday = $habits->where('completed_today', true)->count();
        $completionRate = $totalHabits > 0 ? ($completedToday / $totalHabits) * 100 : 0;
        $longestStreak = $habits->max('streak') ?? 0;

        // Weekly data for chart (MONDAY FIRST)
        $weeklyData = [];
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY); // Start from Monday
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dayName = $date->format('D'); // Mon, Tue, Wed, etc.
            
            $completed = HabitCompletion::whereIn('habit_id', $habits->pluck('id'))
                ->where('completed_date', $date->toDateString())
                ->distinct('habit_id')
                ->count('habit_id');
            
            $weeklyData[] = [
                'day' => $dayName,
                'completed' => $completed
            ];
        }

        return view('habits.index', compact(
            'habits',
            'totalHabits',
            'completedToday',
            'completionRate',
            'longestStreak',
            'weeklyData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string',
        ]);

        Habit::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color' => $request->color,
            'streak' => 0,
            'completed_today' => false,
        ]);

        return redirect()->back()->with('success', 'Habit created successfully!');
    }

    public function toggle(Habit $habit)
    {
        // Ensure user owns this habit
        if ($habit->user_id !== auth()->id()) {
            abort(403);
        }

        $today = Carbon::today()->toDateString();
        $wasCompleted = $habit->completed_today;

        if ($wasCompleted) {
            // Uncomplete: remove completion record
            HabitCompletion::where('habit_id', $habit->id)
                ->where('completed_date', $today)
                ->delete();

            $habit->completed_today = false;
            
            // Decrease streak
            if ($habit->streak > 0) {
                $habit->streak--;
            }
        } else {
            // Complete: add completion record
            HabitCompletion::firstOrCreate([
                'habit_id' => $habit->id,
                'completed_date' => $today,
            ]);

            $habit->completed_today = true;
            $habit->last_completed_at = $today;

            // Check if yesterday was completed to maintain streak
            $yesterday = Carbon::yesterday()->toDateString();
            $wasCompletedYesterday = HabitCompletion::where('habit_id', $habit->id)
                ->where('completed_date', $yesterday)
                ->exists();

            if ($wasCompletedYesterday || $habit->streak == 0) {
                $habit->streak++;
            } else {
                // Streak broken, restart from 1
                $habit->streak = 1;
            }
        }

        $habit->save();

        return redirect()->back();
    }

    public function destroy(Habit $habit)
    {
        // Ensure user owns this habit
        if ($habit->user_id !== auth()->id()) {
            abort(403);
        }

        $habit->delete();

        return redirect()->back()->with('success', 'Habit deleted successfully!');
    }
}
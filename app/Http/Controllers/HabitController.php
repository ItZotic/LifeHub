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
        $habits = Habit::where('user_id', Auth::id())
            ->orderBy('current_streak', 'desc')
            ->get();

        $completedToday = $habits->filter(fn($habit) => $habit->isCompletedToday())->count();
        $totalHabits = $habits->count();

        $longestStreak = $habits->max('longest_streak') ?? 0;

        // Calculate completion rate (last 7 days)
        $weekStart = Carbon::now()->subDays(6)->startOfDay();
        $totalPossible = $totalHabits * 7;
        $totalCompleted = 0;

        foreach ($habits as $habit) {
            $totalCompleted += $habit->completions()
                ->whereBetween('completed_date', [$weekStart, Carbon::now()])
                ->count();
        }

        $completionRate = $totalPossible > 0 ? round(($totalCompleted / $totalPossible) * 100) : 0;

        return view('habits.index', compact('habits', 'completedToday', 'totalHabits', 'longestStreak', 'completionRate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['icon'] = $validated['icon'] ?? 'target';
        $validated['color'] = $validated['color'] ?? 'blue';

        Habit::create($validated);

        return redirect()->route('habits.index')->with('success', 'Habit created successfully!');
    }

    public function update(Request $request, Habit $habit)
    {
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $habit->update($validated);

        return redirect()->route('habits.index')->with('success', 'Habit updated successfully!');
    }

    public function destroy(Habit $habit)
    {
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $habit->delete();

        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully!');
    }

    public function complete(Habit $habit)
    {
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $result = $habit->completeToday();

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Habit completed!' : 'Already completed today.',
            'current_streak' => $habit->current_streak,
        ]);
    }
}
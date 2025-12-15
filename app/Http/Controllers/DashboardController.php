<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Habit;
use App\Models\Transaction;
use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        
        // Goals progress
        $goals = Goal::where('user_id', $user->id)->get();
        $completedGoals = $goals->filter(function ($goal) {
            return $goal->current_value >= $goal->target_value;
        })->count();
        $totalGoals = $goals->count();
        $goalsProgress = $totalGoals > 0 ? ($completedGoals / $totalGoals) * 100 : 0;
        
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
        
        return view('dashboard', compact(
            'completedToday', 
            'totalToday', 
            'taskPercentageChange',
            'longestStreak',
            'weekExpenses',
            'expensePercentageChange',
            'goalsProgress',
            'completedGoals',
            'totalGoals',
            'todayTasks',
            'habits',
            'expensesByCategory',
            'dailyQuote'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Habit;
use App\Models\Transaction;
use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Tasks statistics
        $todayTasks = Task::where('user_id', $user->id)
            ->whereDate('due_date', $today)
            ->get();
        
        $tasksCompleted = $todayTasks->where('completed', true)->count();
        $totalTasks = $todayTasks->count();

        // Habit statistics
        $habits = Habit::where('user_id', $user->id)->get();
        $longestStreak = $habits->max('longest_streak') ?? 0;
        
        $habitsCompletedToday = 0;
        foreach ($habits as $habit) {
            if ($habit->completions()->whereDate('completed_date', $today)->exists()) {
                $habitsCompletedToday++;
            }
        }

        // Wallet statistics
        $weekStart = Carbon::now()->startOfWeek();
        $weekExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$weekStart, Carbon::now()])
            ->sum('amount');

        $balance = Transaction::where('user_id', $user->id)->get()->sum(function ($transaction) {
            return $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
        });

        // Goals progress
        $goals = Goal::where('user_id', $user->id)->get();
        $completedGoals = $goals->where('completed', true)->count();
        $goalsProgress = $goals->count() > 0 ? round(($completedGoals / $goals->count()) * 100) : 0;

        // Weekly expense breakdown
        $expensesByCategory = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$weekStart, Carbon::now()])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Top habits with streaks
        $topHabits = $habits->sortByDesc('current_streak')->take(4);

        return view('dashboard.index', compact(
            'todayTasks',
            'tasksCompleted',
            'totalTasks',
            'longestStreak',
            'habitsCompletedToday',
            'weekExpenses',
            'balance',
            'goalsProgress',
            'completedGoals',
            'goals',
            'expensesByCategory',
            'topHabits'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Habit;
use App\Models\Expense;
use App\Models\HealthMetric;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Today's Tasks
        $todayTasks = Task::where('user_id', $user->id)
            ->whereDate('deadline', $today)
            ->orderBy('priority', 'desc')
            ->orderBy('completed')
            ->limit(4)
            ->get();

        $completedTasks = $todayTasks->where('completed', true)->count();
        $totalTasks = $todayTasks->count();
        $taskProgress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        // Habits
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('streak', 'desc')
            ->limit(4)
            ->get();

        $longestStreak = $habits->max('streak') ?? 0;

        // This Week's Expenses
        $startOfWeek = Carbon::now()->startOfWeek();
        $weekExpenses = Expense::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, Carbon::now()])
            ->get();

        // Group expenses by category
        $expensesByCategory = $weekExpenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        })->sortByDesc(function ($amount) {
            return $amount;
        })->take(4);

        $totalExpenses = $weekExpenses->sum('amount');

        // Last week's expenses for comparison
        $lastWeekExpenses = Expense::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek->copy()->subWeek(), $startOfWeek])
            ->sum('amount');

        $expenseChange = $lastWeekExpenses > 0 
            ? round((($totalExpenses - $lastWeekExpenses) / $lastWeekExpenses) * 100) 
            : 0;

        // Goals Progress (using habits as goals for now)
        $totalHabits = Habit::where('user_id', $user->id)->count();
        $completedHabitsToday = Habit::where('user_id', $user->id)
            ->where('completed_today', true)
            ->count();
        
        $goalsProgress = $totalHabits > 0 ? ($completedHabitsToday / $totalHabits) * 100 : 0;

        // Weather Data (mock for now - you already have weather page)
        $weatherData = [
            'temp' => 26,
            'condition' => 'Sunny',
            'icon' => '☀️',
            'location' => 'Batangas City',
            'high' => 30,
            'low' => 22,
            'humidity' => 65,
        ];

        // Motivational Quote (changes daily, not on every refresh)
        $quotes = [
            ['text' => 'The secret of getting ahead is getting started.', 'author' => 'Mark Twain'],
            ['text' => 'The only way to do great work is to love what you do.', 'author' => 'Steve Jobs'],
            ['text' => 'Success is not final, failure is not fatal: it is the courage to continue that counts.', 'author' => 'Winston Churchill'],
            ['text' => 'Believe you can and you\'re halfway there.', 'author' => 'Theodore Roosevelt'],
            ['text' => 'The future belongs to those who believe in the beauty of their dreams.', 'author' => 'Eleanor Roosevelt'],
            ['text' => 'Don\'t watch the clock; do what it does. Keep going.', 'author' => 'Sam Levenson'],
            ['text' => 'The way to get started is to quit talking and begin doing.', 'author' => 'Walt Disney'],
        ];
        
        // Use today's date as seed so quote stays same all day
        $dayOfYear = Carbon::now()->dayOfYear;
        $dailyQuote = $quotes[$dayOfYear % count($quotes)];

        $currentDate = Carbon::now()->format('l, M d, Y');

        return view('dashboard', compact(
            'todayTasks',
            'completedTasks',
            'totalTasks',
            'taskProgress',
            'habits',
            'longestStreak',
            'expensesByCategory',
            'totalExpenses',
            'expenseChange',
            'goalsProgress',
            'completedHabitsToday',
            'totalHabits',
            'weatherData',
            'dailyQuote',
            'currentDate'
        ));
    }
}
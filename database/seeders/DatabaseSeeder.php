<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Habit;
use App\Models\Transaction;
use App\Models\Goal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample tasks
        $tasks = [
            [
                'title' => 'Review quarterly reports',
                'description' => 'Go through Q4 reports and prepare summary',
                'category' => 'work',
                'priority' => 'high',
                'due_date' => Carbon::today(),
                'completed' => true,
                'completed_at' => Carbon::now(),
            ],
            [
                'title' => 'Team meeting at 2 PM',
                'description' => 'Discuss new project roadmap',
                'category' => 'work',
                'priority' => 'medium',
                'due_date' => Carbon::today(),
                'completed' => false,
            ],
            [
                'title' => 'Update project documentation',
                'description' => 'Add API documentation for new endpoints',
                'category' => 'development',
                'priority' => 'low',
                'due_date' => Carbon::today()->addDays(1),
                'completed' => false,
            ],
            [
                'title' => 'Code review for new feature',
                'description' => 'Review pull requests',
                'category' => 'development',
                'priority' => 'high',
                'due_date' => Carbon::today(),
                'completed' => true,
                'completed_at' => Carbon::now(),
            ],
        ];

        foreach ($tasks as $taskData) {
            $user->tasks()->create($taskData);
        }

        // Create sample habits
        $habits = [
            ['name' => 'Morning Exercise', 'icon' => 'target', 'color' => 'blue', 'current_streak' => 12, 'longest_streak' => 15],
            ['name' => 'Read 30 Minutes', 'icon' => 'fire', 'color' => 'green', 'current_streak' => 8, 'longest_streak' => 10],
            ['name' => 'Meditation', 'icon' => 'star', 'color' => 'purple', 'current_streak' => 5, 'longest_streak' => 7],
            ['name' => 'Drink 8 Glasses Water', 'icon' => 'check', 'color' => 'blue', 'current_streak' => 15, 'longest_streak' => 15],
            ['name' => 'Journaling', 'icon' => 'fire', 'color' => 'orange', 'current_streak' => 3, 'longest_streak' => 5],
            ['name' => 'No Social Media After 9 PM', 'icon' => 'target', 'color' => 'red', 'current_streak' => 7, 'longest_streak' => 9],
        ];

        foreach ($habits as $habitData) {
            $habit = $user->habits()->create($habitData);
            
            // Add completions for the past week
            for ($i = 0; $i < min($habit->current_streak, 7); $i++) {
                $habit->completions()->create([
                    'completed_date' => Carbon::today()->subDays($i),
                ]);
            }
        }

        // Create sample transactions
        $transactions = [
            ['title' => 'Grocery Shopping', 'amount' => 125.50, 'type' => 'expense', 'category' => 'food', 'transaction_date' => Carbon::today()],
            ['title' => 'Uber to Office', 'amount' => 18.00, 'type' => 'expense', 'category' => 'transport', 'transaction_date' => Carbon::today()],
            ['title' => 'Freelance Project', 'amount' => 850.00, 'type' => 'income', 'category' => 'income', 'transaction_date' => Carbon::today()->subDays(1)],
            ['title' => 'Netflix Subscription', 'amount' => 15.99, 'type' => 'expense', 'category' => 'entertainment', 'transaction_date' => Carbon::today()->subDays(1)],
            ['title' => 'Coffee at Starbucks', 'amount' => 6.50, 'type' => 'expense', 'category' => 'food', 'transaction_date' => Carbon::today()->subDays(1)],
            ['title' => 'New Running Shoes', 'amount' => 89.99, 'type' => 'expense', 'category' => 'shopping', 'transaction_date' => Carbon::today()->subDays(2)],
            ['title' => 'Electricity Bill', 'amount' => 120.00, 'type' => 'expense', 'category' => 'bills', 'transaction_date' => Carbon::today()->subDays(3)],
            ['title' => 'Monthly Salary', 'amount' => 3500.00, 'type' => 'income', 'category' => 'income', 'transaction_date' => Carbon::today()->subDays(5)],
        ];

        foreach ($transactions as $transactionData) {
            $user->transactions()->create($transactionData);
        }

        // Create sample goals
        $goals = [
            ['title' => 'Complete Laravel Certification', 'description' => 'Finish all modules and pass exam', 'target_date' => Carbon::today()->addMonths(2), 'completed' => false],
            ['title' => 'Run a 5K Marathon', 'description' => 'Train for and complete a 5K race', 'target_date' => Carbon::today()->addMonths(3), 'completed' => false],
            ['title' => 'Read 12 Books This Year', 'description' => 'Currently at 8 books', 'target_date' => Carbon::today()->endOfYear(), 'completed' => false],
            ['title' => 'Build Personal Portfolio', 'description' => 'Create and deploy website', 'target_date' => Carbon::today()->addMonth(), 'completed' => true],
        ];

        foreach ($goals as $goalData) {
            $user->goals()->create($goalData);
        }
    }
}
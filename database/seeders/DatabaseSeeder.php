<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Habit;
use App\Models\Transaction;
use App\Models\Goal;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a demo user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample tasks
        Task::create([
            'user_id' => $user->id,
            'title' => 'Review quarterly reports',
            'description' => 'Go through Q4 reports and prepare summary',
            'category' => 'Work',
            'priority' => 'high',
            'due_date' => today(),
            'completed' => true,
            'completed_at' => now(),
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Team meeting at 2 PM',
            'description' => 'Discuss new project roadmap',
            'category' => 'Work',
            'priority' => 'medium',
            'due_date' => today(),
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Update project documentation',
            'description' => 'Add API documentation for new endpoints',
            'category' => 'Development',
            'priority' => 'low',
            'due_date' => today(),
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Code review for new feature',
            'description' => '',
            'category' => 'Work',
            'priority' => 'high',
            'due_date' => today(),
        ]);

        // Create sample habits
        $habits = [
            ['name' => 'Morning Exercise', 'icon' => '💪', 'color' => '#4F46E5', 'current_streak' => 12],
            ['name' => 'Read 30 Minutes', 'icon' => '📚', 'color' => '#10B981', 'current_streak' => 8],
            ['name' => 'Meditation', 'icon' => '🧘', 'color' => '#8B5CF6', 'current_streak' => 5],
            ['name' => 'Drink 8 Glasses Water', 'icon' => '💧', 'color' => '#06B6D4', 'current_streak' => 15],
            ['name' => 'Journaling', 'icon' => '📝', 'color' => '#F59E0B', 'current_streak' => 3],
            ['name' => 'No Social Media After 9 PM', 'icon' => '📱', 'color' => '#EC4899', 'current_streak' => 7],
        ];

        foreach ($habits as $habitData) {
            $habit = Habit::create([
                'user_id' => $user->id,
                'name' => $habitData['name'],
                'icon' => $habitData['icon'],
                'color' => $habitData['color'],
                'current_streak' => $habitData['current_streak'],
                'longest_streak' => $habitData['current_streak'],
            ]);

            // Add completions for the streak
            for ($i = 0; $i < $habitData['current_streak']; $i++) {
                $habit->completions()->create([
                    'completed_date' => Carbon::today()->subDays($habitData['current_streak'] - $i - 1),
                ]);
            }
        }

        // Create sample transactions
        $transactions = [
            ['title' => 'Grocery Shopping', 'amount' => 125.50, 'type' => 'expense', 'category' => 'Food', 'transaction_date' => Carbon::parse('Nov 21')],
            ['title' => 'Uber to Office', 'amount' => 18.00, 'type' => 'expense', 'category' => 'Transport', 'transaction_date' => Carbon::parse('Nov 21')],
            ['title' => 'Freelance Project', 'amount' => 850.00, 'type' => 'income', 'category' => 'Income', 'transaction_date' => Carbon::parse('Nov 20')],
            ['title' => 'Netflix Subscription', 'amount' => 15.99, 'type' => 'expense', 'category' => 'Entertainment', 'transaction_date' => Carbon::parse('Nov 20')],
            ['title' => 'Coffee at Starbucks', 'amount' => 6.50, 'type' => 'expense', 'category' => 'Food', 'transaction_date' => Carbon::parse('Nov 20')],
            ['title' => 'New Running Shoes', 'amount' => 89.99, 'type' => 'expense', 'category' => 'Shopping', 'transaction_date' => Carbon::parse('Nov 19')],
            ['title' => 'Electricity Bill', 'amount' => 125.00, 'type' => 'expense', 'category' => 'Bills', 'transaction_date' => Carbon::parse('Nov 19')],
        ];

        foreach ($transactions as $trans) {
            Transaction::create([
                'user_id' => $user->id,
                ...$trans
            ]);
        }

        // Create sample goals
        Goal::create([
            'user_id' => $user->id,
            'title' => 'Complete Laravel Project',
            'target_value' => 4,
            'current_value' => 3,
            'unit' => 'modules',
        ]);

        Goal::create([
            'user_id' => $user->id,
            'title' => 'Read 12 Books',
            'target_value' => 12,
            'current_value' => 9,
            'unit' => 'books',
        ]);

        Goal::create([
            'user_id' => $user->id,
            'title' => 'Save $10,000',
            'target_value' => 10000,
            'current_value' => 7500,
            'unit' => 'dollars',
        ]);

        Goal::create([
            'user_id' => $user->id,
            'title' => 'Exercise 100 Days',
            'target_value' => 100,
            'current_value' => 75,
            'unit' => 'days',
        ]);
    }
}
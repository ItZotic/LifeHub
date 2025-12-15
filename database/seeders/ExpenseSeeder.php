<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user (or create one if none exists)
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $expenses = [
            [
                'user_id' => $user->id,
                'title' => 'Grocery Shopping',
                'amount' => 125.50,
                'category' => 'Food',
                'type' => 'expense',
                'date' => now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Uber to Office',
                'amount' => 18.00,
                'category' => 'Transport',
                'type' => 'expense',
                'date' => now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Freelance Project',
                'amount' => 850.00,
                'category' => 'Other',
                'type' => 'income',
                'date' => now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Netflix Subscription',
                'amount' => 15.99,
                'category' => 'Entertainment',
                'type' => 'expense',
                'date' => now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Coffee at Starbucks',
                'amount' => 6.50,
                'category' => 'Food',
                'type' => 'expense',
                'date' => now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'New Running Shoes',
                'amount' => 89.99,
                'category' => 'Shopping',
                'type' => 'expense',
                'date' => now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Electricity Bill',
                'amount' => 125.00,
                'category' => 'Bills',
                'type' => 'expense',
                'date' => now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Dinner with Friends',
                'amount' => 45.00,
                'category' => 'Food',
                'type' => 'expense',
                'date' => now()->subDays(4)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Gas Station',
                'amount' => 50.00,
                'category' => 'Transport',
                'type' => 'expense',
                'date' => now()->subDays(4)->format('Y-m-d'),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Monthly Salary',
                'amount' => 3500.00,
                'category' => 'Other',
                'type' => 'income',
                'date' => now()->subDays(7)->format('Y-m-d'),
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::create($expense);
        }
    }
}
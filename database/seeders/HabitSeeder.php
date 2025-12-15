<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\HabitCompletion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $habits = [
            [
                'name' => 'Morning Exercise',
                'color' => 'bg-blue-500',
                'streak' => 12,
                'progress' => [1, 1, 1, 1, 1, 1, 1] // 7 days completed
            ],
            [
                'name' => 'Read 30 Minutes',
                'color' => 'bg-green-500',
                'streak' => 8,
                'progress' => [1, 1, 0, 1, 1, 1, 1] // 6 out of 7
            ],
            [
                'name' => 'Meditation',
                'color' => 'bg-purple-500',
                'streak' => 5,
                'progress' => [1, 1, 1, 1, 1, 0, 0] // 5 out of 7
            ],
            [
                'name' => 'Drink 8 Glasses Water',
                'color' => 'bg-cyan-500',
                'streak' => 15,
                'progress' => [1, 1, 1, 1, 1, 1, 1] // Perfect week
            ],
            [
                'name' => 'Journaling',
                'color' => 'bg-orange-500',
                'streak' => 3,
                'progress' => [0, 1, 1, 1, 0, 0, 0] // 3 out of 7
            ],
            [
                'name' => 'No Social Media After 9 PM',
                'color' => 'bg-pink-500',
                'streak' => 7,
                'progress' => [1, 1, 1, 1, 1, 1, 1] // Perfect week
            ],
        ];

        foreach ($habits as $habitData) {
            $habit = Habit::create([
                'user_id' => $user->id,
                'name' => $habitData['name'],
                'color' => $habitData['color'],
                'streak' => $habitData['streak'],
                'completed_today' => $habitData['progress'][6] === 1, // Last day is today
                'last_completed_at' => $habitData['progress'][6] === 1 ? Carbon::today() : null
            ]);

            // Create completions for the last 7 days
            for ($i = 0; $i < 7; $i++) {
                if ($habitData['progress'][$i] === 1) {
                    HabitCompletion::create([
                        'habit_id' => $habit->id,
                        'completed_date' => Carbon::today()->subDays(6 - $i)
                    ]);
                }
            }
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'title' => 'Review quarterly reports',
            'description' => 'Go through Q4 reports and prepare summary',
            'category' => 'Work',
            'priority' => 'high',
            'deadline' => now()->format('Y-m-d'),
            'completed' => true
        ]);

        Task::create([
            'title' => 'Team meeting at 2 PM',
            'description' => 'Discuss new project roadmap',
            'category' => 'Work',
            'priority' => 'medium',
            'deadline' => now()->format('Y-m-d'),
            'completed' => false
        ]);

        Task::create([
            'title' => 'Update project documentation',
            'description' => 'Add API documentation for new endpoints',
            'category' => 'Development',
            'priority' => 'low',
            'deadline' => now()->addDay()->format('Y-m-d'),
            'completed' => false
        ]);

        Task::create([
            'title' => 'Grocery shopping',
            'description' => 'Buy vegetables, fruits, and milk',
            'category' => 'Personal',
            'priority' => 'medium',
            'deadline' => now()->addDay()->format('Y-m-d'),
            'completed' => false
        ]);
    }
}
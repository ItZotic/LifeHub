@extends('layouts.app')

@section('title', 'Dashboard - LifeHub')

@section('content')
{{-- Dashboard View - No PHP Controller Code Here! --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome back! Here's your daily overview.</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-600 dark:text-gray-400">Today</div>
            <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $currentDate }}</div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Tasks Completed -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="space-y-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">Tasks Completed</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedTasks }}/{{ $totalTasks }}</p>
                <p class="text-xs text-green-500">{{ $taskProgress > 0 ? '+' : '' }}{{ round($taskProgress) }}% progress</p>
            </div>
        </div>

        <!-- Habit Streak -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-orange-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                    </svg>
                </div>
                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="space-y-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">Habit Streak</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $longestStreak }} Days</p>
                <p class="text-xs text-green-500">Keep it up!</p>
            </div>
        </div>

        <!-- Weekly Expenses -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="h-4 w-4 {{ $expenseChange >= 0 ? 'text-red-500 rotate-180' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="space-y-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($totalExpenses, 2) }}</p>
                <p class="text-xs {{ $expenseChange >= 0 ? 'text-red-500' : 'text-green-500' }}">{{ $expenseChange > 0 ? '+' : '' }}{{ $expenseChange }}% from last week</p>
            </div>
        </div>

        <!-- Goals Progress -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="space-y-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">Goals Progress</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ round($goalsProgress) }}%</p>
                <p class="text-xs text-green-500">{{ $completedHabitsToday }} of {{ $totalHabits }} completed</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Tasks Summary -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Today's Tasks
            </h2>
            <div class="space-y-3">
                <div class="mb-4">
                    <div class="flex items-center justify-between text-sm mb-2 text-gray-700 dark:text-gray-300">
                        <span>Progress</span>
                        <span>{{ $completedTasks }} of {{ $totalTasks }} completed</span>
                    </div>
                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 transition-all" style="width: {{ $taskProgress }}%"></div>
                    </div>
                </div>
                @forelse($todayTasks as $task)
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="h-5 w-5 rounded border-2 flex items-center justify-center {{ $task->completed ? 'bg-blue-600 border-blue-600' : 'border-gray-400 dark:border-gray-500' }}">
                            @if($task->completed)
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="flex-1 {{ $task->completed ? 'line-through text-gray-500 dark:text-gray-500' : 'text-gray-900 dark:text-white' }}">
                            {{ $task->title }}
                        </span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $task->priority === 'high' ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' : '' }}
                            {{ $task->priority === 'medium' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400' : '' }}
                            {{ $task->priority === 'low' ? 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' : '' }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="h-12 w-12 mx-auto mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p>No tasks for today. <a href="/tasks" class="text-blue-500 hover:underline">Create one</a></p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Weather Widget -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
                Weather
            </h2>
            <div class="space-y-4">
                <div class="text-center py-4">
                    <div class="text-5xl mb-2">{{ $weatherData['icon'] }}</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">{{ $weatherData['temp'] }}°C</div>
                    <div class="text-gray-600 dark:text-gray-400">{{ $weatherData['condition'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-500 mt-2">{{ $weatherData['location'] }}</div>
                </div>
                <div class="grid grid-cols-3 gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-xs text-gray-600 dark:text-gray-400">High</div>
                        <div class="font-semibold text-gray-900 dark:text-white">{{ $weatherData['high'] }}°C</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-600 dark:text-gray-400">Low</div>
                        <div class="font-semibold text-gray-900 dark:text-white">{{ $weatherData['low'] }}°C</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-600 dark:text-gray-400">Humidity</div>
                        <div class="font-semibold text-gray-900 dark:text-white">{{ $weatherData['humidity'] }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Habit Tracker -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                </svg>
                Habit Streaks
            </h2>
            <div class="space-y-3">
                @forelse($habits as $habit)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center {{ $habit->completed_today ? 'bg-orange-500 text-white' : 'bg-gray-200 dark:bg-gray-600' }}">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($habit->completed_today)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                    @endif
                                </svg>
                            </div>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $habit->name }}</span>
                        </div>
                        <span class="px-2 py-1 border border-gray-300 dark:border-gray-600 text-xs rounded-full text-gray-700 dark:text-gray-300">
                            {{ $habit->streak }} days
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>No habits yet. <a href="/habits" class="text-blue-500 hover:underline">Create one</a></p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Expenses Overview -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Weekly Expenses
            </h2>
            <div class="space-y-3">
                <div class="text-center py-4">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">₱{{ number_format($totalExpenses, 2) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total this week</div>
                </div>
                @forelse($expensesByCategory as $category => $amount)
                    @php
                        $colors = ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500'];
                        $color = $colors[$loop->index % 4];
                        $percentage = ($amount / $totalExpenses) * 100;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm text-gray-900 dark:text-white">
                            <span>{{ $category }}</span>
                            <span>₱{{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 rounded-full {{ $color }}" style="width: {{ $percentage }}%"></div>
                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ round($percentage) }}%</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>No expenses this week.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Motivational Quote -->
        <div class="bg-gradient-to-br from-blue-500/5 to-purple-500/5 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
                Daily Motivation
            </h2>
            <div class="space-y-4">
                <div class="space-y-4">
                    <svg class="h-8 w-8 text-blue-500/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <p class="text-lg italic text-gray-700 dark:text-gray-300">
                        "{{ $dailyQuote['text'] }}"
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">— {{ $dailyQuote['author'] }}</p>
                </div>
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Quote of the day</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
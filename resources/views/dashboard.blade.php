@extends('layouts.app')

@section('title', 'Dashboard - LifeHub')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back! Here's your daily overview.</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Today</p>
            <p class="text-lg font-semibold text-gray-900">{{ now()->format('l, M d, Y') }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-1">Tasks Completed</p>
            <p class="text-3xl font-bold text-gray-900">{{ $completedToday }}/{{ $totalToday }}</p>
            <p class="text-sm {{ $taskPercentageChange >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                {{ $taskPercentageChange >= 0 ? '+' : '' }}{{ number_format($taskPercentageChange, 0) }}% from yesterday
            </p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">🔥</span>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-1">Habit Streak</p>
            <p class="text-3xl font-bold text-gray-900">{{ $longestStreak }} Days</p>
            <p class="text-sm text-green-600 mt-2">Keep it up!</p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">$</span>
                </div>
                <svg class="w-6 h-6 {{ $expensePercentageChange >= 0 ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-1">This Week</p>
            <p class="text-3xl font-bold text-gray-900">${{ number_format($weekExpenses, 0) }}</p>
            <p class="text-sm {{ $expensePercentageChange <= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                {{ $expensePercentageChange >= 0 ? '+' : '' }}{{ number_format($expensePercentageChange, 0) }}% from last week
            </p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-1">Goals Progress</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($goalsProgress, 0) }}%</p>
            <p class="text-sm text-green-600 mt-2">{{ $completedGoals }} of {{ $totalGoals }} completed</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Today's Tasks -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Today's Tasks
                    </h2>
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                        <span>Progress</span>
                        <span>{{ $completedToday }} of {{ $totalToday }} completed</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalToday > 0 ? ($completedToday / $totalToday) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($todayTasks->take(4) as $task)
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg {{ $task->completed ? 'opacity-60' : '' }}">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="mr-4">
                                    <div class="w-6 h-6 rounded-full border-2 {{ $task->completed ? 'bg-blue-600 border-blue-600' : 'border-gray-400' }} flex items-center justify-center">
                                        @if($task->completed)
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </button>
                            </form>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 {{ $task->completed ? 'line-through' : '' }}">{{ $task->title }}</p>
                                @if($task->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 50) }}</p>
                                @endif
                            </div>
                            <span class="badge-{{ $task->priority }}">{{ $task->priority }}</span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No tasks for today. Great job!</p>
                    @endforelse
                </div>
            </div>

            <!-- Habit Streaks -->
            <div class="card mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-2">🔥</span>
                    Habit Streaks
                </h2>
                <div class="space-y-3">
                    @forelse($habits as $habit)
                        <div class="flex items-center justify-between p-4 rounded-lg" style="background-color: {{ $habit->color }}20;">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4" style="background-color: {{ $habit->color }};">
                                    <span class="text-xl">{{ $habit->icon }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $habit->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $habit->current_streak }} day streak</p>
                                </div>
                            </div>
                            @if($habit->isCompletedToday())
                                <span class="text-green-600 font-semibold text-sm">Completed Today</span>
                            @else
                                <form action="{{ route('habits.complete', $habit) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-600 font-semibold text-sm hover:text-blue-700">Mark Complete</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No habits yet. Create one to get started!</p>
                    @endforelse
                </div>
            </div>

            <!-- Weekly Expenses -->
            <div class="card mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-2">$</span>
                    Weekly Expenses
                </h2>
                <div class="text-center mb-6">
                    <p class="text-4xl font-bold text-gray-900">${{ number_format($weekExpenses, 2) }}</p>
                    <p class="text-gray-600">Total this week</p>
                </div>
                <div class="space-y-3">
                    @foreach($expensesByCategory as $expense)
                        @php
                            $percentage = $weekExpenses > 0 ? ($expense->total / $weekExpenses) * 100 : 0;
                            $colors = [
                                'Food' => 'blue',
                                'Transport' => 'green',
                                'Shopping' => 'yellow',
                                'Bills' => 'purple',
                                'Entertainment' => 'pink'
                            ];
                            $color = $colors[$expense->category] ?? 'gray';
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-700">{{ $expense->category }}</span>
                                <span class="font-semibold">${{ number_format($expense->total, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-{{ $color }}-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ number_format($percentage, 0) }}%</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Daily Motivation -->
        <div>
            <div class="card mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-2">💡</span>
                    Daily Motivation
                </h2>
                <div class="text-5xl text-blue-200 mb-4">"</div>
                <p class="text-lg text-gray-800 italic mb-4">"{{ $dailyQuote['text'] }}"</p>
                <p class="text-sm text-gray-600">— {{ $dailyQuote['author'] }}</p>
                <p class="text-xs text-gray-500 mt-4 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Quote of the day
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

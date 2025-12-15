@extends('layouts.app')

@section('title', 'Habits - LifeHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Habit Tracker</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ $completedToday }} of {{ $totalHabits }} habits completed today
            </p>
        </div>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Habit
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <!-- Longest Streak -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-orange-500 dark:text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Longest Streak</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $longestStreak }} Days</p>
            </div>
        </div>

        <!-- Today's Progress -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Today's Progress</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $completedToday }}/{{ $totalHabits }}</p>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Completion Rate</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ round($completionRate) }}%</p>
            </div>
        </div>
    </div>

    <!-- Daily Progress Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Progress</h3>
        <div class="space-y-2">
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                <span>Daily Goal</span>
                <span>{{ $completedToday }} of {{ $totalHabits }} completed</span>
            </div>
            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 transition-all duration-300" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>
    </div>

    <!-- Weekly Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Weekly Overview</h3>
        <div style="height: 250px; position: relative;">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Habits Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($habits as $habit)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border {{ $habit->completed_today ? 'ring-2 ring-blue-600 dark:ring-blue-500 border-transparent' : 'border-gray-200 dark:border-gray-700' }} hover:shadow-md transition-all p-6">
                <div class="space-y-4">
                    <!-- Habit Header -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full {{ $habit->color }} flex items-center justify-center">
                                @if($habit->completed_today)
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $habit->name }}</h3>
                                <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/>
                                    </svg>
                                    {{ $habit->streak }} day streak
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('Delete this habit?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Weekly Progress Dots -->
                    <div class="flex items-center gap-1.5">
                        @foreach($habit->weekly_progress as $completed)
                            <div class="h-7 w-7 rounded-lg flex items-center justify-center {{ $completed ? $habit->color : 'bg-gray-200 dark:bg-gray-700' }}">
                                @if($completed)
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Toggle Button -->
                    <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-2 px-4 rounded-lg font-medium transition {{ $habit->completed_today ? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                            {{ $habit->completed_today ? 'Completed Today' : 'Mark Complete' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <svg class="h-12 w-12 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">No habits yet. Create your first habit to get started!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Habit Modal -->
<div id="habitModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add New Habit</h2>
        <form action="{{ route('habits.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Habit Name</label>
                <input type="text" name="name" required placeholder="e.g., Morning Run" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color Theme</label>
                <div class="grid grid-cols-5 gap-2">
                    @foreach(\App\Models\Habit::getColors() as $color)
                        <label class="cursor-pointer">
                            <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" {{ $loop->first ? 'required checked' : '' }}>
                            <div class="h-10 w-10 rounded-lg {{ $color }} peer-checked:ring-2 peer-checked:ring-blue-600 peer-checked:ring-offset-2 dark:peer-checked:ring-offset-gray-800 transition-all"></div>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Create Habit
                </button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function openModal() {
        document.getElementById('habitModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('habitModal').classList.add('hidden');
    }

    // Weekly Chart with Dark Mode Support
    const weeklyData = @json($weeklyData);
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    
    // Check if dark mode is enabled
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9CA3AF' : '#6B7280';
    const gridColor = isDarkMode ? '#374151' : '#E5E7EB';
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: weeklyData.map(d => d.day),
            datasets: [{
                label: 'Habits Completed',
                data: weeklyData.map(d => d.completed),
                backgroundColor: '#3B82F6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: textColor
                    },
                    grid: {
                        color: gridColor
                    }
                },
                x: {
                    ticks: {
                        color: textColor
                    },
                    grid: {
                        color: gridColor
                    }
                }
            }
        }
    });
</script>
@endsection
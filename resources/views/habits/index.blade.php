@extends('layouts.app')

@section('title', 'Habits - LifeHub')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Habit Tracker</h1>
            <p class="text-gray-600 mt-1">{{ $completedToday }} of {{ $totalHabits }} habits completed today</p>
        </div>
        <button onclick="document.getElementById('addHabitModal').classList.remove('hidden')" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Habit
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                    <span class="text-2xl">🔥</span>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Longest Streak</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $longestStreak }} Days</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Today's Progress</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $completedToday }}/{{ $totalHabits }}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Completion Rate</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($completionRate, 0) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Progress -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Today's Progress</h2>
        <div class="mb-4">
            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                <span>Daily Goal</span>
                <span>{{ $completedToday }} of {{ $totalHabits }} completed</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>
    </div>

    <!-- Weekly Overview -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Weekly Overview</h2>
        <div class="flex items-end justify-between gap-4 h-64 px-4">
            @foreach($weekData as $day)
                <div class="flex-1 flex flex-col items-center h-full">
                    <div class="w-full flex-1 flex items-end justify-center mb-3">
                        @if($day['completions'] > 0)
                            <div class="relative w-3/4 bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg transition-all duration-500 hover:from-blue-700 hover:to-blue-500 group" 
                                 style="height: {{ max($day['height'], 8) }}%;">
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    {{ $day['completions'] }} habit{{ $day['completions'] > 1 ? 's' : '' }}
                                </div>
                            </div>
                        @else
                            <div class="w-3/4 bg-gray-200 rounded-t-lg" style="height: 8%;"></div>
                        @endif
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-900">{{ $day['day'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $day['completions'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Habits List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($habits as $habit)
            <div class="card border-2 hover:shadow-lg transition-all duration-200 {{ $habit->isCompletedToday() ? 'opacity-50 hover:opacity-60' : '' }}" style="border-color: {{ $habit->color }};">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4" style="background-color: {{ $habit->color }};">
                            <span class="text-2xl">{{ $habit->icon }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $habit->name }}</h3>
                            <p class="text-sm text-gray-600 flex items-center mt-1">
                                <span class="text-orange-500 mr-1">🔥</span>
                                {{ $habit->current_streak }} day streak
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this habit?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-2 mb-4">
                    @php
                        $completions = $habit->getWeeklyCompletions();
                    @endphp
                    @for($i = 0; $i < 7; $i++)
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200 {{ in_array($i, $completions) ? 'text-white' : 'bg-gray-200 text-gray-400' }}" 
                             style="{{ in_array($i, $completions) ? 'background-color: ' . $habit->color . ';' : '' }}">
                            @if(in_array($i, $completions))
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <span class="text-xs font-medium">{{ $i == 0 ? 'M' : ($i == 1 ? 'T' : ($i == 2 ? 'W' : ($i == 3 ? 'T' : ($i == 4 ? 'F' : ($i == 5 ? 'S' : 'S'))))) }}</span>
                            @endif
                        </div>
                    @endfor
                </div>

                @if($habit->isCompletedToday())
                    <form action="{{ route('habits.incomplete', $habit) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-3 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center group hover:opacity-90" style="background-color: {{ $habit->color }}20; color: {{ $habit->color }};">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="group-hover:hidden">Completed Today</span>
                            <span class="hidden group-hover:inline">Click to Unmark</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('habits.complete', $habit) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-200 transform hover:scale-[1.02]" style="background-color: {{ $habit->color }};">
                            Mark Complete
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="col-span-2 card text-center py-12">
                <div class="flex flex-col items-center">
                    <span class="text-6xl mb-4">🎯</span>
                    <p class="text-gray-500 text-lg font-semibold">No habits yet</p>
                    <p class="text-gray-400 mt-2">Create your first habit to start building better routines!</p>
                    <button onclick="document.getElementById('addHabitModal').classList.remove('hidden')" class="mt-6 btn-primary">
                        Create Your First Habit
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Habit Modal -->
<div id="addHabitModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Add New Habit</h2>
            <button onclick="document.getElementById('addHabitModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('habits.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Habit Name</label>
                <input type="text" name="name" required placeholder="e.g., Morning Exercise" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select name="icon" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="🎯">🎯 Target</option>
                        <option value="💪">💪 Strength</option>
                        <option value="📚">📚 Learning</option>
                        <option value="🧘">🧘 Meditation</option>
                        <option value="🏃">🏃 Running</option>
                        <option value="💧">💧 Water</option>
                        <option value="🌙">🌙 Sleep</option>
                        <option value="🎨">🎨 Creative</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                    <select name="color" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="#4F46E5">🔵 Blue</option>
                        <option value="#10B981">🟢 Green</option>
                        <option value="#F59E0B">🟡 Orange</option>
                        <option value="#8B5CF6">🟣 Purple</option>
                        <option value="#EC4899">🔴 Pink</option>
                        <option value="#06B6D4">🔷 Cyan</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 btn-primary">Add Habit</button>
                <button type="button" onclick="document.getElementById('addHabitModal').classList.add('hidden')" class="flex-1 btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Health & Fitness - LifeHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Health & Fitness</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track your daily health metrics and progress</p>
        </div>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Log Activity
        </button>
    </div>

    <!-- Today's Overview -->
    <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Steps Card -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                @if($stepsProgress >= 100)
                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Goal Met!</span>
                @else
                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                @endif
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Steps</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($todayStats['steps']) }}</p>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 transition-all" style="width: {{ min($stepsProgress, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">Goal: {{ number_format($todayStats['stepsGoal']) }}</p>
            </div>
        </div>

        <!-- Calories Card -->
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
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Calories</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($todayStats['calories']) }}</p>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-600 transition-all" style="width: {{ min($caloriesProgress, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">Goal: {{ number_format($todayStats['caloriesGoal']) }}</p>
            </div>
        </div>

        <!-- Water Card -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-cyan-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
                @if($waterProgress >= 100)
                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Goal Met!</span>
                @endif
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Water</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $todayStats['water'] }}/{{ $todayStats['waterGoal'] }}</p>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-cyan-600 transition-all" style="width: {{ min($waterProgress, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">Glasses</p>
            </div>
        </div>

        <!-- Sleep Card -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </div>
                @if($sleepProgress >= 100)
                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Well Rested</span>
                @else
                    <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                @endif
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Sleep</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $todayStats['sleep'] }}h</p>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-600 transition-all" style="width: {{ min($sleepProgress, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">Goal: {{ $todayStats['sleepGoal'] }}h</p>
            </div>
        </div>

        <!-- Heart Rate Card -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-red-500/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <span class="px-2 py-1 border border-gray-300 dark:border-gray-600 text-xs rounded-full text-gray-700 dark:text-gray-300">{{ $todayStats['heartRate'] > 0 ? 'Normal' : 'Not Set' }}</span>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Heart Rate</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $todayStats['heartRate'] ?: '--' }} {{ $todayStats['heartRate'] ? 'bpm' : '' }}</p>
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Resting</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of the charts and sleep analysis (keeping the same code) -->
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold flex items-center gap-2 text-gray-900 dark:text-white">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Weekly Activity
                </h2>
                <div class="flex gap-2">
                    <button onclick="showChart('steps')" id="btn-steps" class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg">Steps</button>
                    <button onclick="showChart('heart')" id="btn-heart" class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">Heart</button>
                    <button onclick="showChart('sleep')" id="btn-sleep" class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">Sleep</button>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <h2 class="text-lg font-semibold flex items-center gap-2 mb-4 text-gray-900 dark:text-white">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Active Minutes
                </h2>
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $todayStats['activeMinutes'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">of {{ $todayStats['activeMinutesGoal'] }} minutes</div>
                    </div>
                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-500 transition-all" style="width: {{ min($activeProgress, 100) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                        <span>0 min</span>
                        <span>{{ $todayStats['activeMinutesGoal'] }} min</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500/10 to-blue-500/10 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <h2 class="text-lg font-semibold flex items-center gap-2 mb-3 text-gray-900 dark:text-white">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Health Tip
                </h2>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">
                    @if($todayStats['steps'] < $todayStats['stepsGoal'])
                        You're close to reaching your daily step goal! Take a short walk to complete it.
                    @else
                        Great job! You've reached your step goal today!
                    @endif
                </p>
                @if($todayStats['steps'] < $todayStats['stepsGoal'])
                    <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ number_format($todayStats['stepsGoal'] - $todayStats['steps']) }} steps to go</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
        <h2 class="text-xl font-semibold flex items-center gap-2 mb-6 text-gray-900 dark:text-white">
            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            Sleep Analysis
        </h2>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="text-center p-4 rounded-lg bg-purple-500/10">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $sleepAnalysis['total'] }}h</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Sleep</div>
                <div class="text-xs {{ $sleepAnalysis['vsAverage'] > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">{{ $sleepAnalysis['vsAverage'] }}h vs average</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-purple-600/10">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $sleepAnalysis['deep'] }}h</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Deep Sleep</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $sleepAnalysis['deepPercent'] }}% of total</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-purple-400/10">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $sleepAnalysis['light'] }}h</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Light Sleep</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $sleepAnalysis['lightPercent'] }}% of total</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-purple-300/10">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $sleepAnalysis['rem'] }}h</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">REM Sleep</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $sleepAnalysis['remPercent'] }}% of total</div>
            </div>
        </div>
    </div>
</div>

<!-- Log Activity Modal -->
<div id="activityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Log Today's Activity</h2>
        <form action="{{ route('health.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Steps</label>
                <input type="number" name="steps" min="0" placeholder="e.g., 5000" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Calories Burned</label>
                <input type="number" name="calories" min="0" placeholder="e.g., 300" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Water (glasses)</label>
                <input type="number" name="water_glasses" min="0" max="20" placeholder="e.g., 6" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sleep Hours</label>
                <input type="number" name="sleep_hours" min="0" max="24" step="0.5" placeholder="e.g., 7.5" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heart Rate (bpm)</label>
                <input type="number" name="heart_rate" min="30" max="200" placeholder="e.g., 72" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Active Minutes</label>
                <input type="number" name="active_minutes" min="0" placeholder="e.g., 30" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Save Activity
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
        document.getElementById('activityModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('activityModal').classList.add('hidden');
    }

    const weeklySteps = @json($weeklySteps);
    const heartRateData = @json($heartRateData);
    const sleepData = @json($sleepData);
    
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9CA3AF' : '#6B7280';
    const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

    let activityChart;

    function createStepsChart() {
        return new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: weeklySteps.map(d => d.day),
                datasets: [{
                    label: 'Steps',
                    data: weeklySteps.map(d => d.steps),
                    backgroundColor: '#3B82F6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    function createHeartChart() {
        return new Chart(document.getElementById('activityChart'), {
            type: 'line',
            data: {
                labels: heartRateData.map(d => d.time),
                datasets: [{
                    label: 'Heart Rate (bpm)',
                    data: heartRateData.map(d => d.rate),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 50,
                        max: 100,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    function createSleepChart() {
        return new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: sleepData.map(d => d.day),
                datasets: [
                    {
                        label: 'Deep Sleep',
                        data: sleepData.map(d => d.deep),
                        backgroundColor: '#8B5CF6',
                        borderRadius: 8
                    },
                    {
                        label: 'Light Sleep',
                        data: sleepData.map(d => d.light),
                        backgroundColor: '#A78BFA',
                        borderRadius: 8
                    },
                    {
                        label: 'REM Sleep',
                        data: sleepData.map(d => d.rem),
                        backgroundColor: '#C4B5FD',
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, labels: { color: textColor } } },
                scales: {
                    x: {
                        stacked: true,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    y: {
                        stacked: true,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    function showChart(type) {
        if (activityChart) {
            activityChart.destroy();
        }

        document.getElementById('btn-steps').className = type === 'steps' 
            ? 'px-3 py-1 text-sm bg-blue-600 text-white rounded-lg' 
            : 'px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg';
        document.getElementById('btn-heart').className = type === 'heart' 
            ? 'px-3 py-1 text-sm bg-blue-600 text-white rounded-lg' 
            : 'px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg';
        document.getElementById('btn-sleep').className = type === 'sleep' 
            ? 'px-3 py-1 text-sm bg-blue-600 text-white rounded-lg' 
            : 'px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg';

        if (type === 'steps') {
            activityChart = createStepsChart();
        } else if (type === 'heart') {
            activityChart = createHeartChart();
        } else {
            activityChart = createSleepChart();
        }
    }

    activityChart = createStepsChart();
</script>
@endsection
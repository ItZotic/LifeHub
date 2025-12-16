@extends('layouts.app')

@section('title', 'Weather - LifeHub')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Weather</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Current conditions and forecast</p>
        </div>
        <form action="{{ route('weather.refresh') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </form>
    </div>

    <!-- Current Weather Card -->
    <div class="card mb-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
        <!-- Header with Location and Date/Time -->
        <div class="flex justify-between items-start mb-8">
            <div class="flex items-center text-gray-600 dark:text-gray-400">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">{{ $location }}</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('M d, Y g:i A') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Side - Main Weather Display -->
            <div class="flex flex-col items-center justify-center">
                <div class="text-8xl mb-6">{{ $weatherData['current']['icon'] ?? '☁️' }}</div>
                <div class="text-center">
                    <p class="text-7xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $weatherData['current']['temp'] ?? 25 }}°<span class="text-5xl text-gray-500 dark:text-gray-400">{{ strpos(auth()->user()->temperature_unit ?? '', 'Fahrenheit') !== false ? 'F' : 'C' }}</span>
                    </p>
                    <p class="text-xl text-gray-700 dark:text-gray-300 mb-2">{{ $weatherData['current']['condition'] ?? 'Overcast clouds' }}</p>
                    <p class="text-base text-gray-500 dark:text-gray-400">Feels like {{ $weatherData['current']['feels_like'] ?? 26 }}°{{ strpos(auth()->user()->temperature_unit ?? '', 'Fahrenheit') !== false ? 'F' : 'C' }}</p>
                </div>
            </div>

            <!-- Right Side - Weather Details Grid -->
            <div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Humidity -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Humidity</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weatherData['current']['humidity'] ?? 89 }}%</p>
                    </div>

                    <!-- Wind -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Wind</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weatherData['current']['wind_speed'] ?? 17 }} km/h</p>
                    </div>

                    <!-- Visibility -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Visibility</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weatherData['current']['visibility'] ?? 10 }} km</p>
                    </div>

                    <!-- Pressure -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pressure</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weatherData['current']['pressure'] ?? 1012 }} mb</p>
                    </div>
                </div>

                <!-- Sun Times & UV -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">🌅</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sunrise</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['current']['sunrise'] ?? '5:48 AM' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">🌇</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sunset</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['current']['sunset'] ?? '5:32 PM' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">☀️</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">UV Index</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['current']['uv_index'] ?? 0 }} ({{ $weatherData['current']['uv_level'] ?? 'Low' }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hourly Forecast -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
            </svg>
            Hourly Forecast
        </h2>
        <div class="flex overflow-x-auto space-x-4 pb-4">
            @if(isset($weatherData['hourly']) && is_array($weatherData['hourly']))
                @foreach($weatherData['hourly'] as $hour)
                    <div class="flex-shrink-0 text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-xl min-w-[100px] hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $hour['time'] ?? 'N/A' }}</p>
                        <div class="text-4xl mb-2">{{ $hour['icon'] ?? '☁️' }}</div>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $hour['temp'] ?? 25 }}°</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 dark:text-gray-400">No hourly forecast available</p>
            @endif
        </div>
    </div>

    <!-- 7-Day Forecast -->
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            7-Day Forecast
        </h2>
        <div class="space-y-3">
            @if(isset($weatherData['daily']) && is_array($weatherData['daily']))
                @foreach($weatherData['daily'] as $day)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-24">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $day['day'] ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $day['date'] ?? '' }}</p>
                            </div>
                            <div class="text-5xl">{{ $day['icon'] ?? '☁️' }}</div>
                            <div class="flex-1">
                                <p class="text-gray-900 dark:text-white font-medium">{{ $day['condition'] ?? 'N/A' }}</p>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $day['rain_chance'] ?? 0 }}% chance of rain</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">High</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $day['high'] ?? 25 }}°</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Low</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $day['low'] ?? 20 }}°</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">No forecast available</p>
            @endif
        </div>
    </div>
</div>
@endsection
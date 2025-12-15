@extends('layouts.app')

@section('title', 'Weather - LifeHub')

@section('content')
<div class="p-8 space-y-6 max-w-7xl mx-auto">
    @if(isset($error))
        <!-- Error State -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 text-center">
            <svg class="h-12 w-12 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="text-red-800 dark:text-red-200">{{ $error }}</p>
        </div>
    @else
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Weather</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Current conditions and forecast</p>
            </div>
            <button onclick="location.reload()" class="flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>

        <!-- Current Weather -->
        <div class="bg-gradient-to-br from-blue-500/10 to-purple-500/10 border border-gray-200 dark:border-gray-700 rounded-xl p-8">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">{{ $weatherData['location'] }}</span>
                </div>
                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-sm text-gray-600 dark:text-gray-400">
                    {{ $weatherData['lastUpdated'] }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Temperature Display -->
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="text-8xl mb-4">{{ $weatherData['current']['icon'] }}</div>
                    <div class="space-y-2">
                        <div class="flex items-baseline justify-center gap-2">
                            <span class="text-6xl font-bold text-gray-900 dark:text-white">{{ $weatherData['current']['temp'] }}°</span>
                            <span class="text-2xl text-gray-600 dark:text-gray-400">C</span>
                        </div>
                        <div class="text-xl text-gray-700 dark:text-gray-300">
                            {{ $weatherData['current']['condition'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Feels like {{ $weatherData['current']['feelsLike'] }}°C
                        </div>
                    </div>
                </div>

                <!-- Weather Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Humidity -->
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg">
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="h-12 w-12 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Humidity</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $weatherData['details']['humidity'] }}%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Wind Speed -->
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg">
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="h-12 w-12 rounded-lg bg-cyan-500/10 flex items-center justify-center">
                                <svg class="h-6 w-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Wind</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $weatherData['details']['windSpeed'] }} km/h</div>
                            </div>
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg">
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="h-12 w-12 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Visibility</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $weatherData['details']['visibility'] }} km</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pressure -->
                    <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg">
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="h-12 w-12 rounded-lg bg-orange-500/10 flex items-center justify-center">
                                <svg class="h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Pressure</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $weatherData['details']['pressure'] }} mb</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sun & UV Info -->
            <div class="grid md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                        <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Sunrise</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['sun']['sunrise'] }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-orange-500/10 flex items-center justify-center">
                        <svg class="h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Sunset</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['sun']['sunset'] }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-red-500/10 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">UV Index</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $weatherData['details']['uvIndex'] }} 
                            @if($weatherData['details']['uvIndex'] <= 2)
                                (Low)
                            @elseif($weatherData['details']['uvIndex'] <= 5)
                                (Moderate)
                            @elseif($weatherData['details']['uvIndex'] <= 7)
                                (High)
                            @elseif($weatherData['details']['uvIndex'] <= 10)
                                (Very High)
                            @else
                                (Extreme)
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hourly Forecast -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
                Hourly Forecast
            </h2>
            <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
                @foreach($weatherData['hourly'] as $hour)
                    <div class="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $hour['time'] }}</div>
                        <div class="text-4xl">{{ $hour['icon'] }}</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $hour['temp'] }}°</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 7-Day Forecast -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                7-Day Forecast
            </h2>
            <div class="space-y-3">
                @foreach($weatherData['forecast'] as $day)
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-28">
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $day['day'] }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $day['date'] }}</div>
                        </div>
                        <div class="text-4xl">{{ $day['icon'] }}</div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $day['condition'] }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ $day['precipitation'] }}%</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-600 dark:text-gray-400">High</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $day['high'] }}°</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 dark:text-gray-400">Low</div>
                                <div class="text-lg text-gray-600 dark:text-gray-400">{{ $day['low'] }}°</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard - LifeHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ Auth::user()->name }}! 👋</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tasks Stat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tasks</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTasks ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $completedTasks ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Habits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Habits</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalExpenses ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalExpenses ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tasks Card -->
        <a href="/tasks" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all hover:border-blue-300 group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-200 transition-colors">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Tasks</h3>
                    <p class="text-sm text-gray-600">Manage your to-dos</p>
                </div>
            </div>
            <p class="text-sm text-gray-500">Track and complete your daily tasks efficiently</p>
        </a>

        <!-- Habits Card -->
        <a href="/habits" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all hover:border-purple-300 group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-200 transition-colors">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Habits</h3>
                    <p class="text-sm text-gray-600">Build better routines</p>
                </div>
            </div>
            <p class="text-sm text-gray-500">Track daily habits and build streaks</p>
        </a>

        <!-- Wallet Card -->
        <a href="/expenses" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all hover:border-green-300 group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-green-100 rounded-lg p-3 group-hover:bg-green-200 transition-colors">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Wallet</h3>
                    <p class="text-sm text-gray-600">Track expenses</p>
                </div>
            </div>
            <p class="text-sm text-gray-500">Monitor your income and spending patterns</p>
        </a>

        <!-- Health Card -->
        <a href="/health" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all hover:border-red-300 group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-red-100 rounded-lg p-3 group-hover:bg-red-200 transition-colors">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Health</h3>
                    <p class="text-sm text-gray-600">Monitor wellness</p>
                </div>
            </div>
            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">Coming Soon</span>
        </a>

        <!-- Weather Card -->
        <a href="/weather" class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-sm p-6 hover:shadow-md transition-all text-white group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 rounded-lg p-3 group-hover:bg-white/30 transition-colors">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Weather</h3>
                    <p class="text-sm text-white/90">Check forecast</p>
                </div>
            </div>
            <span class="inline-block px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full">Coming Soon</span>
        </a>

        <!-- Settings Card -->
        <a href="/settings" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all hover:border-gray-400 group">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gray-100 rounded-lg p-3 group-hover:bg-gray-200 transition-colors">
                    <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Settings</h3>
                    <p class="text-sm text-gray-600">Customize your app</p>
                </div>
            </div>
            <p class="text-sm text-gray-500">Manage your profile and preferences</p>
        </a>
    </div>
</div>
@endsection
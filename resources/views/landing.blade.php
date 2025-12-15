@extends('layouts.guest')

@section('title', 'LifeHub - Your Personal Digital Assistant')

@section('content')
<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 rounded-lg bg-blue-600 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xl font-semibold">LifeHub</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="/login" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                Login
            </a>
            <a href="/register" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Get Started
            </a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 md:py-32 animate-fade-in">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6 animate-slide-up">
            <div class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm font-medium">
                Your Personal Digital Assistant
            </div>
            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                Your All-In-One Daily Life Dashboard
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Organize tasks, track habits, manage expenses, and stay updated — all in one place.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="/register" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-lg font-medium">
                    Get Started
                </a>
                <a href="/login" class="px-8 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition-colors text-lg font-medium">
                    Login
                </a>
            </div>
            <div class="flex items-center gap-8 pt-8">
                <div>
                    <div class="text-3xl font-bold">10K+</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Active Users</div>
                </div>
                <div class="h-12 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div>
                    <div class="text-3xl font-bold">4.9★</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">User Rating</div>
                </div>
                <div class="h-12 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div>
                    <div class="text-3xl font-bold">99%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Satisfaction</div>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-3xl blur-3xl"></div>
            <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=800&auto=format&fit=crop" alt="Modern workspace" class="w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="max-w-7xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-5xl font-bold mb-4">Everything You Need, One Dashboard</h2>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Powerful features designed to help you stay organized and productive every day.
        </p>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Task Management -->
        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow bg-white dark:bg-gray-800">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500/10 to-blue-600/10 flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Task Management</h3>
            <p class="text-gray-600 dark:text-gray-400">Organize your daily tasks with priorities, deadlines, and categories.</p>
        </div>

        <!-- Habit Tracking -->
        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow bg-white dark:bg-gray-800">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-500/10 to-green-600/10 flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Habit Tracking</h3>
            <p class="text-gray-600 dark:text-gray-400">Build better habits with streak tracking and daily progress monitoring.</p>
        </div>

        <!-- Expense Tracker -->
        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow bg-white dark:bg-gray-800">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Expense Tracker</h3>
            <p class="text-gray-600 dark:text-gray-400">Monitor your spending with visual charts and category breakdowns.</p>
        </div>

        <!-- Goal Setting -->
        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow bg-white dark:bg-gray-800">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500/10 to-purple-600/10 flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Goal Setting</h3>
            <p class="text-gray-600 dark:text-gray-400">Set and achieve your personal and professional goals with ease.</p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="max-w-7xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-5xl font-bold mb-4">Loved by Thousands</h2>
        <p class="text-xl text-gray-600 dark:text-gray-400">
            See what our users are saying about LifeHub
        </p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800">
            <svg class="h-8 w-8 text-blue-500/20 mb-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <p class="text-gray-600 dark:text-gray-400 mb-4">LifeHub has completely transformed how I manage my daily routine. Everything I need in one place!</p>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-semibold">
                    SJ
                </div>
                <div>
                    <div class="font-semibold">Sarah Johnson</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Product Manager</div>
                </div>
            </div>
        </div>

        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800">
            <svg class="h-8 w-8 text-blue-500/20 mb-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <p class="text-gray-600 dark:text-gray-400 mb-4">The habit tracker feature helped me build consistent routines. Highly recommend!</p>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center font-semibold">
                    MC
                </div>
                <div>
                    <div class="font-semibold">Michael Chen</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Entrepreneur</div>
                </div>
            </div>
        </div>

        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800">
            <svg class="h-8 w-8 text-blue-500/20 mb-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Clean, beautiful, and incredibly functional. It's my go-to dashboard every morning.</p>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center font-semibold">
                    ED
                </div>
                <div>
                    <div class="font-semibold">Emma Davis</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Designer</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="max-w-7xl mx-auto px-6 py-20">
    <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl p-12 text-center text-white">
        <h2 class="text-3xl md:text-5xl font-bold mb-6">Ready to Get Started?</h2>
        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
            Join thousands of users who have transformed their daily routine with LifeHub.
        </p>
        <a href="/register" class="inline-block px-8 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors text-lg font-medium">
            Start Your Journey
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="border-t border-gray-200 dark:border-gray-700 mt-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-semibold">LifeHub</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Your personal digital lifestyle dashboard for better productivity.
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Product</h4>
                <div class="space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Features</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Pricing</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">FAQ</div>
                </div>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Company</h4>
                <div class="space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">About</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Blog</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Careers</div>
                </div>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Legal</h4>
                <div class="space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Privacy</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Terms</div>
                    <div class="hover:text-gray-900 dark:hover:text-white cursor-pointer">Security</div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 mt-12 pt-8 text-center text-gray-600 dark:text-gray-400">
            © 2025 LifeHub. All rights reserved.
        </div>
    </div>
</footer>
@endsection
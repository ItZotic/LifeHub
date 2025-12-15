@extends('layouts.guest')

@section('title', 'LifeHub - Your Personal Digital Assistant')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900">LifeHub</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 text-white py-24 px-4 rounded-3xl mx-4 my-8">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-blue-200 mb-4 inline-block px-4 py-2 bg-blue-500 bg-opacity-30 rounded-full text-sm">Your Personal Digital Assistant</p>
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Your All-In-One Daily Life Dashboard</h1>
            <p class="text-xl text-blue-100 mb-8">Organize tasks, track habits, manage expenses, and stay updated — all in one place.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition text-lg">Get Started</a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition text-lg">Login</a>
            </div>
            <div class="mt-12 flex justify-center space-x-12 text-center">
                <div>
                    <div class="text-4xl font-bold">10K+</div>
                    <div class="text-blue-200 mt-2">Active Users</div>
                </div>
                <div>
                    <div class="text-4xl font-bold">4.9★</div>
                    <div class="text-blue-200 mt-2">User Rating</div>
                </div>
                <div>
                    <div class="text-4xl font-bold">99%</div>
                    <div class="text-blue-200 mt-2">Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Everything You Need, One Dashboard</h2>
            <p class="text-xl text-gray-600">Powerful features designed to help you stay organized and productive every day.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Task Management</h3>
                <p class="text-gray-600">Organize your daily tasks with priorities, deadlines, and categories.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Habit Tracking</h3>
                <p class="text-gray-600">Build better habits with streak tracking and daily progress monitoring.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Expense Tracker</h3>
                <p class="text-gray-600">Monitor your spending with visual charts and category breakdowns.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Goal Setting</h3>
                <p class="text-gray-600">Set and achieve your personal and professional goals with ease.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-gray-100 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Loved by Thousands</h2>
                <p class="text-xl text-gray-600">See what our users are saying about LifeHub</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <div class="text-5xl text-blue-200 mb-4">"</div>
                    <p class="text-gray-700 mb-6">LifeHub has completely transformed how I manage my daily routine. Everything I need in one place!</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-3">SJ</div>
                        <div>
                            <p class="font-semibold text-gray-900">Sarah Johnson</p>
                            <p class="text-sm text-gray-500">Product Manager</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <div class="text-5xl text-blue-200 mb-4">"</div>
                    <p class="text-gray-700 mb-6">The habit tracker feature helped me build consistent routines. Highly recommend!</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">MC</div>
                        <div>
                            <p class="font-semibold text-gray-900">Michael Chen</p>
                            <p class="text-sm text-gray-500">Entrepreneur</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <div class="text-5xl text-blue-200 mb-4">"</div>
                    <p class="text-gray-700 mb-6">Clean, beautiful, and incredibly functional. It's my go-to dashboard every morning.</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold mr-3">ED</div>
                        <div>
                            <p class="font-semibold text-gray-900">Emma Davis</p>
                            <p class="text-sm text-gray-500">Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 text-white py-16 px-4 rounded-3xl mx-4 my-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl text-blue-100 mb-8">Join thousands of users who have transformed their daily routine with LifeHub.</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition text-lg">Start Your Journey</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">LifeHub</span>
                    </div>
                    <p class="text-gray-600">Your personal digital lifestyle dashboard for better productivity.</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Features</a></li>
                        <li><a href="#" class="hover:text-blue-600">Pricing</a></li>
                        <li><a href="#" class="hover:text-blue-600">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">About</a></li>
                        <li><a href="#" class="hover:text-blue-600">Blog</a></li>
                        <li><a href="#" class="hover:text-blue-600">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Privacy</a></li>
                        <li><a href="#" class="hover:text-blue-600">Terms</a></li>
                        <li><a href="#" class="hover:text-blue-600">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t pt-8 text-center text-gray-600">
                © 2025 LifeHub. All rights reserved.
            </div>
        </div>
    </footer>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Settings - LifeHub')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Settings</h1>
    <p class="text-gray-600 mb-8">Manage your account and preferences</p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Information -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Profile Information</h2>
        <p class="text-gray-600 mb-6">Update your personal information</p>
        
        <div class="flex items-center mb-6">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mr-6">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Change Avatar</button>
                <p class="text-sm text-gray-500 mt-2">JPG, PNG or GIF (max. 2MB)</p>
            </div>
        </div>

        <form action="{{ route('settings.profile') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Appearance -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Appearance</h2>
        <p class="text-gray-600 mb-6">Customize how LifeHub looks</p>
        
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="font-semibold text-gray-900">Dark Mode</p>
                <p class="text-sm text-gray-600">Switch between light and dark theme</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>English</option>
                    <option>Spanish</option>
                    <option>French</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>USD ($)</option>
                    <option>EUR (€)</option>
                    <option>GBP (£)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Notifications</h2>
        <p class="text-gray-600 mb-6">Manage your notification preferences</p>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Email Notifications</p>
                    <p class="text-sm text-gray-600">Receive updates via email</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Push Notifications</p>
                    <p class="text-sm text-gray-600">Receive push notifications on your device</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Task Reminders</p>
                    <p class="text-sm text-gray-600">Get reminded about upcoming tasks</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Habit Reminders</p>
                    <p class="text-sm text-gray-600">Daily reminders for your habits</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Expense Alerts</p>
                    <p class="text-sm text-gray-600">Alerts when you exceed budget limits</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Security -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Security</h2>
        <p class="text-gray-600 mb-6">Manage your password and security settings</p>
        
        <form action="{{ route('settings.password') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <button type="submit" class="btn-primary">Change Password</button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="card border-2 border-red-200">
        <h2 class="text-xl font-bold text-red-600 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Danger Zone
        </h2>
        <p class="text-gray-600 mb-6">Irreversible actions</p>
        
        <p class="text-gray-700 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
        
        <form action="{{ route('settings.delete') }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Settings - LifeHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Settings</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your account and preferences</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your personal information and avatar</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Avatar Section -->
            <div class="flex items-center gap-6">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                @else
                    <div class="h-20 w-20 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl font-semibold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
                
                <div class="space-y-2">
                    <form action="{{ route('settings.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="document.getElementById('avatarForm').submit()">
                        <label for="avatar" class="cursor-pointer inline-block px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Change Avatar
                        </label>
                    </form>
                    @if(Auth::user()->avatar)
                        <form action="{{ route('settings.avatar.delete') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Remove
                            </button>
                        </form>
                    @endif
                    <p class="text-sm text-gray-500 dark:text-gray-400">JPG, PNG or GIF (max. 2MB)</p>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <form action="{{ route('settings.profile') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', Auth::user()->name) }}"
                            required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', Auth::user()->email) }}"
                            required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Appearance -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Appearance</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Customize how LifeHub looks</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Dark Mode Toggle -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Dark Mode</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Switch between light and dark theme</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Security -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Security
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage your password and security settings</p>
        </div>
        <div class="p-6">
            <form action="{{ route('settings.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="space-y-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                    @error('current_password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                    <p class="text-xs text-gray-500 dark:text-gray-400">Must be at least 8 characters</p>
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Change Password
                </button>
            </form>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-200 dark:border-red-900 mb-6">
        <div class="p-6 border-b border-red-200 dark:border-red-900">
            <h2 class="text-xl font-semibold text-red-600 dark:text-red-400 flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Danger Zone
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Irreversible actions</p>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                Once you delete your account, there is no going back. Please be certain.
            </p>
            <form action="{{ route('settings.delete') }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;
    
    // Check for saved dark mode preference or default to light mode
    const currentMode = localStorage.getItem('darkMode') || 'light';
    
    // Set initial state
    if (currentMode === 'dark') {
        html.classList.add('dark');
        darkModeToggle.checked = true;
    }
    
    // Toggle dark mode
    darkModeToggle.addEventListener('change', function() {
        if (this.checked) {
            html.classList.add('dark');
            localStorage.setItem('darkMode', 'dark');
        } else {
            html.classList.remove('dark');
            localStorage.setItem('darkMode', 'light');
        }
    });
</script>
@endsection
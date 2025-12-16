@extends('layouts.app')

@section('title', 'Settings - LifeHub')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Settings</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">Manage your account and preferences</p>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Information -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Profile Information</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Update your personal information</p>
        
        <div class="flex items-center mb-6">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mr-6">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                @else
                    {{ auth()->user()->initials }}
                @endif
            </div>
            <div>
                <form action="{{ route('settings.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="document.getElementById('avatarForm').submit()">
                    <button type="button" onclick="document.getElementById('avatarInput').click()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Change Avatar
                    </button>
                </form>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">JPG, PNG or GIF (max. 2MB)</p>
            </div>
        </div>

        <form action="{{ route('settings.profile') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? explode(' ', auth()->user()->name)[0] ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? (count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : '') ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Appearance -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Appearance</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Customize how LifeHub looks</p>
        
        <form action="{{ route('settings.appearance') }}" method="POST" id="appearanceForm">
            @csrf
            @method('PUT')
            
            <div class="flex items-center justify-between mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Dark Mode</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Switch between light and dark theme</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="dark_mode" value="1" {{ auth()->user()->dark_mode ? 'checked' : '' }} class="sr-only peer" onchange="toggleDarkMode(this)">
                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                <select name="currency" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="USD ($)" {{ auth()->user()->currency == 'USD ($)' ? 'selected' : '' }}>USD ($)</option>
                    <option value="EUR (€)" {{ auth()->user()->currency == 'EUR (€)' ? 'selected' : '' }}>EUR (€)</option>
                    <option value="GBP (£)" {{ auth()->user()->currency == 'GBP (£)' ? 'selected' : '' }}>GBP (£)</option>
                    <option value="PHP (₱)" {{ auth()->user()->currency == 'PHP (₱)' ? 'selected' : '' }}>PHP (₱)</option>
                </select>
            </div>
            
            <button type="submit" class="btn-primary"> Change Currency </button>
        </form>
    </div>

    <!-- Security -->
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Security</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Manage your password and security settings</p>
        
        <form action="{{ route('settings.password') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_password') border-red-500 @enderror">
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <button type="submit" class="btn-primary">Change Password</button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="card border-2 border-red-200 dark:border-red-800">
        <h2 class="text-xl font-bold text-red-600 dark:text-red-400 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Danger Zone
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Irreversible actions</p>
        
        <p class="text-gray-700 dark:text-gray-300 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
        
        <form action="{{ route('settings.delete') }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone. All your data including tasks, habits, and transactions will be permanently deleted.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                Delete Account
            </button>
        </form>
    </div>
</div>

<script>
function toggleDarkMode(checkbox) {
    // Toggle dark class on html element
    if (checkbox.checked) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'enabled');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'disabled');
    }
    
    // Submit the form
    checkbox.form.submit();
}

// Apply dark mode on page load based on user preference
document.addEventListener('DOMContentLoaded', function() {
    const darkModeEnabled = {{ auth()->user()->dark_mode ? 'true' : 'false' }};
    if (darkModeEnabled) {
        document.documentElement.classList.add('dark');
    }
});
</script>
@endsection
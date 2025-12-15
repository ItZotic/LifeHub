<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LifeHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-lg bg-blue-600 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">LifeHub</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1">
            <a href="/dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="/tasks" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('tasks*') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span>Tasks</span>
            </a>

            <a href="/habits" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('habits*') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Habits</span>
            </a>

            <a href="/expenses" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('expenses*') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span>Wallet</span>
            </a>

            <a href="/health" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('health') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span>Health</span>
            </a>

            <a href="/weather" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('weather') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
                <span>Weather</span>
            </a>

            <a href="/settings" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('settings*') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Settings</span>
            </a>
        </nav>

        <!-- User Section -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-2">
            <div class="flex items-center gap-3 px-4 py-3">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                @else
                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        @yield('content')
    </main>

    <script>
        // Initialize dark mode from localStorage
        if (localStorage.getItem('darkMode') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
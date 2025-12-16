<!DOCTYPE html>
<html lang="en" data-dark-mode="<?php echo e(auth()->check() && auth()->user()->dark_mode ? 'true' : 'false'); ?>" class="<?php echo e(auth()->check() && auth()->user()->dark_mode ? 'dark' : ''); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'LifeHub - Dashboard'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind to use dark mode with class strategy
        tailwind.config = {
            darkMode: 'class',
        }
        
        // Apply dark mode immediately to prevent flash
        if (localStorage.getItem('darkMode') === 'enabled' || 
            (document.documentElement.dataset.darkMode === 'true' && !localStorage.getItem('darkMode'))) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #374151;
            transition: all 0.2s;
        }
        .dark .sidebar-link {
            color: #D1D5DB;
        }
        .sidebar-link:hover {
            background-color: #EFF6FF;
            color: #2563EB;
        }
        .dark .sidebar-link:hover {
            background-color: #1E3A8A;
            color: #93C5FD;
        }
        .sidebar-link.active {
            background-color: #2563EB;
            color: white;
        }
        .sidebar-link.active:hover {
            background-color: #1D4ED8;
            color: white;
        }
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .dark .card {
            background-color: #1F2937;
            border: 1px solid #374151;
        }
        .btn-primary {
            background-color: #2563EB;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #1D4ED8;
        }
        .dark .btn-primary {
            background-color: #3B82F6;
        }
        .dark .btn-primary:hover {
            background-color: #2563EB;
        }
        .btn-secondary {
            background-color: #E5E7EB;
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }
        .btn-secondary:hover {
            background-color: #D1D5DB;
        }
        .dark .btn-secondary {
            background-color: #374151;
            color: #D1D5DB;
        }
        .dark .btn-secondary:hover {
            background-color: #4B5563;
        }
        .badge-high {
            background-color: #FEE2E2;
            color: #DC2626;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .dark .badge-high {
            background-color: #7F1D1D;
            color: #FCA5A5;
        }
        .badge-medium {
            background-color: #DBEAFE;
            color: #2563EB;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .dark .badge-medium {
            background-color: #1E3A8A;
            color: #93C5FD;
        }
        .badge-low {
            background-color: #F3F4F6;
            color: #4B5563;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .dark .badge-low {
            background-color: #374151;
            color: #9CA3AF;
        }
        
        /* Priority Badge Styles - Softer Colors */
        .priority-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        /* Low Priority - Soft Green */
        .priority-low {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .dark .priority-low {
            background-color: #1F4438;
            color: #A7F3D0;
        }

        /* Medium Priority - Soft Yellow/Amber */
        .priority-medium {
            background-color: #FEF3C7;
            color: #78350F;
        }
        .dark .priority-medium {
            background-color: #4D3F1A;
            color: #FDE68A;
        }

        /* High Priority - Soft Red/Pink */
        .priority-high {
            background-color: #FEE2E2;
            color: #7F1D1D;
        }
        .dark .priority-high {
            background-color: #4C2424;
            color: #FECACA;
        }
        
        /* Smooth transitions for dark mode */
        * {
            transition-property: background-color, border-color, color;
            transition-duration: 200ms;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg flex flex-col transition-colors duration-200">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-full flex items-center justify-center transition-colors duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">LifeHub</span>
                </div>
            </div>
            
            <nav class="flex-1 py-4">
                <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="<?php echo e(route('tasks.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('tasks.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Tasks
                </a>
                <a href="<?php echo e(route('habits.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('habits.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Habits
                </a>
                <a href="<?php echo e(route('wallet.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('wallet.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Wallet
                </a>
                <a href="<?php echo e(route('health.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('health.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Health
                </a>
                <a href="<?php echo e(route('weather.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('weather.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                    Weather
                </a>
                <a href="<?php echo e(route('settings.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
            </nav>
            
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-full flex items-center justify-center text-white font-bold transition-colors duration-200">
                        <?php if(auth()->user()->avatar): ?>
                            <img src="<?php echo e(Storage::url(auth()->user()->avatar)); ?>" alt="Avatar" class="w-full h-full rounded-full object-cover">
                        <?php else: ?>
                            <?php echo e(auth()->user()->initials); ?>

                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 dark:text-white"><?php echo e(auth()->user()->full_name); ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html><?php /**PATH C:\Users\ASUS\Desktop\WebSys_Final_Project\New folder (2)\resources\views/layouts/app.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Dashboard - LifeHub'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome back! Here's your daily overview.</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">Today</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo e(now()->format('l, M d, Y')); ?></p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tasks Completed</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($completedToday); ?>/<?php echo e($totalToday); ?></p>
            <p class="text-sm <?php echo e($taskPercentageChange >= 0 ? 'text-green-600' : 'text-red-600'); ?> mt-2">
                <?php echo e($taskPercentageChange >= 0 ? '+' : ''); ?><?php echo e(number_format($taskPercentageChange, 0)); ?>% from yesterday
            </p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">🔥</span>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Habit Streak</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($longestStreak); ?> Days</p>
            <p class="text-sm text-green-600 mt-2">Keep it up!</p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo e(auth()->user()->currency_symbol); ?></span>
                </div>
                <svg class="w-6 h-6 <?php echo e($expensePercentageChange >= 0 ? 'text-red-500' : 'text-green-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">This Week</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e(auth()->user()->formatCurrency($weekExpenses, 0)); ?></p>
            <p class="text-sm <?php echo e($expensePercentageChange <= 0 ? 'text-green-600' : 'text-red-600'); ?> mt-2">
                <?php echo e($expensePercentageChange >= 0 ? '+' : ''); ?><?php echo e(number_format($expensePercentageChange, 0)); ?>% from last week
            </p>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Goals Completed</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($goalsCompleted); ?>/<?php echo e($totalGoals); ?></p>
            <p class="text-sm text-green-600 mt-2"><?php echo e(number_format($goalsCompletionRate, 0)); ?>% completion rate</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Today's Tasks -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Today's Tasks
                    </h2>
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span>Progress</span>
                        <span><?php echo e($completedToday); ?> of <?php echo e($totalToday); ?> completed</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full" style="width: <?php echo e($totalToday > 0 ? ($completedToday / $totalToday) * 100 : 0); ?>%"></div>
                    </div>
                </div>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $todayTasks->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg <?php echo e($task->completed ? 'opacity-60' : ''); ?>">
                            <form action="<?php echo e(route('tasks.toggle', $task)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="mr-4">
                                    <div class="w-6 h-6 rounded-full border-2 <?php echo e($task->completed ? 'bg-blue-600 border-blue-600' : 'border-gray-400 dark:border-gray-600'); ?> flex items-center justify-center">
                                        <?php if($task->completed): ?>
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                </button>
                            </form>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white <?php echo e($task->completed ? 'line-through' : ''); ?>"><?php echo e($task->title); ?></p>
                                <?php if($task->description): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo e(Str::limit($task->description, 50)); ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="priority-badge priority-<?php echo e($task->priority); ?>"><?php echo e(ucfirst($task->priority)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No tasks for today. Great job!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Habit Streaks -->
            <div class="card mt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="text-2xl mr-2">🔥</span>
                    Habit Streaks
                </h2>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $habits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-4 rounded-lg dark:bg-gray-800/50" style="background-color: <?php echo e($habit->color); ?>20;">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4" style="background-color: <?php echo e($habit->color); ?>;">
                                    <span class="text-xl"><?php echo e($habit->icon); ?></span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white"><?php echo e($habit->name); ?></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($habit->current_streak); ?> day streak</p>
                                </div>
                            </div>
                            <?php if($habit->isCompletedToday()): ?>
                                <span class="text-green-600 font-semibold text-sm">Completed Today</span>
                            <?php else: ?>
                                <form action="<?php echo e(route('habits.complete', $habit)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:text-blue-700 dark:hover:text-blue-300">Mark Complete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No habits yet. Create one to get started!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Weekly Expenses -->
            <div class="card mt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="text-2xl mr-2"><?php echo e(auth()->user()->currency_symbol); ?></span>
                    Weekly Expenses
                </h2>
                <div class="text-center mb-6">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white"><?php echo e(auth()->user()->formatCurrency($weekExpenses)); ?></p>
                    <p class="text-gray-600 dark:text-gray-400">Total this week</p>
                </div>
                <div class="space-y-3">
                    <?php $__currentLoopData = $expensesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $percentage = $weekExpenses > 0 ? ($expense->total / $weekExpenses) * 100 : 0;
                            $colors = [
                                'Food' => 'blue',
                                'Transport' => 'green',
                                'Shopping' => 'yellow',
                                'Bills' => 'purple',
                                'Entertainment' => 'pink'
                            ];
                            $color = $colors[$expense->category] ?? 'gray';
                        ?>
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-700 dark:text-gray-300"><?php echo e($expense->category); ?></span>
                                <span class="font-semibold text-gray-900 dark:text-white"><?php echo e(auth()->user()->formatCurrency($expense->total)); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-<?php echo e($color); ?>-500 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(number_format($percentage, 0)); ?>%</p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Weather & Daily Motivation Sidebar -->
        <div>
            <!-- Weather Widget -->
            <div class="card mb-8 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <span class="text-2xl mr-2"><?php echo e($weatherData['current']['icon'] ?? '☁️'); ?></span>
                        Weather
                    </h2>
                    <a href="<?php echo e(route('weather.index')); ?>" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View Full</a>
                </div>
                <div class="text-center mb-4">
                    <p class="text-5xl font-bold text-gray-900 dark:text-white"><?php echo e($weatherData['current']['temp'] ?? 25); ?>°<span class="text-2xl"><?php echo e(strpos(auth()->user()->temperature_unit ?? '', 'Fahrenheit') !== false ? 'F' : 'C'); ?></span></p>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mt-2"><?php echo e($weatherData['current']['condition'] ?? 'Overcast clouds'); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <?php echo e(auth()->user()->weather_location ?? 'Batangas, PH'); ?>

                    </p>
                </div>
            </div>

            <!-- Daily Motivation -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="text-2xl mr-2">💡</span>
                    Daily Motivation
                </h2>
                <div class="text-5xl text-blue-200 dark:text-blue-800 mb-4">"</div>
                <p class="text-lg text-gray-800 dark:text-gray-200 italic mb-4">"<?php echo e($dailyQuote['text']); ?>"</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">— <?php echo e($dailyQuote['author']); ?></p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-4 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Quote of the day
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\WebSys_Final_Project\New folder (2)\resources\views/dashboard.blade.php ENDPATH**/ ?>
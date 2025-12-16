

<?php $__env->startSection('title', 'Health & Fitness - LifeHub'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Health & Fitness</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track your daily health metrics and progress</p>
        </div>
        <button onclick="document.getElementById('logActivityModal').classList.remove('hidden')" class="btn-primary">
            + Log Activity
        </button>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <!-- Steps -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($stepsStatus == 'Goal Met!' ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>">
                    <?php echo e($stepsStatus); ?>

                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Steps</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($todayMetric->steps)); ?></p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-3">
                <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($stepsProgress); ?>%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Goal: <?php echo e(number_format($stepsGoal)); ?></p>
        </div>

        <!-- Calories -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">🔥</span>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($caloriesStatus == 'Goal Met!' ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>">
                    <?php echo e($caloriesStatus); ?>

                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Calories Burned</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($todayMetric->calories)); ?></p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-3">
                <div class="bg-orange-500 h-2 rounded-full" style="width: <?php echo e($caloriesProgress); ?>%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Goal: <?php echo e(number_format($caloriesGoal)); ?></p>
        </div>

        <!-- Water -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">💧</span>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($waterStatus == 'Goal Met!' ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>">
                    <?php echo e($waterStatus); ?>

                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Water</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($todayMetric->water_glasses); ?>/<?php echo e($waterGoal); ?></p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-3">
                <div class="bg-cyan-500 h-2 rounded-full" style="width: <?php echo e($waterProgress); ?>%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Goal: 8 Glasses</p>
        </div>

        <!-- Sleep -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">🌙</span>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($sleepStatus == 'Well Rested' ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>">
                    <?php echo e($sleepStatus); ?>

                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Sleep</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($todayMetric->sleep_hours); ?>h</p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-3">
                <div class="bg-purple-500 h-2 rounded-full" style="width: <?php echo e($sleepProgress); ?>%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Goal: <?php echo e($sleepGoal); ?>h</p>
        </div>

        <!-- Heart Rate -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">❤️</span>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                    <?php echo e($heartRateStatus); ?>

                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Heart Rate</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($todayMetric->heart_rate); ?> <span class="text-base">bpm</span></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3"><?php echo e($heartRateStatus); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Weekly Activity Chart -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        ⚡ Weekly Activity
                    </h2>
                    <div class="flex space-x-2">
                        <button onclick="switchChart('steps')" id="btn-steps" class="px-3 py-1 text-sm font-medium bg-blue-600 text-white rounded-lg transition">Steps</button>
                        <button onclick="switchChart('heart')" id="btn-heart" class="px-3 py-1 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">Heart</button>
                        <button onclick="switchChart('sleep')" id="btn-sleep" class="px-3 py-1 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">Sleep</button>
                    </div>
                </div>
                
                <!-- Chart container -->
                <div style="height: 250px; max-height: 250px;">
                    <canvas id="healthChart"></canvas>
                </div>
            </div>

            <!-- Sleep Analysis -->
            <div class="card mt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    🌙 Sleep Analysis
                </h2>
                <div class="grid grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-indigo-100/50 dark:bg-indigo-900/20 rounded-xl">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($sleepBreakdown['total']); ?>h</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Sleep</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">8h vs average</p>
                    </div>
                    <div class="text-center p-4 bg-blue-100/50 dark:bg-blue-900/20 rounded-xl">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($sleepBreakdown['deep']); ?>h</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Deep Sleep</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">37% of total</p>
                    </div>
                    <div class="text-center p-4 bg-cyan-100/50 dark:bg-cyan-900/20 rounded-xl">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($sleepBreakdown['light']); ?>h</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Light Sleep</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">43% of total</p>
                    </div>
                    <div class="text-center p-4 bg-violet-100/50 dark:bg-violet-900/20 rounded-xl">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($sleepBreakdown['rem']); ?>h</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">REM Sleep</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">20% of total</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Minutes & Health Tip -->
        <div>
            <div class="card mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    ⚡ Active Minutes
                </h2>
                <div class="text-center mb-6">
                    <p class="text-6xl font-bold text-gray-900 dark:text-white"><?php echo e($todayMetric->active_minutes); ?></p>
                    <p class="text-gray-600 dark:text-gray-400">of 60 minutes</p>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-yellow-500 h-3 rounded-full" style="width: <?php echo e(min(100, ($todayMetric->active_minutes / 60) * 100)); ?>%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>0 min</span>
                    <span>60 min</span>
                </div>
            </div>

            <div class="card bg-green-50 dark:bg-green-900/20">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Health Tip</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            You're close to reaching your daily step goal! Take a short walk to complete it.
                        </p>
                        <p class="text-sm text-green-600 dark:text-green-400 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <?php echo e(number_format($stepsRemaining)); ?> steps to go
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Activity Modal -->
<div id="logActivityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Log Activity</h2>
            <button onclick="document.getElementById('logActivityModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?php echo e(route('health.log')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Steps</label>
                    <input type="number" name="steps" value="<?php echo e($todayMetric->steps); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Calories Burned</label>
                    <input type="number" name="calories" value="<?php echo e($todayMetric->calories); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Water (glasses)</label>
                    <input type="number" name="water_glasses" value="<?php echo e($todayMetric->water_glasses); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0" max="20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sleep (hours)</label>
                    <input type="number" name="sleep_hours" value="<?php echo e($todayMetric->sleep_hours); ?>" step="0.1" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0" max="24">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" value="<?php echo e($todayMetric->heart_rate); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0" max="250">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Active Minutes</label>
                    <input type="number" name="active_minutes" value="<?php echo e($todayMetric->active_minutes); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" min="0">
                </div>
            </div>

            <div class="flex space-x-4 mt-6">
                <button type="button" onclick="document.getElementById('logActivityModal').classList.add('hidden')" class="flex-1 btn-secondary">Cancel</button>
                <button type="submit" class="flex-1 btn-primary">Save Activity</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Get weekly metrics data from Laravel
    const weeklyMetricsRaw = <?php echo json_encode($weeklyMetrics, 15, 512) ?>;
    
    // Chart data
    const chartData = {
        steps: [],
        heart: [],
        sleep: []
    };
    
    // Goals
    const goals = {
        steps: <?php echo e($stepsGoal); ?>,
        sleep: <?php echo e($sleepGoal); ?>

    };
    
    // Day labels
    const dayLabels = [];
    
    // Extract data
    weeklyMetricsRaw.forEach((metric) => {
        dayLabels.push(metric.day_name);
        chartData.steps.push(parseInt(metric.steps) || 0);
        chartData.heart.push(parseInt(metric.heart_rate) || 0);
        chartData.sleep.push(parseFloat(metric.sleep_hours) || 0);
    });
    
    console.log('Chart Data:', chartData);
    console.log('Day Labels:', dayLabels);

    let currentChart = 'steps';
    let healthChart = null;

    // Initialize Chart
    const ctx = document.getElementById('healthChart');
    
    // Chart colors based on dark mode
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#D1D5DB' : '#374151';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    function createChart(type) {
        // Destroy existing chart
        if (healthChart) {
            healthChart.destroy();
        }

        // Chart configurations
        const configs = {
            steps: {
                type: 'bar',
                data: chartData.steps,
                color: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                label: 'Steps',
                goal: goals.steps
            },
            sleep: {
                type: 'bar',
                data: chartData.sleep,
                color: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.8)',
                label: 'Sleep (hours)',
                goal: goals.sleep
            },
            heart: {
                type: 'line',
                data: chartData.heart,
                color: '#EF4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                label: 'Heart Rate (bpm)',
                goal: null
            }
        };

        const config = configs[type];

        // Create chart based on type
        if (config.type === 'bar') {
            // Bar chart configuration
            healthChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dayLabels,
                    datasets: [{
                        label: config.label,
                        data: config.data,
                        backgroundColor: config.backgroundColor,
                        borderColor: config.color,
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return config.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: config.goal ? Math.max(...config.data, config.goal * 1.2) : undefined,
                            ticks: {
                                color: textColor,
                                maxTicksLimit: 6,
                                stepSize: type === 'steps' ? 2500 : undefined
                            },
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: gridColor
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: textColor
                            }
                        }
                    }
                },
                plugins: [{
                    id: 'goalLine',
                    afterDraw: (chart) => {
                        if (config.goal) {
                            const ctx = chart.ctx;
                            const yAxis = chart.scales.y;
                            const xAxis = chart.scales.x;
                            const goalY = yAxis.getPixelForValue(config.goal);

                            ctx.save();
                            ctx.beginPath();
                            ctx.setLineDash([5, 5]);
                            ctx.strokeStyle = isDark ? '#9CA3AF' : '#6B7280';
                            ctx.lineWidth = 2;
                            ctx.moveTo(xAxis.left, goalY);
                            ctx.lineTo(xAxis.right, goalY);
                            ctx.stroke();
                            ctx.restore();

                            // Goal label
                            ctx.fillStyle = isDark ? '#9CA3AF' : '#6B7280';
                            ctx.font = '12px sans-serif';
                            ctx.fillText('Goal: ' + config.goal, xAxis.right - 80, goalY - 5);
                        }
                    }
                }]
            });
        } else {
            // Line chart configuration (Heart Rate)
            healthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dayLabels,
                    datasets: [{
                        label: config.label,
                        data: config.data,
                        borderColor: config.color,
                        backgroundColor: config.backgroundColor,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: config.color,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return config.label + ': ' + context.parsed.y + ' bpm';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' bpm';
                                },
                                maxTicksLimit: 6,
                                color: textColor
                            },
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: gridColor
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 7,
                                color: textColor
                            }
                        }
                    }
                }
            });
        }
    }

    // Switch chart function
    function switchChart(type) {
        currentChart = type;
        
        // Update button styles
        ['steps', 'heart', 'sleep'].forEach(btn => {
            const element = document.getElementById('btn-' + btn);
            if (btn === type) {
                element.classList.remove('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
                element.classList.add('bg-blue-600', 'text-white');
            } else {
                element.classList.remove('bg-blue-600', 'text-white');
                element.classList.add('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
            }
        });
        
        // Create new chart
        createChart(type);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing health charts...');
        createChart('steps');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\WebSys_Final_Project\New folder (2)\resources\views/health.blade.php ENDPATH**/ ?>
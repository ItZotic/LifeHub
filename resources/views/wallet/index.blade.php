@extends('layouts.app')

@section('title', 'Wallet - LifeHub')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Expense Tracker</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track your spending and manage your budget</p>
        </div>
        <button onclick="document.getElementById('addTransactionModal').classList.remove('hidden')" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Transaction
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Expenses</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->formatCurrency($totalExpenses) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This week</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Income</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->formatCurrency($totalIncome) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This month</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center mr-4">
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->currency_symbol }}</span>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Balance</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->formatCurrency($balance) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Spending by Category -->
        <div class="card">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Spending by Category</h2>
            @if($categoryData->count() > 0)
                <div style="height: 250px; max-height: 250px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">No expense data yet</p>
            @endif
        </div>

        <!-- Weekly Spending Trend -->
        <div class="card">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Weekly Spending Trend</h2>
            <div style="height: 250px; max-height: 250px;">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Transaction History</h2>
            <div class="flex space-x-2">
                <a href="{{ route('wallet.index', ['filter' => 'all']) }}" class="px-3 py-1 rounded-lg text-sm {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">All</a>
                <a href="{{ route('wallet.index', ['filter' => 'expenses']) }}" class="px-3 py-1 rounded-lg text-sm {{ $filter === 'expenses' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">Expenses</a>
                <a href="{{ route('wallet.index', ['filter' => 'income']) }}" class="px-3 py-1 rounded-lg text-sm {{ $filter === 'income' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">Income</a>
            </div>
        </div>
        <div class="space-y-3">
            @forelse($transactions->take(10) as $transaction)
                <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 {{ $transaction->type === 'income' ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }} rounded-full flex items-center justify-center mr-4">
                            @if($transaction->type === 'income')
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $transaction->title }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->category }} • {{ $transaction->transaction_date->format('M d') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}{{ auth()->user()->formatCurrency($transaction->amount) }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">No transactions yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div id="addTransactionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add Transaction</h2>
            <button onclick="document.getElementById('addTransactionModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('wallet.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                <input type="text" name="title" required placeholder="e.g., Grocery Shopping" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount ({{ auth()->user()->currency_symbol }})</label>
                    <input type="number" name="amount" step="0.01" required placeholder="0.00" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                    <select name="type" id="transactionType" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select name="category" id="transactionCategory" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date</label>
                <input type="date" name="transaction_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 btn-primary">Add Transaction</button>
                <button type="button" onclick="document.getElementById('addTransactionModal').classList.add('hidden')" class="flex-1 btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Category management based on transaction type
const categories = {
    expense: ['Food', 'Transport', 'Shopping', 'Bills', 'Entertainment', 'Healthcare', 'Education', 'Other'],
    income: ['Salary', 'Allowance', 'Freelance', 'Investment', 'Gift', 'Business', 'Other']
};

function updateCategories() {
    const type = document.getElementById('transactionType').value;
    const categorySelect = document.getElementById('transactionCategory');
    categorySelect.innerHTML = '';
    
    categories[type].forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });
}

// Initialize categories on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCategories();
    
    // Update categories when type changes
    document.getElementById('transactionType').addEventListener('change', updateCategories);
    
    // Set default date to today
    const dateInput = document.querySelector('input[name="transaction_date"]');
    if (dateInput) {
        dateInput.valueAsDate = new Date();
    }
});

const currencySymbol = '{{ auth()->user()->currency_symbol }}';

// Pie Chart for Category Spending
@if($categoryData->count() > 0)
const categoryCtx = document.getElementById('categoryChart');
if (categoryCtx) {
    const categoryColors = ['#4F46E5', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#F43F5E'];
    const categoryLabels = [
        @foreach($categoryData as $cat)
            '{{ $cat->category }}',
        @endforeach
    ];
    const categoryValues = [
        @foreach($categoryData as $cat)
            {{ $cat->total }},
        @endforeach
    ];
    
    // Calculate percentages
    const total = categoryValues.reduce((a, b) => a + b, 0);
    const percentages = categoryValues.map(val => ((val / total) * 100).toFixed(0));
    
    new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: categoryLabels.map((label, i) => label + ' ' + percentages[i] + '%'),
            datasets: [{
                data: categoryValues,
                backgroundColor: categoryColors.slice(0, {{ $categoryData->count() }}),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        usePointStyle: false,
                        boxWidth: 15,
                        padding: 15,
                        font: {
                            size: 12
                        },
                        color: document.documentElement.classList.contains('dark') ? '#D1D5DB' : '#374151'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = categoryLabels[context.dataIndex] || '';
                            const value = context.parsed || 0;
                            const percentage = percentages[context.dataIndex];
                            return label + ': ' + currencySymbol + value.toFixed(2) + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
}
@endif

// Line Chart for Weekly Trend
const weeklyCtx = document.getElementById('weeklyChart');
if (weeklyCtx) {
    new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($weeklyTrend as $day)
                    '{{ $day['day'] }}',
                @endforeach
            ],
            datasets: [{
                label: 'Spending',
                data: [
                    @foreach($weeklyTrend as $day)
                        {{ $day['amount'] }},
                    @endforeach
                ],
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#2563EB',
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
                            return currencySymbol + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return currencySymbol + value;
                        },
                        maxTicksLimit: 6,
                        color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                    },
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7,
                        color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                    }
                }
            }
        }
    });
}
</script>
@endsection
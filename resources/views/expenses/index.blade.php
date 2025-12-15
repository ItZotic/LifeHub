@extends('layouts.app')

@section('title', 'Wallet - LifeHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Expense Tracker</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track your spending and manage your budget</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Transaction
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <!-- Total Expenses -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Expenses</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">₱{{ number_format($totalExpenses, 2) }}</p>
                <p class="text-xs text-red-500 mt-1">This week</p>
            </div>
        </div>

        <!-- Total Income -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Income</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">₱{{ number_format($totalIncome, 2) }}</p>
                <p class="text-xs text-green-500 mt-1">This month</p>
            </div>
        </div>

        <!-- Balance -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Balance</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">₱{{ number_format($balance, 2) }}</p>
                <p class="text-xs text-blue-500 mt-1">Current</p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid lg:grid-cols-2 gap-6 mb-6">
        <!-- Category Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Spending by Category</h3>
            <div style="height: 300px; position: relative;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Trend Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Weekly Spending Trend</h3>
            <div style="height: 300px; position: relative;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
        </div>
        
        <!-- Tabs -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <div class="flex px-6">
                <a href="{{ route('expenses.index', ['filter' => 'all']) }}" 
                   class="px-4 py-3 border-b-2 font-medium text-sm transition {{ $filter === 'all' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    All
                </a>
                <a href="{{ route('expenses.index', ['filter' => 'expenses']) }}" 
                   class="px-4 py-3 border-b-2 font-medium text-sm transition {{ $filter === 'expenses' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Expenses
                </a>
                <a href="{{ route('expenses.index', ['filter' => 'income']) }}" 
                   class="px-4 py-3 border-b-2 font-medium text-sm transition {{ $filter === 'income' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Income
                </a>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="p-6 space-y-3">
            @forelse($expenses as $expense)
                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-lg {{ $expense->type === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                            @if($expense->type === 'income')
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $expense->title }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded text-xs text-gray-700 dark:text-gray-300">
                                    {{ $expense->category }}
                                </span>
                                <span class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $expense->date->format('M d') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-lg font-semibold {{ $expense->type === 'income' ? 'text-green-500' : 'text-red-500' }}">
                            {{ $expense->type === 'income' ? '+' : '-' }}₱{{ number_format($expense->amount, 2) }}
                        </div>
                        <div class="flex gap-1">
                            <button onclick="openEditModal({{ $expense->id }}, '{{ $expense->title }}', '{{ $expense->amount }}', '{{ $expense->category }}', '{{ $expense->type }}', '{{ $expense->date->format('Y-m-d') }}')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400">No transactions yet. Add your first transaction to get started!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add Transaction</h2>
        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select name="type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select type</option>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" required placeholder="e.g., Grocery Shopping" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                <input type="number" name="amount" step="0.01" min="0" required placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <select name="category" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select category</option>
                    @foreach(\App\Models\Expense::getCategories() as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Add Transaction
                </button>
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Transaction Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Edit Transaction</h2>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select id="editType" name="type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" id="editTitle" name="title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                <input type="number" id="editAmount" name="amount" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <select id="editCategory" name="category" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach(\App\Models\Expense::getCategories() as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                <input type="date" id="editDate" name="date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Update Transaction
                </button>
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Modal functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    function openEditModal(id, title, amount, category, type, date) {
        document.getElementById('editForm').action = `/expenses/${id}`;
        document.getElementById('editTitle').value = title;
        document.getElementById('editAmount').value = amount;
        document.getElementById('editCategory').value = category;
        document.getElementById('editType').value = type;
        document.getElementById('editDate').value = date;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Category Chart
    const categoryData = @json($categoryData);
    if (categoryData.length > 0) {
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.name),
                datasets: [{
                    data: categoryData.map(item => item.value),
                    backgroundColor: categoryData.map(item => item.color),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Trend Chart
    const trendData = @json($trendData);
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: trendData.map(item => item.day),
            datasets: [{
                label: 'Spending',
                data: trendData.map(item => item.amount),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
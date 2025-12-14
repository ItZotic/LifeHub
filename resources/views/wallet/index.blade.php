@extends('layouts.app')

@section('title', 'Wallet - LifeHub')

@section('content')
<style>
    .header-with-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .add-btn {
        padding: 10px 20px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .stat-icon.red { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .stat-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .stat-label {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
    }
    .stat-period {
        font-size: 12px;
        color: #ef4444;
    }
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }
    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .category-item:last-child {
        border-bottom: none;
    }
    .category-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .category-name {
        font-weight: 600;
    }
    .category-bar {
        flex: 1;
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        margin-left: 12px;
    }
    .category-fill {
        height: 100%;
        background: var(--primary);
    }
    .category-amount {
        font-weight: 700;
        min-width: 80px;
        text-align: right;
    }
    .transactions-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        padding: 4px;
        background: #f9fafb;
        border-radius: 10px;
    }
    .filter-tab {
        flex: 1;
        padding: 8px 16px;
        border-radius: 8px;
        background: transparent;
        border: none;
        color: var(--muted);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        text-align: center;
    }
    .filter-tab.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .transaction-item {
        padding: 16px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.04);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .transaction-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .transaction-icon.expense {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    .transaction-icon.income {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }
    .transaction-info {
        flex: 1;
    }
    .transaction-title {
        font-weight: 600;
        margin-bottom: 4px;
    }
    .transaction-meta {
        font-size: 13px;
        color: var(--muted);
        display: flex;
        gap: 12px;
    }
    .transaction-amount {
        font-weight: 700;
        font-size: 16px;
    }
    .transaction-amount.expense {
        color: #ef4444;
    }
    .transaction-amount.income {
        color: #22c55e;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 32px;
        max-width: 500px;
        width: 90%;
    }
    .modal-header {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 24px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }
    .btn-secondary {
        padding: 12px 24px;
        border: 1px solid var(--border);
        background: white;
        color: var(--text);
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Expense Tracker</h1>
    <p class="page-subtitle">Track your spending and manage your budget</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 9.5L12 4.5 7 9.5M12 4.5v15"/>
            </svg>
        </div>
        <div class="stat-label">Total Expenses</div>
        <div class="stat-value">${{ number_format($totalExpenses, 2) }}</div>
        <div class="stat-period">This week</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 14.5l5 5 5-5M12 19.5v-15"/>
            </svg>
        </div>
        <div class="stat-label">Total Income</div>
        <div class="stat-value">${{ number_format($totalIncome, 2) }}</div>
        <div class="stat-period" style="color: #22c55e;">This month</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-label">Balance</div>
        <div class="stat-value">${{ number_format($balance, 2) }}</div>
        <div class="stat-period" style="color: var(--muted);">Current</div>
    </div>
</div>

<div class="content-grid">
    <div class="section">
        <h2 class="section-title">Spending by Category</h2>
        @forelse($categoriesWithPercentage as $category => $data)
        <div class="category-item">
            <div class="category-info">
                <span class="category-name">{{ ucfirst($category) }}</span>
                <div class="category-bar" style="width: 120px;">
                    <div class="category-fill" style="width: {{ $data['percentage'] }}%"></div>
                </div>
                <span style="font-size: 12px; color: var(--muted);">{{ $data['percentage'] }}%</span>
            </div>
            <div class="category-amount">${{ number_format($data['amount'], 2) }}</div>
        </div>
        @empty
        <p style="text-align: center; color: var(--muted); padding: 20px;">No expenses this week</p>
        @endforelse
    </div>

    <div class="section">
        <h2 class="section-title">Weekly Spending Trend</h2>
        <div style="height: 200px; display: flex; align-items: flex-end; gap: 8px;">
            @foreach($weeklyTrend as $day)
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                <div style="width: 100%; background: var(--primary); border-radius: 6px 6px 0 0; transition: all 0.3s; min-height: 20px;"
                     data-height="{{ $day['amount'] > 0 ? ($day['amount'] / max(array_column($weeklyTrend, 'amount')) * 150) : 0 }}"
                     style="height: {{ $day['amount'] > 0 ? ($day['amount'] / max(array_column($weeklyTrend, 'amount')) * 150) : 20 }}px;"></div>
                <div style="margin-top: 8px; font-size: 12px; color: var(--muted); font-weight: 600;">{{ $day['day'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="transactions-section">
    <div class="header-with-button">
        <h2 class="section-title" style="margin: 0;">Recent Transactions</h2>
        <button class="add-btn" onclick="openModal()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Expense
        </button>
    </div>

    <div class="filter-tabs">
        <a href="{{ route('wallet.index', ['filter' => 'all']) }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('wallet.index', ['filter' => 'expenses']) }}" class="filter-tab {{ $filter === 'expenses' ? 'active' : '' }}">Expenses</a>
        <a href="{{ route('wallet.index', ['filter' => 'income']) }}" class="filter-tab {{ $filter === 'income' ? 'active' : '' }}">Income</a>
    </div>

    <div class="transaction-list">
        @forelse($transactions as $transaction)
        <div class="transaction-item">
            <div class="transaction-icon {{ $transaction->type }}">
                @if($transaction->type === 'expense')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 9.5L12 4.5 7 9.5M12 4.5v15"/>
                </svg>
                @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 14.5l5 5 5-5M12 19.5v-15"/>
                </svg>
                @endif
            </div>
            <div class="transaction-info">
                <div class="transaction-title">{{ $transaction->title }}</div>
                <div class="transaction-meta">
                    <span>{{ ucfirst($transaction->category) }}</span>
                    <span>📅 {{ $transaction->transaction_date->format('M d') }}</span>
                </div>
            </div>
            <div class="transaction-amount {{ $transaction->type }}">
                {{ $transaction->formatted_amount }}
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px; color: var(--muted);">
            <div style="font-size: 48px; margin-bottom: 12px;">💰</div>
            <p>No transactions yet. Add your first transaction!</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal" id="transactionModal">
    <div class="modal-content">
        <h2 class="modal-header">Add Transaction</h2>
        <form method="POST" action="{{ route('wallet.transactions.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Type</label>
                <select name="type" class="form-select" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-input" required placeholder="e.g., Grocery Shopping">
            </div>
            <div class="form-group">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-input" step="0.01" required placeholder="0.00">
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="food">Food</option>
                    <option value="transport">Transport</option>
                    <option value="shopping">Shopping</option>
                    <option value="bills">Bills</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="health">Health</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date</label>
                <input type="date" name="transaction_date" class="form-input" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="form-textarea" rows="3" placeholder="Add any additional notes"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="add-btn" style="flex: 1;">Add Transaction</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('transactionModal').classList.add('active');
}

function closeModal() {
    document.getElementById('transactionModal').classList.remove('active');
}

document.getElementById('transactionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
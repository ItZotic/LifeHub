@extends('layouts.app')

@section('title', 'Dashboard - LifeHub')

@section('content')
<style>
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
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .stat-icon.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
    .stat-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .stat-icon.purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
    .stat-content {
        flex: 1;
    }
    .stat-label {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .stat-change {
        font-size: 13px;
        font-weight: 600;
    }
    .stat-change.positive { color: #22c55e; }
    .stat-change.negative { color: #ef4444; }
    .stat-change.neutral { color: var(--muted); }
    .content-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .task-item {
        padding: 16px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.05);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .task-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid var(--primary);
        border-radius: 6px;
        flex-shrink: 0;
    }
    .task-checkbox.checked {
        background: var(--primary);
        position: relative;
    }
    .task-info {
        flex: 1;
    }
    .task-title {
        font-weight: 600;
        margin-bottom: 2px;
    }
    .task-title.completed {
        text-decoration: line-through;
        color: var(--muted);
    }
    .task-meta {
        font-size: 13px;
        color: var(--muted);
        display: flex;
        gap: 12px;
    }
    .priority-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    .priority-badge.high { background: #fee2e2; color: #991b1b; }
    .priority-badge.medium { background: #dbeafe; color: #1e40af; }
    .priority-badge.low { background: #fef3c7; color: #92400e; }
    .progress-bar {
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }
    .progress-fill {
        height: 100%;
        background: var(--primary);
        transition: width 0.3s;
    }
    .progress-label {
        font-size: 13px;
        color: var(--muted);
        text-align: right;
    }
    .habit-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    .habit-card {
        padding: 16px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.05);
        border: 2px solid transparent;
    }
    .habit-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .habit-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: white;
    }
    .habit-name {
        font-weight: 600;
        font-size: 14px;
    }
    .habit-streak {
        font-size: 12px;
        color: var(--muted);
    }
    .weather-widget {
        text-align: center;
    }
    .weather-icon {
        font-size: 64px;
        margin-bottom: 12px;
    }
    .weather-temp {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .weather-condition {
        color: var(--muted);
        margin-bottom: 8px;
    }
    .weather-location {
        font-size: 13px;
        color: var(--muted);
    }
    .weather-details {
        display: flex;
        justify-content: space-around;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border);
    }
    .weather-detail {
        text-align: center;
    }
    .weather-detail-label {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 4px;
    }
    .weather-detail-value {
        font-weight: 600;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Welcome back! Here's your daily overview.</p>
    <div style="text-align: right; margin-top: -40px; color: var(--muted); font-size: 14px;">
        <div style="font-weight: 600;">Today</div>
        <div>{{ now()->format('l, M d, Y') }}</div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 11 12 14 22 4"/>
                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Tasks Completed</div>
            <div class="stat-value">{{ $tasksCompleted }}/{{ $totalTasks }}</div>
            <div class="stat-change positive">+12% from yesterday</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Habit Streak</div>
            <div class="stat-value">{{ $longestStreak }} Days</div>
            <div class="stat-change neutral">Keep it up!</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">This Week</div>
            <div class="stat-value">${{ number_format($weekExpenses, 2) }}</div>
            <div class="stat-change negative">+8% from last week</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Goals Progress</div>
            <div class="stat-value">{{ $goalsProgress }}%</div>
            <div class="stat-change positive">{{ $completedGoals }} of {{ $goals->count() }} completed</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <div>
        <div class="content-section">
            <div class="section-header">
                <div class="section-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"/>
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                    </svg>
                </div>
                <h2 class="section-title">Today's Tasks</h2>
            </div>

            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $totalTasks > 0 ? ($tasksCompleted / $totalTasks * 100) : 0 }}%"></div>
            </div>
            <div class="progress-label">{{ $tasksCompleted }} of {{ $totalTasks }} completed</div>

            <div class="task-list" style="margin-top: 20px;">
                @forelse($todayTasks as $task)
                <div class="task-item">
                    <div class="task-checkbox {{ $task->completed ? 'checked' : '' }}"></div>
                    <div class="task-info">
                        <div class="task-title {{ $task->completed ? 'completed' : '' }}">{{ $task->title }}</div>
                        <div class="task-meta">
                            <span>📁 {{ ucfirst($task->category) }}</span>
                            <span>📅 {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No date' }}</span>
                        </div>
                    </div>
                    <span class="priority-badge {{ $task->priority }}">{{ $task->priority }}</span>
                </div>
                @empty
                <p style="text-align: center; color: var(--muted); padding: 20px;">No tasks for today. Great job!</p>
                @endforelse
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <div class="section-icon" style="background: rgba(249, 115, 22, 0.1); color: #f97316;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/>
                    </svg>
                </div>
                <h2 class="section-title">Habit Streaks</h2>
            </div>

            <div class="habit-list">
                @forelse($topHabits as $habit)
                <div class="habit-card">
                    <div class="habit-header">
                        <div class="habit-icon">🔥</div>
                        <div>
                            <div class="habit-name">{{ $habit->name }}</div>
                            <div class="habit-streak">{{ $habit->current_streak }} day streak</div>
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: var(--muted); padding: 20px;">No habits tracked yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div>
        <div class="content-section">
            <div class="section-header">
                <div class="section-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 10h-1.26A8 8 0 109 20h9a5 5 0 000-10z"/>
                    </svg>
                </div>
                <h2 class="section-title">Weather</h2>
            </div>

            <div class="weather-widget">
                <div class="weather-icon">☀️</div>
                <div class="weather-temp">72°F</div>
                <div class="weather-condition">Sunny</div>
                <div class="weather-location">San Francisco, CA</div>
                
                <div class="weather-details">
                    <div class="weather-detail">
                        <div class="weather-detail-label">High</div>
                        <div class="weather-detail-value">78°F</div>
                    </div>
                    <div class="weather-detail">
                        <div class="weather-detail-label">Low</div>
                        <div class="weather-detail-value">65°F</div>
                    </div>
                    <div class="weather-detail">
                        <div class="weather-detail-label">Humidity</div>
                        <div class="weather-detail-value">45%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <div class="section-icon" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h2 class="section-title">Daily Motivation</h2>
            </div>

            <div style="text-align: center; padding: 20px;">
                <div style="font-size: 48px; margin-bottom: 16px;">💬</div>
                <p style="font-style: italic; font-size: 16px; line-height: 1.6; margin-bottom: 12px;">
                    "The secret of getting ahead is getting started."
                </p>
                <p style="color: var(--muted); font-size: 14px;">— Mark Twain</p>
            </div>
        </div>
    </div>
</div>
@endsection
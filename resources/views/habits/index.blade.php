@extends('layouts.app')

@section('title', 'Habits - LifeHub')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-icon.orange { background: rgba(249, 115, 22, 0.1); }
    .stat-icon.green { background: rgba(34, 197, 94, 0.1); }
    .stat-icon.blue { background: rgba(59, 130, 246, 0.1); }
    .stat-label {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 700;
    }
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
        transition: all 0.2s;
    }
    .add-btn:hover {
        background: #316bce;
    }
    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .progress-bar-container {
        margin-bottom: 16px;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .progress-bar {
        height: 10px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), #60a5fa);
    }
    .habit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 16px;
    }
    .habit-card {
        background: white;
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.2s;
    }
    .habit-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    .habit-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .habit-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .habit-info {
        flex: 1;
    }
    .habit-name {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
    }
    .habit-streak {
        font-size: 13px;
        color: var(--muted);
    }
    .habit-streak.active {
        color: #f97316;
        font-weight: 600;
    }
    .week-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }
    .day-cell {
        aspect-ratio: 1;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--border);
        font-size: 12px;
    }
    .day-cell.completed {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    .day-cell .day-icon {
        font-size: 16px;
    }
    .complete-btn {
        width: 100%;
        padding: 10px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .complete-btn:hover {
        background: #316bce;
    }
    .complete-btn:disabled {
        background: #e5e7eb;
        color: var(--muted);
        cursor: not-allowed;
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
    .form-input, .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
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
    <h1 class="page-title">Habit Tracker</h1>
    <p class="page-subtitle">{{ $completedToday }} of {{ $totalHabits }} habits completed today</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange">🔥</div>
        <div class="stat-label">Longest Streak</div>
        <div class="stat-value">{{ $longestStreak }} Days</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✓</div>
        <div class="stat-label">Today's Progress</div>
        <div class="stat-value">{{ $completedToday }}/{{ $totalHabits }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">📈</div>
        <div class="stat-label">Completion Rate</div>
        <div class="stat-value">{{ $completionRate }}%</div>
    </div>
</div>

<div class="section">
    <div class="progress-bar-container">
        <div class="progress-label">
            <span class="section-title" style="margin: 0;">Daily Goal</span>
            <span style="color: var(--muted);">{{ $completedToday }} of {{ $totalHabits }} completed</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $totalHabits > 0 ? ($completedToday / $totalHabits * 100) : 0 }}%"></div>
        </div>
    </div>
</div>

<div class="header-with-button">
    <h2 class="section-title" style="margin: 0;">Weekly Overview</h2>
    <button class="add-btn" onclick="openModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Habit
    </button>
</div>

<div class="habit-grid">
    @forelse($habits as $habit)
    <div class="habit-card">
        <div class="habit-header">
            <div class="habit-icon">
                {{ $habit->icon === 'target' ? '🎯' : '⭐' }}
            </div>
            <div class="habit-info">
                <div class="habit-name">{{ $habit->name }}</div>
                <div class="habit-streak {{ $habit->current_streak > 0 ? 'active' : '' }}">
                    🔥 {{ $habit->current_streak }} day streak
                </div>
            </div>
        </div>
        
        <div class="week-grid">
            @foreach($habit->getWeeklyCompletions() as $day)
            <div class="day-cell {{ $day['completed'] ? 'completed' : '' }}">
                <div class="day-icon">{{ $day['completed'] ? '✓' : '○' }}</div>
                <div style="font-size: 10px; margin-top: 2px;">{{ $day['day'] }}</div>
            </div>
            @endforeach
        </div>
        
        <button 
            class="complete-btn" 
            onclick="completeHabit({{ $habit->id }})"
            {{ $habit->isCompletedToday() ? 'disabled' : '' }}
        >
            {{ $habit->isCompletedToday() ? 'Completed Today' : 'Mark Complete' }}
        </button>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: var(--muted);">
        <div style="font-size: 64px; margin-bottom: 16px;">🎯</div>
        <h3>No habits yet</h3>
        <p>Create your first habit to start tracking!</p>
    </div>
    @endforelse
</div>

<!-- Add Habit Modal -->
<div class="modal" id="habitModal">
    <div class="modal-content">
        <h2 class="modal-header">Add New Habit</h2>
        <form method="POST" action="{{ route('habits.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Habit Name</label>
                <input type="text" name="name" class="form-input" required placeholder="e.g., Morning Exercise">
            </div>
            <div class="form-group">
                <label class="form-label">Icon</label>
                <select name="icon" class="form-select">
                    <option value="target">🎯 Target</option>
                    <option value="fire">🔥 Fire</option>
                    <option value="star">⭐ Star</option>
                    <option value="check">✓ Check</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Color</label>
                <select name="color" class="form-select">
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Purple</option>
                    <option value="red">Red</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="add-btn" style="flex: 1;">Create Habit</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('habitModal').classList.add('active');
}

function closeModal() {
    document.getElementById('habitModal').classList.remove('active');
}

function completeHabit(habitId) {
    fetch(`/habits/${habitId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

document.getElementById('habitModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
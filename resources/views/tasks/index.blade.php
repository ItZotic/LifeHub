@extends('layouts.app')

@section('title', 'Tasks - LifeHub')

@section('content')
<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
    }
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-left: auto;
        margin-right: 16px;
    }
    .filter-tab {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: white;
        color: var(--muted);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .filter-tab.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
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
    .progress-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .progress-title {
        font-weight: 600;
        font-size: 16px;
    }
    .progress-count {
        color: var(--muted);
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
        transition: width 0.3s;
    }
    .tasks-container {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
    }
    .task-item {
        padding: 20px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.04);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s;
        cursor: pointer;
    }
    .task-item:hover {
        background: rgba(59, 130, 246, 0.08);
    }
    .task-item.completed {
        opacity: 0.6;
    }
    .task-checkbox {
        width: 24px;
        height: 24px;
        border: 2px solid var(--primary);
        border-radius: 8px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .task-checkbox.checked {
        background: var(--primary);
    }
    .task-info {
        flex: 1;
    }
    .task-title {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 4px;
    }
    .task-title.completed {
        text-decoration: line-through;
        color: var(--muted);
    }
    .task-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: var(--muted);
    }
    .task-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .priority-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-transform: lowercase;
    }
    .priority-badge.high { background: #fee2e2; color: #991b1b; }
    .priority-badge.medium { background: #dbeafe; color: #1e40af; }
    .priority-badge.low { background: #fef3c7; color: #92400e; }
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
    .form-textarea {
        resize: vertical;
        min-height: 100px;
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
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--muted);
    }
    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 16px;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Tasks</h1>
    <p class="page-subtitle">{{ $completedCount }} of {{ $totalCount }} tasks completed</p>
</div>

<div class="header-actions">
    <div class="search-box">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" placeholder="Search tasks..." id="searchInput">
    </div>
    
    <div class="filter-tabs">
        <a href="{{ route('tasks.index', ['filter' => 'all']) }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('tasks.index', ['filter' => 'today']) }}" class="filter-tab {{ $filter === 'today' ? 'active' : '' }}">Today</a>
        <a href="{{ route('tasks.index', ['filter' => 'upcoming']) }}" class="filter-tab {{ $filter === 'upcoming' ? 'active' : '' }}">Upcoming</a>
        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="filter-tab {{ $filter === 'completed' ? 'active' : '' }}">Completed</a>
    </div>
    
    <button class="add-btn" onclick="openModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Task
    </button>
</div>

<div class="progress-section">
    <div class="progress-header">
        <span class="progress-title">Overall Progress</span>
        <span class="progress-count">{{ $completedCount }}/{{ $totalCount }} completed</span>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ $totalCount > 0 ? ($completedCount / $totalCount * 100) : 0 }}%"></div>
    </div>
</div>

<div class="tasks-container">
    @forelse($tasks as $task)
    <div class="task-item {{ $task->completed ? 'completed' : '' }}" data-task-id="{{ $task->id }}">
        <div class="task-checkbox {{ $task->completed ? 'checked' : '' }}" onclick="toggleTask({{ $task->id }})">
            @if($task->completed)
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            @endif
        </div>
        <div class="task-info">
            <div class="task-title {{ $task->completed ? 'completed' : '' }}">{{ $task->title }}</div>
            <div class="task-meta">
                <span class="task-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No date' }}
                </span>
                <span class="task-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                    </svg>
                    {{ ucfirst($task->category) }}
                </span>
            </div>
        </div>
        <span class="priority-badge {{ $task->priority }}">{{ $task->priority }}</span>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon">📝</div>
        <h3>No tasks found</h3>
        <p>Create your first task to get started!</p>
    </div>
    @endforelse
</div>

<!-- Add Task Modal -->
<div class="modal" id="taskModal">
    <div class="modal-content">
        <h2 class="modal-header">Add New Task</h2>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Task Title</label>
                <input type="text" name="title" class="form-input" required placeholder="Enter task title">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea" placeholder="Add details about this task"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="work">Work</option>
                    <option value="personal">Personal</option>
                    <option value="development">Development</option>
                    <option value="health">Health</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select" required>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-input">
            </div>
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="add-btn" style="flex: 1;">Create Task</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('taskModal').classList.add('active');
}

function closeModal() {
    document.getElementById('taskModal').classList.remove('active');
}

function toggleTask(taskId) {
    fetch(`/tasks/${taskId}/toggle`, {
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
        }
    });
}

// Close modal on outside click
document.getElementById('taskModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
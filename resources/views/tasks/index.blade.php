@extends('layouts.app')

@section('title', 'Tasks - LifeHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tasks</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ $completedCount }} of {{ $totalCount }} tasks completed
            </p>
        </div>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Task
        </button>
    </div>

    <!-- Filters and Search -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search tasks..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>
            <div class="flex gap-2">
                <button type="submit" name="filter" value="all" class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    All
                </button>
                <button type="submit" name="filter" value="today" class="px-4 py-2 rounded-lg {{ $filter === 'today' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    Today
                </button>
                <button type="submit" name="filter" value="upcoming" class="px-4 py-2 rounded-lg {{ $filter === 'upcoming' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    Upcoming
                </button>
                <button type="submit" name="filter" value="completed" class="px-4 py-2 rounded-lg {{ $filter === 'completed' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    Completed
                </button>
            </div>
        </div>
    </form>

    <!-- Progress Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-gray-900 dark:text-white font-medium">Overall Progress</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">
                {{ $completedCount }}/{{ $totalCount }} completed
            </span>
        </div>
        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div
                class="h-full bg-blue-600 transition-all duration-300"
                style="width: {{ $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0 }}%"
            ></div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="space-y-3">
        @forelse($tasks as $task)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-all border border-gray-200 dark:border-gray-700 p-6 {{ $task->completed ? 'bg-gray-50 dark:bg-gray-700/50' : '' }}">
                <div class="flex items-start gap-4">
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="mt-1">
                            @if($task->completed)
                                <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                </svg>
                            @endif
                        </button>
                    </form>
                    
                    <div class="flex-1 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="font-semibold {{ $task->completed ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                {{ $task->title }}
                            </h3>
                            <span class="px-2 py-1 text-xs font-medium rounded 
                                {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 
                                   ($task->priority === 'medium' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-sm {{ $task->completed ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $task->description }}
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                {{ $task->category }}
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $task->deadline->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-12 text-center">
                <p class="text-gray-600 dark:text-gray-400">No tasks found. Try adjusting your filters or add a new task.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal -->
<div id="taskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add New Task</h2>
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select name="category" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select category</option>
                        <option value="Work">Work</option>
                        <option value="Personal">Personal</option>
                        <option value="Development">Development</option>
                        <option value="Health">Health</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    <select name="priority" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                <input type="date" name="deadline" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create Task
                </button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('taskModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('taskModal').classList.add('hidden');
    }
</script>
@endsection
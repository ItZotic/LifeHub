@extends('layouts.app')

@section('title', 'Tasks - LifeHub')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tasks</h1>
            <p class="text-gray-600 mt-1">{{ $completed }} of {{ $total }} tasks completed</p>
        </div>
        <button onclick="document.getElementById('addTaskModal').classList.remove('hidden')" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Task
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 mr-4">
                <input type="text" placeholder="Search tasks..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.index', ['filter' => 'all']) }}" class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
                <a href="{{ route('tasks.index', ['filter' => 'today']) }}" class="px-4 py-2 rounded-lg {{ $filter === 'today' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Today</a>
                <a href="{{ route('tasks.index', ['filter' => 'upcoming']) }}" class="px-4 py-2 rounded-lg {{ $filter === 'upcoming' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Upcoming</a>
                <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="px-4 py-2 rounded-lg {{ $filter === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Completed</a>
            </div>
        </div>
    </div>

    <!-- Overall Progress -->
    <div class="card mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-600">Overall Progress</span>
            <span class="text-sm font-semibold text-gray-900">{{ $completed }}/{{ $total }} completed</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $total > 0 ? ($completed / $total) * 100 : 0 }}%"></div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse($tasks as $task)
            <div class="card {{ $task->completed ? 'opacity-60' : '' }}">
                <div class="flex items-start">
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="mr-4 mt-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <div class="w-6 h-6 rounded-full border-2 {{ $task->completed ? 'bg-blue-600 border-blue-600' : 'border-gray-400' }} flex items-center justify-center">
                                @if($task->completed)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                        </button>
                    </form>
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900 {{ $task->completed ? 'line-through' : '' }}">{{ $task->title }}</h3>
                            <span class="badge-{{ $task->priority }}">{{ $task->priority }}</span>
                        </div>
                        @if($task->description)
                            <p class="text-gray-600 mb-3 {{ $task->completed ? 'line-through' : '' }}">{{ $task->description }}</p>
                        @endif
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $task->category }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $task->due_date->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 ml-4">
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 text-lg">No tasks found</p>
                <p class="text-gray-400 mt-2">Create your first task to get started!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Task Modal -->
<div id="addTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Add New Task</h2>
            <button onclick="document.getElementById('addTaskModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Work">Work</option>
                        <option value="Personal">Personal</option>
                        <option value="Development">Development</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                    <select name="priority" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                <input type="date" name="due_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 btn-primary">Add Task</button>
                <button type="button" onclick="document.getElementById('addTaskModal').classList.add('hidden')" class="flex-1 btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
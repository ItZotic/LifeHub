<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());
        
        $filter = $request->get('filter', 'all');
        
        switch ($filter) {
            case 'today':
                $query->today();
                break;
            case 'upcoming':
                $query->upcoming();
                break;
            case 'completed':
                $query->completed();
                break;
        }
        
        $tasks = $query->orderBy('due_date', 'asc')->get();
        $completed = Task::where('user_id', auth()->id())->where('completed', true)->count();
        $total = Task::where('user_id', auth()->id())->count();
        
        return view('tasks.index', compact('tasks', 'completed', 'total', 'filter'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]);
        
        Task::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }
    
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]);
        
        $task->update($validated);
        
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }
    
    public function toggleComplete(Task $task)
    {
        $this->authorize('update', $task);
        
        $task->update([
            'completed' => !$task->completed,
            'completed_at' => $task->completed ? null : now()
        ]);
        
        return back();
    }
    
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $task->delete();
        
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
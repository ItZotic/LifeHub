<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // ← ADD THIS IMPORT

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::where('user_id', $user->id);  // ← Keep this
        
        // ❌ REMOVE THIS LINE - it overwrites the user filter!
        // $query = Task::query(); 
        
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
        
        if ($search = $request->get('search')) {
            $query->search($search);
        }
        
        $tasks = $query->orderBy('deadline', 'asc')->get();
        
        // ← ADD user_id filter to counts
        $completedCount = Task::where('user_id', $user->id)
            ->where('completed', true)
            ->count();
        $totalCount = Task::where('user_id', $user->id)->count();
        
        return view('tasks.index', compact('tasks', 'completedCount', 'totalCount', 'filter', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'required|date'
        ]);

        $validated['user_id'] = Auth::id();  // ← ADD THIS LINE

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function toggle(Task $task)
    {
        // ← ADD authorization check
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $task->update(['completed' => !$task->completed]);
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        // ← ADD authorization check
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
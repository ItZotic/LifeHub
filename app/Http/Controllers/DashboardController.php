<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalTasks = Task::where('user_id', $user->id)->count();
        $completedTasks = Task::where('user_id', $user->id)
            ->where('completed', true)
            ->count();
        $totalExpenses = Expense::where('user_id', $user->id)->count();
        
        return view('dashboard', compact('totalTasks', 'completedTasks', 'totalExpenses'));
    }
}
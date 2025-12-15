<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get filter from request
        $filter = $request->get('filter', 'all');
        
        // Base query for user's expenses
        $query = Expense::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Apply filters
        if ($filter === 'expenses') {
            $query->expenses();
        } elseif ($filter === 'income') {
            $query->income();
        }
        
        $expenses = $query->get();
        
        // Calculate totals
        $totalExpenses = Expense::where('user_id', $user->id)
            ->expenses()
            ->thisWeek()
            ->sum('amount');
        
        $totalIncome = Expense::where('user_id', $user->id)
            ->income()
            ->thisMonth()
            ->sum('amount');
        
        $balance = $totalIncome - Expense::where('user_id', $user->id)
            ->expenses()
            ->thisMonth()
            ->sum('amount');
        
        // Category breakdown data
        $categoryData = Expense::where('user_id', $user->id)
            ->expenses()
            ->thisMonth()
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $colors = Expense::getCategoryColors();
                return [
                    'name' => $item->category,
                    'value' => (float) $item->total,
                    'color' => $colors[$item->category] ?? '#6B7280'
                ];
            });
        
        // Weekly trend data
        $trendData = [];
        $startOfWeek = now()->startOfWeek();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $amount = Expense::where('user_id', $user->id)
                ->expenses()
                ->whereDate('date', $date)
                ->sum('amount');
            
            $trendData[] = [
                'day' => $date->format('D'),
                'amount' => (float) $amount
            ];
        }
        
        return view('expenses.index', compact(
            'expenses',
            'totalExpenses',
            'totalIncome',
            'balance',
            'categoryData',
            'trendData',
            'filter'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction added successfully!');
    }

    public function update(Request $request, Expense $expense)
    {
        // Ensure user owns this expense
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        // Ensure user owns this expense
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WalletController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Transaction::where('user_id', auth()->id());
        
        if ($filter === 'expenses') {
            $query->expenses();
        } elseif ($filter === 'income') {
            $query->income();
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        
        // Calculate totals
        $totalExpenses = Transaction::where('user_id', auth()->id())
            ->expenses()
            ->thisWeek()
            ->sum('amount');
        
        $totalIncome = Transaction::where('user_id', auth()->id())
            ->income()
            ->thisMonth()
            ->sum('amount');
        
        $allExpenses = Transaction::where('user_id', auth()->id())
            ->expenses()
            ->sum('amount');
        
        $allIncome = Transaction::where('user_id', auth()->id())
            ->income()
            ->sum('amount');
        
        $balance = $allIncome - $allExpenses;
        
        // Category breakdown
        $categoryData = Transaction::where('user_id', auth()->id())
            ->expenses()
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();
        
        $categoryTotal = $categoryData->sum('total');
        
        // Weekly spending trend
        $weeklyTrend = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $amount = Transaction::where('user_id', auth()->id())
                ->expenses()
                ->whereDate('transaction_date', $date)
                ->sum('amount');
            $weeklyTrend[] = [
                'day' => $date->format('D'),
                'amount' => $amount
            ];
        }
        
        return view('wallet.index', compact(
            'transactions', 
            'totalExpenses', 
            'totalIncome', 
            'balance',
            'categoryData',
            'categoryTotal',
            'weeklyTrend',
            'filter'
        ));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'transaction_date' => 'required|date',
        ]);
        
        Transaction::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);
        
        return redirect()->route('wallet.index')->with('success', 'Transaction added successfully!');
    }
    
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
        $transaction->delete();
        
        return redirect()->route('wallet.index')->with('success', 'Transaction deleted successfully!');
    }
}
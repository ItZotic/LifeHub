<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Transaction::where('user_id', Auth::id());

        switch ($filter) {
            case 'expenses':
                $query->expenses();
                break;
            case 'income':
                $query->income();
                break;
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        $totalExpenses = Transaction::where('user_id', Auth::id())
            ->expenses()
            ->thisWeek()
            ->sum('amount');

        $totalIncome = Transaction::where('user_id', Auth::id())
            ->income()
            ->thisMonth()
            ->sum('amount');

        $balance = Transaction::where('user_id', Auth::id())->get()->sum(function ($transaction) {
            return $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
        });

        // Spending by category
        $spendingByCategory = Transaction::where('user_id', Auth::id())
            ->expenses()
            ->thisWeek()
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->category => $item->total];
            });

        $totalSpending = $spendingByCategory->sum();
        $categoriesWithPercentage = $spendingByCategory->map(function ($amount) use ($totalSpending) {
            return [
                'amount' => $amount,
                'percentage' => $totalSpending > 0 ? round(($amount / $totalSpending) * 100) : 0,
            ];
        });

        // Weekly spending trend
        $weeklyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $amount = Transaction::where('user_id', Auth::id())
                ->expenses()
                ->whereDate('transaction_date', $date)
                ->sum('amount');
            
            $weeklyTrend[] = [
                'day' => $date->format('D'),
                'amount' => $amount,
            ];
        }

        return view('wallet.index', compact(
            'transactions',
            'filter',
            'totalExpenses',
            'totalIncome',
            'balance',
            'categoriesWithPercentage',
            'weeklyTrend'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:50',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('wallet.index')->with('success', 'Transaction added successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('wallet.index')->with('success', 'Transaction deleted successfully!');
    }
}
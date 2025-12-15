<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'category',
        'type',
        'date',
        'description'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeExpenses($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('date', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper methods
    public static function getCategories()
    {
        return [
            'Food',
            'Transport',
            'Shopping',
            'Bills',
            'Entertainment',
            'Health',
            'Education',
            'Other'
        ];
    }

    public static function getCategoryColors()
    {
        return [
            'Food' => '#4C7DFF',
            'Transport' => '#10B981',
            'Shopping' => '#F59E0B',
            'Bills' => '#8B5CF6',
            'Entertainment' => '#EF4444',
            'Health' => '#06B6D4',
            'Education' => '#F97316',
            'Other' => '#6B7280'
        ];
    }
}
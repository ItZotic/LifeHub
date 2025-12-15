<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'priority',
        'deadline',
        'completed'
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed' => 'boolean'
    ];

    public function scopeToday($query)
    {
        return $query->whereDate('deadline', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('completed', false)
                     ->whereDate('deadline', '>', today());
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'ilike', "%{$search}%")
              ->orWhere('description', 'ilike', "%{$search}%");
        });
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
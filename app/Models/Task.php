<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'category', 
        'priority', 'due_date', 'completed', 'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('due_date', '>', today());
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }
}

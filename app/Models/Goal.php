<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'target_value', 'current_value', 'unit'
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentage()
    {
        if ($this->target_value == 0) {
            return 0;
        }
        return min(100, ($this->current_value / $this->target_value) * 100);
    }
}

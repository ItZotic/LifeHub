<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'steps',
        'calories',
        'water_glasses',
        'sleep_hours',
        'heart_rate',
        'active_minutes',
    ];

    protected $casts = [
        'date' => 'date',
        'sleep_hours' => 'decimal:1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
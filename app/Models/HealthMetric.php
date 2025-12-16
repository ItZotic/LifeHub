<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * Get the user that owns the health metric.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create today's health metric
     */
    public static function getTodayMetric($userId)
    {
        return static::firstOrCreate(
            [
                'user_id' => $userId,
                'date' => Carbon::today(),
            ],
            [
                'steps' => 0,
                'calories' => 0,
                'water_glasses' => 0,
                'sleep_hours' => 0,
                'heart_rate' => 0,
                'active_minutes' => 0,
            ]
        );
    }

    /**
     * Get weekly metrics
     */
    public static function getWeeklyMetrics($userId)
    {
        return static::where('user_id', $userId)
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->orderBy('date')
            ->get();
    }

    /**
     * Calculate sleep breakdown
     */
    public function getSleepBreakdown()
    {
        $totalHours = $this->sleep_hours;
        $deepSleep = $totalHours * 0.37; // 37% deep sleep
        $lightSleep = $totalHours * 0.43; // 43% light sleep
        $remSleep = $totalHours * 0.20; // 20% REM sleep

        return [
            'total' => round($totalHours, 1),
            'deep' => round($deepSleep, 1),
            'light' => round($lightSleep, 1),
            'rem' => round($remSleep, 1),
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Habit extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'streak',
        'completed_today',
        'last_completed_at'
    ];

    protected $casts = [
        'completed_today' => 'boolean',
        'last_completed_at' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(HabitCompletion::class);
    }

    // Get weekly progress (last 7 days)
    public function getWeeklyProgressAttribute(): array
    {
        $progress = [];
        $today = Carbon::today();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $completed = $this->completions()
                ->whereDate('completed_date', $date)
                ->exists();
            $progress[] = $completed ? 1 : 0;
        }
        
        return $progress;
    }

    // Toggle habit completion for today
    public function toggleToday(): void
    {
        $today = Carbon::today();
        
        if ($this->completed_today) {
            // Unmark as completed
            HabitCompletion::where('habit_id', $this->id)
                ->whereDate('completed_date', $today)
                ->delete();
            
            $this->update([
                'completed_today' => false,
                'streak' => max(0, $this->streak - 1)
            ]);
        } else {
            // Mark as completed
            HabitCompletion::firstOrCreate([
                'habit_id' => $this->id,
                'completed_date' => $today
            ]);
            
            $this->update([
                'completed_today' => true,
                'last_completed_at' => $today,
                'streak' => $this->streak + 1
            ]);
        }
    }

    // Update completion status based on today's date
    public function updateTodayStatus(): void
    {
        $today = Carbon::today();
        $completedToday = $this->completions()
            ->whereDate('completed_date', $today)
            ->exists();
        
        $this->update(['completed_today' => $completedToday]);
    }

    // Available colors
    public static function getColors(): array
    {
        return [
            'bg-blue-500',
            'bg-green-500',
            'bg-purple-500',
            'bg-cyan-500',
            'bg-orange-500',
            'bg-pink-500',
            'bg-red-500',
            'bg-yellow-500',
            'bg-indigo-500',
            'bg-teal-500'
        ];
    }
}
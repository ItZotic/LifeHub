<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'icon', 'color', 
        'current_streak', 'longest_streak'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completions()
    {
        return $this->hasMany(HabitCompletion::class);
    }

    public function isCompletedToday()
    {
        return $this->completions()
            ->whereDate('completed_date', today())
            ->exists();
    }

    public function getWeeklyCompletions()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $this->completions()
            ->whereBetween('completed_date', [$startOfWeek, $endOfWeek])
            ->pluck('completed_date')
            ->map(function ($date) {
                return Carbon::parse($date)->dayOfWeek;
            })
            ->toArray();
    }

    public function markComplete()
    {
        if (!$this->isCompletedToday()) {
            $this->completions()->create([
                'completed_date' => today()
            ]);

            $this->updateStreak();
        }
    }

    public function markIncomplete()
    {
        $completion = $this->completions()
            ->whereDate('completed_date', today())
            ->first();

        if ($completion) {
            $completion->delete();
            $this->recalculateStreak();
        }
    }

    private function updateStreak()
    {
        $yesterday = Carbon::yesterday();
        $wasCompletedYesterday = $this->completions()
            ->whereDate('completed_date', $yesterday)
            ->exists();

        if ($wasCompletedYesterday || $this->current_streak == 0) {
            $this->increment('current_streak');
            if ($this->current_streak > $this->longest_streak) {
                $this->longest_streak = $this->current_streak;
                $this->save();
            }
        } else {
            $this->current_streak = 1;
            $this->save();
        }
    }

    private function recalculateStreak()
    {
        // Get all completions ordered by date descending
        $completions = $this->completions()
            ->orderBy('completed_date', 'desc')
            ->pluck('completed_date')
            ->map(function ($date) {
                return Carbon::parse($date);
            });

        $currentStreak = 0;
        $expectedDate = Carbon::today();

        // Calculate current streak
        foreach ($completions as $completionDate) {
            // If this completion is on the expected date or yesterday
            if ($completionDate->isSameDay($expectedDate) || 
                $completionDate->isSameDay($expectedDate->copy()->subDay())) {
                $currentStreak++;
                $expectedDate = $completionDate->copy()->subDay();
            } else {
                break;
            }
        }

        // Update current streak
        $this->current_streak = $currentStreak;
        $this->save();
    }
}
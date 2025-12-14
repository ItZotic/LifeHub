<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'color',
        'current_streak',
        'longest_streak',
    ];

    protected $casts = [
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
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
            ->whereDate('completed_date', Carbon::today())
            ->exists();
    }

    public function completeToday()
    {
        if ($this->isCompletedToday()) {
            return false;
        }

        $this->completions()->create([
            'completed_date' => Carbon::today(),
        ]);

        $this->updateStreak();
        return true;
    }

    public function updateStreak()
    {
        $completions = $this->completions()
            ->orderBy('completed_date', 'desc')
            ->get();

        if ($completions->isEmpty()) {
            $this->current_streak = 0;
            $this->save();
            return;
        }

        $streak = 0;
        $expectedDate = Carbon::today();

        foreach ($completions as $completion) {
            if ($completion->completed_date->isSameDay($expectedDate)) {
                $streak++;
                $expectedDate->subDay();
            } else {
                break;
            }
        }

        $this->current_streak = $streak;
        
        if ($streak > $this->longest_streak) {
            $this->longest_streak = $streak;
        }

        $this->save();
    }

    public function getWeeklyCompletions()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $completions = $this->completions()
            ->whereBetween('completed_date', [$startOfWeek, $endOfWeek])
            ->pluck('completed_date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        $weekData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weekData[] = [
                'day' => $date->format('D'),
                'completed' => in_array($date->format('Y-m-d'), $completions),
            ];
        }

        return $weekData;
    }
}
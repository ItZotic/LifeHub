<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'dark_mode',
        'language',
        'currency',
        'email_notifications',
        'push_notifications',
        'task_reminders',
        'habit_reminders',
        'expense_alerts',
        'weather_location',
        'temperature_unit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dark_mode' => 'boolean',
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'task_reminders' => 'boolean',
            'habit_reminders' => 'boolean',
            'expense_alerts' => 'boolean',
        ];
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute()
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        return $this->name;
    }

    /**
     * Get the initials for avatar.
     */
    public function getInitialsAttribute()
    {
        if ($this->first_name && $this->last_name) {
            return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get the currency symbol based on user's currency setting.
     */
    public function getCurrencySymbolAttribute()
    {
        $currencyMap = [
            'USD ($)' => '$',
            'EUR (€)' => '€',
            'GBP (£)' => '£',
            'PHP (₱)' => '₱',
        ];

        return $currencyMap[$this->currency] ?? '$';
    }

    /**
     * Format amount with user's currency.
     */
    public function formatCurrency($amount, $decimals = 2)
    {
        return $this->currency_symbol . number_format($amount, $decimals);
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the habits for the user.
     */
    public function habits()
    {
        return $this->hasMany(Habit::class);
    }

    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the goals for the user.
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the health metrics for the user.
     */
    public function healthMetrics()
    {
        return $this->hasMany(HealthMetric::class);
    }
}
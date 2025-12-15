<?php

namespace App\Providers;

use App\Models\Habit;
use App\Models\Task;
use App\Models\Transaction;
use App\Policies\HabitPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Habit::class => HabitPolicy::class,
        Task::class => TaskPolicy::class,
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
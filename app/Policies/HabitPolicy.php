<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

class HabitPolicy
{
    /**
     * Determine if the user can update the habit.
     */
    public function update(User $user, Habit $habit): bool
    {
        return $user->id === $habit->user_id;
    }

    /**
     * Determine if the user can delete the habit.
     */
    public function delete(User $user, Habit $habit): bool
    {
        return $user->id === $habit->user_id;
    }
}
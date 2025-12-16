<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile
            $table->string('avatar')->nullable()->after('email');
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            
            // Appearance
            $table->boolean('dark_mode')->default(false)->after('remember_token');
            $table->string('language')->default('English')->after('dark_mode');
            $table->string('currency')->default('USD ($)')->after('language');
            
            // Notifications
            $table->boolean('email_notifications')->default(true)->after('currency');
            $table->boolean('push_notifications')->default(true)->after('email_notifications');
            $table->boolean('task_reminders')->default(true)->after('push_notifications');
            $table->boolean('habit_reminders')->default(true)->after('task_reminders');
            $table->boolean('expense_alerts')->default(false)->after('habit_reminders');
            
            // Weather Settings
            $table->string('weather_location')->default('San Francisco, CA')->after('expense_alerts');
            $table->string('temperature_unit')->default('Fahrenheit (°F)')->after('weather_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'first_name',
                'last_name',
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
            ]);
        });
    }
};
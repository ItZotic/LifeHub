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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('users', 'weather_location')) {
                $table->string('weather_location')->default('Batangas, PH')->nullable()->after('expense_alerts');
            }
            
            if (!Schema::hasColumn('users', 'temperature_unit')) {
                $table->string('temperature_unit')->default('Celsius (°C)')->nullable()->after('weather_location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['weather_location', 'temperature_unit']);
        });
    }
};
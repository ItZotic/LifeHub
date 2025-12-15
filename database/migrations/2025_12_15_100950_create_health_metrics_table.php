<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('steps')->default(0);
            $table->integer('calories')->default(0);
            $table->integer('water_glasses')->default(0);
            $table->decimal('sleep_hours', 3, 1)->default(0);
            $table->integer('heart_rate')->nullable();
            $table->integer('active_minutes')->default(0);
            $table->timestamps();
            
            // Ensure one record per user per day
            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_metrics');
    }
};
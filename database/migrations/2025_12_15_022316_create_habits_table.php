<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('color')->default('bg-blue-500');
            $table->integer('streak')->default(0);
            $table->boolean('completed_today')->default(false);
            $table->date('last_completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('habit_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->date('completed_date');
            $table->timestamps();
            
            $table->unique(['habit_id', 'completed_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habit_completions');
        Schema::dropIfExists('habits');
    }
};
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\SettingsController;

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Expenses/Wallet
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    
    // Habits
    Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::patch('/habits/{habit}/toggle', [HabitController::class, 'toggle'])->name('habits.toggle');
    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])->name('habits.destroy');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/avatar', [SettingsController::class, 'updateAvatar'])->name('settings.avatar');
    Route::delete('/settings/avatar', [SettingsController::class, 'deleteAvatar'])->name('settings.avatar.delete');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
    
    // Health (placeholder)
    Route::get('/health', function () {
        return view('health');
    })->name('health');
    
    // Weather (placeholder)
    Route::get('/weather', function () {
        return view('weather');
    })->name('weather');
});
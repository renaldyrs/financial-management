<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Members
    Route::resource('members', MemberController::class);
    
    // Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::resource('expense-categories', ExpenseCategoryController::class);
    
    // Incomes
    Route::resource('incomes', IncomeController::class);
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\MealItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DailySummaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('meals', MealController::class);
    Route::post('/meals/{meal}/items', [MealItemController::class, 'store'])->name('meal-items.store');
    Route::delete('/meal-items/{mealItem}', [MealItemController::class, 'destroy'])->name('meal-items.destroy');
    Route::get('/daily-summary', [DailySummaryController::class, 'index'])->name('daily-summary.index');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\MealItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DailySummaryController;
use App\Http\Controllers\WeightEntryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeItemController;
use App\Http\Controllers\AdminController;
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
    Route::resource('weight-entries', WeightEntryController::class);
    Route::resource('recipes', RecipeController::class);

    Route::post('/recipes/{recipe}/items', [RecipeItemController::class, 'store'])
        ->name('recipe-items.store');

    Route::delete('/recipe-items/{recipeItem}', [RecipeItemController::class, 'destroy'])
        ->name('recipe-items.destroy');
    
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::patch('/admin/products/{product}/approve', [AdminController::class, 'approveProduct'])
        ->name('admin.products.approve');

    Route::patch('/admin/products/{product}/reject', [AdminController::class, 'rejectProduct'])
        ->name('admin.products.reject');

    Route::patch('/admin/recipes/{recipe}/approve', [AdminController::class, 'approveRecipe'])
        ->name('admin.recipes.approve');

    Route::patch('/admin/recipes/{recipe}/reject', [AdminController::class, 'rejectRecipe'])
        ->name('admin.recipes.reject');
});

require __DIR__.'/auth.php';
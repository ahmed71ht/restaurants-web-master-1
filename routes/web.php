<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Routes
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Restaurants Index
    Route::get('/restaurants', [RestaurantsController::class, 'index'])->name('restaurant.index');

    // Admin only
    Route::middleware('admin')->group(function () {

        // Restaurants create/store/edit/update
        Route::get('/restaurants/create', [RestaurantsController::class, 'create'])->name('restaurant.create');
        Route::post('/restaurants', [RestaurantsController::class, 'store'])->name('restaurant.store');

        Route::get('/restaurants/{restaurant}/edit', [RestaurantsController::class, 'edit'])->name('restaurant.edit');
        Route::patch('/restaurants/{restaurant}', [RestaurantsController::class, 'update'])->name('restaurant.update');

        // Foods create/store/edit/update
        Route::get('/restaurants/{restaurant}/food/create', [FoodController::class, 'create'])->name('food.create');
        Route::post('/restaurants/{restaurant}/food', [FoodController::class, 'store'])->name('food.store');

        Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('food.edit');
        Route::patch('/foods/{food}', [FoodController::class, 'update'])->name('food.update');

        // Admin dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    Route::get('/restaurants/{restaurant}', [RestaurantsController::class, 'show'])->name('restaurant.show');
    Route::get('/food/buy/{food}', [FoodController::class, 'show'])->name('food.buy');
    Route::post('/food/buy/{food}', [FoodController::class, 'buyStore'])->name('food.buy.store');

});

require __DIR__.'/auth.php';

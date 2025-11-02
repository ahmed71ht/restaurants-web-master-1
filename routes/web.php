<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Restaurants routes
    Route::get('/restaurants', [RestaurantsController::class, 'index'])->name('restaurant.index');       // قائمة المطاعم
    Route::get('/restaurants/create', [RestaurantsController::class, 'create'])->name('restaurant.create'); // فورم إضافة مطعم
    Route::post('/restaurants', [RestaurantsController::class, 'store'])->name('restaurant.store');       // حفظ المطعم الجديد
    Route::get('/restaurants/{restaurant}', [RestaurantsController::class, 'show'])->name('restaurant.show'); // عرض مطعم محدد

});

require __DIR__.'/auth.php';

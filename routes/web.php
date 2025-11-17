<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UserOrdersController;
use App\Http\Controllers\DeliveryController;
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

    Route::middleware('ownerOrAdmin')->group(function () {
        Route::get('/restaurant/{restaurant}/orders', [OrderController::class, 'orders'])->name('restaurant.orders');
        Route::post('/restaurant/{restaurant}/orders/{order}/accept', [OrderController::class, 'acceptOrder'])->name('restaurant.orders.accept');
        Route::post('/restaurant/{restaurant}/orders/{order}/reject', [OrderController::class, 'rejectOrder'])->name('restaurant.orders.reject');
        Route::delete('/orders/{restaurant}/delete-rejected', [OrderController::class, 'deleteRejected'])->name('orders.deleteRejected');

        Route::delete('/restaurants/{restaurant}/food/{food}', [FoodController::class, 'destroy'])->name('food.destroy');

        Route::get('/restaurants/{restaurant}/food/create', [FoodController::class, 'create'])->name('food.create');
        Route::post('/restaurants/{restaurant}/food', [FoodController::class, 'store'])->name('food.store');

        Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('food.edit');
        Route::patch('/foods/{food}', [FoodController::class, 'update'])->name('food.update');
    });

    Route::middleware(['DeliveryOrAdmin'])->group(function () {
        Route::get('/restaurant/{restaurant}/delivery', [DeliveryController::class, 'index'])->name('restaurant.delivery.index');
        Route::post('/restaurant/{restaurant}/delivery/{order}', [DeliveryController::class, 'updateStatus'])->name('restaurant.delivery.updateStatus');
        Route::delete('/delivery/{restaurant}/delete-delivered', [DeliveryController::class, 'deleteDelivered'])->name('delivery.deleteDelivered');
    });


    // Admin only
    Route::middleware('admin')
        ->prefix('admin/dashboard')
        ->group(function () {
            
            Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

            Route::get('/restaurants/create', [RestaurantsController::class, 'create'])->name('restaurant.create');
            Route::post('/restaurants', [RestaurantsController::class, 'store'])->name('restaurant.store');

            Route::get('/restaurants/{restaurant}/edit', [RestaurantsController::class, 'edit'])->name('restaurant.edit');
            Route::patch('/restaurants/{restaurant}', [RestaurantsController::class, 'update'])->name('restaurant.update');

            Route::get('/restaurants', [AdminController::class, 'index'])->name('admin.restaurants.index');

            Route::delete('/restaurants/{restaurant}', [RestaurantsController::class, 'destroy'])->name('restaurant.destroy');

            Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
            Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');

        });


    Route::get('/restaurants/{restaurant}', [RestaurantsController::class, 'show'])->name('restaurant.show');
    Route::get('/food/buy/{food}', [FoodController::class, 'show'])->name('food.buy');
    Route::post('/food/buy/{food}', [FoodController::class, 'buyStore'])->name('food.buy.store');
    Route::post('/cart/checkout', [FoodController::class, 'checkout'])->name('cart.checkout');

    Route::get('/restaurant/{restaurant}/my-orders', [UserOrdersController::class, 'userOrders'])->name('restaurant.user.orders');
    Route::get('/restaurant/{restaurant}/order/{order}/edit/food', [UserOrdersController::class, 'edit'])->name('restaurant.user.edit');
    Route::post('/restaurant/{restaurant}/order/{order}/food', [UserOrdersController::class, 'update'])->name('orders.update');
    Route::delete('/order/{order}', [UserOrdersController::class, 'delete'])->name('order.delete');

});

require __DIR__.'/auth.php';

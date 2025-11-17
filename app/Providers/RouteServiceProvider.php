<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\Restaurant;
use App\Models\Food;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        parent::boot();

        // تعريف ربط النماذج (Route Model Binding)
        Route::model('restaurant', Restaurant::class);
        Route::model('food', Food::class);
    }
}

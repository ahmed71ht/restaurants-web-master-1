<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Food;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->get();

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function dashboard()
    {
        $restaurantsCount = Restaurant::count();
        $foodsCount = Food::count();

        $latestRestaurant = Restaurant::latest()->first();
        $latestFoods = Food::with('restaurant')->latest()->take(10)->get();
        $latestRestaurants = Restaurant::latest()->take(10)->get();

        // Aggregation: number of foods per restaurant (top 10)
        $foodsPerRestaurant = DB::table('foods')
            ->select('restaurant_id', DB::raw('count(*) as total'))
            ->groupBy('restaurant_id')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->map(function($row){
                $r = Restaurant::find($row->restaurant_id);
                return [
                    'name' => $r ? $r->name : 'غير معروف',
                    'total' => $row->total,
                ];
            });

        return view('admin.dashboard', compact(
            'restaurantsCount',
            'foodsCount',
            'latestRestaurant',
            'latestFoods',
            'latestRestaurants',
            'foodsPerRestaurant'
        ));
    }
}
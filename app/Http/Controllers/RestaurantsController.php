<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('restaurant.index', compact('restaurants'));
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurant.show', compact('restaurant'));
    }

    public function create()
    {
        $users = User::all();
        return view('restaurant.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'delivery_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'required|string',
            'location' => 'required|string'
        ]);

        $data = $request->only(['owner_id', 'name', 'description', 'phone', 'location', 'delivery_id']);;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('restaurantImg'), $imageName);
            $data['image'] = 'restaurantImg/' . $imageName;
        }

        Restaurant::create($data);

        return redirect()->route('restaurant.index')->with('success', 'تم إضافة المطعم بنجاح');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('restaurant.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $restaurant->update($request->only('name', 'location'));

        return redirect()->route('admin.dashboard')->with('success', 'تم تحديث المطعم بنجاح');
    }

    public function destroy(Restaurant $restaurant)
    {
        // إذا الصورة موجودة في DB
        if ($restaurant->image && file_exists(public_path($restaurant->image))) {
            unlink(public_path($restaurant->image));
        }

        $restaurant->delete();

        return redirect()->route('restaurant.index')->with('success', 'تم حذف المطعم بنجاح');
    }

    public function topRestaurants()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // جمع بيانات التعليقات
        $comments = DB::table('restaurant_comments')
            ->select('restaurant_id',
                    DB::raw('AVG(rating) as avg_rating'),
                    DB::raw('COUNT(*) as total_comments'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('restaurant_id');

        // جمع بيانات الطلبات
        $orders = DB::table('orders')
            ->select('restaurant_id',
                    DB::raw('COUNT(*) as total_orders'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('restaurant_id');

        // دمج البيانات وحساب النقاط
        $topRestaurants = DB::table('restaurants')
            ->leftJoinSub($comments, 'c', 'restaurants.id', 'c.restaurant_id')
            ->leftJoinSub($orders, 'o', 'restaurants.id', 'o.restaurant_id')
            ->select('restaurants.*',
                    DB::raw('
                        (COALESCE(c.avg_rating,0)*0.5 + 
                        COALESCE(o.total_orders,0)*0.3 + 
                        COALESCE(c.total_comments,0)*0.2) as score,
                        COALESCE(c.avg_rating,0) as avg_rating,
                        COALESCE(o.total_orders,0) as total_orders,
                        COALESCE(c.total_comments,0) as total_comments
                    '))
            ->orderByDesc('score')
            ->limit(10)
            ->get();

        return view('restaurant.top', compact('topRestaurants'));
    }


}

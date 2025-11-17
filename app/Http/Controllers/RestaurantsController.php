<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
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
            'location' => 'required|string'
        ]);

        $data = $request->only(['owner_id', 'name', 'description', 'location', 'delivery_id']);;

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

}

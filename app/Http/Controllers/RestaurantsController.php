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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('restaurants'), $imageName);
            $data['image'] = 'restaurants/' . $imageName;
        }

        Restaurant::create($data);

        return redirect()->route('restaurant.index')->with('success', 'تم إضافة المطعم بنجاح');
    }

}

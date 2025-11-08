<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Food;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);
        return view('food.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foodImg'), $imageName);
            $data['image'] = 'foodImg/' . $imageName;
        }

        $data['restaurant_id'] = $restaurant->id;

        Food::create($data);

        return redirect()->route('restaurant.show', $restaurant->id)->with('success', 'تم إضافة الأكلة بنجاح');
    }

    public function buyStore(Request $request, Food $food)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
        ]);

        $quantity = $request->quantity;
        $total = $food->price * $quantity;

        \App\Models\Order::create([
            'customer_id' => auth()->id(),
            'restaurant_id' => $food->restaurant_id,
            'food_id' => $food->id, // لو ضفت هذا الحقل
            'quantity' => $quantity, // لو ضفت هذا الحقل
            'total_price' => $total,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        return redirect()->route('restaurant.index')->with('success', "تم تأكيد الطلب ✅ | الكمية: $quantity | المجموع: $total$");
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        return view('food.buy', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        return view('food.edit', compact('food'));
    }

public function update(Request $request, Food $food)
{
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->only(['name', 'description']);

    if ($request->hasFile('image')) {

        if ($food->image && file_exists(public_path($food->image))) {
            unlink(public_path($food->image));
        }

        $file = $request->file('image');
        $imageName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('foodImg'), $imageName);
        $data['image'] = 'foodImg/' . $imageName;
    }

    $food->update($data);

    return redirect()->route('admin.dashboard')->with('success', 'تم تحديث الأكلة بنجاح');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

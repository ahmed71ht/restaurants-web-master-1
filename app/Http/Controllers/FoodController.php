<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index()
    {
        //
    }

    public function create($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);
        return view('food.create', compact('restaurant'));
    }

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

        // إنشاء الطبق
        $food = Food::create($data);

        /* 🔥 إرسال إيميل Gmail للمتابعين */
        foreach ($restaurant->followers as $follower) {
            $follower->notify(new \App\Notifications\NewDishEmail($food));
        }

        return redirect()->route('restaurant.show', $restaurant->id)
                        ->with('success', 'تم إضافة الأكلة بنجاح');
    }


    public function buyStore(Request $request, Food $food)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $quantity = $request->quantity;
        $total = $food->price * $quantity;

        \App\Models\Order::create([
            'customer_id' => auth()->id(),
            'restaurant_id' => $food->restaurant_id,
            'food_id' => $food->id,
            'quantity' => $quantity,
            'total_price' => $total,
            'location' => $request->location ?? 'الموقع غير محدد',
            'phone' => $request->phone,
            'status' => 'pending',
        ]);

        return redirect()->route('restaurant.index')->with('success', "تم تأكيد الطلب ✅ | الكمية: $quantity | المجموع: $total₺");
    }

    public function show(Food $food)
    {
        return view('food.buy', compact('food'));
    }

    public function edit(Food $food)
    {
        return view('food.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['price', 'name', 'description']);

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

        return redirect()->route('restaurant.show', $food->restaurant_id)->with('success', 'تم تحديث الأكلة بنجاح');
    }

    public function destroy($restaurant_id, $food_id)
    {
        $food = Food::where('id', $food_id)
            ->where('restaurant_id', $restaurant_id)
            ->firstOrFail();

        if ($food->image && file_exists(public_path($food->image))) {
            unlink(public_path($food->image));
        }

        $food->delete();

        return redirect()->route('restaurant.index')->with('success', 'تم حذف الأكلة بنجاح');
    }

    /**
     * Checkout: استقبال مصفوفة العناصر (JSON) وإنشاء طلب واحد (إذا كلها من نفس المطعم)
     * body: { items: [{id, restaurant_id, name, price, quantity}], phone, location }
     */
    public function checkout(Request $request)
    {
        $payload = $request->all();

        // تحقق بسيط
        $validator = Validator::make($payload, [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'phone' => 'required|string|max:30',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'بيانات غير صحيحة', 'errors' => $validator->errors()], 422);
        }

        $items = $payload['items'];

        // تأكد أن كل العناصر من نفس المطعم
        $restaurantIds = array_unique(array_map(function($i){ return $i['restaurant_id'] ?? null; }, $items));
        if (count($restaurantIds) > 1) {
            return response()->json(['success' => false, 'message' => 'يجب أن تكون جميع العناصر من نفس المطعم'], 422);
        }

        $restaurantId = $restaurantIds[0] ?? null;

        // احسب المجموع
        $total = 0;
        foreach ($items as $it) {
            $total += floatval($it['price']) * intval($it['quantity']);
        }

        // تأكد من تسجيل الدخول
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول أولاً'], 401);
        }

        // عمل الطلب داخل معاملة DB
        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => auth()->id(),
                'restaurant_id' => $restaurantId,
                'total_price' => $total,
                'status' => 'pending',
                'phone' => $payload['phone'] ?? null,
                'location' => $payload['location'] ?? 'الموقع غير محدد',
            ]);

            // لاحظ: يجب أن تكون علاقة many-to-many بين orders و foods مع جدول محوري (order_food) فيه عمود quantity
            foreach ($items as $it) {
                // تأكد من وجود الوجبة فعلاً تحت نفس المطعم (اختياري لسلامة البيانات)
                $food = Food::find($it['id']);
                if (!$food) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'عنصر غير موجود'], 404);
                }
                $order->foods()->attach($food->id, ['quantity' => intval($it['quantity']), 'price' => $it['price']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'تم إنشاء الطلب بنجاح',
                'redirect' => route('restaurant.index') // أو أي صفحة تريد إعادة التوجيه إليها
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'خطأ في إنجاز الطلب: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Order;

class UserOrdersController extends Controller
{
    /**
     * عرض جميع الطلبات الخاصة بالمستخدم لمطعم معين
     */
    public function userOrders(Restaurant $restaurant)
    {
        $user = auth()->user();

        $orders = $restaurant->orders()
            ->where('customer_id', $user->id)
            ->with('foods', 'customer')
            ->latest()
            ->get();

        return view('restaurant.user.orders', compact('orders', 'restaurant'));
    }

    /**
     * صفحة تعديل طلب محدد
     */
    public function edit(Restaurant $restaurant, Order $order)
    {
        $user = auth()->user();

        if ($order->customer_id != $user->id) {
            abort(403, 'لا يمكنك تعديل هذا الطلب.');
        }

        $order->load(['foods' => function ($q) {
            $q->withPivot('id', 'quantity', 'price');
        }]);

        return view('restaurant.user.edit', compact('order', 'restaurant'));
    }

    /**
     * تحديث الطلب (تغيير الأصناف والكمية)
     */
    public function update(Request $request, Restaurant $restaurant, Order $order)
    {
        $user = auth()->user();

        if ($order->customer_id != $user->id || $order->status === 'accepted') {
            return back()->with('error', 'لا يمكنك تعديل هذا الطلب.');
        }

        $request->validate([
            'order_food_id' => 'nullable|array',
            'order_food_id.*' => 'nullable|integer|exists:order_food,id',
            'food_id' => 'nullable|array',
            'food_id.*' => 'nullable|integer|exists:foods,id',
            'quantity' => 'nullable|array',
            'quantity.*' => 'nullable|integer|min:1',
        ]);

        $order_food_ids = $request->input('order_food_id');
        $food_ids = $request->input('food_id');
        $quantities = $request->input('quantity');

        foreach ($order_food_ids as $index => $pivot_id) {

            // جيب السطر من Pivot مباشرة من جدول order_food
            $old = \DB::table('order_food')
                ->where('id', $pivot_id)
                ->first();

            if ($old) {

                // امسح السطر القديم
                \DB::table('order_food')->where('id', $pivot_id)->delete();

                // جيب معلومات الأكل الجديد
                $newFood = \App\Models\Food::find($food_ids[$index]);

                // أضف السطر الجديد
                $order->foods()->attach($food_ids[$index], [
                    'quantity' => $quantities[$index],
                    'price' => $newFood->price,
                ]);
            }
        }


        return redirect()->route('restaurant.user.orders', $restaurant->id)
                        ->with('success', 'تم تحديث جميع الأصناف بنجاح.');
    }


    /**
     * حذف الطلب
     */
    public function delete(Order $order)
    {
        $user = auth()->user();

        if ($order->customer_id != $user->id || $order->status === 'accepted') {
            return back()->with('error', 'لا يمكنك حذف هذا الطلب.');
        }

        $order->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح.');
    }
}

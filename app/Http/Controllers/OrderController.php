<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // عرض الطلبات لمطعم محدد
    public function orders(Restaurant $restaurant)
    {
        // تحقق إذا المستخدم هو owner أو admin
        if (!in_array(auth()->user()->role, ['owner', 'admin']) || (auth()->user()->role == 'owner' && auth()->id() !== $restaurant->owner_id)) {
            abort(403);
        }

        $orders = $restaurant->orders()->with('foods', 'customer')->latest()->get();

        return view('restaurant.orders', compact('orders', 'restaurant'));
    }



    // قبول الطلب
    public function acceptOrder(Restaurant $restaurant, Order $order)
    {
        if(auth()->id() != $restaurant->owner_id || $order->restaurant_id != $restaurant->id){
            abort(403);
        }

        $order->update(['status' => 'accepted']);
        return back()->with('success', 'تم قبول الطلب');
    }

    // رفض الطلب
    public function rejectOrder(Restaurant $restaurant, Order $order)
    {
        if(auth()->id() != $restaurant->owner_id || $order->restaurant_id != $restaurant->id){
            abort(403);
        }

        $order->update(['status' => 'rejected']);
        return back()->with('success', 'تم رفض الطلب');
    }
}

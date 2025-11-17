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
        $user = auth()->user();

        if ($user->role !== 'admin' && $user->id !== $restaurant->owner_id) {
            abort(403, 'غير مسموح لك بالدخول إلى هذا القسم');
        }

        $orders = $restaurant->orders()->with('foods', 'customer')->latest()->get();

        return view('restaurant.orders', compact('orders', 'restaurant'));
    }

    public function acceptOrder(Restaurant $restaurant, Order $order)
    {
        // تحقق الصلاحيات
        if(auth()->user()->role !== 'admin' && auth()->id() != $restaurant->owner_id){
            return redirect()->route('restaurant.orders', $restaurant->id)
                            ->with('error', 'ليس لديك صلاحية للقيام بهذا الإجراء');
        }

        $order->update(['status' => 'accepted']);

        return redirect()->route('restaurant.orders', $restaurant->id)
                        ->with('success', 'تم قبول الطلب');
    }

    public function rejectOrder(Restaurant $restaurant, Order $order)
    {
        if(auth()->user()->role !== 'admin' && auth()->id() != $restaurant->owner_id){
            return redirect()->route('restaurant.orders', $restaurant->id)
                            ->with('error', 'ليس لديك صلاحية للقيام بهذا الإجراء');
        }

        $order->update(['status' => 'rejected']);

        return redirect()->route('restaurant.orders', $restaurant->id)
                        ->with('success', 'تم رفض الطلب');
    }

    public function deleteRejected()
    {
        Order::where('status', 'rejected')->delete();

        return redirect()->back()->with('success', 'تم حذف كل الطلبات المرفوضة.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // عرض طلبات الدليفري لمطعم معيّن
    public function index(Restaurant $restaurant)
    {
        $user = auth()->user();

        // السماح للآدمن أو مالك المطعم فقط
        if ($user->role !== 'admin' && $user->id !== $restaurant->owner_id) {
            abort(403, 'غير مسموح لك بالدخول إلى هذا القسم');
        }

        $orders = $restaurant->orders()
            ->with('foods', 'customer')
            ->where('status', 'accepted')
            ->whereNotNull('delivery_status')
            ->latest()
            ->get();

        return view('restaurant.delivery', compact('orders', 'restaurant'));
    }

    // تحديث حالة التوصيل
    public function updateStatus(Restaurant $restaurant, Order $order, Request $request)
    {
        // التحقق من الصلاحيات
        if (auth()->user()->role !== 'admin' && auth()->id() != $restaurant->owner_id) {
            return back()->with('error', 'ليس لديك صلاحية للقيام بهذا الإجراء');
        }

        // الحالات المسموح بها
        $request->validate([
            'delivery_status' => 'required|in:pending_delivery,on_the_way,delivered'
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status
        ]);

        return back()->with('success', 'تم تحديث حالة التوصيل بنجاح');
    }

    public function deleteDelivered()
    {
        Order::where('delivery_status', 'delivered')->delete();

        return redirect()->back()->with('success', 'تم حذف كل الطلبات التي تم توصيلها.');
    }
}

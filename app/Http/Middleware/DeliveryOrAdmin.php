<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class DeliveryOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // لو المستخدم admin، يسمح له دائمًا
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // جلب المطعم من الراوت
        $restaurant = $request->route('restaurant');

        // إذا وصلنا فقط ID، نجلب المطعم من قاعدة البيانات
        if (is_numeric($restaurant)) {
            $restaurant = Restaurant::find($restaurant);
        }

        // تحقق من صلاحيات الدليفري
        if ($user && $restaurant && $user->id === $restaurant->delivery_id) {
            return $next($request);
        }

        abort(403, 'غير مسموح لك بالدخول إلى هذا القسم');
    }
}

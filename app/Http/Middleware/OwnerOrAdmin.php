<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Food;

class OwnerOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // نحاول الحصول على كائن المطعم من الراوت
        $restaurant = $request->route('restaurant');

        // دعم مسارات {food} لجلب المطعم
        $food = $request->route('food');
        if ($food && !$restaurant) {
            if (!($food instanceof Food)) {
                $food = Food::find($food);
            }
            $restaurant = $food ? $food->restaurant : null;
        }

        // لو رقم، نجلبه من قاعدة البيانات
        if (is_numeric($restaurant)) {
            $restaurant = Restaurant::find($restaurant);
        }

        // التحقق من الصلاحيات
        if ($user && $restaurant && ($user->role === 'admin' || $user->id === $restaurant->owner_id)) {
            return $next($request);
        }

        abort(403, 'غير مسموح لك بالدخول إلى هذا القسم');
    }
}

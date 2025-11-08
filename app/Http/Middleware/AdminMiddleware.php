<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تأكد أن المستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        // تأكد أن المستخدم أدمن
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مسموح لك بالدخول هنا 😅');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    
    public function following()
    {
        // جلب المطاعم التي يتابعها المستخدم
        $followingRestaurants = auth()->user()->followedRestaurants()->get();

        return view('restaurant.following', compact('followingRestaurants'));
    }

    public function follow(Restaurant $restaurant)
    {
        $user = auth()->user();
        $user->followedRestaurants()->syncWithoutDetaching($restaurant->id);

        if(request()->expectsJson()){
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تمت المتابعة');
    }

    public function unfollow(Restaurant $restaurant)
    {
        $user = auth()->user();
        $user->followedRestaurants()->detach($restaurant->id);

        if(request()->expectsJson()){
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تم إلغاء المتابعة');
    }
}

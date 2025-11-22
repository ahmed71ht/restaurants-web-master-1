<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantComment;

class RestaurantCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|min:3',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        RestaurantComment::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $request->restaurant_id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'تم إضافة التعليق بنجاح');
    }

}

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


    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|min:3',
        ]);

        $comment = RestaurantComment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'غير مسموح'], 403);
        }

        $comment->update([
            'comment' => $request->comment
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $comment = RestaurantComment::findOrFail($id);
        $restaurantOwnerId = $comment->restaurant->owner_id;
        $user = auth()->user();

        // السماح للكاتب الأصلي أو admin أو صاحب المطعم بالحذف
        if ($comment->user_id !== $user->id && $user->role !== 'admin' && $user->id !== $restaurantOwnerId) {
            return back()->with('error', 'غير مسموح بحذف التعليق');
        }

        $comment->delete();

        return back()->with('success', 'تم حذف التعليق');
    }

}

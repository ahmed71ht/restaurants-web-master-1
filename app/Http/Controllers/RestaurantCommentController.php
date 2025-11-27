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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('comments'), $imageName);
        }

        RestaurantComment::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $request->restaurant_id,
            'comment' => $request->comment,
            'image' => $imageName,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'تم إضافة التعليق بنجاح');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|min:3',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment = RestaurantComment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'غير مسموح'], 403);
        }

        $imageName = $comment->image;

        if ($request->hasFile('image')) {
            if ($comment->image && file_exists(public_path('comments/' . $comment->image))) {
                unlink(public_path('comments/' . $comment->image));
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('comments'), $imageName);
        }

        $comment->update([
            'comment' => $request->comment,
            'image' => $imageName,
            'rating' => $request->rating,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $comment = RestaurantComment::findOrFail($id);
        $restaurantOwnerId = $comment->restaurant->owner_id;
        $user = auth()->user();

        if ($comment->user_id !== $user->id && $user->role !== 'admin' && $user->id !== $restaurantOwnerId) {
            return back()->with('error', 'غير مسموح بحذف التعليق');
        }

        if ($comment->image && file_exists(public_path('comments/' . $comment->image))) {
            unlink(public_path('comments/' . $comment->image));
        }

        $comment->delete();

        return back()->with('success', 'تم حذف التعليق');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentReply;

class CommentReplyController extends Controller
{
    public function store(Request $request, $commentId)
    {
        $request->validate([
            'reply' => 'required|min:3',
        ]);

        CommentReply::create([
            'user_id'    => auth()->id(),
            'comment_id' => $commentId,
            'reply'      => $request->reply,
        ]);

        return back()->with('success', 'تم إضافة الرد بنجاح');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|min:3',
        ]);

        $reply = CommentReply::findOrFail($id);

        // السماح فقط لصاحب الرد
        if ($reply->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مسموح'
            ], 403);
        }

        $reply->update([
            'reply' => $request->reply
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $reply = CommentReply::findOrFail($id);

        $user = auth()->user();

        // للوصول لصاحب المطعم لازم نجيب التعليق الأساسي → ثم المطعم
        $restaurantOwnerId = $reply->comment->restaurant->owner_id;

        // السماح لصاحب الرد أو الادمن أو صاحب المطعم
        if (
            $reply->user_id !== $user->id &&
            $user->role !== 'admin' &&
            $user->id !== $restaurantOwnerId
        ) {
            return back()->with('error', 'غير مسموح بحذف الرد');
        }

        $reply->delete();

        return back()->with('success', 'تم حذف الرد');
    }

}

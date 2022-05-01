<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getAllComment(): JsonResponse
    {
        $allComment = Comment::with(['author', 'post'])
                    ->paginate(10);
        return response()->json([
            'data' => $allComment,
        ], Response::HTTP_ACCEPTED);
    }

    public function createComment(Request $request): JsonResponse
    {
        // For Creating Comment
        $createComment = Comment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
            'author_id' => Auth::user()->id
        ]);
        if ($createComment->save()) {
            return response()->json([
                'message' => 'Comment created successfully!!'
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'message' => 'Not successful'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function updateComment(Request $request): JsonResponse
    {
        $updateComment = Comment::where('id', $request->comment_id)->update([
            'content' => $request->content,
            'post_id'  => $request->post_id
        ]);
        if ($updateComment) {
            return response()->json([
                'message' => ' Comment successfully Updated!!'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'Comment has not been Updated'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function deleteComment(Request $request): JsonResponse
    {
        $deleteComment = Comment::where('id', $request->comment_id)->delete();
        if ($deleteComment) {
            return response()->json([
                'message' => 'Comment was successfully deleted'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Comment not deleted',
        ], Response::HTTP_BAD_REQUEST);
    }

}

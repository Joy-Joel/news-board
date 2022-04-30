<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getAllPost(): JsonResponse
    {
        $allPost = Post::with('comments')
            ->paginate(10);
        return response()->json([
            'data' => $allPost,
        ], Response::HTTP_ACCEPTED);
    }

    public function createPost(Request $request): JsonResponse
    {
        // For Creating News Post

        $createPost = Post::create([
            'title' => $request->title,
            'link' => $request->link,
            'author_id' => Auth::user()->id
        ]);
        if ($createPost->save()) {
            return response()->json([
                'message' => 'Post created successfully!!'
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'message' => 'Not successful'
        ], Response::HTTP_BAD_REQUEST);
    }


    public function updatePost(Request $request): JsonResponse|Exception
    {
        try {
            $updatePost = Post::where('id', $request->post_id)->update([
                'title' => $request->title,
                'link'  => $request->link
            ]);
            if ($updatePost) {
                return response()->json([
                    'message' => ' News Post successfully Updated!!'
                ], Response::HTTP_OK);
            }
            return response()->json([
                'message' => 'Post has not been Updated'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deletePost(Request $request): JsonResponse
    {
        $deletePost = Post::where('id', $request->post_id)->delete();
        if ($deletePost) {
            return response()->json([
                'message' => 'Post was successfully deleted'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Post not deleted',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function upvotePost($post_id)
    {
        $vote = new Vote([
            'vote'
        ]);
    }

    // public function upvotePost()
    // {

    // }
}

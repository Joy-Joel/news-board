<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPost()
    {
        $allPost = Post::with('comments')
            ->paginate(10);
        return response()->json([
            'data' => $allPost,
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPost(Request $request)
    {
        // For Creating News Post

        $createPost = Post::create([
            'title' => $request->title,
            'link' => $request->link,
            'author_id' => Auth::user()->id
        ]);
        if ($createPost->save()) {
            return response()->json([
                'message' => 'Post created successfully !!'
            ], Response::HTTP_CREATED);
        }
            return response()->json([
                'message' => 'Not successful'
            ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePost(Request $request)
    {
        try {
            $updatePost = Post::where('id', $request->post_id)->update([
                'title' => $request->title,
                'link'  => $request->link
            ]);
            if ($updatePost) {
                return response()->json([
                    'message' => ' News Post successfully Updated!!'
                ], Response::HTTP_ACCEPTED);
            }
            return response()->json([
                'message'=> 'Post has not been Updated'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePost(Request $request)
    {
        try {
            $deletePost = Post::where('id', $request->post_id)->delete();
            if ($deletePost) {
                return response()->json([
                    'message' => 'Post was successfully deleted'
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Post not deleted',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

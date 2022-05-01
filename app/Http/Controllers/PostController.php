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
        $allPost = Post::with(['author', 'comments', 'votes'])
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


    public function updatePost(Request $request): JsonResponse
    {
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

    public function votePost(Request $request)
    {
        if(($request->get('vote') == 1) || ($request->get('vote') == 0)){
            $postExists = Post::where('id', $request->post_id)->first();

            if(!$postExists){
                return new JsonResponse(['message' => 'post does not exist'],Response::HTTP_BAD_REQUEST);
            }

            $hasUserVotedPost = $this->check_if_user_voted_post($request);
            // return $hasUserVotedPost;
            if($hasUserVotedPost == "not voted") {
                $vote = new Vote([
                    'vote' => $request->vote,
                    'user_id' => Auth::user()->id,
                    'post_id' => $request->post_id,
                ]);
                if(!$vote->save()) {
                    return new JsonResponse([],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                return new JsonResponse([
                    'message' => 'vote successful'
                ],Response::HTTP_OK);
            }
            if($request->vote == 1){
                return new JsonResponse(['message' => 'Already upvoted'],Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $vote = Vote::where('post_id', $request->post_id)
                        ->where('user_id', Auth::user()->id)
                        ->first();
            $vote->vote = $request->vote;
            $vote->save();
        }
        return 'cannot use fake number';

    }

    public function check_if_user_voted_post($request) //put in camel case
    {
        $vote = Vote::where('post_id', $request->post_id)
                    ->where('user_id', Auth::user()->id)
                    ->first();

        if(!empty($vote)){
            return "voted";
        }
        return "not voted";
    }

    public function downvote(Request $request){

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Response as ResponseTrait;

class PostController extends Controller
{
    use ResponseTrait;
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
        if ($request->query('vote') == 1 || $request->query('vote') == 0) {
            $postExists = Post::where('id', $request->post_id)->first();

            if (!$postExists) {
                $this->failedResponse('post does not exist', Response::HTTP_BAD_REQUEST);
            }

            $hasUserVotedPost = $this->check_if_user_voted_post($request);

            if ($hasUserVotedPost) {
                if($hasUserVotedPost['vote'] == $request->query('vote'))
                {
                    $checkVoteType = ($request->query('vote') == 1) ?'Upvoted': 'Downvoted';
                    return $this->failedResponse('Already '. $checkVoteType, Response::HTTP_UNPROCESSABLE_ENTITY);
                }else{
                    if($this->updateVote($request)){
                        return $this->successResponse('vote successful', Response::HTTP_OK);
                    }
                }
            }else{
                if($this->createNewVote($request)){
                    return new JsonResponse([
                        'message' => 'vote successful'
                    ], Response::HTTP_OK);
                }
                return new JsonResponse([
                    'message' => 'An Error Occured'
                ], Response::HTTP_OK);
            }
        }
        return new JsonResponse([
        'message' => 'Cannot use'
        ], Response::HTTP_OK);
    }

    public function updateVote($request)
    {
        Vote::where('user_id', Auth::user()->id)
        ->where('post_id', $request->query('post_id'))
        ->update([
            'vote' => $request->query('vote')
        ]);
        return true;
    }

    public function createNewVote($request)
    {
        $vote = new Vote([
            'vote' => $request->query('vote'),
            'user_id' => Auth::user()->id,
            'post_id' => $request->query('post_id'),
        ]);
        $vote->save();
        return true;
    }

    public function check_if_user_voted_post($request) //put in camel case
    {
        $vote = Vote::where('post_id', $request->post_id)
                ->where('user_id', Auth::user()->id)
                ->first();
        return (!empty($vote)) ? $vote: false;
    }

}

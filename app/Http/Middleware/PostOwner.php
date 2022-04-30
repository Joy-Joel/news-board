<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostOwner
{
    /**
     * Handle an incoming request.RedirectResponse
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\
     */
    public function handle(Request $request, Closure $next)
    {
        $post = Post::where('id', $request->post_id)->first();

        if(Auth::user()->id !== $post->author_id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorised'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

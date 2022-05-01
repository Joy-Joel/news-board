<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authenticating User
Route::post('/register',  [AuthController::class, 'userRegister']);
Route::post('/login',     [AuthController::class, 'userLogin']);

Route::middleware(['auth:sanctum','isPostOwner'])->prefix('post')->group(function () {
    Route::post('/', [PostController::class, 'createPost'])
            ->withoutMiddleware('isPostOwner');

    Route::get('/', [PostController::class, 'getAllPost'])
            ->withoutMiddleware('isPostOwner');

    Route::post('/vote', [PostController::class, 'votePost'])
    ->withoutMiddleware('isPostOwner');

    Route::put('/update', [PostController::class, 'updatePost']);
    Route::delete('/delete', [PostController::class, 'deletePost']);
});

// Get all Comments
Route::get('/comment', [CommentController::class, 'getAllComment']);

Route::middleware(['auth:sanctum'])->prefix('comment')->group(function () {
    Route::post('/', [CommentController::class, 'createComment']);
    Route::put('/update', [CommentController::class, 'updateComment']);
    Route::delete('/delete', [CommentController::class, 'deleteComment']);
});

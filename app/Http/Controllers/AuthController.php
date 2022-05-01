<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateAccountRequest;

class AuthController extends Controller
{

    public function userRegister(CreateAccountRequest $request): JsonResponse
    {
        $request->validated();
            $registerUser = User::create([
                'username'  => $request->get('username'),
                'password' => Hash::make($request->get('password')),

            ]);

            if(!$registerUser->save()) {
                Log::error(
                    'failed to create user account',
                    [
                        'payload' => $request->except('password'),
                    ]
                    );
                return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return new JsonResponse([
                'message' => 'Registration Successful'
            ], Response::HTTP_CREATED);
    }

   //  For User login
   public function userLogin(LoginRequest $request): JsonResponse
   {
        $request->validated();

        if (!Auth::attempt($request->only(['username', 'password']))) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
        $token = $request->user()->createToken('authorize');

        return new JsonResponse(
            [
                'data' => [
                    'token' => $token->plainTextToken,
                ],
            ], Response::HTTP_OK
        );
   }


    // User Logout
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse([
            'message' => 'Logout Successful'
        ], Response::HTTP_OK);
    }

}

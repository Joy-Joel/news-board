<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function userRegister(Request $request)
    {
        //User Registration
        $validator = Validator::make($request->all(), [

            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        try {
            $registerUser = User::create([
                'username'  => $request->username,
                'password' => Hash::make($request->password),
            ]);
            $registerUser->save();
            return $this->success([
                'status'    => '200',
                'message'   => 'User Registered',
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

   //  For User login
   public function userLogin(LoginRequest $request)
   {
        $request->validated();

        if (!Auth::attempt($request->only(['email', 'password']))) {
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
    public function logout(Request $request)
    {
        try {

            return [
                'message' => 'Token Revoked!!!'
            ];
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
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

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
   public function userLogin(Request $request)
   {

       try {

           if (!Auth::attempt($request->only(['user', 'password']))) {
               return $this->error('Credentials not match', 401);
           }

           return $this->success([
               'message'=>'Logged In Successfully!',
               'data'=> [
                   'user'=> $request->user(),
               ]
           ]);
       } catch (Exception $e) {
           return $e->getMessage();
       }
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

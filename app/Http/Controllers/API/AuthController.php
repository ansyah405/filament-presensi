<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $req){
        $req->validate([
            /** 
             * Email
             * 
             * @example ansyah405@gmail.com
             */
            'email' => 'required|email|string', 
            /** 
             * Password
             * 
             * @example password
             */
            'password' => 'required|'
        ]);

        $user = User::where('email', $req->email)->first();

        if(!$user || ! Hash::check($req->password, $user->password)){
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Invalid Email or Password'
            ], 422);
        }

        $token  = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'success' => true,
            'data' =>  [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ],
            'message' => 'Login Successful'
        ]);

    }
}

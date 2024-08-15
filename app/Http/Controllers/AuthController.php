<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    

    public function logout(Request $request)
    {
        
        $request->user()->tokens()->delete();
        return [
            'message'=>'You are logged out'
        ];

    }

    public function register_new(Request $request)
    {

    Log::info('Login request data:', $request->all());
        
      $fields= $request->validate([
        'name'=>'required|max:255',
        'email'=>['required', 'email'],
        'email_verified_at'=>now(),
        'password'=>'required',
       

      ]);
    
      $user= User::create($fields);
      $token = $user->createToken($request->name);

      return[
        'user'=> $user,
        'token'=>$token->plainTextToken
      ];
    }
    public function login_new(Request $request){
        
        $credentials = $request->validate([
            
            'email'=> ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'Email or password is incorrect'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have permission to authenticate as admin'
            ], 403);
        }
        if (!$user->email_verified_at) {
            Auth::logout();
            return response([
                'message' => 'Your email address is not verified'
            ], 403);
        }
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
}
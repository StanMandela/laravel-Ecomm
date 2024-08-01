<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=> ['required', 'email','exists:users'],
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
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout(Request $request)
    {
        
        $request->user()->tokens()->delete();
        return [
            'message'=>'You are logged out'
        ];

    }

    public function register(Request $request)
    {
      $fields= $request->validate([
        'name'=>'required|max:255',
        'email'=>'required|email|unique:users',
        'password'=>'required|confirmed'
      ]);
    
      $user= User::create($fields);
      $token = $user->createToken($request->name);

      return[
        'user'=> $user,
        'token'=>$token->plainTextToken
      ];
    }
    public function login2(Request $request){
        
        $request->validate([
            'email'=> ['required', 'email','exists:users'],
            'password' => 'required',
           
        ]);
        $user = User::where('email', $request->email)->first();
       
        if(!$user || Hash::check($request->password,$user->password)){
            return[
                'message'=>"The provided credentials are incorrect"
            ];
        }
        $token = $user->createToken($user->name);

        return[
          'user'=> $user,
          'token'=>$token->plainTextToken
        ];
    }
}
<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;


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

   // Log::info('Register user data:', $request->all());
        
      $fields= $request->validate([
        'name'=>'required|max:255',
        'last_name'=>'required|max:255',
        'email'=>['required', 'email'],
        'email_verified_at'=>now(),
        'password'=>'required',
    
      ]);
    try{
      $user= User::create($fields);
      $token = $user->createToken($request->name);
    
      return[
        'user'=> $user,
        'token'=>$token->plainTextToken
      ];
    }catch (QueryException $e) {
        if ($e->getCode() === '23000') { // Integrity constraint violation
            return response()->json([
                'status'=> false,
                'message' => 'Email already in use'
            ], 409);
            Log::error('error occured:', $e);

        }

        return response()->json(['message' => 'An unexpected error occurred'], 500);
    }
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
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }
    public function getUser(Request $request){

        return new UserResource($request->user());
    }
    public function sendTestEmail()
    {
        $data = [
            'name' => 'John Doe',
        ];
    
        Mail::to('recipient@example.com')->send(new MyEmail($data));
    
        return "Test email sent!";
    }
}
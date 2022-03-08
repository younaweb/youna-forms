<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register(Request $request)
   {
    //    return response($request);
       $data=$request->validate([
           'name'=>'required|string',
           'email'=>'required|string|email|unique:users,email',
           'password'=>'required|confirmed|min:6|max:20',
       ]);
       $user=User::create([
           'name'=>$data['name'],
           'email'=>$data['email'],
           'password'=>bcrypt($data['password']),
       ]);
       $token=$user->createToken('myAppToken')->plainTextToken;
       $response=[
           'user'=>$user,
           'token'=>$token,
       ];
       return response($response,201);
   }

   public function login(Request $request)
   {
       $credentials=$request->validate([
           'email'=>'',
           'password'=>'',
           'remember'=>'boolean'
       ]);
       $remember=$credentials['remember']??false;
       unset($credentials['remember']);

       if(! Auth::attempt($credentials,$remember)){
           return response([
               'error'=>"Credentials incorrect"],422);
       }
       $token=auth()->user->createToken('myAppToken')->plainTextToken;
       $response=[
           'user'=>auth()->user(),
           'token'=>$token,
       ];
       return response($response,200);

   }
}

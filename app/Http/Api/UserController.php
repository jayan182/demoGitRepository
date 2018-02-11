<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function getUserData(Request $request){
        try{
            return User::all();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function login(Request $request){
        try{
            $credentials = $request->only(['email', 'password']);
            $email = $request->get('email');

            $username = User::where('email','=',$email)->first();
            if(!$username){
                return response()->json("Invalid email or password");
            }
            else{
                try {
                    if(!$token = JWTAuth::attempt($credentials)) {
                        return $this->response->errorUnauthorized();
                    }
                } catch (JWTException $e) {
                    return $e->getMessage();
                }
                return response()->json(compact('username','token'));
            }
        }catch(\Exception $e){
            //return $e->getMessage();
			return $e->getMessage();//add by user a
        }
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function login(Request $request){
        try{
            $client = new Client(['base_uri'=>'http://localhost:8016/api/']);
            $response = $client->request('post','login',[
                'form_params' =>[
                    'email' => $request->get('email'),
                    'password' => $request->get('password')
                ]
            ]);
            $userapi = \GuzzleHttp\json_decode($response->getBody()->getContents())->username;
            $user = new User();
            $user->id = $userapi->id;
            $user->email = $userapi->email;
            Auth::login($user);
            return view('jwt.homepage');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getUserData(){
        try{
            /*$user = JWTAuth::toUser($request->token);
            return response()->json(['result' => $user]);*/
            $token= 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAxNi9hcGkvbG9naW4iLCJpYXQiOjE1MDYzMDcwMDcsImV4cCI6MTUwNjMxMDYwNywibmJmIjoxNTA2MzA3MDA3LCJqdGkiOiJldXFOSFBSSkx4cjl6QXk3In0.gTUudfZQPE1pPnQwWl30BkNElgvHcKpQvjVuOGqqnYI';
            $client = new Client(['base_uri'=>'http://localhost:8016/api/']);
            $response = $client->request('get','getUserData'.'?token='.$token);
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            print_r($data);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

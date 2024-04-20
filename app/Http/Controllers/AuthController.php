<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid login"], 401);
        }

        if(Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $user->token = bcrypt($user->id);
            $user->save();

            return response()->json(['token' => $user->token], 200);
        } else {
            return response()->json(["message" => "Invalid login"], 401);
        }
    }


    public function logout(){
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json(["message" => "logout success"], 200);
    }
}

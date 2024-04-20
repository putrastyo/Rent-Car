<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
{
    public function register(Request $request){

        // jika bukan admin maka tidak boleh register
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }

        // validasi
        $validator = FacadesValidator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'phone' => '081234565'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid login"], 401);
        }


        // simpan database
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        // return json
        return response()->json(['message' => 'success'], 200);
    }

    public function index(){
        // jika admin, tampilkan semua
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }

        $users = User::all();
        return response()->json($users);

    }


    public function update(Request $request, string $id){
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }

        // validasi
        $validator = FacadesValidator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid login"], 401);
        }


        // simpan database
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        // return json
        return response()->json(['message' => 'success'], 200);
    }


    public function destroy(Request $request, string $id){
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }

        // validasi
        $validator = FacadesValidator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid login"], 401);
        }


        // simpan database
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        // return json
        return response()->json(['message' => 'success'], 200);
    }
}

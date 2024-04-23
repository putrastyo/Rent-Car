<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        // 1. jika bukan admin maka tidak boleh register
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 401);
        }
        // 3. simpan database
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();
        // 4. return json
        return response()->json(['message' => 'create Register success'], 200);
    }

    /**
     * Get users.
     */
    public function index(){
        // 1. jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. tampilkan
        $users = User::all();
        // 3. return
        return response()->json($users);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. get data by id
        $user = User::find($id);
        // 2. Jika data tidak ditemukan
        if(!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        // 3. return json
        return response()->json($user);
    }

    public function update(Request $request, string $id){
        // 1. Jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid login"], 401);
        }
        // 3. simpan database
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();
        // 4. return json
        return response()->json(['message' => 'update Register success'], 200);
    }

    public function destroy(string $id){
        // 1. Jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. delete
        $user = User::find($id);
        if(!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        $user->delete();

        // 3. return json
        return response()->json(['message' => 'delete Register success'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CarReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            $carReturns = CarReturn::all();
        } else {
            $carReturns = CarReturn::where('user_id', Auth::user()->id)->get();
        }

        return response()->json($carReturns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != 'admin') {
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'rent_id' => 'required|exists:users,id', // ada di kolom user id
            'penalty_id' => 'required|exists:users,id', // ada di kolom user id
            'date_return' => 'required',
            'total' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422); // jika data tidak valid
        }
        // 3. simpan database
        $carReturn = new CarReturn(); // menambah data
        $carReturn->rent_id = $request->rent_id;
        $carReturn->penalty_id = $request->penalty_id;
        $carReturn->date_return = $request->date_return;
        $carReturn->total = $request->total;
        $carReturn->save();

        // 4. return json
        return response()->json(['message' => 'Car Return success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. get data by id
        $carReturn = CarReturn::find($id);
        // 2. Jika data tidak ditemukan
        if(!$carReturn) {
            return response()->json(["message" => "Car Return not found"], 404);
        }
        // 3. return json
        return response()->json($carReturn);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->role != 'admin') {
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'rent_id' => 'required|exists:users,id', // ada di kolom user id
            'penalty_id' => 'required|exists:users,id', // ada di kolom user id
            'date_return' => 'required',
            'total' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422);
        }
        // 3. update data di database
        $carReturn = CarReturn::find($id); // memperbarui data
        $carReturn->rent_id = $request->rent_id;
        $carReturn->penalty_id = $request->penalty_id;
        $carReturn->date_return = $request->date_return;
        $carReturn->total = $request->total;
        $carReturn->save();

        // 4. return json
        return response()->json(['message' => 'update Car Return success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. delete
        $carReturn = CarReturn::find($id);

        if(!$carReturn) {
            return response()->json(["message" => "Car Return not found"], 404);
        }
        $carReturn->delete();

        // 3. return json
        return response()->json(['message' => 'delete Car Return success'], 200);
    }
}

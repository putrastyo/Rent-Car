<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Jika admin, maka tampilkan semua, jika bukan admin, tampilkan yang dia punya
        if(Auth::user()->role == 'admin') {
            $rents = Rent::all();
        } else {
            $rents = Rent::where('user_id', Auth::user()->id)->get();
        }

        return response()->json($rents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)  // add data
    {
        // 1. Jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin') {
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // ada di kolom user id
            'tenant' => 'required',
            'no_car' => 'required',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'total' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422); // jika data tidak valid
        }
        // 3. simpan database
        $rent = new Rent(); // menambah data
        $rent->user_id = $request->user_id;
        $rent->tenant = $request->tenant;
        $rent->no_car = $request->no_car;
        $rent->date_borrow = $request->date_borrow;
        $rent->date_return = $request->date_return;
        $rent->down_payment = $request->down_payment;
        $rent->total = $request->total;
        $rent->save();

        // 4. return json
        return response()->json(['message' => 'create Rent success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. get data by id
        $rent = Rent::find($id);
        // 2. Jika data tidak ditemukan
        if(!$rent) {
            return response()->json(["message" => "Rent not found"], 404);
        }
        // 3. return json
        return response()->json($rent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin') {
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. validasi
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tenant' => 'required',
            'no_car' => 'required',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'total' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422);
        }
        // 3. update data di database
        $rent = Rent::find($id); // memperbarui data
        $rent->user_id = $request->user_id;
        $rent->tenant = $request->tenant;
        $rent->no_car = $request->no_car;
        $rent->date_borrow = $request->date_borrow;
        $rent->date_return = $request->date_return;
        $rent->down_payment = $request->down_payment;
        $rent->total = $request->total;
        $rent->save();

        // 4. return json
        return response()->json(['message' => 'update Rent success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Jika bukan admin, maka tidak boleh
        if(Auth::user()->role != 'admin'){
            return response()->json(["message" => "Forbidden"], 403);
        }
        // 2. delete
        $rent = Rent::find($id);

        if(!$rent) {
            return response()->json(["message" => "Rent not found"], 404);
        }
        $rent->delete();

        // 3. return json
        return response()->json(['message' => 'delete Rent success'], 200);
    }
}

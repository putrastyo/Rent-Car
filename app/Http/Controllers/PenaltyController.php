<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            $penalties = Penalty::all();
        } else {
            $penalties = Penalty::where('user_id', Auth::user()->id)->get();
        }

        return response()->json($penalties);
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
            'user_id' => 'required|exists:users,id', // ada di kolom user id
            'no_car' => 'required',
            'keterangan' => 'required',
            'total' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422); // jika data tidak valid
        }
        // 3. simpan database
        $penalty = new Penalty(); // menambah data
        $penalty->user_id = $request->user_id;
        $penalty->no_car = $request->no_car;
        $penalty->keterangan = $request->keterangan;
        $penalty->total = $request->total;
        $penalty->save();

        // 4. return json
        return response()->json(['message' => 'create Penalty success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. get data by id
        $penalty = Penalty::find($id);
        // 2. Jika data tidak ditemukan
        if(!$penalty) {
            return response()->json(["message" => "Penalty not found"], 404);
        }
        // 3. return json
        return response()->json($penalty);
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
            'user_id' => 'required|exists:users,id', // ada di kolom user id
            'no_car' => 'required',
            'keterangan' => 'required',
            'total' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(["message" => "Invalid field"], 422);
        }
        // 3. update data di database
        $penalty = Penalty::find($id); // memperbarui data
        $penalty->user_id = $request->user_id;
        $penalty->no_car = $request->no_car;
        $penalty->keterangan = $request->keterangan;
        $penalty->total = $request->total;
        $penalty->save();

        // 4. return json
        return response()->json(['message' => 'update Penalty success'], 200);
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
        $penalty = Penalty::find($id);

        if(!$penalty) {
            return response()->json(["message" => "Penalty not found"], 404);
        }
        $penalty->delete();

        // 3. return json
        return response()->json(['message' => 'delete Penalty success'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $riwayats = Riwayat::all();

        return response()->json($riwayats, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jemput' => 'required|integer',
            'tanggal' => 'required|date',
            'koin' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $riwayat = Riwayat::create($request->all());

        return response()->json($riwayat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $riwayat = Riwayat::findOrFail($id);

        return response()->json($riwayat, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_jemput' => 'required|integer',
            'tanggal' => 'required|date',
            'koin' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $riwayat = Riwayat::findOrFail($id);
        $riwayat->update($request->all());

        return response()->json($riwayat, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
    public function request_pencairan($id){
        $pencairan=riwayat::find($id);
        $pencairan->update(['status'=>'request penukaran']) ;
        return response()->json(['message'=> 'request penukaran','data'=>$pencairan]);
    }
    public function validasi_pencairan($id){
        $pencairan=riwayat::find($id);
        $pencairan->update(['status'=>'sudah di tukarkan']) ;
        return response()->json(['message'=> 'sudah di tukarkan','data'=>$pencairan]);
    }
        
    }



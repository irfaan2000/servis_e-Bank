<?php

namespace App\Http\Controllers;

use App\Models\Outlite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OutliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $outlites = Outlite::where('status','validasi')->get();

        return response()->json($outlites, 200);
    }
    public function index_belum_valid()
    {
        $outlites = Outlite::where('status','belum validasi')->get();

        return response()->json($outlites, 200);
    }
    public function user_valid($id)
    {
        $outlites = Outlite::find($id);
        $outlites->update(['status'=>'sudah di validasi']);

        return response()->json($outlites, 200);
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
            'id_user' => 'required|integer',
            'nama_outlite' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'status' => 'required|string',
            'lng' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $outlite = Outlite::create($request->all());

        return response()->json($outlite, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $outlite = Outlite::findOrFail($id);

        return response()->json($outlite, 200);
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
            'id_user' => 'required|integer',
            'nama_outlite' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'status' => 'required|string',
            'lng' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $outlite = Outlite::findOrFail($id);
        $outlite->update($request->all());

        return response()->json($outlite, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $outlite = Outlite::findOrFail($id);
        $outlite->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
    public function findNearestOutlite($latitude, $longitude)
    {
        $earthRadius = 6371; // Radius Bumi dalam kilometer

        $outlite = DB::table('outlites')
        ->select('id', 'nama_outlite', 'alamat', 'no_hp', 'status', 'lat', 'lng')
        ->selectRaw(
            "(CASE
                WHEN ( $earthRadius * acos( cos( radians(?) ) *
                    cos( radians( lat ) )
                    * cos( radians( lng ) - radians(?)
                    ) + sin( radians(?) ) *
                    sin( radians( lat ) ) )
                ) < 1 THEN
                CONCAT(( $earthRadius * acos( cos( radians(?) ) *
                    cos( radians( lat ) )
                    * cos( radians( lng ) - radians(?)
                    ) + sin( radians(?) ) *
                    sin( radians( lat ) ) )
                ) * 1000, ' m')
                ELSE
                CONCAT(( $earthRadius * acos( cos( radians(?) ) *
                    cos( radians( lat ) )
                    * cos( radians( lng ) - radians(?)
                    ) + sin( radians(?) ) *
                    sin( radians( lat ) ) )
                ), ' km')
            END) AS distance",
            [$latitude, $longitude, $latitude, $latitude, $longitude, $latitude, $latitude, $longitude, $latitude]
        )
        ->orderBy('distance')
        ->where('status','sudah di validasi')
        ->get();
        return response()->json($outlite);
    }

}

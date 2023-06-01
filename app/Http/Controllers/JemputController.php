<?php

namespace App\Http\Controllers;

use App\Models\Jemput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JemputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $jemputs = Jemput::all();

        return response()->json($jemputs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'id_user' => 'required|integer',
        //     'id_outlite' => 'required|integer',
        //     'kategori_sampah' => 'required|string',
        //     'tanggal' => 'required|date',
        //     'alamat' => 'required|string',
        //     'catatan' => 'required|string',
        //     'lat' => 'required|numeric',
        //     'lng' => 'required|numeric',
        //     'status' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        $earthRadius = 6371; // Radius Bumi dalam kilometer

        $outlite = DB::table('outlites')
            ->select('id', 'nama_outlite', 'alamat', 'no_hp', 'status', 'lat', 'lng')
            ->selectRaw(
                "( $earthRadius * acos( cos( radians(?) ) *
                cos( radians( lat ) )
                * cos( radians( lng ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( lat ) ) )
                ) AS distance",
                [$request->lat, $request->lng, $request->lat]
            )
            ->whereRaw(
                "( $earthRadius * acos( cos( radians(?) ) *
                cos( radians( lat ) )
                * cos( radians( lng ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( lat ) ) )
                ) <= 20",
                [$request->lat, $request->lng, $request->lat]
            )
            ->orderBy('distance')
            ->first();
            $outlite2 = DB::table('outlites')
            ->select('id', 'nama_outlite', 'alamat', 'no_hp', 'status', 'lat', 'lng')
            ->selectRaw(
                "( $earthRadius * acos( cos( radians(?) ) *
                cos( radians( lat ) )
                * cos( radians( lng ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( lat ) ) )
                ) AS distance",
                [$request->lat, $request->lng, $request->lat]
            )
            ->orderBy('distance')
            ->first(1);
            if($outlite==null){
                return response()->json([
                    'status'=>'maaf terlalu jauh mas',
                    'data'=>$outlite2
                ]);
            }
            $jemput = Jemput::create([
                'id_user'=>$request->id_user,
                'id_outlite'=>$outlite->id,
                'kategori_sampah'=>$request->kategori_sampah,
                'tanggal'=>$request->tanggal,
                'alamat'=>$request->alamat,
                'catatan'=>$request->catatan,
                'status'=>'belum di jemput',
                'lat'=>$request->lat,
                'lng'=>$request->lng
            ]);

        

        return response()->json($jemput, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $jemput = Jemput::findOrFail($id);

        return response()->json($jemput, 200);
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
            'id_outlite' => 'required|integer',
            'kategori_sampah' => 'required|string',
            'tanggal' => 'required|date',
            'alamat' => 'required|string',
            'catatan' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $jemput = Jemput::findOrFail($id);
        $jemput->update($request->all());

        return response()->json($jemput, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $jemput = Jemput::findOrFail($id);
        $jemput->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
    public function valid_jemput($id){
        $jemput=jemput::find($id);
        $jemput->update(['status'=>'valid']);
        return response()->json(['message'=> 'sudah di jemput','data'=>$jemput]);
    }
    public function segera_jemput($id){
        $jemput=jemput::find($id);
        $jemput->update(['status'=>'segera di jemput']);
        return response()->json(['message'=> 'segera di jemput','data'=>$jemput]);}
}

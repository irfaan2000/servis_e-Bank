<?php

namespace App\Http\Controllers;

use App\Models\Sedekah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SedekahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil semua data sedekah dari database
        $sedekahs = Sedekah::all();

        // Kirim daftar sedekah sebagai respons JSON
        return response()->json($sedekahs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        // $validator = Validator::make($request->all(), [
        //     'nama_sampah' => 'required|string',
        //     'foto' => 'required|string',
        //     'opsi' => 'required|string',
        //     'lat' => 'nullable|numeric',
        //     'lng' => 'nullable|numeric',
        //     'status' => 'required|string',
        // ]);

        // // Jika validasi gagal, kirim pesan validasi sebagai respons JSON
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        // Buat entri sedekah baru dalam database
        $file = $request->file('foto');
        $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file
        $path = $file->storeAs('public/image', $filename); // Menyimpan file di folder public dengan nama asli
    
        $sedekah = Sedekah::create([
            'id_user'=>$request->id_user,
            'id_outlite'=>$request->id_outlite,
            'nama_sampah' => $request->nama_sampah,
            'foto' => $filename, // Menyimpan nama file di kolom 'foto'
            'opsi' => $request->opsi,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $request->status,
        ]);

        // Kirim sedekah baru sebagai respons JSON dengan kode respons 201 (Created)
        return response()->json($sedekah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Cari sedekah berdasarkan ID
        $sedekah = Sedekah::findOrFail($id);

        // Kirim detail sedekah sebagai respons JSON
        return response()->json($sedekah, 200);
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
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'nama_sampah' => 'required|string',
            'foto' => 'required|string',
            'opsi' => 'required|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        // Jika validasi gagal, kirim pesan validasi sebagai respons JSON
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Cari sedekah berdasarkan ID
        $sedekah = Sedekah::findOrFail($id);

        // Update sedekah dengan data yang diterima dari permintaan
        $sedekah->update($request->all());

        // Kirim sedekah yang diperbarui sebagai respons JSON dengan kode respons 200 (OK)
        return response()->json($sedekah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Cari sedekah berdasarkan ID
        $sedekah = Sedekah::findOrFail($id);

        // Hapus sedekah
        $sedekah->delete();

        // Kirim pesan sukses sebagai respons JSON dengan kode respons 200 (OK)
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
    public function valid_sedekah($id){
        $sedekah=sedekah::find($id);
        $sedekah->update(['status'=>'valid']);
        return response()->json(['message'=> 'sudah di validasi','data'=>$sedekah]);
    }
    public function jemput_sedekah($id){
        $sedekah=sedekah::find($id);
        $sedekah->update(['status'=>'segera di jemput']);
        return response()->json(['message'=> 'segera di jemput','data'=>$sedekah]);
    }

}

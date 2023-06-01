<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users|max:255',
        //     'password' => 'required|string|min:6',
        //     'alamat' => 'nullable|string',
        //     'no_hp' => 'nullable|string',
        //     'foto' => 'nullable|string',
        // ]);

        // // Jika validasi gagal, kirim pesan validasi sebagai respons JSON
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        // Buat entri pengguna baru dalam database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'=>$request->role
        ]);
        $token = $user->createToken('api_token')->plainTextToken;


        // Kirim respons sukses dengan kode respons 201 (Created)
        return response()->json(['message' => 'Registration successful',
            'data'=>$user,
            'token'=>$token
    ], 201);
    }

    /**
     * Log in an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Ambil kredensial login dari permintaan
        $credentials = $request->only('email', 'password');

        // Coba melakukan login menggunakan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json(['token' => $token,
            'data'=>$user
        ], 200);
        } else {
            // Kirim pesan kesalahan jika kredensial tidak valid
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    /**
     * Log out the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Lakukan logout pengguna terautentikasi

        // Kirim pesan sukses dengan kode respons 200 (OK)
        return response()->json(['message' => 'Logged out'], 200);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // Dapatkan detail pengguna terautentikasi
        $user = Auth::user();

        // Kirim detail pengguna sebagai respons JSON
        return response()->json($user, 200);
    }
    public function lihat_user(){
        $user=User::where('role','user')->get();
        return response()->json(['status'=>'succes','data'=>$user]);
    }
    
    public function ganti_userrole($id){
        $user=User::find($id);
        $user->update(['role'=>'admin_outlite']);
        return response()->json(['status'=>'succes','data'=>$user]);
    }
    
}

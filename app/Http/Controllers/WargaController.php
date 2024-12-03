<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wargas = Warga::all();
        
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data warga berhasil diambil'
            ],
            'data' => $wargas,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'meta' => [
                'code' => 405,
                'status' => 'error',
                'message' => 'Method not allowed'
            ],
            'data' => [],
        ], 405);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:50|unique:warga,no_kk',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:warga,nik',
            'alamat' => 'required|string',
            'rt_alamat' => 'required|string|max:2', 
            'no_telp_hp' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|in:L,P',
        ]);

        $warga = Warga::create($validated);

        if (!$warga) {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Data warga gagal disimpan'
                ],
                'data' => [],
            ], 400);
        }

        return response()->json([
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Data warga berhasil disimpan'
            ],
            'data' => $warga,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warga = Warga::find($id);
        if (!$warga) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Data warga tidak ditemukan'
                ],
                'data' => [],
            ], 404);
        }
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data warga berhasil diambil'
            ],
            'data' => $warga,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $warga = Warga::find($id);
        if (!$warga) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Data warga tidak ditemukan'
                ],
                'data' => [],
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'nik' => 'sometimes|required|string|max:16|unique:warga,nik,' . $id,
            'alamat' => 'sometimes|required|string',
            'no_telp_hp' => 'sometimes|required|string',
            'tgl_lahir' => 'sometimes|required|date',
        ]);
        
        $warga->update($validated);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data warga berhasil diupdate'
            ],
            'data' => $warga,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warga = Warga::find($id);
        if (!$warga) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Data warga tidak ditemukan'
                ],
                'data' => [],
            ], 404);
        }

        $warga->delete();
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data warga berhasil dihapus'
            ],
            'data' => [],
        ], 200);
    }
}

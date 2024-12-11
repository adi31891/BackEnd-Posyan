<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'code' => 200,
                'status' => 'success',
                'message' => 'Form create berhasil diambil'
            ],
            'data' => [
                'master_tables' => [

                    'genders' => ['L' => 'Laki-laki', 'P' => 'Perempuan']
                ]
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
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

            return response()->json([
                'meta' => [
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Data warga berhasil disimpan',
                    'new_id' => $warga->id
                ],
                'data' => $warga,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                'data' => [],
            ], 400);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
                'message' => 'Form edit berhasil diambil'
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

        try {
            $validated = $request->validate([
                'nama' => 'sometimes|required|string|max:255',
                'nik' => 'sometimes|required|string|max:16|unique:warga,nik,' . $id,
                'alamat' => 'sometimes|required|string|max:255',
                'no_telp_hp' => 'sometimes|required|string|max:20',
                'tempat_lahir' => 'sometimes|required|string|max:50',
                'tgl_lahir' => 'sometimes|required|date',
                'Jenis_Kelamin' => 'sometimes|required|in:L,P',
                'rt_alamat' => 'sometimes|required|string|max:2',
                'is_deleted' => 'sometimes|boolean',
                'is_meninggal' => 'sometimes|boolean',
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
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                'data' => [],
            ], 400);
        }
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

        try {
            $warga->delete();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data warga berhasil dihapus'
                ],
                'data' => [],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                'data' => [],
            ], 400);
        }
    }
}

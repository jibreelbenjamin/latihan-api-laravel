<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::all();
        return response()->json($data, 200);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'data ditemukan',
        //     'data' => $data
        // ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataBuku = new Buku;

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;
        
        try { // error handling menggunakan try catch
            $post = $dataBuku->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memasukan data',
                'data' => $dataBuku
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage() // memuat error
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);
        if($data){ // null handling
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;
        
        try { // error handling menggunakan try catch
            $post = $dataBuku->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil update data',
                'data' => $dataBuku
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage() // memuat error
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }
        
        try { // error handling menggunakan try catch
            $post = $dataBuku->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil hapus data',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage() // memuat error
            ], 500);
        }
    }
}

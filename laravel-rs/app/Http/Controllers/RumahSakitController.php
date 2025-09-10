<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    public function index()
    {
        $rumahsakit = RumahSakit::latest()->get();
        return view('rumahsakit.index', compact('rumahsakit'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_rumah_sakit' => 'required|string|max:255',
                'alamat' => 'required|string',
                'email' => 'required|email|unique:rumah_sakit,email',
                'telepon' => 'required|string|max:20'
            ]);

            RumahSakit::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data',
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    public function edit($id)
    {
        try {
            $rumahsakit = RumahSakit::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $rumahsakit
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rumahsakit = RumahSakit::findOrFail($id);

            $request->validate([
                'nama_rumah_sakit' => 'required|string|max:255',
                'alamat' => 'required|string',
                'email' => 'required|email|unique:rumah_sakit,email,'.$id,
                'telepon' => 'required|string|max:20'
            ]);

            $rumahsakit->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data',
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $rumahsakit = RumahSakit::findOrFail($id);
            $rumahsakit->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ], 422);
        }
    }
}
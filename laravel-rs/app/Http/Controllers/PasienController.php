<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::with('rumahSakit')->latest()->get();
        $rumahsakit = RumahSakit::all();
        return view('pasien.index', compact('pasien', 'rumahsakit'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_pasien' => 'required',
                'alamat' => 'required',
                'no_telepon' => 'required',
                'rumah_sakit_id' => 'required|exists:rumah_sakit,id'
            ]);

            Pasien::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama_pasien' => 'required',
                'alamat' => 'required',
                'no_telepon' => 'required',
                'rumah_sakit_id' => 'required|exists:rumah_sakit,id'
            ]);

            $pasien = Pasien::findOrFail($id);
            $pasien->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            $pasien->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getByRumahSakit($id)
    {
        $pasien = Pasien::with('rumahSakit')
            ->where('rumah_sakit_id', $id)
            ->get();
        return response()->json($pasien);
    }
}

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

    public function getByRumahSakit($id)
    {
        $pasien = Pasien::where('rumah_sakit_id', $id)->get();
        return response()->json($pasien);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'rumah_sakit_id' => 'required'
        ]);

        Pasien::create($request->all());
        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $pasien = Pasien::find($id);
        return response()->json($pasien);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'rumah_sakit_id' => 'required'
        ]);

        Pasien::find($id)->update($request->all());
        return response()->json(['success' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        Pasien::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}

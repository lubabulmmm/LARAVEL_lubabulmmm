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
        $request->validate([
            'nama_rumah_sakit' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'telepon' => 'required'
        ]);

        RumahSakit::create($request->all());
        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $rumahsakit = RumahSakit::find($id);
        return response()->json($rumahsakit);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rumah_sakit' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'telepon' => 'required'
        ]);

        RumahSakit::find($id)->update($request->all());
        return response()->json(['success' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        RumahSakit::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}

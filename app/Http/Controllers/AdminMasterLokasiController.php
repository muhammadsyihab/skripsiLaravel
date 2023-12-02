<?php

namespace App\Http\Controllers;

use App\Models\MasterLokasi;
use Illuminate\Http\Request;

class AdminMasterLokasiController extends Controller
{
    public function index()
    {
        $title = "Lokasi";
        $lokasi = MasterLokasi::all();
        return view('master_lokasi.index', compact('lokasi', 'title'));
    }

    public function create()
    {
        $title = "Tambah Lokasi";
        return view('master_lokasi.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'lattitude' => 'required',
            'longtitude' => 'required',
            'radius' => 'required',
        ]);

        MasterLokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'lattitude' => $request->lattitude,
            'longtitude' => $request->longtitude,
            'radius' => $request->radius,
        ]);

        return redirect()->route('lokasi.index')->with('success', 'Berhasil di input');
    }

    public function edit($id)
    {
        $title = "Edit Lokasi";
        $lokasi = MasterLokasi::where('id', $id)->first();
        return view('master_lokasi.edit', compact('lokasi', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'lattitude' => 'required',
            'longtitude' => 'required',
            'radius' => 'required',
        ]);

        MasterLokasi::where('id', $id)->update([
            'nama_lokasi' => $request->nama_lokasi,
            'lattitude' => $request->lattitude,
            'longtitude' => $request->longtitude,
            'radius' => $request->radius,
        ]);

        return redirect()->route('lokasi.index')->with('success', 'Berhasil di update');
    }

    public function destroy($id)
    {
        MasterLokasi::where('id', $id)->delete();
        return redirect()->route('lokasi.index')->with('danger', 'Berhasil di delete');
    }
}

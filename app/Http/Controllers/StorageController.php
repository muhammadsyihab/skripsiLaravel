<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index()
    {
        $title = "Storage";
        $storages = Storage::all();
        return view('storage.index', compact('storages', 'title'));
    }

    public function create()
    {
        $title = "Tambah Data Storage";
        $locations = MasterLokasi::all();
        return view('storage.create', compact('locations', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_lokasi_id' => 'required',
            'nama_storage' => 'required',
            'kapasitas' => 'required',
        ]);

        Storage::create([
            'master_lokasi_id' => $request->master_lokasi_id,
            'nama_storage' => $request->nama_storage,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('storage.index')->with('success', 'Berhasil di input');
    }

    public function edit($id)
    {
        $title = "Edit Data Storage";
        $locations = MasterLokasi::all();
        $storageById = Storage::where('id', $id)->first();
        return view('storage.edit', compact('locations', 'storageById', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_lokasi_id' => 'required',
            'nama_storage' => 'required',
            'kapasitas' => 'required',
        ]);

        Storage::where('id', $id)->update([
            'master_lokasi_id' => $request->master_lokasi_id,
            'nama_storage' => $request->nama_storage,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('storage.index')->with('success', 'Berhasil di update');
    }

    public function delete(Request $request, $id)
    {
        MasterLokasi::where('id', $id)->delete();
        return redirect()->route('storage.index')->with('danger', 'Berhasil di delete');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\AdminMasterSparepartResource;
use PDF;

class AdminMasterSparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'sparepart')->get();

        return view('master_sp.index', [
            'spareparts' => AdminMasterSparepartResource::collection($spareparts),
        ]);
    }

    public function indexOli()
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'oli')->get();

        return view('master_sp.index', [
            'spareparts' => AdminMasterSparepartResource::collection($spareparts),
        ]);
    }

    public function create()
    {
        return view('master_sp.create');
    }

    public function createOli()
    {
        return view('master_sp.createOli');
    }

    public function store(Request $request)
    {
        $request->validate([    
            'nama_item' => 'required',
            'part_number' => 'required',
            'uom' => 'required',
        ]);

        if(!isset($request->qty)) 
            $request->qty = 0;

        Sparepart::create([
            'nama_item' => $request->nama_item,
            'part_number' => $request->part_number,
            'uom' => $request->uom,
            'jenis' => 'sparepart',
            'qty' => $request->qty,
        ]);

        return redirect()->route('sparepart.index')->with('success', 'Berhasil di input');
        
    }

    public function storeOli(Request $request)
    {
        $request->validate([    
            'nama_item' => 'required',
            'part_number' => 'required',
            'uom' => 'required',
        ]);

        if(!isset($request->qty)) 
            $request->qty = 0;

        Sparepart::create([
            'nama_item' => $request->nama_item,
            'part_number' => $request->part_number,
            'uom' => $request->uom,
            'jenis' => 'oli',
            'qty' => $request->qty,
        ]);

        return redirect()->route('oli.index')->with('success', 'Berhasil di input');
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sparepart = Sparepart::where('id', $id)->first();
        return view('master_sp.edit', [
            'sparepart' => $sparepart,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required',
            'part_number' => 'required',
            'uom' => 'required',
        ]);

        $spareparts = Sparepart::where('id', $id);

        $spareparts->update([
            'nama_item' => $request->nama_item,
            'part_number' => $request->part_number,
            'uom' => $request->uom,
        ]);

        return redirect()->route('sparepart.index')->with('success', 'Berhasil di update');
    }

    public function editOli($id)
    {
        $sparepart = Sparepart::where('id', $id)->first();
        return view('master_sp.editOli', [
            'sparepart' => $sparepart,
        ]);
    }

    public function updateOli(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required',
            'part_number' => 'required',
            'uom' => 'required',
        ]);

        $spareparts = Sparepart::where('id', $id);

        $spareparts->update([
            'nama_item' => $request->nama_item,
            'part_number' => $request->part_number,
            'uom' => $request->uom,
        ]);

        return redirect()->route('oli.index')->with('success', 'Berhasil di update');
    }

    public function destroy($id)
    {
        $sparepartById = Sparepart::find($id);
        $jenis = $sparepartById->jenis;
        $sparepartById->delete();
        
        if ($jenis == 'sparepart') {
            return redirect()->route('sparepart.index')->with('danger', 'Berhasil di delete');
        } elseif($jenis == 'oli') {
            return redirect()->route('oli.index')->with('danger', 'Berhasil di delete');
        }
    }

    public function pdf(Request $request)
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'sparepart')->get();

        $pdf = PDF::loadView('pdf.sparepart', [
            'spareparts' => $spareparts,
        ]);

        return $pdf->stream('SparePart.pdf');
    }

    public function excel(Request $request)
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'sparepart')->get();

        return view('excel.sparepart', [
            'spareparts' => $spareparts,
        ]);
    }

    public function pdfOli(Request $request)
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'oli')->get();

        $pdf = PDF::loadView('pdf.sparepart_oli', [
            'spareparts' => $spareparts,
        ]);

        return $pdf->stream('SparePart.pdf');
    }

    public function excelOli(Request $request)
    {
        $spareparts = Sparepart::with('unit')->where('jenis', 'oli')->get();

        return view('excel.sparepart_oli', [
            'spareparts' => $spareparts,
        ]);
    }

}

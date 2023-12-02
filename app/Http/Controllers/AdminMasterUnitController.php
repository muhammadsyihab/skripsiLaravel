<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Unit;
use App\Models\DailyUnit;
use App\Imports\UnitExcel;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\MasterUnitResource;

class AdminMasterUnitController extends Controller
{
    public function index()
    {
        $locations = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $locations = DB::table('master_lokasi')->get();
            $units = DB::table('master_unit')
            ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->select(
                'master_unit.*',
                'master_lokasi.nama_lokasi',
                DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger'),
                // DB::raw("
                //     (
                //         SELECT waktu_insiden 
                //         FROM tb_tiketing 
                //         WHERE master_unit_id = master_unit.id 
                //     ) 
                //     AS hm_bd"
                // ),
                // DB::raw("
                //     (
                //         SELECT end_insiden 
                //         FROM tb_tiketing 
                //         WHERE master_unit_id = master_unit.id
                //     ) 
                //     AS hm_bd_end"
                // ),
                // DB::raw("
                //     (
                //         SELECT waktu_insiden 
                //         FROM tb_tiketing 
                //         WHERE master_unit_id = master_unit.id 
                //     ) 
                //     AS hm_bd"
                // ),
                // DB::raw("
                //     (
                //         SELECT end_insiden 
                //         FROM tb_tiketing 
                //         WHERE master_unit_id = master_unit.id
                //     ) 
                //     AS hm_bd_end"
                // ),
            )
            ->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $units = DB::table('master_unit')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->select(
                    'master_unit.*',
                    'master_lokasi.nama_lokasi',
                    DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger'),
                    // DB::raw("
                    //     (
                    //         SELECT waktu_insiden 
                    //         FROM tb_tiketing 
                    //         WHERE master_unit_id = master_unit.id 
                    //     ) 
                    //     AS hm_bd"
                    // ),
                    // DB::raw("
                    //     (
                    //         SELECT end_insiden 
                    //         FROM tb_tiketing 
                    //         WHERE master_unit_id = master_unit.id
                    //     ) 
                    //     AS hm_bd_end"
                    // ),
                )
                ->get();
        }
        

        return view('master_unit.index', [
            'locations' => $locations,
            'locationFilter' => $locationFilter,
            'units' => MasterUnitResource::collection($units),
        ]);
    }

    public function filter(Request $request) // kada tepakai lagi

    {
        $locations = DB::table('master_lokasi')->get();
        $locationFilter = DB::table('master_lokasi')->where('id', $request->location)->select('nama_lokasi', 'id')->first();
        $units = DB::table('master_unit')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->select(
                'master_unit.*',
                'master_lokasi.nama_lokasi',
                DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger')
            )
            ->where('master_lokasi_id', '=', $request->location)
            ->get();

        return view('master_unit.index', [
            'locations' => $locations,
            'locationFilter' => $locationFilter,
            'units' => MasterUnitResource::collection($units),
        ]);
    }

    public function create()
    {
        $lokasi = MasterLokasi::all();

        return view('master_unit.create', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'no_serial' => 'required',
            'no_lambung' => 'required',
            'status_unit' => 'required',
            'status_kepemilikan' => 'required',
            'keterangan' => 'required',
            'total_hm' => 'required',
        ]);

        Unit::create([
            'jenis' => $request->jenis,
            'master_lokasi_id' => auth()->user()->master_lokasi_id,
            'no_serial' => $request->no_serial,
            'no_lambung' => $request->no_lambung,
            'status_unit' => $request->status_unit,
            'status_kepemilikan' => $request->status_kepemilikan,
            'keterangan' => $request->keterangan,
            'total_hm' => $request->total_hm,
        ]);
        return redirect()->route('unit.index')->with('success', 'Berhasil di input');
    }

    public function edit($id)
    {
        $lokasi = MasterLokasi::all();

        $unit = Unit::find($id);

        return view('master_unit.edit', compact('unit', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required',
            'no_serial' => 'required',
            'no_lambung' => 'required',
            'status_unit' => 'required',
            'status_kepemilikan' => 'required',
            'keterangan' => 'required',
            'total_hm' => 'required',
        ]);

        $location = $request->master_lokasi_id;
        if (!isset($location)) {
            $location = auth()->user()->master_lokasi_id;
        }

        // Unit::where('id', $id)->update(request()->except(['_token', '_method']));
        Unit::where('id', $id)->update([
            'jenis' => $request->jenis,
            'master_lokasi_id' => $location,
            'no_serial' => $request->no_serial,
            'no_lambung' => $request->no_lambung,
            'status_unit' => $request->status_unit,
            'status_kepemilikan' => $request->status_kepemilikan,
            'keterangan' => $request->keterangan,
            'total_hm' => $request->total_hm,
        ]);

        return redirect()->route('unit.index')->with('success', 'Berhasil di update');
    }

    public function destroy($id)
    {
        Unit::where('id', $id)->delete();
        return redirect()->route('unit.index')->with('danger', 'Berhasil di delete');
    }



    public function import(Request $request)
    {
        // validasi
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new UnitExcel, $request->file('file'));

        return redirect()->route('unit.index')->with('success', 'Berhasil di import');
    }

    public function pdf(Request $request)
    {
        if (auth()->user()->role == 0) {
            $units = DB::table('master_unit')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->select(
                    'master_unit.*',
                    'master_lokasi.nama_lokasi',
                    DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger')
                )
                ->where('master_lokasi_id', '=', $request->location)
                ->get();
        } else {
            $units = DB::table('master_unit')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->select(
                    'master_unit.*',
                    'master_lokasi.nama_lokasi',
                    DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger')
                )
                ->where('master_lokasi_id', '=', auth()->user()->master_lokasi_id)
                ->get();
        }

        $pdf = PDF::loadView('pdf.unit', ['units' => $units]);

        return $pdf->stream('MasterUnit.pdf');
    }

    public function excel(Request $request)
    {
        if (auth()->user()->role == 0) {
            $units = DB::table('master_unit')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->select(
                    'master_unit.*',
                    'master_lokasi.nama_lokasi',
                    DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger')
                )
                ->where('master_lokasi_id', '=', $request->location)
                ->get();
        } else {
            $units = DB::table('master_unit')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->select(
                    'master_unit.*',
                    'master_lokasi.nama_lokasi',
                    DB::raw('(select hm from master_service where master_unit_id = master_unit.id  and status = 0 order by hm asc limit 1) as hm_triger')
                )
                ->where('master_lokasi_id', '=', auth()->user()->master_lokasi_id)
                ->get();
        }

        return view('excel.unit', [
            'units' => $units
        ]);

    }

    public function show($id)
    {
        $histories = DB::table('tb_history_unit')
            ->select('tb_history_unit.*', 'master_unit.no_lambung')
            ->join('master_unit', 'tb_history_unit.master_unit_id', 'master_unit.id')
            ->where('master_unit_id', $id)
            ->get();
        return view('master_unit.show', compact('histories'));
    }
}
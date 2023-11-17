<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\MasterUnitResource;
use App\Http\Resources\MasterServiceResource;
use App\Http\Resources\AdminMasterSparepartResource;

class AdminMasterServiceController extends Controller
{
    public function index()
    {
        $locations = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $locations = DB::table('master_lokasi')->get();
            $services = DB::table('master_service')
            ->join('master_unit', 'master_service.master_unit_id', '=', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->join('service_sparepart', 'master_service.id', '=', 'service_sparepart.service_id')
            ->join('master_sparepart', 'master_sparepart.id', '=', 'service_sparepart.sparepart_id')
            ->select(
                'master_service.*',
                'master_lokasi.nama_lokasi',
                'master_unit.jenis',
                'master_unit.no_lambung',
                'master_unit.total_hm',
                DB::raw("GROUP_CONCAT(master_sparepart.nama_item SEPARATOR ', ') as nama_sparepart"),
            )
            ->groupBy('master_service.id')
            ->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $services = DB::table('master_service')
            ->join('master_unit', 'master_service.master_unit_id', '=', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->join('service_sparepart', 'master_service.id', '=', 'service_sparepart.service_id')
            ->join('master_sparepart', 'master_sparepart.id', '=', 'service_sparepart.sparepart_id')
            ->select(
                'master_service.*',
                'master_lokasi.nama_lokasi',
                'master_unit.jenis',
                'master_unit.no_lambung',
                'master_unit.total_hm',
                DB::raw("GROUP_CONCAT(master_sparepart.nama_item SEPARATOR ', ') as nama_sparepart"),
            )
            ->groupBy('master_service.id')
            ->get();
        }
        
        return view('master_service.index', [
            'services' => MasterServiceResource::collection($services),
            'locations' => $locations,
            'locationFilter' => $locationFilter,
        ]);
    }

    public function filter(Request $request) // kada tepakai lagi
    {
        $request->validate([
            'lokasi' => 'required'
        ]);

        $services = DB::table('master_service')
            ->join('master_unit', 'master_service.master_unit_id', '=', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->join('service_sparepart', 'master_service.id', '=', 'service_sparepart.service_id')
            ->join('master_sparepart', 'master_sparepart.id', '=', 'service_sparepart.sparepart_id')
            ->where('master_lokasi.id', $request->lokasi)
            ->select(
                'master_service.*',
                'master_lokasi.nama_lokasi',
                'master_unit.jenis',
                'master_unit.no_lambung',
                DB::raw("GROUP_CONCAT(master_sparepart.nama_item SEPARATOR ', ') as nama_sparepart"),
            )
            ->groupBy('master_service.id')
            ->get();

        $allPit = DB::table('master_lokasi')->get();

        return view('master_service.index', [
            'services' => MasterServiceResource::collection($services),
            'allPit' => $allPit
        ]);
    }



    public function create()
    {
        $spareparts = DB::table('master_sparepart')->get();
        if (auth()->user()->role != 0) {
            $units = DB::table('master_unit')->where('master_lokasi_id', auth()->user()->master_lokasi_id)->select('no_lambung', 'total_hm', 'id')->get();
        }
        $units = DB::table('master_unit')->select('no_lambung', 'total_hm', 'id')->get();
        return view('master_service.create', [
            'spareparts' => AdminMasterSparepartResource::collection($spareparts),
            'units' => MasterUnitResource::collection($units)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_unit_id' => 'required',
            'hm' => 'required',
        ]);


        $service = Service::create([
            'master_unit_id' => $request->master_unit_id,
            'hm' => $request->hm,
        ]);

        $service->spareparts()->attach($request->spareparts);

        return redirect()->route('service.index')->with('success', 'Service baru telah dibuat');
    }

    public function edit($id)
    {
        $spareparts = DB::table('master_sparepart')->get();
        $units = DB::table('master_unit')->where('master_lokasi_id', auth()->user()->master_lokasi_id)->select('no_lambung', 'total_hm', 'id')->get();

        $serviceById = DB::table('master_service')
                            ->where('master_service.id', $id)
                            ->join('service_sparepart', 'master_service.id', '=', 'service_sparepart.service_id')
                            ->join('master_sparepart', 'master_sparepart.id', '=', 'service_sparepart.sparepart_id')
                            ->select(
                                'master_service.*',
                                DB::raw("GROUP_CONCAT(master_sparepart.nama_item SEPARATOR ', ') as nama_sparepart"),
                            )
                            ->groupBy('master_service.id')
                            ->first();

        $selected = explode(", " ,$serviceById->nama_sparepart);
        
        return view('master_service.edit', [
            'spareparts' => AdminMasterSparepartResource::collection($spareparts),
            'units' => MasterUnitResource::collection($units),
            'serviceById' => $serviceById,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_unit_id' => 'required',
            'hm' => 'required',
        ]);

        $serviceById = Service::find($id);
        $serviceById->update([
            'master_unit_id' => $request->master_unit_id,
            'hm' => $request->hm,
        ]);

        $serviceById->spareparts()->sync($request->spareparts);



        return redirect()->route('service.index')->with('success', 'Service baru telah diperbaharui');
    }

    public function destroy($id)
    {
        Service::where('id', $id)->delete();

        return redirect()->route('service.index')->with('success', 'Service telah dihapus');
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Shift;
use App\Models\DailyMekanik;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\MekanikWebDailyResource;

class DailyMekanikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = MasterLokasi::all();
        if (auth()->user()->role == 0) {
            $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                ->join('tagline_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                ->whereMonth('mekanik_daily.created_at', now()->format('m'))
                ->whereYear('mekanik_daily.created_at', now()->format('Y'))
                ->orderBy('master_unit_id', 'desc')->get();
        } else {
            $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                ->join('tagline_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                ->where('master_lokasi.id', auth()->user()->lokasi->id)
                ->whereMonth('mekanik_daily.created_at', now()->format('m'))
                ->whereYear('mekanik_daily.created_at', now()->format('Y'))
                ->orderBy('master_unit_id', 'desc')->get();
        }

        return view('daily_mekanik.index', [
            'mekanik' => MekanikWebDailyResource::collection($mekanik),
            'locations' => $locations,
            'date' => null,
        ]);
    }

    public function filter(Request $request)
    {
        $locations = MasterLokasi::all();
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                    ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id') 
                    ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                    ->whereMonth('mekanik_daily.created_at', now()->format('m'))
                    ->whereYear('mekanik_daily.created_at', now()->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            } else {
                $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                    ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('tagline_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                    ->whereMonth('mekanik_daily.created_at', now()->parse($request->bulan)->format('m'))
                    ->whereYear('mekanik_daily.created_at', now()->parse($request->bulan)->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            }
        } else {
            if (empty($request->bulan)) {
                $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                    ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('tagline_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                    ->where('master_lokasi.id', auth()->user()->lokasi->id)
                    ->whereMonth('mekanik_daily.created_at', now()->format('m'))
                    ->whereYear('mekanik_daily.created_at', now()->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            } else {
                $mekanik = DailyMekanik::select('mekanik_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal_mekanik.shift_id', 'shift.waktu', 'tagline_mekanik.jam_kerja_masuk', 'tagline_mekanik.jam_kerja_keluar')
                    ->join('users', 'mekanik_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal_mekanik', 'mekanik_daily.tb_jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('tagline_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                    ->join('master_unit', 'mekanik_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                    ->where('master_lokasi.id', auth()->user()->lokasi->id)
                    ->whereMonth('mekanik_daily.created_at', now()->parse($request->bulan)->format('m'))
                    ->whereYear('mekanik_daily.created_at', now()->parse($request->bulan)->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            }
        }
        
        return view('daily_mekanik.index', [
            'mekanik' => MekanikWebDailyResource::collection($mekanik),
            'locations' => $locations,
            'date' => $request->bulan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = "Edit Daily Mekanik";
        $mekanik = DailyMekanik::with('unit', 'user')->where('id', $id)->first();
        $lokasi = MasterLokasi::all();
        $shift = Shift::all();
        $unit = Unit::all();
        return view('daily_mekanik.edit', compact('mekanik', 'unit', 'lokasi', 'shift', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'users_id' => 'required',
            'master_unit_id' => 'required',
            'kerusakan' => 'required',
            'estimasi_perbaikan_hm' => 'required',
            'perbaikan_hm' => 'required',
            'perbaikan' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]);

        DailyMekanik::where('id', $id)->update([
            'users_id' => $request->users_id,
            'master_unit_id' => $request->master_unit_id,
            'kerusakan' => $request->kerusakan,
            'estimasi_perbaikan_hm' => $request->estimasi_perbaikan_hm,
            'perbaikan_hm' => $request->perbaikan_hm,
            'perbaikan' => $request->perbaikan,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('mekanik.index')->with('success', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

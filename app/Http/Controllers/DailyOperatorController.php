<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\DailyOperator;
use App\Models\WorkerSchedule;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\OperatorWebDailyResource;

class DailyOperatorController extends Controller
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
            $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                ->join('users', 'operator_daily.users_id', '=', 'users.id')
                ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                ->whereMonth('operator_daily.created_at', now()->format('m'))
                ->whereYear('operator_daily.created_at', now()->format('Y'))
                ->orderBy('master_unit_id', 'desc')->get();
        } else {
            $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                ->join('users', 'operator_daily.users_id', '=', 'users.id')
                ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                ->where('master_lokasi.id', auth()->user()->lokasi->id)
                ->whereMonth('operator_daily.created_at', now()->format('m'))
                ->whereYear('operator_daily.created_at', now()->format('Y'))
                ->orderBy('master_unit_id', 'desc')->get();
        }

        return view('daily_operator.index', [
            'operator' => OperatorWebDailyResource::collection($operator),
            'date' => null,
            'locations' => $locations,
        ]);
    }

    public function filter(Request $request)
    {
        $locations = MasterLokasi::all();
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                    ->join('users', 'operator_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                    ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                    ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                    ->whereMonth('operator_daily.created_at', now()->format('m'))
                    ->whereYear('operator_daily.created_at', now()->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            } else {
                $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                    ->join('users', 'operator_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                    ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                    ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                    ->whereMonth('operator_daily.created_at', now()->parse($request->bulan)->format('m'))
                    ->whereYear('operator_daily.created_at', now()->parse($request->bulan)->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            }
        } else {
            if (empty($request->bulan)) {
                $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                    ->join('users', 'operator_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                    ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                    ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                    ->where('master_lokasi.id', auth()->user()->lokasi->id)
                    ->whereMonth('operator_daily.created_at', now()->format('m'))
                    ->whereYear('operator_daily.created_at', now()->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            } else {
                $operator = DailyOperator::select('operator_daily.*', 'users.name', 'master_unit.jenis', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi', 'tb_jadwal.shift_id', 'shift.waktu', 'tagline_operator.jam_kerja_masuk AS jamMasuk', 'tagline_operator.jam_kerja_keluar AS jamKeluar')
                    ->join('users', 'operator_daily.users_id', '=', 'users.id')
                    ->join('tb_jadwal', 'operator_daily.tb_jadwal_id', '=', 'tb_jadwal.id')
                    ->join('tagline_operator', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                    ->join('master_unit', 'operator_daily.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
                    ->where('master_lokasi.id', auth()->user()->lokasi->id)
                    ->whereMonth('operator_daily.created_at', now()->parse($request->bulan)->format('m'))
                    ->whereYear('operator_daily.created_at', now()->parse($request->bulan)->format('Y'))
                    ->orderBy('master_unit_id', 'desc')->get();
            }
        }
        // return view('daily_operator.index', compact('operator', 'title'));
        return view('daily_operator.index', [
            'operator' => OperatorWebDailyResource::collection($operator),
            'date' => $request->bulan,
            'locations' => $locations,
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
        $title = "Edit Daily Operator";
        $operator = DailyOperator::with('user', 'unit', 'jadwal')->where('id', $id)->first();
        $unit = Unit::all();
        return view('daily_operator.edit', compact('operator', 'unit', 'title'));
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
            'master_unit_id' => 'required',
            'status' => 'required',
        ]);
        DailyOperator::where('id', $id)->update([
            'master_unit_id' => $request->master_unit_id,
            'status' => $request->status,
        ]);

        return redirect()->route('operator.index')->with('success', "Data berhasil diubah");
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

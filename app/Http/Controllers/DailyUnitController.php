<?php

namespace App\Http\Controllers;

use App\Http\Resources\MasterUnitResource;
use DB;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Shift;
use App\Models\Tiket;
use App\Models\FuelUnit;
use App\Models\DailyUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use PDF;

class DailyUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $units = DB::table('master_unit')->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $units = DB::table('master_unit')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->get();
        }


        return view('daily_unit.index', [
            'units' => MasterUnitResource::collection($units),
            'locationFilter' => $locationFilter,
        ]);
    }

    public function filter(Request $request)
    {
        $locationFilter = null;
        $unitById = DB::table('master_unit')->where('id', $request->unit)->select('jenis', 'no_lambung', 'id')->first();
        $date = $request->date;
        if (auth()->user()->role == 0) {
            $units = DB::table('master_unit')->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $units = DB::table('master_unit')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->get();
        }

        $locations = DB::table('master_lokasi')->get();


        $dailys = DB::table('daily_unit')
            ->leftJoin('users', 'daily_unit.users_id', '=', 'users.id')
            ->leftJoin('master_unit', 'daily_unit.master_unit_id', '=', 'master_unit.id')
            ->leftJoin('fuel_to_unit', 'fuel_to_unit.daily_unit_id', '=', 'daily_unit.id')
            ->leftJoin('shift', 'daily_unit.shift_id', '=', 'shift.id')
            ->where('daily_unit.master_unit_id', $request->unit)
            ->whereMonth('tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal', now()->parse($request->date)->format('Y'))
            ->select(
                'daily_unit.*',
                'users.name as operator',
                'master_unit.no_lambung',
                'master_unit.total_hm',
                'shift.waktu',
                DB::raw('sum(qty_to_unit) as fuel'),
                DB::raw("
                    (
                        SELECT waktu_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                        ORDER BY id DESC LIMIT 1
                    ) 
                    AS hm_bd"
                ),
                DB::raw("
                    (
                        SELECT end_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                        ORDER BY id DESC LIMIT 1
                    ) 
                    AS hm_bd_end"
                ),
            )
            ->get();


        $totWh = 0;
        $totStb = 0;
        $totBd = 0;
        foreach ($dailys as $daily) {
            $totWh += $daily->end_unit - $daily->start_unit;
            if (12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) < 0) {
                $totBd += 12 - ($daily->end_unit - $daily->start_unit);
                $totStb += 0;
            } else {
                $totBd += now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
                $totStb += 12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
            }
        }

        if ($totWh != null) {
            $pa = ($totWh + $totStb) / ($totWh + $totStb + $totBd) * 100;
            $ua = ($totWh / ($totWh + $totStb)) * 100;
            $ma = ($totWh / ($totWh + $totBd)) * 100;
        } else {
            $pa = 0;
            $ua = 0;
            $ma = 0;
        }

        return view('daily_unit.filter', compact('dailys', 'pa', 'ua', 'ma', 'units', 'totWh', 'totStb', 'totBd', 'locationFilter', 'unitById', 'date', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Tambah Daily Unit";
        $user = User::all();
        $unit = Unit::all();
        $shifts = Shift::all();
        return view('daily_unit.create', compact('user', 'unit', 'shifts', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required',
            'master_unit_id' => 'required',
            'shift_id' => 'required',
            'tanggal' => 'required',
            'end_unit' => 'required',
            'wh' => 'required',
            'bd' => 'required',
        ]);


        $stb = 12 - (int) $request->wh - (int) $request->bd;

        DailyUnit::create([
            'users_id' => $request->users_id,
            'master_unit_id' => $request->master_unit_id,
            'shift_id' => $request->shift_id,
            'tanggal' => $request->tanggal,
            'end_unit' => $request->end_unit,
            'wh' => $request->wh,
            'stb' => $stb,
            'bd' => $request->bd,
        ]);

        return redirect()->route('daily.index')->with('success', 'Berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyUnit  $dailyUnit
     * @return \Illuminate\Http\Response
     */
    public function show(DailyUnit $dailyUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyUnit  $dailyUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyUnit $dailyUnit, $id)
    {
        //
        $title = "Edit Daily Unit";
        $day = DailyUnit::where('id', $id)->first();
        $user = User::all();
        $unit = Unit::all();
        return view('daily_unit.edit', compact('user', 'unit', 'day', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyUnit  $dailyUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyUnit $dailyUnit, $id)
    {
        //
        $request->validate([
            'users_id' => 'required',
            'master_unit_id' => 'required',
            'tanggal' => 'required',
            'end_unit' => 'required',
            'qty_fuel_awal' => 'required',
            'qty_fuel_end' => 'required',
            'wh' => 'required',
            'bd' => 'required',
        ]);

        $nilai = FuelUnit::where('master_unit_id', 5)->latest('tanggal')->first();

        $qty_awal = (int) $request->qty_fuel_awal + $nilai->qty_to_unit;

        $penggunaan = (int) $qty_awal - $request->qty_fuel_end;

        $stb = 12 - (int) $request->wh - (int) $request->bd;

        DailyUnit::create([
            'users_id' => $request->users_id,
            'master_unit_id' => $request->master_unit_id,
            'fuel_to_unit_id' => $nilai->id,
            'tanggal' => $request->tanggal,
            'end_unit' => $request->end_unit,
            'qty_fuel_awal' => $request->qty_fuel_awal,
            'penggunaan_fuel' => $penggunaan,
            'qty_fuel_end' => $request->qty_fuel_end,
            'wh' => $request->wh,
            'stb' => $stb,
            'bd' => $request->bd,
        ]);

        return redirect()->route('daily.index')->with('success', 'Berhasil di perbaharui');
    }

    public function pdf(Request $request)
    {

        $dailys = DB::table('daily_unit')
            ->join('users', 'daily_unit.users_id', '=', 'users.id')
            ->leftJoin('master_unit', 'daily_unit.master_unit_id', '=', 'master_unit.id')
            ->leftJoin('fuel_to_unit', 'fuel_to_unit.daily_unit_id', '=', 'daily_unit.id')
            ->leftJoin('shift', 'daily_unit.shift_id', '=', 'shift.id')
            ->where('daily_unit.master_unit_id', $request->unit)
            ->whereMonth('tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal', now()->parse($request->date)->format('Y'))
            ->select(
                'daily_unit.*',
                'users.name as operator',
                'master_unit.no_lambung',
                'master_unit.total_hm',
                'shift.waktu',
                DB::raw('sum(qty_to_unit) as fuel'),
                DB::raw("
                    (
                        SELECT waktu_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                        AND DATE_FORMAT(waktu_insiden, '%d-%b-%Y %H') = DATE_FORMAT(daily_unit.tanggal, '%d-%b-%Y %H')
                    ) 
                    AS hm_bd"
                ),
                DB::raw("
                    (
                        SELECT end_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                    ) 
                    AS hm_bd_end"
                ),
            )
            ->get();


        $totWh = 0;
        $totStb = 0;
        $totBd = 0;
        foreach ($dailys as $daily) {
            $totWh += $daily->end_unit - $daily->start_unit;
            if (12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) < 0) {
                $totBd += 12 - ($daily->end_unit - $daily->start_unit);
                $totStb += 0;
            } else {
                $totBd += now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
                $totStb += 12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
            }
        }

        if ($totWh != null) {
            $pa = ($totWh + $totStb) / ($totWh + $totStb + $totBd) * 100;
            $ua = ($totWh / ($totWh + $totStb)) * 100;
            $ma = ($totWh / ($totWh + $totBd)) * 100;
        } else {
            $pa = 0;
            $ua = 0;
            $ma = 0;
        }

        $pdf = PDF::loadView('pdf.dailyunit', [
            'dailys' => $dailys,
            'pa' => $pa,
            'ua' => $ua,
            'ma' => $ma,
            'totWh' => $totWh,
            'totStb' => $totStb,
            'totBd' => $totBd,
        ]);

        return $pdf->stream('dailyUnit.pdf');
    }

    public function excel(Request $request)
    {
        $dailys = DB::table('daily_unit')
            ->join('users', 'daily_unit.users_id', '=', 'users.id')
            ->leftJoin('master_unit', 'daily_unit.master_unit_id', '=', 'master_unit.id')
            ->leftJoin('fuel_to_unit', 'fuel_to_unit.daily_unit_id', '=', 'daily_unit.id')
            ->leftJoin('shift', 'daily_unit.shift_id', '=', 'shift.id')
            ->where('daily_unit.master_unit_id', $request->unit)
            ->whereMonth('tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal', now()->parse($request->date)->format('Y'))
            ->select(
                'daily_unit.*',
                'users.name as operator',
                'master_unit.no_lambung',
                'master_unit.total_hm',
                'shift.waktu',
                DB::raw('sum(qty_to_unit) as fuel'),
                DB::raw("
                    (
                        SELECT waktu_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                        AND DATE_FORMAT(waktu_insiden, '%d-%b-%Y %H') = DATE_FORMAT(daily_unit.tanggal, '%d-%b-%Y %H')
                    ) 
                    AS hm_bd"
                ),
                DB::raw("
                    (
                        SELECT end_insiden 
                        FROM tb_tiketing 
                        WHERE master_unit_id = daily_unit.master_unit_id 
                    ) 
                    AS hm_bd_end"
                ),
            )
            ->get();


        $totWh = 0;
        $totStb = 0;
        $totBd = 0;
        foreach ($dailys as $daily) {
            $totWh += $daily->end_unit - $daily->start_unit;
            if (12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) < 0) {
                $totBd += 12 - ($daily->end_unit - $daily->start_unit);
                $totStb += 0;
            } else {
                $totBd += now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
                $totStb += 12 - ($daily->end_unit - $daily->start_unit) - now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end);
            }
        }

        if ($totWh != null) {
            $pa = ($totWh + $totStb) / ($totWh + $totStb + $totBd) * 100;
            $ua = ($totWh / ($totWh + $totStb)) * 100;
            $ma = ($totWh / ($totWh + $totBd)) * 100;
        } else {
            $pa = 0;
            $ua = 0;
            $ma = 0;
        }

        return view('excel.dailyunit', [
            'dailys' => $dailys,
            'pa' => $pa,
            'ua' => $ua,
            'ma' => $ma,
            'totWh' => $totWh,
            'totStb' => $totStb,
            'totBd' => $totBd,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyUnit  $dailyUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyUnit $dailyUnit)
    {
        //
    }

// public function filter(Request $request)
// {

//     $units = Unit::all();
//     if ($request->unit === "0") {
//         if ($request->blnthn === null) {
//             $title = "Daily Unit";
//             $dailys = DailyUnit::with('user', 'unit', 'fuelUnits', 'shift')->where('tanggal', now()->format('Y-m-d'))->get();
//             $total = DailyUnit::selectRaw('sum(wh) as totwh,sum(stb) as totstb,sum(bd) as totbd')->whereMonth('tanggal', now()->format('m'))->whereYear('tanggal', now()->format('Y'))->get();

//             $pa = ($total[0]->totwh + $total[0]->totstb) / ($total[0]->totwh + $total[0]->totstb + $total[0]->totbd) * 100;
//             $ua = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totstb)) * 100;
//             $ma = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totbd)) * 100;

//             return view('daily_unit.index', compact('dailys', 'pa', 'ua', 'ma', 'units', 'title'));
//         } else {
//             $title = "Daily Unit";
//             $dailys = DailyUnit::with('user', 'unit', 'fuelUnits', 'shift')->where('tanggal', $request->blnthn)->get();
//             $total = DailyUnit::selectRaw('sum(wh) as totwh,sum(stb) as totstb,sum(bd) as totbd')->whereMonth('tanggal', Carbon::parse($request->blnthn)->format('m'))->whereYear('tanggal', Carbon::parse($request->blnthn)->format('Y'))->get();

//             $pa = ($total[0]->totwh + $total[0]->totstb) / ($total[0]->totwh + $total[0]->totstb + $total[0]->totbd) * 100;
//             $ua = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totstb)) * 100;
//             $ma = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totbd)) * 100;

//             return view('daily_unit.index', compact('dailys', 'pa', 'ua', 'ma', 'units', 'title'));
//         }
//     } else {
//         if ($request->blnthn === null) {
//             $title = "Daily Unit";
//             $dailys = DailyUnit::with('user', 'unit', 'fuelUnits', 'shift')->where('tanggal', now()->format('Y-m-d'))->where('master_unit_id', $request->unit)->get();
//             $total = DailyUnit::selectRaw('sum(wh) as totwh,sum(stb) as totstb,sum(bd) as totbd')->whereMonth('tanggal', now()->format('m'))->whereYear('tanggal', now()->format('Y'))->get();

//             $pa = ($total[0]->totwh + $total[0]->totstb) / ($total[0]->totwh + $total[0]->totstb + $total[0]->totbd) * 100;
//             $ua = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totstb)) * 100;
//             $ma = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totbd)) * 100;

//             return view('daily_unit.index', compact('dailys', 'pa', 'ua', 'ma', 'units', 'title'));
//         } else {
//             $title = "Daily Unit";
//             $dailys = DailyUnit::with('user', 'unit', 'fuelUnits', 'shift')->where('tanggal', $request->blnthn)->where('master_unit_id', $request->unit)->get();
//             $total = DailyUnit::selectRaw('sum(wh) as totwh,sum(stb) as totstb,sum(bd) as totbd')->whereMonth('tanggal', Carbon::parse($request->blnthn)->format('m'))->whereYear('tanggal', Carbon::parse($request->blnthn)->format('Y'))->get();

//             $pa = ($total[0]->totwh + $total[0]->totstb) / ($total[0]->totwh + $total[0]->totstb + $total[0]->totbd) * 100;
//             $ua = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totstb)) * 100;
//             $ma = ($total[0]->totwh / ($total[0]->totwh + $total[0]->totbd)) * 100;

//             return view('daily_unit.index', compact('dailys', 'pa', 'ua', 'ma', 'units', 'title'));
//         }
//     }
// }
}
<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Unit;
use App\Models\Jadwal;
use App\Models\DailyUnit;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\DailyOperator;
use App\Http\Resources\UnitResource;

class APIUnitController extends Controller
{
    public function getAllUnits()
    {
        $units = Unit::with('lokasi')->get();

        if (!empty($units)) {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => UnitResource::collection($units)
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed'
        ])->setStatusCode(400);
    }

    public function getUnit()
    {
        $datas = [];
        // $units = Jadwal::with('unit', 'user')
        // ->where('users_id', auth()->user()->id)
        // ->latest()
        // ->first();

        $unit = DB::table('tagline_operator')
            ->select(
                'tagline_operator.jam_kerja_masuk',
                'tagline_operator.jam_kerja_keluar',
                'tb_jadwal.master_unit_id',
                'tb_jadwal.users_id',
                'users.name',
                'master_unit.no_lambung',
                'master_unit.no_serial',
                'master_unit.jenis',
                'master_unit.id AS id_unit',
            )
            ->join('tb_jadwal', 'tagline_operator.jadwal_operator_id', '=','tb_jadwal.id')
            ->join('users', 'tb_jadwal.users_id', 'users.id')
            ->join('master_unit', 'tb_jadwal.master_unit_id', 'master_unit.id')
            ->where('tb_jadwal.users_id', auth()->user()->id)
            ->where('tagline_operator.jam_kerja_masuk', '<=', now()->format('Y-m-d H:i:s'))
            ->where('tagline_operator.jam_kerja_keluar', '>=', now()->format('Y-m-d H:i:s'))
            ->first();

        if (!empty($unit)) {

                $datas['user'] = $unit->name;
                $datas['no_serial'] = $unit->no_serial;
                $datas['no_lambung'] = $unit->no_lambung;

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => $datas
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed'
        ])->setStatusCode(400);
    }

    public function getHm(Request $request)
    {
        if(isset($request->tanggal)) {
            $units = DailyUnit::with('unit', 'user', 'shift')->where('tanggal', '<=', $request->tanggal)->where('users_id', auth()->user()->id)->get();
        } else {
            $units = DailyUnit::with('unit', 'user', 'shift')
            ->whereMonth('tanggal', now()->format('m'))
            ->where('end_unit', '!=', 0)
            ->where('users_id', auth()->user()->id)
            ->whereMonth('tanggal', now()->format('m'))
            ->get();
        }

        
        if (!empty($units)) {
            $hm = $units->sum('end_unit') - $units->sum('start_unit');
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => ['hm' => $hm . ' HM']
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => ['hm' => 0 . ' HM']
            ]);
        }
        
        return response()->json([
            'code' => 400,
            'message' => 'failed'
        ])->setStatusCode(400);
    }
}

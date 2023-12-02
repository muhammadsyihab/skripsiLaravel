<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use DB;
use Illuminate\Http\Request;
use App\Models\JadwalMekanik;
use App\Http\Resources\JadwalResource;

class APIJadwalController extends Controller
{
    public function jadwals()
    {
        if (auth()->user()->role == 3) {
            $jadwals = DB::table('tagline_mekanik')
                ->select(
                    'tagline_mekanik.*',
                    'tb_jadwal_mekanik.*',
                    'users.name',
                )
                ->leftJoin('tb_jadwal_mekanik', 'tagline_mekanik.jadwal_mekanik_id', 'tb_jadwal_mekanik.id')
                ->join('users', 'tb_jadwal_mekanik.users_id', 'users.id')
                ->where('users_id', auth()->user()->id)
                ->orderBy('jam_kerja_masuk', 'DESC')
                ->take(20)
                ->get();
        } else {
            $jadwals = DB::table('tagline_operator')
                ->select(
                    'tagline_operator.*',
                    'tb_jadwal.*',
                    'master_unit.no_lambung',
                    'master_unit.jenis',
                    'master_unit.id',
                    'master_unit.status_unit as unitStatus',
                    'users.name',
                )
                ->leftJoin('tb_jadwal', 'tagline_operator.jadwal_operator_id', 'tb_jadwal.id')
                ->join('master_unit', 'tb_jadwal.master_unit_id', 'master_unit.id')
                ->join('users', 'tb_jadwal.users_id', 'users.id')
                ->where('users_id', auth()->user()->id)
                ->orderBy('jam_kerja_masuk', 'DESC')
                ->take(20)
                ->get();
        }

        if (!empty($jadwals)) {
            return response()->json([
                'code' => 200,
                'datas' => JadwalResource::collection($jadwals),
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed'
        ])->setStatusCode(400);
    }

    public function jadwal()
    {
        $datas = [];
        if (auth()->user()->role == 3) {
            $jadwal = DB::table('tagline_mekanik')
                ->select(
                    'tagline_mekanik.*',
                    'tb_jadwal_mekanik.*',
                    'users.name',
                )
                ->join('tb_jadwal_mekanik', 'tagline_mekanik.jadwal_mekanik_id', '=', 'tb_jadwal_mekanik.id')
                ->join('users', 'tb_jadwal_mekanik.users_id', 'users.id')
                ->where('tb_jadwal_mekanik.users_id', auth()->user()->id)
                ->where('tagline_mekanik.jam_kerja_masuk', '<=', now()->format('Y-m-d H:i:s'))
                ->where('tagline_mekanik.jam_kerja_keluar', '>=', now()->format('Y-m-d H:i:s'))
                ->first();
        } else {
            $jadwal = DB::table('tagline_operator')
                ->select(
                    'tagline_operator.*',
                    'tb_jadwal.*',
                    'users.name',
                    'master_unit.no_lambung',
                    'master_unit.jenis',
                    'master_unit.id AS id_unit',
                )
                ->join('tb_jadwal', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
                ->join('users', 'tb_jadwal.users_id', 'users.id')
                ->join('master_unit', 'tb_jadwal.master_unit_id', 'master_unit.id')
                ->where('tb_jadwal.users_id', auth()->user()->id)
                ->where('tagline_operator.jam_kerja_masuk', '<=', now()->format('Y-m-d H:i:s'))
                ->where('tagline_operator.jam_kerja_keluar', '>=', now()->format('Y-m-d H:i:s'))
                ->first();
        }

        if ($jadwal->shift_id == 1) {
            $shift = 'Day';
        } else {
            $shift = 'Night';
        }

        if (!empty($jadwal)) {
            $datas['id'] = $jadwal->id;
            $datas['shift'] = $shift;
            if (auth()->user()->role == 4) {
                $datas['id_unit'] = (string) $jadwal->id_unit;
                $datas['no_lambung'] = $jadwal->no_lambung;
                $datas['nama_unit'] = $jadwal->jenis;
            }
            $datas['name'] = $jadwal->name;
            $datas['jam_kerja_masuk'] = $jadwal->jam_kerja_masuk;
            $datas['jam_kerja_keluar'] = $jadwal->jam_kerja_keluar;

            return response()->json([
                'code' => 200,
                'datas' => $datas,
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'messages' => 'Jadwal hari ini tidak ada.',
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed'
        ])->setStatusCode(400);
    }
}

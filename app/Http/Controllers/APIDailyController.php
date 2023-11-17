<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Unit;
use App\Models\Jadwal;
use App\Models\DailyUnit;
use Illuminate\Support\Str;
use App\Models\DailyMekanik;
use Illuminate\Http\Request;
use App\Models\DailyOperator;
use App\Models\WorkerSchedule;
use App\Models\JadwalMekanik;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Operator;
use App\Http\Resources\DailyMekanikResource;
use App\Http\Resources\DailyOperatorResource;

class APIDailyController extends Controller
{
    public function getDailyMekanikTasks() {
        $tasks = DailyMekanik::with('unit', 'user')
        ->where('users_id', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->get()
        ->count();
        
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'datas' => ['tasks' => $tasks . ' Task']
        ]);
    }

    public function getStatus() {
        $jadwal = Jadwal::with('dailyOperator')->where('users_id', auth()->user()->id)
        // ->where('jam_kerja_masuk', '<=', now()->format('Y-m-d h:i:s'))
        // ->where('jam_kerja_keluar', '>=', now()->format('Y-m-d h:i:s'))
        // ->latest('jam_kerja_masuk')
        ->latest('created_at')
        ->first();
        
        if (isset($jadwal)) {
            if($jadwal->dailyOperator->count() == 1) {
                return response()->json([
                    'code' => 200,
                    'messages' => 'Sudah dimulai',
                    'datas' => 1
                ]);
            } elseif($jadwal->dailyOperator->count() == 2) {
                return response()->json([
                    'code' => 200,
                    'messages' => 'Sudah diakhiri',
                    'datas' => 2
                ]);
            }
        } 

        return response()->json([
            'code' => 200,
            'messages' => 'Belum dimulai / Belum terjadwal',
            'datas' => 0
        ]);

        // return response()->json([
        //     'code' => 400,
        //     'messages' => 'Gagal mengambil status daily operator'
        // ])->setStatusCode(400);
    }

    public function getDailyOperator()
    {
        $dailys = DailyOperator::with('unit', 'user', 'jadwal')
        ->where('users_id', auth()->user()->id)
        // ->whereMonth('created_at', now()->format('m'))
        ->get();

        if (!empty($dailys)) {

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => DailyOperatorResource::collection($dailys)
            ]);
        }
    }

    public function getDailyMekanik()
    {
        $dailys = DailyMekanik::with('unit', 'user', 'jadwalMekanik')
        ->where('users_id', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->take(20)
        ->get();

        if (!empty($dailys)) {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' => DailyMekanikResource::collection($dailys)
            ]);
        }
    }

    public function getBytesFromHexString($hexdata)
    {
        for ($count = 0; $count < strlen($hexdata); $count += 2)
            $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

        return implode($bytes);
    }

    public function getImageMimeType($imagedata)
    {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png" => "89504E470D0A1A0A",
            "gif" => "474946",
            "bmp" => "424D",
            "tiff" => "4949",
            "tiff" => "4D4D"
        );

        foreach ($imagemimetypes as $mime => $hexbytes) {
            $bytes = $this->getBytesFromHexString($hexbytes);
            if (substr($imagedata, 0, strlen($bytes)) == $bytes)
                return $mime;
        }

        return NULL;
    }

    public function postDailyOperator(Request $request)
    {

        try {
            // $jadwal = Jadwal::where('users_id', auth()->user()->id)
            // // ->where('jam_kerja_masuk', '<=', now()->format('Y-m-d H:i:s'))
            // // ->where('jam_kerja_keluar', '>=', now()->format('Y-m-d H:i:s'))
            // ->latest()
            // ->first();

            $jadwal = DB::table('tagline_operator')
            ->select(
                'tagline_operator.*',
                'tb_jadwal.*',
                'users.name',
                'master_unit.no_lambung',
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
    
            if (!$jadwal) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Operator belum terjadwal'
                ])->setStatusCode(400);
            }
    
            $countDailyUnit = DailyUnit::whereYear('tanggal', now()->format('Y'))->whereMonth('tanggal', now()->format('m'))->whereDay('tanggal', now()->format('d'))->where('users_id', auth()->user()->id)->where('master_unit_id', $jadwal->id_unit)->get()->count();
            $countDailyOperator = DailyOperator::where('tb_jadwal_id', $jadwal->id)
            ->where('status', $request->status)
            ->get()
            ->count();
            $alreadyStart = DailyOperator::where('tb_jadwal_id', $jadwal->id)
            ->where('status', 'Mulai')
            ->get()
            ->count();
            
            $masterUnit = Unit::where('id', $jadwal->master_unit_id)->first();
            
            if ($masterUnit->total_hm > $request->hm) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'HM/KM kurang dari HM/KM Total'
                ])->setStatusCode(400);
            }

            
    
            // if ($countDailyOperator < 1) {
                if($request->status == "Mulai") {
                    // jika daily unit sudah ada
                    if ($countDailyUnit) {
                        return response()->json([
                            'code' => 400,
                            'messages' => 'Daily Unit telah dibuat'
                        ])->setStatusCode(400);
                    }

                    // status unit
                    $masterUnit->update(['status_unit'=> 1]);

                    // create daily unit
                    DailyUnit::create([
                        'users_id' => auth()->user()->id,
                        'master_unit_id' => $jadwal->master_unit_id,
                        'shift_id' => $jadwal->shift_id,
                        'start_unit' => $request->hm,
                        'tanggal' => now(),
                    ]);

                    // save daily operator
                    $photoSave = null;
        
                    if ($photo = $request->file('photo_hm')) {
                        $destinationPath = 'storage/photoHm/';
                        $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                        $photo->move($destinationPath, $profileImage);
                        $photoSave = "$profileImage";
                    }
        
                    $daily = DailyOperator::create([
                        'users_id' => auth()->user()->id,
                        'master_unit_id' => $jadwal->master_unit_id,
                        'tb_jadwal_id' => $jadwal->id,
                        'hm' => $request->hm,
                        'photo_hm' => $photoSave,
                        'status' => $request->status,
                    ]);
        
                    if (!$daily) {
                        return response()->json([
                            'code' => 400,
                            'messages' => 'failed insert to table daily operator'
                        ])->setStatusCode(400);
                    }
                    
                } elseif ($request->status == "Berakhir") {                    
                    // status unit
                    $masterUnit->update(['status_unit'=> 0]);

                    // update daily unit
                    $dailyUnit = DailyUnit::where('users_id', auth()->user()->id)
                    ->where('master_unit_id', $jadwal->master_unit_id)
                    ->where('shift_id', $jadwal->shift_id)
                    ->latest('tanggal')
                    ->first();
    
                    // jika daily unit tidak ada
                    if (!isset($dailyUnit) || $alreadyStart == 0) {
                        return response()->json([
                            'code' => 400,
                            'messages' => 'Daily belum dimulai'
                        ])->setStatusCode(400);
                    }
    
                    // update master unit
                    $masterUnit->update([
                        'total_hm' => $request->hm,
                    ]);
                    
                    // update daily unit
                    $dailyUnit->update([
                        'end_unit' => $request->hm,
                    ]);
                    
                    // save daily operator
                    $photoSave = null;
                        
                    if ($photo = $request->file('photo_hm')) {
                        $destinationPath = 'storage/photoHm/';
                        $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                        $photo->move($destinationPath, $profileImage);
                        $photoSave = "$profileImage";
                    }

                    $daily = DailyOperator::create([
                        'users_id' => auth()->user()->id,
                        'master_unit_id' => $jadwal->master_unit_id,
                        'tb_jadwal_id' => $jadwal->id,
                        'hm' => $request->hm,
                        'photo_hm' => $photoSave,
                        'status' => $request->status,
                    ]);

                    if (!$daily) {
                        return response()->json([
                            'code' => 400,
                            'messages' => 'failed insert to table daily operator'
                        ])->setStatusCode(400);
                    }
                }
            // } else {
            //     return response()->json([
            //         'code' => 400,
            //         'messages' => 'Sudah Dimulai / Sudah Berakhir'
            //     ])->setStatusCode(400);
            // }
    
            return response()->json([
                'code' => 200,
                'messages' => 'success',
                'datas' =>  $daily
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'messages' => 'Ada kesalahan ' . $th
            ])->setStatusCode(400);
        }
        
    }

    public function postDailyMekanik(Request $request)
    {   
        try {
            if(!$request->tb_jadwal_id) {
                return response()->json([
                    'code' => 200,
                    'messages' => 'Jadwal hari ini tidak ada.',
                ])->setStatusCode(400);
            }

            $unit = Unit::select('master_lokasi_id')->find($request->master_unit_id);

            // create daily mekanik
            $photoSave = $request->photo;

            if ($photo = $request->file('photo')) {
                $destinationPath = 'storage/mekanikDaily/';
                $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $profileImage);
                $photoSave = "$profileImage";
            }

            $daily = DailyMekanik::create([
                'users_id' => auth()->user()->id,
                'master_unit_id' => $request->master_unit_id,
                'tb_jadwal_mekanik_id' => $request->tb_jadwal_id,
                'kerusakan' => $request->kerusakan,
                'estimasi_perbaikan_hm' => $request->perbaikan_hm,
                'perbaikan_hm' => $request->perbaikan_hm,
                'perbaikan' => $request->perbaikan,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'photo' => $photoSave,
            ]);

            return response()->json([
                'code' => 200,
                'messages' => 'success',
                // 'datas' =>  $daily
                'datas' =>  'asdasdasd'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'messages' => 'failed insert to table daily mekanik ' . $th
            ])->setStatusCode(400);
        }        
    }

    
}

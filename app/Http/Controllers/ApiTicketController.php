<?php

namespace App\Http\Controllers;

use Session;
use DB;
use App\Models\Unit;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Jadwal;
use App\Models\Sparepart;
use App\Models\RiwayatUnit;
use App\Models\RiwayatTiket;
use Illuminate\Http\Request;
use App\Models\DailyOperator;
use Illuminate\Support\Facades\Auth;
use App\Models\SparepartBarangKeluar;
use App\Http\Resources\TicketResource;
use App\Http\Resources\HistoriesTicket;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Validator;

class ApiTicketController extends Controller
{
    public function index()
    {
        $tickets = Tiket::with('units', 'users')->where('status_ticket', '<', 6)->orderBy('id', 'DESC')->get();

        if (!empty($tickets)) {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' =>  TicketResource::collection($tickets),
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed',
        ])->setStatusCode(400);
    }

    public function getHistory($id)
    {
        $datas = [];
        $ticket = Tiket::find($id);
        $histories = RiwayatTiket::with('user')->where('tb_tiketing_id', $id)->orderBy('id', 'DESC')->get();
        if (!empty($histories)) {
            return response()->json([
                'code' => 200,
                'id_ticket' => '#00' . $ticket->id,
                'judul' => $ticket->judul,
                'datas' => HistoriesTicket::collection($histories),
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed',
        ])->setStatusCode(400);
    }

    public function postTicket(Request $request)
    {
        if (auth()->user()->role == 4) {
            // $jadwal = Jadwal::where('users_id', auth()->user()->id)
            // ->where('jam_kerja_masuk', '<=', now()->format('Y-m-d H:i:s'))
            // ->where('jam_kerja_keluar', '>=', now()->format('Y-m-d H:i:s'))
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
                ->join('tb_jadwal', 'tagline_operator.jadwal_operator_id', '=', 'tb_jadwal.id')
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

            $countDailyOperator = DailyOperator::where('tb_jadwal_id', $jadwal->id)
                ->where('users_id', auth()->user()->id)
                ->get()
                ->count();

            if ($countDailyOperator == 1) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Unit masih berjalan perlu diakhiri oleh operator'
                ])->setStatusCode(400);
            }

            // mengubah status unit menjadi breakdown
            $unit = Unit::find($request->master_unit_id);

            if (!$unit) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Unit tidak ada'
                ])->setStatusCode(400);
            }

            if ($unit->status_unit == 2) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Unit sudah breakdown'
                ])->setStatusCode(400);
            }

            $unit->update([
                'status_unit' => 2,
            ]);

            // menyimpan photo ke tiket
            $photoSave = $request->photo;

            if ($photo = $request->file('photo')) {
                $destinationPath = 'storage/tiketPhoto/';
                $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $profileImage);
                $photoSave = "$profileImage";
            }

            // membuat ticket status 10 menunggu acc planner
            $ticket = Tiket::create([
                'master_unit_id' => $request->master_unit_id,
                'users_id' => auth()->user()->id,
                'photo' => $photoSave,
                'judul' => $request->judul,
                'waktu_insiden' => now(),
                'nama_pembuat' => auth()->user()->id,
                'status_ticket' => 0,
                'latlong' => $request->latlong,
            ]);
            Notification::create([
                'users_id' => auth()->user()->id,
                'judul' => $request->judul,
                'isi' => $request->judul,
                'priority' => '1',
            ]);

            if (!$ticket) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Gagal membuat laporan kerusakan'
                ])->setStatusCode(400);
            }

            // chat pertama
            $historyTicket = RiwayatTiket::create([
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $ticket->id,
                'keterangan' => $request->judul,
                'photo' => null,
            ]);

            if (!$historyTicket) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Gagal chat pertama'
                ])->setStatusCode(400);
            }

            return response()->json([
                'code' => 200,
                'messages' => 'Pengaduan berhasil dibuat'
            ]);
        }

        return response()->json([
            'code' => 400,
            'messages' => 'Ada kesalahan'
        ])->setStatusCode(400);
    }

    // ini lagi
    public function postHistoryTicket(Request $request)
    {
        if (auth()->user()->role == 3) {
            $photoSave = $request->photo;

            if ($photo = $request->file('photo')) {
                $destinationPath = 'storage/chat/';
                $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $profileImage);
                $photoSave = "$profileImage";
            }

            $historyTicket = RiwayatTiket::create([
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $request->tb_tiketing_id,
                'keterangan' => $request->keterangan,
                'photo' => $photoSave,
            ]);

            if (!$historyTicket) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Gagal memasukan riwayat pengaduan'
                ])->setStatusCode(400);
            }

            return response()->json([
                'code' => 200,
                'messages' => 'success',
                'datas' =>  $historyTicket
            ]);
        } else {
            return response()->json([
                'code' => 401,
                'messages' => 'Anda tidak diizinkan'
            ])->setStatusCode(401);
        }
    }

    public function postTindakanTicket(Request $request)
    {
        if (auth()->user()->role == 3) {
            // status tiket menjadi acc logistik pembelian pribadi
            $ticket = Tiket::find($request->tb_tiketing_id);

            $ticket->update(['status_ticket' => 4]);
            // if ($ticket->status_ticket <= 4) {
            // }

            $photoSave = null;

            if ($photo = $request->file('photo')) {
                $destinationPath = 'storage/chat/';
                $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $profileImage);
                $photoSave = "$profileImage";
            }

            // posting photo
            // if (isset($request->photo)) {
            //     $image_64 = $request->photo; //your base64 encoded data
            //     $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            //     $replace = substr($image_64, 0, strpos($image_64, ',')+1); 

            //     // find substring fro replace here eg: data:image/png;base64,
            //     $image = str_replace($replace, '', $image_64); 
            //     $image = str_replace(' ', '+', $image); 
            //     $imageName = date('YmdHis').'.'.$extension;
            //     Storage::disk('public')->put('/storage/chat/'.$imageName, base64_decode($image));
            // } else {
            //     $imageName = null;
            // }



            $historyTicket = RiwayatTiket::create([
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $request->tb_tiketing_id,
                'keterangan' => $request->keterangan,
                'photo' => $photoSave,
            ]);

            if (!$historyTicket) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'Gagal melakukan tindakan tiket'
                ])->setStatusCode(400);
            }

            return response()->json([
                'code' => 200,
                'messages' => 'success',
                'datas' =>  $historyTicket
            ]);
        } else {
            return response()->json([
                'code' => 401,
                'messages' => 'Anda tidak diizinkan'
            ])->setStatusCode(401);
        }
    }

    public function groundTest(Request $request)
    {
        if (auth()->user()->role == 4) {
            $ticket = Tiket::find($request->tb_tiketing_id);
            if ($ticket->status_ticket <= 5) {
                $ticket->update(['status_ticket' => 5]);
            }

            $photoSave = $request->photo;

            if ($photo = $request->file('photo')) {
                $destinationPath = 'storage/chat/';
                $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $profileImage);
                $photoSave = "$profileImage";
            }

            $historyTicket = RiwayatTiket::create([
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $request->tb_tiketing_id,
                'keterangan' => $request->keterangan,
                'photo' => $photoSave,
            ]);

            if (!$historyTicket) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'failed insert to table tindakan tiket'
                ])->setStatusCode(400);
            }

            return response()->json([
                'code' => 200,
                'messages' => 'success',
                'datas' =>  $historyTicket
            ]);
        } else {
            return response()->json([
                'code' => 401,
                'messages' => 'Anda tidak diizinkan'
            ])->setStatusCode(401);
        }
    }
}

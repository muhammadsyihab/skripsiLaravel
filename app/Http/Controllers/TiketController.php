<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\MasterLokasi;
use Session;
use App\Models\Unit;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Sparepart;
use App\Models\RiwayatUnit;
use App\Models\RiwayatTiket;
use Illuminate\Http\Request;
use App\Models\SparepartBarangKeluar;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Artisan;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('tiket.index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => null,
        ]);
    }

    public function allTiket()
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                // ->whereMonth('waktu_insiden', now()->format('m'))
                // ->whereYear('waktu_insiden', now()->format('Y'))
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                // ->whereMonth('waktu_insiden', now()->format('m'))
                // ->whereYear('waktu_insiden', now()->format('Y'))
                // ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('tiket.all_index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => null,
        ]);

        // $lokasi = MasterLokasi::all();
        // $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung')
        //     ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
        //     ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
        //     ->whereMonth('waktu_insiden', now()->format('m'))
        //     ->whereYear('waktu_insiden', now()->format('Y'))
        //     ->orderBy('id', 'DESC')
        //     ->get();
        // $user_id = auth()->user()->id;

        // return view('tiket.all_index', compact('tiket', 'user_id', 'title', 'lokasi'));
    }

    public function historyTiket()
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '>', 5)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '>', 5)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('tiket.history_index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => null,
        ]);

        // $lokasi = MasterLokasi::all();
        // $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung')
        //     ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
        //     ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
        //     ->whereMonth('waktu_insiden', now()->format('m'))
        //     ->whereYear('waktu_insiden', now()->format('Y'))
        //     ->orderBy('id', 'DESC')
        //     ->where('status_ticket', '>', 5)
        //     ->get();
        // $user_id = auth()->user()->id;

        // return view('tiket.history_index', compact('tiket', 'user_id', 'title', 'lokasi'));
    }

    public function reqTiket()
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '=', 0)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->format('m'))
                ->whereYear('waktu_insiden', now()->format('Y'))
                ->where('status_ticket', '=', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('tiket.permintaan', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => null,
        ]);
    }

    public function indexFilter(Request $request)
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->where('status_ticket', '<', 6)
                    ->where('status_ticket', '>', 0)
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->where('status_ticket', '<', 6)
                    ->where('status_ticket', '>', 0)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        } else {
            if (empty($request->bulan)) {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->where('status_ticket', '<', 6)
                    ->where('status_ticket', '>', 0)
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->where('status_ticket', '<', 6)
                    ->where('status_ticket', '>', 0)
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        }

        return view('tiket.index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => $request->bulan,
        ]);
    }

    public function allTiketFilter(Request $request)
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        } else {
            if (empty($request->bulan)) {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        }

        return view('tiket.all_index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => $request->bulan,
        ]);
    }

    public function historyTiketFilter(Request $request)
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '>', 5)
                    ->get();
            } else {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '>', 5)
                    ->get();
            }
        } else {
            if (empty($request->bulan)) {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '>', 5)
                    ->get();
            } else {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '>', 5)
                    ->get();
            }
        }

        return view('tiket.history_index', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
            'date' => $request->bulan,
        ]);
    }

    public function reqTiketFilter(Request $request)
    {
        $title = "Laporan Perbaikan";
        $lokasi = null;
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            if (empty($request->bulan)) {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '=', 0)
                    ->get();
            } else {
                $lokasi = MasterLokasi::all();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '=', 0)
                    ->get();
            }
        } else {
            if (empty($request->bulan)) {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', now()->format('m'))
                    ->whereYear('waktu_insiden', now()->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '=', 0)
                    ->get();
            } else {
                $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
                $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                    ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                    ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                    ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                    ->whereMonth('waktu_insiden', Carbon::parse($request->bulan)->format('m'))
                    ->whereYear('waktu_insiden', Carbon::parse($request->bulan)->format('Y'))
                    ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                    ->orderBy('id', 'DESC')
                    ->where('status_ticket', '=', 0)
                    ->get();
            }
        }

        return view('tiket.permintaan', [
            'title' => $title,
            'lokasi' => $lokasi,
            'locationFilter' => $locationFilter,
            'tiket' => TicketResource::collection($tiket),
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
        $title = "Tambah Laporan Perbaikan";
        $users = $users = User::all();
        $units = $units = Unit::all();
        return view('tiket.create', compact('users', 'units', 'title'));
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
            'waktu_insiden' => 'required',
            'status_ticket' => 'required',
            'prioritas' => 'required',
            'judul' => 'required',
            'nama_pembuat' => 'required',
            'master_unit_id' => 'required',
        ]);

        Unit::find($request->master_unit_id)->update([
            'status_unit' => 2,
        ]);

        $data = [
            'waktu_insiden' => $request->waktu_insiden,
            'status_ticket' => $request->status_ticket,
            'photo' => $request->photo,
            'prioritas' => $request->prioritas,
            'judul' => $request->judul,
            'nama_pembuat' => $request->nama_pembuat,
            'users_id' => auth()->user()->id,
            'master_unit_id' => $request->master_unit_id,
        ];

        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/tiketphoto/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $data['photo'] = "$profileImage";
        }

        Tiket::create($data);

        return redirect()->route('ticket.index')->with('success', 'Berhasil di input');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Laporan Perbaikan";
        $users = User::all();
        $units = $units = Unit::all();
        $tiketById = Tiket::where('id', $id)->first();
        return view('tiket.edit', compact('tiketById', 'users', 'units', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'waktu_insiden' => 'required',
            'status_ticket' => 'required',
            'prioritas' => 'required',
            'judul' => 'required',
            'nama_pembuat' => 'required',
            'master_unit_id' => 'required',
        ]);
        $tiketById = Tiket::where('id', $id);
        $data = [
            'waktu_insiden' => $request->waktu_insiden,
            'status_ticket' => $request->status_ticket,
            'photo' => $request->photo,
            'prioritas' => $request->prioritas,
            'judul' => $request->judul,
            'nama_pembuat' => $request->nama_pembuat,
            'users_id' => auth()->user()->id,
            'master_unit_id' => $request->master_unit_id,
        ];
        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/tiketphoto/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $data['photo'] = "$profileImage";
        } else {
            unset($data['photo']);
        }
        $tiketById->update($data);

        return redirect()->route('ticket.index')->with('success', 'Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tiket $tiket)
    {
        //
    }

    // nama function sesuaikan dengan route
    public function pdfReqTicket(Request $request)
    { 
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '=', 0)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '=', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }


        $pdf = PDF::loadView('pdf.daftarpermintaanlaporankerusakan', [
            'tiket' => $tiket
        ]);

        return $pdf->stream('breakdown.pdf');
    }

    public function pdfTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }


        $pdf = PDF::loadView('pdf.daftarlaporankerusakan', [
            'tiket' => $tiket
        ]);

        return $pdf->stream('breakdown.pdf');
    }

    public function pdfAllTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }


        $pdf = PDF::loadView('pdf.daftarsemualaporankerusakan', [
            'tiket' => $tiket
        ]);

        return $pdf->stream('breakdown.pdf');
    }

     public function pdfHistoryTicket(Request $request)
    {

        // $tiket = Tiket::with('users', 'master_unit', 'master_lokasi')
        //     ->where('status_ticket', '>', 5)
        //     ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
        //     ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
        //     ->orderBy('tanggal_masuk', 'ASC')
        //     ->get();

        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '>', 5)
                ->orderBy('id', 'DESC')
                ->get();
        
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '>', 5)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        $pdf = PDF::loadView('pdf.historilaporankerusakan', [
            'tiket' => $tiket
        ]);

        return $pdf->stream('breakdown.pdf');
    }


    public function excelReqTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '=', 0)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '=', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('excel.daftarpermintaanlaporankerusakan', [
            'tiket' => $tiket,
        ]);
    }

    public function excelTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '<', 6)
                ->where('status_ticket', '>', 0)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

        return view('excel.daftarlaporankerusakan', [
            'tiket' => $tiket,
        ]);

    }

    public function excelAllTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                 ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }


         return view('excel.daftarsemualaporankerusakan', [
            'tiket' => $tiket,
        ]);

    }

     public function excelHistoryTicket(Request $request)
    {
        if (auth()->user()->role == 0) {
            $lokasi = MasterLokasi::all();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'master_unit.no_lambung', 'master_lokasi.nama_lokasi')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '>', 5)
                ->orderBy('id', 'DESC')
                ->get();
        
        } else {
            $locationFilter = MasterLokasi::where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $tiket = Tiket::select('tb_tiketing.*', 'users.name', 'users.master_lokasi_id', 'master_unit.no_lambung')
                ->join('users', 'tb_tiketing.users_id', '=', 'users.id')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->join('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
                ->whereMonth('waktu_insiden', now()->parse($request->date)->format('m'))
                ->whereYear('waktu_insiden', now()->parse($request->date)->format('Y'))
                ->where('status_ticket', '>', 5)
                ->where('master_unit.master_lokasi_id', auth()->user()->master_lokasi_id)
                ->orderBy('id', 'DESC')
                ->get();
            # code...
        }

         return view('excel.historilaporankerusakan', [
            'tiket' => $tiket,
        ]);

    }

    

}
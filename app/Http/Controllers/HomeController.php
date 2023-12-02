<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Unit;
use App\Models\User;
use App\Models\Tiket;


use App\Models\FuelStock;
use App\Models\Sparepart;
use App\Models\MasterLokasi;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SparepartBarangKeluar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if ( request()->routeIs('home') ) {
        //     auth()->logout();
        //     Session::put('user_id', auth()->user()->id);
        //     return back()->withErrors(['email' => 'Your account is not activated yet, please verify your Account.']);
        // // }

        $title = "Halaman Utama";
        $tiket = Tiket::with('users', 'units')->orderBy('id', 'DESC')->get();
        $users = User::all()->take(5);
        $user_id = auth()->user()->id;
        $lokasi = MasterLokasi::all();

        $units = Unit::select('master_unit.*', 'master_lokasi.lattitude', 'master_lokasi.longtitude', 'master_lokasi.nama_lokasi')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->get();

        // Jumlah Sparepart Keluar
        $cekSparepart = SparepartBarangKeluar::with('sparepart')
            ->select('master_sparepart_id')
            ->selectRaw('sum(qty_keluar) as total')
            ->groupBy('master_sparepart_id')
            ->whereMonth('tanggal_keluar', now()->format('m'))
            ->whereYear('tanggal_keluar', now()->format('Y'))
            ->get();

        // return $cekSparepart[0]->sparepart->nama_item;

        // Fuel

        $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
            ->orderBy('tanggal', 'ASC')
            ->whereMonth('tanggal', now()->format('m'))
            ->whereYear('tanggal', now()->format('Y'))
            ->take(5)
            ->get();

        $stockTotal = 0;
        $stockSuply = 0;
        $stockUnit = 0;
        $total = 0;
        $rataStockUnit = 0;
        $sisaStock = 0;
        $penanggungJawab = 'asdasd';
        foreach ($stocks as $stock) {
            $stockOpen = $stock->where('tanggal', '<', $stock->tanggal)->select('stock')->latest()->first();
            if (is_null($stockOpen)) {
                $stock['stock_open_total'] = 0;
            } else {
                $stock['stock_open_total'] = $stockOpen->stock + $stockTotal;
            }
            $stock['qty_to_unit_day'] = $stock->fuelOuts->where('shift', 1)->sum('qty_to_unit');
            $stock['qty_to_unit_night'] = $stock->fuelOuts->where('shift', 2)->sum('qty_to_unit');
            $stockSuply += $stock->fuelSuplies->sum('do_datang');
            $stockUnit += $stock->fuelOuts->sum('qty_to_unit');
            $sisaStock = $stock->max('stock');
            // $penanggungJawab = $stock->storage->user->name;
            $penanggungJawab = 'asdasdasd';
            $total = $stockSuply * 16;
            $rataStockUnit = $stockUnit / count($stocks);
        }

        // Sparepart
        $spareparts = Sparepart::with('unit')->where('jenis', 'sparepart')->get();

        // Count Unit
        $unitAllCount = Unit::get()->count();
        // $unitReady = DB::table('master_unit')
        //     ->addSelect(
        //         'master_unit.jenis',
        //         DB::raw('COUNT(master_unit.jenis) as unitReady'),
        //     )
        //     ->where('status_unit', 0)
        //     ->groupBy('master_unit.jenis')
        //     ->get();

        // $datas['unitReady'] = DB::table('master_unit')->select('jenis', DB::raw('COUNT(jenis) as unitReady'))->where('status_unit', 0)->groupBy('jenis')->get();
        // $datas['satuan'] = ;

        $data = DB::table('master_unit')
            ->select(DB::raw("jenis, 
            status_unit, 
            COUNT(*) AS jumlah, 
            (COUNT(*)/(SELECT COUNT(*) FROM master_unit)*100) AS persentase"))
            ->groupBy('jenis', 'status_unit')
            ->get();

        $jenisUnit = DB::table('master_unit')
            ->select(DB::raw("jenis"))
            ->groupBy('jenis')
            ->get();

        $unitWork = DB::table('master_unit')
            ->addSelect(
                'master_unit.jenis',
                DB::raw('COUNT(master_unit.jenis) as unitWork'),
            )
            ->where('status_unit', 1)
            ->groupBy('master_unit.jenis')
            ->get();

        $unitBreak = DB::table('master_unit')
            ->addSelect(
                'master_unit.jenis',
                DB::raw('COUNT(master_unit.jenis) as unitBreak'),
            )
            ->where('status_unit', 1)
            ->groupBy('master_unit.jenis')
            ->get();

        $unitJenis = null;

        // return $cek = DB::table('master_unit')->select('*', DB::raw('COUNT(jenis) as ready'))->where('status_unit', 0)->groupBy('jenis')->get();

        $a = DB::table('master_unit')->where('status_unit', 0)->get()->count();
        $b = DB::table('master_unit')->where('status_unit', 1)->get()->count();
        $c = DB::table('master_unit')->where('status_unit', 2)->get()->count();

        if ($a != 0) {
            $unitReady = round(($a / $unitAllCount) * 100);
        } else {
            $unitReady = 0;
        }

        if ($b != 0) {
            $unitWork = round(($b / $unitAllCount) * 100);
        } else {
            $unitWork = 0;
        }

        if ($c != 0) {
            $unitBreak = round(($c / $unitAllCount) * 100);
        } else {
            $unitBreak = 0;
        }

        //detail per unit        

        return view(
            'home.index',
            compact(
                'unitJenis',
                'units',
                'tiket',
                'user_id',
                'users',
                'title',
                'lokasi',
                'stocks',
                'stockTotal',
                'stockSuply',
                'stockUnit',
                'sisaStock',
                'rataStockUnit',
                'spareparts',
                'unitReady',
                'unitWork',
                'unitBreak',
                'unitAllCount',
                'cekSparepart',
                'data',
                'jenisUnit',
            )
        );
    }

    public function indexArea($id)
    {
        $title = "Halaman Utama";
        $lokasi = MasterLokasi::all();
        $map = MasterLokasi::where('id', $id)->get();

        $units = Unit::select('master_unit.*', 'master_lokasi.lattitude', 'master_lokasi.longtitude', 'master_lokasi.nama_lokasi', 'master_lokasi.radius')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
            ->where('master_lokasi_id', $id)
            ->get();

        return view('home.detail', compact('units', 'title', 'lokasi', 'map'));
    }

    public function getSparepart()
    {
        $brgkeluar = SparepartBarangKeluar::with(['sparepart'])
            ->whereMonth('tanggal_keluar', now()->format('m'))
            ->whereYear('tanggal_keluar', now()->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        $datas = [];
        foreach ($brgkeluar as $bk) {
            $datas[$bk->id] = $bk->sparepart->nama_item;
        }

        return json_encode($datas);
    }

    public function getQtySparepart()
    {
        $brgkeluar = SparepartBarangKeluar::with(['sparepart'])
            ->whereMonth('tanggal_keluar', now()->format('m'))
            ->whereYear('tanggal_keluar', now()->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        $datas = [];
        foreach ($brgkeluar as $bk) {
            $datas[$bk->id] = $bk->qty_keluar;
        }

        return json_encode($datas);
    }

    public function notifikasi()
    {
        $notifications = Notification::where('users_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('home.notifikasi', compact('notifications'));
    }
}
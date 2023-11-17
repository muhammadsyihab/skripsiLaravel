<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use PDF;
use App\Models\FuelStock;
use App\Models\FuelSuply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\FuelSuplyResource;

class FuelSuplyController extends Controller
{

    public function index()
    {
        $storagesAll = Storage::all();
        $locations = DB::table('master_lokasi')->get();

        
        $fuelSuplies = DB::table('fuel_suply')
            ->select(
                'fuel_suply.*',
                'fuel_to_stock.tanggal',
                'master_lokasi.nama_lokasi',
                'master_lokasi.nama_lokasi',
                'storage.nama_storage',
            )
            ->join('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->join('master_lokasi', 'fuel_to_stock.master_lokasi_id', 'master_lokasi.id')
            ->join('storage', 'fuel_suply.storage_id', 'storage.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        $date = null;

        $totalDoDatang = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_datang) as totalDoDatang'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        $totalByDo = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(qty_by_do) as totalByDo'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        $totalDoM = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_minus) as totalDoM'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        if (auth()->user()->role == 0) {
            $fuelSuplies = $fuelSuplies->get();
            $totalDoDatang = $totalDoDatang->get();
            $totalByDo = $totalByDo->get();
            $totalDoM = $totalDoM->get();
        } else {
            $fuelSuplies = $fuelSuplies->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalDoDatang = $totalDoDatang->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalByDo = $totalByDo->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalDoM = $totalDoM->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
        }

        return view('fuel_suply.index', [
            'fuelSuplies' => FuelSuplyResource::collection($fuelSuplies),
            'totalDoDatang' => $totalDoDatang,
            'totalByDo' => $totalByDo,
            'totalDoM' => $totalDoM,
            'storagesAll' => $storagesAll,
            'locations' => $locations,
            'date' => $date,
        ]);
    }

    public function filter(Request $request)
    {
        $storagesAll = Storage::all();
        $locations = DB::table('master_lokasi')->get();

        // $fuelSuplies = DB::table('fuel_suply')
        //     ->select(
        //         'fuel_suply.*',
        //         'fuel_to_stock.tanggal'
        //     )
        //     ->join('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
        //     ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
        //     ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
        //     ->orderBy('fuel_to_stock_id', 'ASC')
        //     ->get();

        $fuelSuplies = DB::table('fuel_suply')
        ->select(
            'fuel_suply.*',
            'fuel_to_stock.tanggal',
            'master_lokasi.nama_lokasi',
            'master_lokasi.nama_lokasi',
            'storage.nama_storage',
        )
        ->join('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
        ->join('master_lokasi', 'fuel_to_stock.master_lokasi_id', 'master_lokasi.id')
        ->join('storage', 'fuel_suply.storage_id', 'storage.id')
        ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
        ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
        ->orderBy('fuel_to_stock_id', 'ASC');

        $date = $request->tanggal;

        $totalDoDatang = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_datang) as totalDoDatang'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        $totalByDo = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(qty_by_do) as totalByDo'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();

        $totalDoM = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_minus) as totalDoM'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC');
            // ->get();
        
        if (auth()->user()->role == 0) {
            $fuelSuplies = $fuelSuplies->get();
            $totalDoDatang = $totalDoDatang->get();
            $totalByDo = $totalByDo->get();
            $totalDoM = $totalDoM->get();
        } else {
            $fuelSuplies = $fuelSuplies->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalDoDatang = $totalDoDatang->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalByDo = $totalByDo->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
            $totalDoM = $totalDoM->where('fuel_to_stock.master_lokasi_id', auth()->user()->master_lokasi_id)->get();
        }

        return view('fuel_suply.index', [
            'fuelSuplies' => FuelSuplyResource::collection($fuelSuplies),
            'totalDoDatang' => $totalDoDatang,
            'totalByDo' => $totalByDo,
            'totalDoM' => $totalDoM,
            'storagesAll' => $storagesAll,
            'locations' => $locations,
            'date' => $date,
        ]);
    }

    public function create()
    {
        $title = "Tambah Fuel To Suply";
        $stocks = FuelStock::with('lokasi')->get();
        $storages = Storage::all();
        return view('fuel_suply.create', compact('stocks', 'storages', 'title'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'storage_id' => 'required',
        //     'fuel_to_stock_id' => 'required',
        //     'transporter' => 'required',
        //     'no_plat_kendaraan' => 'required',
        //     'no_surat_jalan' => 'required',
        //     'driver' => 'required',
        //     'penerima' => 'required',
        //     'tc_storage_sebelum' => 'required',
        //     'tc_storage_sesudah' => 'required',
        //     'suhu_diterima' => 'required',
        //     'qty_by_do' => 'required',
        // ]);

        $stockById = FuelStock::find($request->fuel_to_stock_id);
        $storageById = Storage::find($request->storage_id);
        $stocksNextId = FuelStock::where('tanggal', '>=', $stockById->tanggal)
            ->where('master_lokasi_id', $stockById->master_lokasi_id)
            ->orderBy('tanggal', 'ASC')
            ->get();

        $kenaikanStorage = $request->tc_storage_sesudah - $request->tc_storage_sebelum;
        $qty_do_datang = $kenaikanStorage * $storageById->kapasitas;
        // $stock = $stockById->stock + $qty_do_datang;
        $doMinPlus = $qty_do_datang - $request->qty_by_do;

        foreach ($stocksNextId as $sn) {
            $sn->update([
                'stock' => $sn->stock + $qty_do_datang
            ]);
        }

        FuelSuply::create([
            'fuel_to_stock_id' => $request->fuel_to_stock_id,
            'storage_id' => $request->storage_id,
            'transporter' => $request->transporter,
            'no_plat_kendaraan' => $request->no_plat_kendaraan,
            'no_surat_jalan' => $request->no_surat_jalan,
            'driver' => $request->driver,
            'penerima' => $request->penerima,
            'tc_storage_sebelum' => $request->tc_storage_sebelum,
            'tc_storage_sesudah' => $request->tc_storage_sesudah,
            'tc_kenaikan_storage' => $kenaikanStorage,
            'suhu_diterima' => $request->suhu_diterima,
            'qty_by_do' => $request->qty_by_do,
            'do_datang' => $qty_do_datang,
            'do_minus' => $doMinPlus,
        ]);

        return redirect()->route('fuel-suply.index')->with('success', 'Suply baru telah dibuat');
    }

    public function edit($id)
    {
        $title = "Edit Fuel To Suply";
        $stocks = FuelStock::all();
        $storages = Storage::all();
        $suplierById = FuelSuply::find($id);
        return view('fuel_suply.edit', compact('suplierById', 'stocks', 'storages', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fuel_to_stock_id' => 'required',
            'storage_id' => 'required',
            'transporter' => 'required',
            'no_plat_kendaraan' => 'required',
            'no_surat_jalan' => 'required',
            'driver' => 'required',
            'penerima' => 'required',
            'tc_storage_sebelum' => 'required',
            'tc_storage_sesudah' => 'required',
            'suhu_diterima' => 'required',
            'qty_by_do' => 'required',
        ]);

        $suplierById = FuelSuply::find($id);
        $stockById = FuelStock::find($suplierById->fuel_to_stock_id);
        $stockByIdReq = FuelStock::find($request->fuel_to_stock_id);
        $storageById = Storage::find($request->storage_id);


        $kenaikanStorage = $request->tc_storage_sesudah - $request->tc_storage_sebelum;
        $qty_do_datang = $kenaikanStorage * $storageById->kapasitas;
        $doMinPlus = $qty_do_datang - $request->qty_by_do;

        $suplierById->update([
            'fuel_to_stock_id' => $request->fuel_to_stock_id,
            'storage_id' => $request->storage_id,
            'transporter' => $request->transporter,
            'no_plat_kendaraan' => $request->no_plat_kendaraan,
            'no_surat_jalan' => $request->no_surat_jalan,
            'driver' => $request->driver,
            'penerima' => $request->penerima,
            'tc_storage_sebelum' => $request->tc_storage_sebelum,
            'tc_storage_sesudah' => $request->tc_storage_sesudah,
            'tc_kenaikan_storage' => $kenaikanStorage,
            'suhu_diterima' => $request->suhu_diterima,
            'qty_by_do' => $request->qty_by_do,
            'do_datang' => $qty_do_datang,
            'do_minus' => $doMinPlus,
        ]);

        $stocks = FuelStock::with('fuelOuts', 'fuelSuplies')->orderBy('tanggal', 'ASC')->where('master_lokasi_id', $stockByIdReq->master_lokasi_id)->get();
        $fuelUnit = 0;
        $stockTotal = 0;
        foreach ($stocks as $stock) {
            $fuelUnit += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotal += $stock->fuelSuplies->sum('do_datang');
            $stock->update([
                'stock' => $stockTotal - $fuelUnit
            ]);
        }

        $stocksBefore = FuelStock::with('fuelOuts', 'fuelSuplies')->orderBy('tanggal', 'ASC')->where('master_lokasi_id', $stockById->master_lokasi_id)->get();
        $fuelUnitBefore = 0;
        $stockTotalBefore = 0;
        foreach ($stocksBefore as $stock) {
            $fuelUnitBefore += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotalBefore += $stock->fuelSuplies->sum('do_datang');
            $stock->update([
                'stock' => $stockTotalBefore - $fuelUnitBefore
            ]);
        }

        return redirect()->route('fuel-suply.index')->with('success', 'Suply baru telah diperbaharui');
    }

    public function destroy($id)
    {
        $suplierById = FuelSuply::find($id);
        $stockById = FuelStock::find($suplierById->fuel_to_stock_id);
        $stocksNextId = FuelStock::with('fuelSuplies')
            ->where('tanggal', '>=', $stockById->tanggal)
            ->where('master_lokasi_id', $stockById->master_lokasi_id)
            ->orderBy('tanggal', 'ASC')
            ->get();

        foreach ($stocksNextId as $sn) {
            $sn->update([
                'stock' => $sn->stock - $suplierById->do_datang,
            ]);
        }

        $suplierById->delete();

        return redirect()->route('fuel-suply.index')->with('danger', 'Berhasil di delete');
    }

    public function pdf(Request $request)
    {

        $fuelSuplies = DB::table('fuel_suply')
            ->select(
                'fuel_suply.*',
                'fuel_to_stock.tanggal'
            )
            ->join('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalDoDatang = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_datang) as totalDoDatang'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalByDo = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(qty_by_do) as totalByDo'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalDoM = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_minus) as totalDoM'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $customPaper = array(0,0,900,700);
        $pdf = PDF::loadView('pdf.fuel_suply', [
            'fuelSuplies' => $fuelSuplies,
            'totalDoDatang' => $totalDoDatang,
            'totalByDo' => $totalByDo,
            'totalDoM' => $totalDoM,
        ])->setPaper($customPaper, 'landscape');

        return $pdf->stream('fuelSuply.pdf');
    }

    public function excel(Request $request)
    {
        $fuelSuplies = DB::table('fuel_suply')
            ->select(
                'fuel_suply.*',
                'fuel_to_stock.tanggal'
            )
            ->join('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalDoDatang = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_datang) as totalDoDatang'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalByDo = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(qty_by_do) as totalByDo'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $totalDoM = DB::table('fuel_suply')
            ->select(
                DB::raw('sum(do_minus) as totalDoM'),
            )
            ->leftJoin('fuel_to_stock', 'fuel_suply.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        return view('excel.fuel_suply', [
            'fuelSuplies' => $fuelSuplies,
            'totalDoDatang' => $totalDoDatang,
            'totalByDo' => $totalByDo,
            'totalDoM' => $totalDoM,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use PDF;
use App\Models\FuelStock;
use App\Models\FuelSuply;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\FuelStockResource;

class FuelStockController extends Controller
{
    public function index()
    {
        $locations = MasterLokasi::all();
        $storages = Storage::all();

        // $stocks = DB::table('fuel_to_stock')
        //     ->select(
        //         'fuel_to_stock.*',
        //         'fuel_to_unit.qty_to_unit',
        //         DB::raw("
        //             (
        //                 SELECT sum(fuel_suply.do_datang)
        //                 FROM fuel_suply 
        //                 WHERE fuel_to_stock_id = fuel_to_stock.id 
        //             ) 
        //             AS do_datang"
        //         ),
        //         DB::raw("
        //             (
        //                 SELECT fuel_to_stock.tanggal
        //                 FROM fuel_to_stock
        //                 WHERE fuel_to_stock.tanggal = fuel_to_stock.tanggal
        //             ) 
        //             AS stock_open"
        //         ),
        //     )
        //     ->leftJoin('fuel_to_unit', 'fuel_to_unit.fuel_to_stock_id', '=', 'fuel_to_stock.id')
        //     ->leftJoin('fuel_suply', 'fuel_suply.fuel_to_stock_id', '=', 'fuel_to_stock.id')
        //     ->whereMonth('tanggal', now()->format('m'))
        //     ->whereYear('tanggal', now()->format('Y'))
        //     ->groupBy('fuel_to_stock.id')
        //     ->get();

        // return $stocks;

        if (auth()->user()->role == 0) {
            $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
            ->orderBy('tanggal', 'ASC')
            ->whereMonth('tanggal', now()->format('m'))
            ->whereYear('tanggal', now()->format('Y'))
            ->get();
        } else {
            $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
                ->orderBy('tanggal', 'ASC')
                ->whereMonth('tanggal', now()->format('m'))
                ->whereYear('tanggal', now()->format('Y'))
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->get();
        }

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

        $date = null;
        return view('fuel_stock.index', [
            'stocks' => FuelStockResource::collection($stocks),
            'total' => $total,
            'storages' => $storages,
            'locations' => $locations,
            'stockSuply' => $stockSuply,
            'stockUnit' => $stockUnit,
            'rataStockUnit' => $rataStockUnit,
            'sisaStock' => $sisaStock,
            'penanggungJawab' => $penanggungJawab,
            'date' => $date,
            'total' => $total,
        ]);
    }

    public function filter(Request $request)
    {
        $locations = MasterLokasi::all();
        $storages = Storage::all();

        if (auth()->user()->role == 0) {
            $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
            ->whereMonth('tanggal',now()->parse($request->tanggal)->format('m'))
            ->whereYear('tanggal', now()->parse($request->tanggal)->format('Y'))
            ->where('master_lokasi_id', $request->lokasi)
            ->orderBy('tanggal', 'ASC')
            ->get();
        } else {
            $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
                ->orderBy('tanggal', 'ASC')
                ->whereMonth('tanggal', now()->parse($request->tanggal)->format('m'))
                ->whereYear('tanggal', now()->parse($request->tanggal)->format('Y'))
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->get();
        }

        $stockTotal = 0;
        $stockSuply = 0;
        $stockUnit = 0;
        $total = 0;
        $rataStockUnit = 0;
        $sisaStock = 0;
        $penanggungJawab = 'asdasd';
        foreach ($stocks as $stock) {
            $stockOpen = $stock->where('tanggal', '<', $stock->tanggal)->where('master_lokasi_id', $request->lokasi)->select('stock')->orderBy('tanggal', 'DESC')->latest()->first();
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
            $penanggungJawab = 'asdasdasd';
            $total = $stockSuply * 16;
            $rataStockUnit = $stockUnit / count($stocks);
        }

        $date = $request->tanggal;
        $locate = $request->lokasi;

        return view('fuel_stock.filter', [
            'stocks' => FuelStockResource::collection($stocks),
            'total' => $total,
            'storages' => $storages,
            'locations' => $locations,
            'stockSuply' => $stockSuply,
            'stockUnit' => $stockUnit,
            'rataStockUnit' => $rataStockUnit,
            'sisaStock' => $sisaStock,
            'penanggungJawab' => $penanggungJawab,
            'date' => $date,
            'total' => $total,
            'locate' => $locate,
        ]);
    }

    public function show($id)
    {
        $storages = Storage::with(['stocks'])
            ->where('master_lokasi_id', $id)
            ->get();

        foreach ($storages as $storage) {
            foreach ($storage->stocks as $stock) {
                $stock['stock_open_total'] = $stock->where('tanggal', '<', $stock->tanggal)->where('storage_id', $stock->storage_id)->max('stock');
                $stock['qty_to_unit_day'] = $stock->fuelOuts->where('shift', 1)->sum('qty_to_unit');
                $stock['qty_to_unit_night'] = $stock->fuelOuts->where('shift', 2)->sum('qty_to_unit');
            }
        }

        return view('fuel_stock.lokasi', compact('storages'));
    }

    public function create()
    {
        $title = "Tambah Fuel To Stock";
        $lokasi = MasterLokasi::all();
        return view('fuel_stock.create', compact('lokasi', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);

        $stockLast = FuelStock::where('tanggal', '<=', $request->tanggal)->where('master_lokasi_id', $request->master_lokasi_id)->max('stock');

        if (!$stockLast) {
            $stockLast = 0;
        }

        // return $stockLast;

        FuelStock::create([
            'tanggal' => $request->tanggal,
            'stock' => $stockLast,
            'master_lokasi_id' => $request->master_lokasi_id,
        ]);

        $stocks = FuelStock::with(['fuelOuts', 'fuelSuplies'])->where('master_lokasi_id', $request->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();


        $fuelUnit = 0;
        $stockTotal = 0;
        foreach ($stocks as $stock) {
            $fuelUnit += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotal += $stock->fuelSuplies->sum('do_datang');
            $stock->update([
                'stock' => $stockTotal - $fuelUnit
            ]);
        }

        return redirect()->back()->with('success', 'Stock baru telah dibuat');
    }

    public function edit($id)
    {
        $title = "Edit Fuel To Stock";
        $stockById = FuelStock::find($id);
        $lokasi = MasterLokasi::all();
        return view('fuel_stock.edit', compact('stockById', 'title', 'lokasi'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'tanggal' => 'required',
        ]);

        $stockById = FuelStock::find($id);
        FuelStock::find($id)->update([
            'tanggal' => $request->tanggal,
            'master_lokasi_id' => $request->master_lokasi_id,
        ]);

        $stocks = FuelStock::with(['fuelOuts', 'fuelSuplies'])->where('master_lokasi_id', $request->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();
        $stocksBefore = FuelStock::with(['fuelOuts', 'fuelSuplies'])->where('master_lokasi_id', $stockById->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();

        $fuelUnit = 0;
        $stockTotal = 0;
        foreach ($stocks as $stock) {
            $fuelUnit += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotal += $stock->fuelSuplies->sum('do_datang');
            $stock->update([
                'stock' => $stockTotal - $fuelUnit
            ]);
        }

        $fuelUnitBefore = 0;
        $stockTotalBefore = 0;
        foreach ($stocksBefore as $stock) {
            $fuelUnitBefore += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotalBefore += $stock->fuelSuplies->sum('do_datang');
            $stock->update([
                'stock' => $stockTotalBefore - $fuelUnitBefore
            ]);
        }

        return redirect()->route('fuel-stock.index')->with('success', 'Suply baru telah diperbaharui');
    }

    public function destroy($id)
    {
        $stockById = FuelStock::find($id);
        $stocksNextId = FuelStock::with('fuelOuts', 'fuelSuplies')->where('tanggal', '>', $stockById->tanggal)->where('master_lokasi_id', $stockById->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();

        $fuelUnit = 0;
        $stockTotal = 0;
        foreach ($stocksNextId as $sn) {
            $fuelUnit += $sn->fuelOuts->sum('qty_to_unit');
            $stockTotal += $sn->fuelSuplies->sum('do_datang');
            $sn->update([
                'stock' => $sn->stock - ($stockById->fuelSuplies->sum('do_datang') - $stockById->fuelOuts->sum('qty_to_unit'))
            ]);
        }

        $stockById->delete();
        return redirect()->route('fuel-stock.index')->with('danger', 'Berhasil di delete');
    }

    public function pdf(Request $request)
    {

        $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
            ->orderBy('tanggal', 'ASC')
            ->whereMonth('tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal', now()->parse($request->date)->format('Y'))
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

        $pdf = PDF::loadView('pdf.fuel_stock', [
            'stocks' => $stocks,
            'stockTotal' => $stockTotal,
            'stockSuply' => $stockSuply,
            'stockUnit' => $stockUnit,
            'total' => $total,
            'rataStockUnit' => $rataStockUnit,
            'sisaStock' => $sisaStock,
            'penanggungJawab' => $penanggungJawab,
        ]);

        return $pdf->stream('FuelStock.pdf');
    }

    public function excel(Request $request)
    {
        $stocks = FuelStock::with(['fuelSuplies', 'fuelOuts', 'storage'])
            ->orderBy('tanggal', 'ASC')
            ->whereMonth('tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal', now()->parse($request->date)->format('Y'))
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

        return view('excel.fuel_stock', [
            'stocks' => $stocks,
            'stockTotal' => $stockTotal,
            'stockSuply' => $stockSuply,
            'stockUnit' => $stockUnit,
            'total' => $total,
            'rataStockUnit' => $rataStockUnit,
            'sisaStock' => $sisaStock,
            'penanggungJawab' => $penanggungJawab,
        ]);
    }
}
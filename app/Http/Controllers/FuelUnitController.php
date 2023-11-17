<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Shift;
use App\Models\Storage;
use App\Models\FuelUnit;
use App\Models\DailyUnit;
use App\Models\FuelStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\FuelUnitResource;

class FuelUnitController extends Controller
{
    public function index()
    {

        $storagesAll = Storage::all();
        $locations = DB::table('master_lokasi')->get();

        $fuelToUnits = DB::table('fuel_to_unit')
            ->select(
                'fuel_to_unit.*',
                'fuel_to_stock.tanggal',
                'fuel_to_stock.stock',
                'master_unit.no_lambung',
                'master_lokasi.nama_lokasi',
                'master_unit.total_hm',
                'users.name',
            )
            ->join('daily_unit', 'fuel_to_unit.daily_unit_id', 'daily_unit.id')
            ->join('users', 'daily_unit.users_id', 'users.id')
            ->join('master_unit', 'daily_unit.master_unit_id', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', 'master_lokasi.id')
            ->join('fuel_to_stock', 'fuel_to_unit.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();


        return view('fuel_unit.index', [
            'storages' => FuelUnitResource::collection($fuelToUnits),
            'storagesAll' => $storagesAll,
            'locations' => $locations,
            'date' => null,
        ]);
    }

    public function filter(Request $request)
    {
        $locations = Storage::all();
        $fuelToUnits = DB::table('fuel_to_unit')
            ->select(
                'fuel_to_unit.*',
                'fuel_to_stock.tanggal',
                'fuel_to_stock.stock',
                'master_unit.no_lambung',
                'master_lokasi.nama_lokasi',
                'master_unit.total_hm',
                'users.name',
            )
            ->join('daily_unit', 'fuel_to_unit.daily_unit_id', 'daily_unit.id')
            ->join('users', 'daily_unit.users_id', 'users.id')
            ->join('master_unit', 'daily_unit.master_unit_id', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', 'master_lokasi.id')
            ->join('fuel_to_stock', 'fuel_to_unit.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->tanggal)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        return view('fuel_unit.index', [
            'storages' => FuelUnitResource::collection($fuelToUnits),
            'locations' => $locations,
            'date' => $request->tanggal,
        ]);
    }

    public function create()
    {
        $title = "Tambah Fuel To Unit";
        $stocks = FuelStock::all();
        $units = Unit::all();
        $shifts = Shift::all();
        $dailys = DailyUnit::with('unit')->get();
        return view('fuel_unit.create', compact('stocks', 'units', 'shifts', 'dailys', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fuel_to_stock_id' => 'required',
            'daily_unit_id' => 'required',
            'qty_to_unit' => 'required',
        ]);


        $daily = DailyUnit::where('tanggal', $request->daily_unit_id)
            ->latest()
            ->first();

        if (!$daily) {
            return redirect()->back()->with('danger', 'Ada kesalahan input data dengan daily unit');
        }

        $stockById = FuelStock::find($request->fuel_to_stock_id);
        $stocksNextId = FuelStock::where('tanggal', '>=', $stockById->tanggal)
            ->orderBy('tanggal', 'ASC')
            ->get();

        $daily->update([
            'penggunaan_fuel' => $daily->penggunaan_fuel + $request->qty_to_unit
        ]);

        foreach ($stocksNextId as $sn) {
            $sn->update([
                'stock' => $sn->stock - $request->qty_to_unit
            ]);
        }

        FuelUnit::create([
            'fuel_to_stock_id' => $request->fuel_to_stock_id,
            'daily_unit_id' => $daily->id,
            'qty_to_unit' => $request->qty_to_unit,
            'shift' => $daily->shift_id,
        ]);

        return redirect()->route('fuel-unit.index')->with('success', 'Fuel baru telah dibuat');
    }

    public function edit($id)
    {
        $title = "Edit Fuel To Unit";
        $stocks = FuelStock::all();
        $units = Unit::all();
        $shifts = Shift::all();
        $fuelUnitById = FuelUnit::find($id);
        $dailyFuel = $fuelUnitById->dailyUnit()->first();
        $dailys = DailyUnit::with('unit')->get();
        return view('fuel_unit.edit', compact('fuelUnitById', 'stocks', 'units', 'dailys', 'dailyFuel', 'shifts', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fuel_to_stock_id' => 'required',
            'daily_unit_id' => 'required',
            'qty_to_unit' => 'required',
        ]);

        $fuelOut = FuelUnit::find($id);
        $dailyBefore = DailyUnit::find($fuelOut->daily_unit_id);
        $daily = DailyUnit::where('tanggal', $request->daily_unit_id)
            ->latest()
            ->first();

        if (!$daily) {
            return redirect()->back()->with('danger', 'Ada kesalahan input data dengan daily unit');
        }

        $dailyBefore->update([
            'penggunaan_fuel' => $dailyBefore->penggunaan_fuel - $request->qty_to_unit
        ]);

        $daily->update([
            'penggunaan_fuel' => $daily->penggunaan_fuel + $request->qty_to_unit
        ]);

        FuelUnit::find($id)->update([
            'fuel_to_stock_id' => $request->fuel_to_stock_id,
            'daily_unit_id' => $daily->id,
            'qty_to_unit' => $request->qty_to_unit,
            'shift' => $daily->shift_id,
        ]);

        $stockById = FuelStock::find($request->fuel_to_stock_id);
        $stockByIdBefore = FuelStock::find($fuelOut->fuel_to_stock_id);

        $stocks = FuelStock::with('fuelOuts', 'fuelSuplies')->where('master_lokasi_id', $stockById->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();
        $fuelUnit = 0;
        $stockTotal = 0;
        foreach ($stocks as $stock) {
            $fuelUnit += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotal += $stock->fuelSuplies->sum('do_datang');
            $data[$stock->id]['stock'] = $stockTotal;
            $data[$stock->id]['fuelUnit'] = $fuelUnit;
            $data[$stock->id]['sum'] = $stock->fuelSuplies->sum('do_datang');
            $data[$stock->id]['stockafter'] = $stockTotal - $fuelUnit;
            $stock->update([
                'stock' => $stockTotal - $fuelUnit
            ]);
        }

        $stocksBefore = FuelStock::with('fuelOuts', 'fuelSuplies')->where('master_lokasi_id', $stockByIdBefore->master_lokasi_id)->orderBy('tanggal', 'ASC')->get();
        $fuelUnitBefore = 0;
        $stockTotalBefore = 0;
        foreach ($stocksBefore as $stock) {
            $fuelUnitBefore += $stock->fuelOuts->sum('qty_to_unit');
            $stockTotalBefore += $stock->fuelSuplies->sum('do_datang');
            $data[$stock->id]['stock'] = $stockTotalBefore;
            $data[$stock->id]['fuelUnit'] = $fuelUnitBefore;
            $data[$stock->id]['sum'] = $stock->fuelSuplies->sum('do_datang');
            $data[$stock->id]['stockafter'] = $stockTotalBefore - $fuelUnitBefore;
            $stock->update([
                'stock' => $stockTotalBefore - $fuelUnitBefore
            ]);
        }
        return redirect()->route('fuel-unit.index')->with('success', 'Fuel baru telah dibuat');
    }

    public function destroy($id)
    {
        $outById = FuelUnit::find($id);
        $daily = DailyUnit::find($outById->daily_unit_id);
        $stockById = FuelStock::find($outById->fuel_to_stock_id);
        $stocksNextId = FuelStock::with('fuelOuts')
            ->where('tanggal', '>=', $stockById->tanggal)
            ->where('master_lokasi_id', $stockById->master_lokasi_id)
            ->orderBy('tanggal', 'ASC')
            ->get();

        $daily->update([
            'penggunaan_fuel' => $daily->penggunaan_fuel - $outById->qty_to_unit
        ]);

        foreach ($stocksNextId as $sn) {
            $sn->update([
                'stock' => $sn->stock + $outById->qty_to_unit,
            ]);
        }

        $outById->delete();

        return redirect()->route('fuel-unit.index')->with('danger', 'Berhasil di delete');
    }

    public function pdf(Request $request)
    {
        $fuelToUnits = DB::table('fuel_to_unit')
            ->select(
                'fuel_to_unit.*',
                'fuel_to_stock.tanggal',
                'fuel_to_stock.stock',
                'master_unit.no_lambung',
                'master_lokasi.nama_lokasi',
                'master_unit.total_hm',
                'users.name',
            )
            ->join('daily_unit', 'fuel_to_unit.daily_unit_id', 'daily_unit.id')
            ->join('users', 'daily_unit.users_id', 'users.id')
            ->join('master_unit', 'daily_unit.master_unit_id', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', 'master_lokasi.id')
            ->join('fuel_to_stock', 'fuel_to_unit.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        $pdf = PDF::loadView('pdf.fuel_unit', [
            'fuelToUnits' => $fuelToUnits,
        ]);

        return $pdf->stream('fuelUnit.pdf');
    }

    public function excel(Request $request)
    {
        $fuelToUnits = DB::table('fuel_to_unit')
            ->select(
                'fuel_to_unit.*',
                'fuel_to_stock.tanggal',
                'fuel_to_stock.stock',
                'master_unit.no_lambung',
                'master_lokasi.nama_lokasi',
                'master_unit.total_hm',
                'users.name',
            )
            ->join('daily_unit', 'fuel_to_unit.daily_unit_id', 'daily_unit.id')
            ->join('users', 'daily_unit.users_id', 'users.id')
            ->join('master_unit', 'daily_unit.master_unit_id', 'master_unit.id')
            ->join('master_lokasi', 'master_unit.master_lokasi_id', 'master_lokasi.id')
            ->join('fuel_to_stock', 'fuel_to_unit.fuel_to_stock_id', 'fuel_to_stock.id')
            ->whereMonth('fuel_to_stock.tanggal', now()->parse($request->date)->format('m'))
            ->whereYear('fuel_to_stock.tanggal', now()->parse($request->date)->format('Y'))
            ->orderBy('fuel_to_stock_id', 'ASC')
            ->get();

        return view('excel.fuel_unit', [
            'fuelToUnits' => $fuelToUnits,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Excel;
use App\Exports\ExportBrgMasuk;
use Illuminate\Support\Facades\DB;
use App\Models\SparepartBarangMasuk;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\AdminLgBrgMskResource;

class AdminLgBrgMskController extends Controller
{

    public function index()
    {
        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 0)
            ->whereMonth('tanggal_masuk', now()->format('m'))
            ->whereYear('tanggal_masuk', now()->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        $date = null;

        return view('brgmasuk.index', [
            'brgmasuk' => AdminLgBrgMskResource::collection($brgmasuk),
            'total' => $total,
            'date' => $date
        ]);
    }

    public function indexPO()
    {
        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 1)
            ->whereMonth('tanggal_masuk', now()->format('m'))
            ->whereYear('tanggal_masuk', now()->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        return view('purchasing_order.index', [
            'brgmasuk' => AdminLgBrgMskResource::collection($brgmasuk),
            'total' => $total,
        ]);
    }

    public function indexPOBatal()
    {
        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 2)
            ->whereMonth('tanggal_masuk', now()->format('m'))
            ->whereYear('tanggal_masuk', now()->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        return view('purchasing_order.index_batal', [
            'brgmasuk' => AdminLgBrgMskResource::collection($brgmasuk),
            'total' => $total,
        ]);
    }

    public function filter(Request $request)
    {
        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 0)
            ->whereMonth('tanggal_masuk', now()->parse($request->bulan)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->bulan)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();
        
        $date = $request->bulan;

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        return view('brgmasuk.index', [
            'brgmasuk' => AdminLgBrgMskResource::collection($brgmasuk),
            'total' => $total,
            'date' => $date,
        ]);
    }

    public function filterPO(Request $request)
    {
        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 1)
            ->whereMonth('tanggal_masuk', now()->parse($request->bulan)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->bulan)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        $date = $request->bulan;
        
        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        return view('purchasing_order.index', [
            'brgmasuk' => AdminLgBrgMskResource::collection($brgmasuk),
            'total' => $total,
            'date' => $date,
        ]);
    }

    public function create()
    {
        $title = "Tambah Barang Masuk";
        $spareparts = Sparepart::all();
        return view('brgmasuk.create', compact('spareparts', 'title'));
    }

    public function createPO()
    {
        $title = "Tambah Purchasing Order";
        $spareparts = Sparepart::all();
        return view('purchasing_order.create', compact('spareparts', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_sparepart_id' => 'required',
            'qty_masuk' => 'required',
            'item_price' => 'required',
            'vendor' => 'required',
        ]);

        $sparepart = Sparepart::where('id', $request->master_sparepart_id)->first();

        $amount = $request->qty_masuk * $request->item_price;

        SparepartBarangMasuk::create([
            'tanggal_masuk' => now(),
            'master_sparepart_id' => $request->master_sparepart_id,
            'qty_masuk' => $request->qty_masuk,
            'status' => 0,
            'item_price' => $request->item_price,
            'amount' => $amount,
            'vendor' => $request->vendor,
        ]);

        $qty_total = $request->qty_masuk + $sparepart->qty;

        Sparepart::where('id', $request->master_sparepart_id)
            ->update([
                'qty' => $qty_total,
                'item_price' => $request->item_price,
            ]);

        return redirect()->route('brgmasuk.index')->with('success', 'Berhasil di input');
    }

    public function storePO(Request $request)
    {
        $request->validate([
            'tanggal_masuk' => 'required',
            'master_sparepart_id' => 'required',
            'qty_masuk' => 'required',
            'item_price' => 'required',
            'vendor' => 'required',
            'nomor_po' => 'required',
            'penerima' => 'required',
        ]);

        $amount = $request->qty_masuk * $request->item_price;

        SparepartBarangMasuk::create([
            'tanggal_masuk' => $request->tanggal_masuk,
            'master_sparepart_id' => $request->master_sparepart_id,
            'qty_masuk' => $request->qty_masuk,
            'status' => 1,
            'item_price' => $request->item_price,
            'amount' => $amount,
            'vendor' => $request->vendor,
            'nomor_po' => $request->nomor_po,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('purchasing.order.index')->with('success', 'Berhasil di input');
    }

    public function receivePO($id)
    {
        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();
        $sparepart = Sparepart::find($brgmasukById->master_sparepart_id);

        $qty_total = $brgmasukById->qty_masuk + $sparepart->qty;

        $brgmasukById->update([
            'status' => 0,
        ]);

        $sparepart->update([
            'qty' => $qty_total,
            'item_price' => $brgmasukById->item_price,
        ]);

        return redirect()->route('purchasing.order.index')->with('success', 'Berhasil di diterima');
    }

    public function edit($id)
    {
        $title = "Barang Masuk";
        $spareparts = Sparepart::all();
        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();
        return view('brgmasuk.edit', compact('spareparts', 'brgmasukById', 'title'));
    }

    public function editPO($id)
    {
        $title = "Edit Purchasing Order";
        $spareparts = Sparepart::all();
        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();
        return view('purchasing_order.edit', compact('spareparts', 'brgmasukById', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_sparepart_id' => 'required',
            'qty_masuk' => 'required',
            'item_price' => 'required',
            'vendor' => 'required',
        ]);


        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();
        $spareparts = Sparepart::where('id', $brgmasukById->master_sparepart_id)->first();
        $sparepartsReq = Sparepart::where('id', $request->master_sparepart_id)->first();

        $spareparts->update([
            'item_price' => $request->item_price
        ]);

        if ($request->master_sparepart_id != $spareparts->id) {
            $qty_total = $spareparts->qty - $request->qty_masuk;
            $spareparts->update([
                'qty' => $qty_total,
            ]);
            $qty_total = $sparepartsReq->qty + $request->qty_masuk;
            $sparepartsReq->update([
                'qty' => $qty_total,
            ]);
        } elseif ($request->master_sparepart_id == $spareparts->id) {
            $qty_total = $sparepartsReq->qty - ($brgmasukById->qty_masuk - $request->qty_masuk);
            $sparepartsReq->update([
                'qty' => $qty_total,
            ]);
        }

        $amount = $request->qty_masuk * $request->item_price;
        $brgmasukById->update([
            'tanggal_masuk' => $brgmasukById->tanggal_masuk,
            'master_sparepart_id' => $request->master_sparepart_id,
            'qty_masuk' => $request->qty_masuk,
            'status' => 0,
            'item_price' => $request->item_price,
            'amount' => $amount,
            'vendor' => $request->vendor,
        ]);

        return redirect()->route('brgmasuk.index')->with('success', 'Berhasil di update');
    }

    public function updatePO(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required',
            'master_sparepart_id' => 'required',
            'qty_masuk' => 'required',
            'item_price' => 'required',
            'vendor' => 'required',
            'nomor_po' => 'required',
            'penerima' => 'required',
        ]);

        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();
        $amount = $request->qty_masuk * $request->item_price;

        $brgmasukById->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => 1,
            'master_sparepart_id' => $request->master_sparepart_id,
            'qty_masuk' => $request->qty_masuk,
            'item_price' => $request->item_price,
            'amount' => $amount,
            'vendor' => $request->vendor,
            'nomor_po' => $request->nomor_po,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('purchasing.order.index')->with('success', 'Berhasil di update');
    }

    public function destroy($id)
    {
        $brgmasukById = SparepartBarangMasuk::where('id', $id)->first();

        $redirect = '';
        if ($brgmasukById->status == 1) {
            $redirect = 'purchasing.order.index';
        } else {
            $redirect = 'brgmasuk.index';
        }

        $sparepart = Sparepart::where('id', $brgmasukById->master_sparepart_id)->first();
        $sparepart->update([
            'qty' => $sparepart->qty - $brgmasukById->qty_masuk
        ]);
        $brgmasukById->delete();

        return redirect()->route($redirect)->with('danger', 'Berhasil di delete');
    }

    public function pdf(Request $request)
    {

        $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 0)
            ->whereMonth('tanggal_masuk', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->date)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        $pdf = PDF::loadView('pdf.brgmasuk', ['brgmasuk' => $brgmasuk, 'total' => $total]);

        return $pdf->stream('ReceivedPart.pdf');
    }

    public function excel(Request $request)
    {
          $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 0)
            ->whereMonth('tanggal_masuk', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->date)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        return view('excel.brgmasuk', [
            'brgmasuk' => $brgmasuk,
            'total' => $total
        ]);

    }

    public function pdfPo(Request $request)
    {

         $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 1)
            ->whereMonth('tanggal_masuk', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->date)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

        $pdf = PDF::loadView('pdf.po', [
            'brgmasuk' => $brgmasuk,
            'total' => $total
        ]);

        return $pdf->stream('ReceivedPart.pdf');
    }

    public function excelPo(Request $request)
    {
          $brgmasuk = SparepartBarangMasuk::with('sparepart')
            ->where('status', 1)
            ->whereMonth('tanggal_masuk', now()->parse($request->date)->format('m'))
            ->whereYear('tanggal_masuk', now()->parse($request->date)->format('Y'))
            ->orderBy('tanggal_masuk', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgmasuk as $bg) {
            $total += $bg->amount;
        }

          return view('excel.brgmasuk', [
            'brgmasuk' => $brgmasuk,
            'total' => $total
        ]);

    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\SparepartBarangKeluarPribadi;
use App\Http\Resources\AdminLgBrgKlrPribadiResource;
use PDF;

class AdminLgBrgKlrPribadiController extends Controller
{
    public function index()
    {
        $allPit = MasterLokasi::all();

        $brgkeluar =  SparepartBarangKeluarPribadi::with('user', 'ticket', 'unit')
            ->whereMonth('tanggal_keluar', now()->format('m'))
            ->whereYear('tanggal_keluar', now()->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        $date = null;

        // ngambil grand total
        $total = 0;
        foreach ($brgkeluar as $bg) {
            $total += $bg->amount;
        }

        return view('brgkeluarprb.index', [
            'brgkeluar' => AdminLgBrgKlrPribadiResource::collection($brgkeluar),
            'total' => $total,
            'pitName' => 'All PIT',
            'allPit' => $allPit,
            'date' => $date,
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'lokasi' => 'required',
        ]);

        $allPit = MasterLokasi::all();
        $pit = MasterLokasi::find($request->lokasi);
        $pit = $pit->nama_lokasi;
 
        $brgkeluar =  SparepartBarangKeluarPribadi::with(['user', 'ticket'])
            ->whereMonth('tanggal_keluar', now()->parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', now()->parse($request->bulan)->format('Y'))
            ->join('master_unit', 'lg_brg_klr_prb.master_unit_id', '=', 'master_unit.id')
            ->where('master_lokasi_id', $request->lokasi)
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgkeluar as $bg) {
            $total += $bg->amount;
        }

        return view('brgkeluarprb.index', [
            'brgkeluar' => AdminLgBrgKlrPribadiResource::collection($brgkeluar),
            'total' => $total,
            'pitName' => $pit,
            'allPit' => $allPit,
            'date' => $request->bulan,
        ]);
    }


    public function destroy($id)
    {
        SparepartBarangKeluarPribadi::find($id)->delete();
        return redirect()->route('brgkeluarprb.index')->with('danger', 'Berhasil di delete');
    }

     public function pdf(Request $request)
    {

       $request->validate([
            'bulan' => 'required',
            'lokasi' => 'required',
        ]);

        $allPit = MasterLokasi::all();
        $pit = MasterLokasi::find($request->lokasi);
        $pit = $pit->nama_lokasi;
 
        $brgkeluar =  SparepartBarangKeluarPribadi::with(['user', 'ticket'])
            ->whereMonth('tanggal_keluar', now()->parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', now()->parse($request->bulan)->format('Y'))
            ->join('master_unit', 'lg_brg_klr_prb.master_unit_id', '=', 'master_unit.id')
            ->where('master_lokasi_id', $request->lokasi)
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgkeluar as $bg) {
            $total += $bg->amount;
        }

        $pdf = PDF::loadView('pdf.brgkeluarprb', [
             'brgkeluar' => AdminLgBrgKlrPribadiResource::collection($brgkeluar),
            'total' => $total,
            'pitName' => $pit,
            'allPit' => $allPit,
        ]);

        return $pdf->stream('BarangKeluar.pdf');
    }

    public function excel(Request $request)
    {
          $request->validate([
            'bulan' => 'required',
            'lokasi' => 'required',
        ]);

        $allPit = MasterLokasi::all();
        $pit = MasterLokasi::find($request->lokasi);
        $pit = $pit->nama_lokasi;
 
        $brgkeluar =  SparepartBarangKeluarPribadi::with(['user', 'ticket'])
            ->whereMonth('tanggal_keluar', now()->parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', now()->parse($request->bulan)->format('Y'))
            ->join('master_unit', 'lg_brg_klr_prb.master_unit_id', '=', 'master_unit.id')
            ->where('master_lokasi_id', $request->lokasi)
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        // ngambil grand total
        $total = 0;
        foreach ($brgkeluar as $bg) {
            $total += $bg->amount;
        }

          return view('excel.brgkeluarprb', [
            'brgkeluar' => $brgkeluar,
            'total' => $total
        ]);

    }

}

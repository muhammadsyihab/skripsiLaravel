<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Sparepart;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\SparepartBarangMasuk;
use App\Models\SparepartBarangKeluar;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\AdminLgBrgKlrResource;
use PDF;

class AdminLgBrgKlrController extends Controller
{
    public function index()
    {
        $lokasi = MasterLokasi::all();

        $brgkeluar =  SparepartBarangKeluar::with('sparepart', 'users', 'unit')
        ->whereMonth('tanggal_keluar', now()->format('m'))
        ->whereYear('tanggal_keluar', now()->format('Y'))
        ->orderBy('tanggal_keluar', 'ASC')->get();

        $total = 0;
        foreach ($brgkeluar as $bk) {
            $user = User::find($bk->penerima);
            if (isset($user)) {
                $bk['penerima'] = $user->name;
            } else {
                $bk['penerima'] = 'Masih Belum Ditentukan';
            }
            $bk['amount'] = $bk->qty_keluar * $bk->sparepart->item_price;
            $total += $bk['amount'];
        }

        return view('brgkeluar.index', [
            'brgkeluar' => AdminLgBrgKlrResource::collection($brgkeluar),
            'total' => $total,
            'pit' => 'All PIT',
            'lokasi' => $lokasi,
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'master_lokasi_id' => 'required',
        ]);

        $title = "Barang Keluar";

        $lokasi = MasterLokasi::all();
        $pit = MasterLokasi::find($request->master_lokasi_id);
        $pit = $pit->nama_lokasi;

        $brgkeluar = SparepartBarangKeluar::with('sparepart', 'users')
            ->where('master_lokasi_id', $request->master_lokasi_id)
            ->whereMonth('tanggal_keluar', Carbon::parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', Carbon::parse($request->bulan)->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();
            

        $total = 0;
        foreach ($brgkeluar as $bk) {
            $user = User::find($bk->penerima);
            if (isset($user)) {
                $bk['penerima'] = $user->name;
            } else {
                $bk['penerima'] = 'Masih Belum Ditentukan';
            }
            $bk['amount'] = $bk->qty_keluar * $bk->sparepart->item_price;
            $total += $bk['amount'];
        }
        
        // return view('brgkeluar.index', compact('brgkeluar', 'title', 'total', 'lokasi', 'pit'));
        return view('brgkeluar.index', [
            'brgkeluar' => AdminLgBrgKlrResource::collection($brgkeluar),
            'total' => $total,
            'pit' => $pit,
            'lokasi' => $lokasi,
        ]);
    }

    public function create()
    {
        $title = "Tambah Barang Keluar";
        $spareparts = Sparepart::all();
        $users = User::all();
        $tickets = Tiket::all();
        return view('brgkeluar.create', compact('spareparts', 'users', 'tickets', 'title'));
    }

    public function store(Request $request)
    {
        $spareparts = Sparepart::where('id', $request->master_sparepart_id)->first();

        $request->validate([
            'master_sparepart_id' => 'required',
            'tb_tiketing_id' => 'required',
            'qty_keluar' => 'required',
            'penerima' => 'required',
            'tanggal_keluar' => 'required',
            'estimasi_pengiriman' => 'required',
            'photo' => 'required',
        ]);

        $datas = [
            'master_sparepart_id' => $request->master_sparepart_id,
            'tb_tiketing_id' => $request->tb_tiketing_id,
            'users_id' => auth()->user()->id,
            'qty_keluar' => $request->qty_keluar,
            'status' => $request->status,
            'penerima' => $request->penerima,
            'hm_odo' => $request->hm_odo,
            'tanggal_keluar' => $request->tanggal_keluar,
            'estimasi_pengiriman' => $request->estimasi_pengiriman,
        ];

        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/spKeluar/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $datas['photo'] = "$profileImage";
        }

        SparepartBarangKeluar::create($datas);

        if ($request->qty_keluar <= $spareparts->qty) {
            $qty_total = $spareparts->qty - $request->qty_keluar;
            Sparepart::where('id', $request->master_sparepart_id)
                ->update([
                    'qty' => $qty_total,
                ]);

            Artisan::call('cache:clear');
            return redirect()->route('brgkeluar.index')->with('success', 'Berhasil di Input');
        } else {

            Artisan::call('cache:clear');
            return redirect()->route('brgkeluar.index')->with('success', 'Stok Barang di kurang');
        }
    }

    public function edit($id)
    {
        $title = "Edit Barang Keluar";
        $spareparts = Sparepart::all();
        $users = User::all();
        $brgkeluarById = SparepartBarangKeluar::where('id', $id)->first();
        $tickets = Tiket::all();
        return view('brgkeluar.edit', compact('spareparts', 'brgkeluarById', 'users', 'tickets', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_sparepart_id' => 'required',
            'tb_tiketing_id' => 'required',
            'qty_keluar' => 'required',
            'penerima' => 'required',
            'tanggal_keluar' => 'required',
            'estimasi_pengiriman' => 'required',
        ]);

        $brgKeluarById = SparepartBarangKeluar::where('id', $id)->first();
        $spareparts = Sparepart::where('id', $brgKeluarById->master_sparepart_id)->first();
        $sparepartsReq = Sparepart::where('id', $request->master_sparepart_id)->first();

        if ($request->master_sparepart_id != $spareparts->id) {
            $qty_total = $spareparts->qty + $request->qty_keluar;
            $spareparts->update([
                'qty' => $qty_total,
            ]);

            $qty_total =  $sparepartsReq->qty - $request->qty_keluar;
            $sparepartsReq->update([
                'qty' => $qty_total,
            ]);
        } elseif ($request->master_sparepart_id == $spareparts->id) {
            $qty_total = $sparepartsReq->qty + ($brgKeluarById->qty_keluar - $request->qty_keluar);
            $sparepartsReq->update([
                'qty' => $qty_total,
            ]);
        }

        $datas = [
            'master_sparepart_id' => $request->master_sparepart_id,
            'tb_tiketing_id' => $request->tb_tiketing_id,
            'users_id' => auth()->user()->id,
            'qty_keluar' => $request->qty_keluar,
            'status' => $request->status,
            'penerima' => $request->penerima,
            'hm_odo' => $request->hm_odo,
            'tanggal_keluar' => $request->tanggal_keluar,
            'estimasi_pengiriman' => $request->estimasi_pengiriman
        ];

        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/spKeluar/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $datas['photo'] = "$profileImage";
        }

        $brgKeluarById->update($datas);

        return redirect()->route('brgkeluar.index')->with('success', 'Berhasil diperbaharui');
    }

    public function destroy($id)
    {
        SparepartBarangkeluar::where('id', $id)->delete();
        return redirect()->route('brgkeluar.index')->with('danger', 'Berhasil di delete');
    }

    // public function filter(Request $request)
    // {
    //     $title = "Barang Keluar";
    //     $brgkeluar = SparepartBarangKeluar::with('sparepart', 'users')->whereMonth('tanggal_keluar', Carbon::parse($request->bulan)->format('m'))->whereYear('tanggal_keluar', Carbon::parse($request->bulan)->format('Y'))->orderBy('tanggal_keluar', 'ASC')->get();

    //     return view('brgkeluar.index', compact('brgkeluar', 'title'));
    // }

    public function pdf(Request $request)
    {

        $request->validate([
            'bulan' => 'required',
            'master_lokasi_id' => 'required',
        ]);

        $title = "Barang Keluar";

        $lokasi = MasterLokasi::all();
        $pit = MasterLokasi::find($request->master_lokasi_id);
        $pit = $pit->nama_lokasi;

        $brgkeluar = SparepartBarangKeluar::with('sparepart', 'users')
            ->where('master_lokasi_id', $request->master_lokasi_id)
            ->whereMonth('tanggal_keluar', Carbon::parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', Carbon::parse($request->bulan)->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        $total = 0;
        foreach ($brgkeluar as $bk) {
            $user = User::find($bk->penerima);
            if (isset($user)) {
                $bk['penerima'] = $user->name;
            } else {
                $bk['penerima'] = 'Masih Belum Ditentukan';
            }
            $bk['amount'] = $bk->qty_keluar * $bk->sparepart->item_price;
            $total += $bk['amount'];
        }

        $pdf = PDF::loadView('pdf.brgkeluar', [
            'brgkeluar' => AdminLgBrgKlrResource::collection($brgkeluar),
            'total' => $total,
            'pit' => $pit,
            'lokasi' => $lokasi,
        ]);

        return $pdf->stream('BarangKeluar.pdf');
    }

    public function excel(Request $request)
    {
          $request->validate([
            'bulan' => 'required',
            'master_lokasi_id' => 'required',
        ]);


        $lokasi = MasterLokasi::all();
        $pit = MasterLokasi::find($request->master_lokasi_id);
        $pit = $pit->nama_lokasi;

          $brgkeluar = SparepartBarangKeluar::with('sparepart', 'users')
            ->where('master_lokasi_id', $request->master_lokasi_id)
            ->whereMonth('tanggal_keluar', Carbon::parse($request->bulan)->format('m'))
            ->whereYear('tanggal_keluar', Carbon::parse($request->bulan)->format('Y'))
            ->orderBy('tanggal_keluar', 'ASC')
            ->get();

        $total = 0;
        foreach ($brgkeluar as $bk) {
            $user = User::find($bk->penerima);
            if (isset($user)) {
                $bk['penerima'] = $user->name;
            } else {
                $bk['penerima'] = 'Masih Belum Ditentukan';
            }
            $bk['amount'] = $bk->qty_keluar * $bk->sparepart->item_price;
            $total += $bk['amount'];
        }

          return view('excel.brgkeluar', [
            'brgkeluar' => $brgkeluar,
            'total' => $total
        ]);

    }

}

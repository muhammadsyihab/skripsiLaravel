<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Sparepart;
use App\Models\RiwayatUnit;
use App\Models\RiwayatTiket;
use App\Models\SparepartBarangKeluar;
use App\Models\SparepartBarangKeluarPribadi;
use Symfony\Component\HttpFoundation\Request;

class TicketVueController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();
        
        if ($user->role == 2) {
            $userRole = 'planner';
        } else if ($user->role == 3) {
            $userRole = 'logistik';
        } else {
            $userRole = 'superadmin';
        }

        $ticket = Tiket::find($id);
        $unit = Unit::with('lokasi')->where('id', $ticket->master_unit_id)->first();
        $unit['lokasi_unit'] = $unit->lokasi->nama_lokasi;
        $ticket['pembuat'] = User::where('id', $ticket->nama_pembuat)->first();
        $unitHistories = RiwayatUnit::with('unit')->where('master_unit_id', $unit->id)->orderBy('created_at', 'DESC')->get();
        $histories = RiwayatTiket::with('user', 'ticket')->where('tb_tiketing_id', $id)->get();
        $spareparts = Sparepart::all();
        $users = User::all();
        $user = auth()->user();
        $requests = SparepartBarangKeluar::with('sparepart')->where('status', 0)->where('tb_tiketing_id', $ticket->id)->with('sparepart')->get();
        $requestPribadi = SparepartBarangKeluarPribadi::with('user', 'unit')
        ->where('status', 2)
        ->where('tb_tiketing_id', $ticket->id)
        ->where('amount', '>=', 2000000)
        ->get();

        return inertia('Ticket/index',  compact(
            'ticket', 
            'unit',
            'unitHistories',
            'histories',
            'users',
            'spareparts',
            'requests',
            'requestPribadi',
            'user'
        ));
    }

    public function getTicketById($id) {
        $ticket = Tiket::find($id);

        inertia('Ticket/panel/information',  compact(
            'ticket', 
        ));
    }

    public function postHistory(Request $requests) {
        $photoSave = null;

        if ($photo = $requests->file('photo')) {
            $destinationPath = 'storage/chat/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $photoSave = "$profileImage";
        }

        RiwayatTiket::create([
            'users_id' => auth()->user()->id, 
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $requests->keterangan,
            'photo' => $photoSave,
        ]);
        
        return redirect()->back();
    }

    public function postHistoryUnit(Request $requests) {
        Unit::find($requests->master_unit_id)->update([
            'keterangan' => $requests->ket_sp,
            'status_unit' => $requests->status_sp,
        ]);

        RiwayatUnit::create([
            'master_unit_id' => $requests->master_unit_id,
            'ket_sp' => $requests->ket_sp,
            'status_sp' => $requests->status_sp,
            'pj_alat' => $requests->pj_alat,
        ]);
        
        return redirect()->back()->with('success', 'History Unit Telah Diperbaharui');
    }

    public function postRequest(Request $requests) {
        // status tiket menjadi request sparepart dan menunggu acc logistik
        $ticket = Tiket::find($requests->tb_tiketing_id);
        if ($ticket->status_ticket <= 2) {
            $ticket->update(['status_ticket' => 2]);
        }

        $spareparts = json_decode($requests->qty_keluar);
        foreach ($spareparts as $sparepartKeluar) {
            // menambahkan sparepart barang keluar
            SparepartBarangKeluar::create([
                'master_unit_id' => $requests->master_unit_id,
                'master_lokasi_id' => $requests->master_lokasi_id,
                'master_sparepart_id' => $sparepartKeluar->id,
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $requests->tb_tiketing_id,
                'qty_keluar' => $sparepartKeluar->qty_keluar,
                'status' => $requests->status,
                'hm_odo' => 0,
                'tanggal_keluar' => now(),
            ]);
            
            // menambahkan chat pembuatan tiket
            $penerima = User::find($requests->penerima);
            $keterangan = auth()->user()->name . ' telah request sparepart ' . $sparepartKeluar->nama_item . ', '. $sparepartKeluar->qty_keluar . ' ' . $sparepartKeluar->uom;
            $chat = RiwayatTiket::create([
                'users_id' => auth()->user()->id,
                'tb_tiketing_id' => $requests->tb_tiketing_id,
                'keterangan' => $keterangan,
            ]);

        }
        
        return redirect()->back()->with('success', 'Request Ke Logistik Berhasil');
    }

    public function cancelRequest(Request $requests, $id) {
        // return $id;

        $sparepartKeluar = SparepartBarangKeluar::find($id);
        $sparepartKeluar->update([
            'status' => 4,
        ]);

        // chat request ditolak
        $keterangan = 'Request sparepart '. $sparepartKeluar->sparepart->nama_item .' dengan jumlah '. $sparepartKeluar->qty_keluar .' '. $sparepartKeluar->sparepart->uom .' telah ditolak logistik';
        $chat = RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('danger', 'Request Sparepart Telah di Cancel');
    }

    public function accRequest(Request $requests, $id) {
        // status tiket menjadi acc logistik
        $ticket = Tiket::find($requests->tb_tiketing_id);
        if ($ticket->status_ticket <= 3) {
            $ticket->update(['status_ticket' => 3]);
        }

        $sparepartKeluar = SparepartBarangKeluar::with('users', 'sparepart')->where('id', $id)->first();

        // update stock sparepart
        $sparepart = Sparepart::find($sparepartKeluar->master_sparepart_id);
        if ($sparepartKeluar->qty_keluar <= $sparepart->qty) {
            $sparepart->update([ 
                'qty' => $sparepart->qty - $sparepartKeluar->qty_keluar,
            ]);
        } else {
            return redirect()->back()->with('danger', 'Request Sparepart Tidak Bisa di Acc, Karena Stock Kurang');
        }
        
        // menambahkan sparepart keluar
        $sparepartKeluar->update([
            'estimasi_pengiriman' => $requests->estimasi_pengiriman,
            'status' => $requests->status,
            'penerima' => $requests->penerima,
        ]);


        // menambahkan chat sparepart telah di acc logistik
        $penerima = User::find($requests->penerima);
        $keterangan = 'Request sparepart ' . $sparepartKeluar->sparepart->nama_item . ', '. $sparepartKeluar->qty_keluar . ' ' . $sparepartKeluar->sparepart->uom . ' telah di acc. Estimasi pengiriman ' . $sparepartKeluar->estimasi_pengiriman . ' jam, kepada ' . $penerima->name;
        $chat = RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('success', 'Request Sparepart Telah di Acc');
    }

    public function postRequestKosong(Request $requests) {
        // status tiket menjadi acc logistik pembelian pribadi
        

        $amount = $requests->qty * $requests->item_price;
        $status = 1;
        if ($amount >= 2000000) {
            $status = 2;
        } else {
            $ticket = Tiket::find($requests->tb_tiketing_id);
            // if ($ticket->status_ticket <= 3) {
            //     $ticket->update(['status_ticket' => 3]);
            // }
        }

        SparepartBarangKeluarPribadi::create([
            'master_unit_id' => $requests->master_unit_id, 
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id, 
            'part_number' => $requests->part_number, 
            'nama_item' => $requests->nama_item, 
            'qty' => $requests->qty, 
            'item_price' => $requests->item_price, 
            'amount' => $amount, 
            'uom' => $requests->uom, 
            'status' => $status, 
            'pembeli' => $requests->pembeli, 
            'penerima' => $requests->penerima, 
            'tanggal_keluar' => now(), 
            'estimasi' => $requests->estimasi, 
            'photo' => null, 
        ]);

        // menambahkan chat sparepart pembelian pribadi
        $penerima = User::find($requests->penerima);
        $pembeli = User::find($requests->pembeli);

        if ($status == 2) {
            $keterangan = nl2br('Pembelian pribadi menunggu disetujui PIC, Nama Item: ' . $requests->nama_item . ', Harga Item: ' . $requests->item_price . ', Jumlah: ' . $requests->qty . ', Estimasi: ' . $requests->estimasi . ' Jam');
        } elseif ($status == 1) {
            $keterangan = nl2br('Pembelian pribadi disetujui warehouse, Nama Item: ' . $requests->nama_item . ', Harga Item: ' . $requests->item_price . ', Jumlah: ' . $requests->qty . ', Estimasi: ' . $requests->estimasi . ' Jam');
        }
        
        $chat = RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('success', 'Request Pembelian Pribadi berhasil');
    }

    public function postRequestKosongAcc(Request $requests, $id) {
        // status tiket menjadi acc logistik pembelian pribadi
        $ticket = Tiket::find($requests->tb_tiketing_id);
        // if ($ticket->status_ticket <= 7) {
        //     $ticket->update(['status_ticket' => 7]);
        // }

        $sparepart = SparepartBarangKeluarPribadi::find($id);
        $sparepart->update([
            'status' => 3
        ]);

        // menambahkan chat sparepart pembelian pribadi
        $penerima = User::find($requests->penerima);
        $pembeli = User::find($requests->pembeli);
        
        $keterangan = nl2br('Pembelian pribadi disetujui PIC Nama Item: ' . $sparepart->nama_item . ', Harga Item: ' . $sparepart->item_price . ', Jumlah: ' . $sparepart->qty . ', Amount: ' . $sparepart->amount . ', Estimasi: ' . $sparepart->estimasi . ' Jam');
        $chat = RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('success', 'Request Pembelian Pribadi Di Acc PIC');
    }

    public function postRequestKosongCancel(Request $requests, $id) {
        $sparepart = SparepartBarangKeluarPribadi::find($id);
        $sparepart->update([
            'status' => 4
        ]);

        $keterangan = 'Request pembelian pribadi sparepart '. $sparepart->nama_item .' dengan jumlah '. $sparepart->qty .' '. $sparepart->uom .' telah ditolak PIC';
        $chat = RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $requests->tb_tiketing_id,
            'keterangan' => $keterangan,
        ]);
    }

    public function ulangTicket($id) {
        $ticket = Tiket::find($id);
        if ($ticket->status_ticket == 4) {
            $ticket->update([
                'status_ticket' => 1
            ]);
            return redirect()->back()->with('success', 'Pengaduan Berhasil Diulang');
        }
        return redirect()->back()->with('danger', 'Pengaduan Gagal Diulang');
    }

    public function tutupTicket(Request $request, $id) {
        $ticket = Tiket::find($id);
        
        Unit::find($request->unit_id)->update([
            'status_unit' => 0,
        ]);
        
        if ($ticket->status_ticket == 4) {
            $ticket->update([
                'status_ticket' => 6,
                'end_insiden' => now(),
            ]);
            return redirect()->back()->with('success', 'Pengaduan Berhasil Ditutup');
        }
        return redirect()->back()->with('danger', 'Pengaduan Gagal Ditutup');
    }

    public function refresh() {
        return redirect()->back()->with('success', 'Berhasil Disegarkan');
    }
    
}

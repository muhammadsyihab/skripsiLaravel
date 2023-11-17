<?php

namespace App\Http\Livewire;

use DB;
use App\Models\Unit;
use App\Models\Tiket;
use App\Models\Sparepart;
use App\Models\SparepartBarangKeluar;
use App\Models\SparepartBarangKeluarPribadi;
use App\Models\RiwayatTiket;
use App\Models\User;
use Livewire\Component;

class Tindakan extends Component
{
    public $inputSparepart, $jumlah, $pengaduanId, $masterUnitId, $showModalPermintaan, $penerimaPribadi, 
            $partNumberPribadi, 
            $namaItem, 
            $qty, 
            $itemPrice, 
            $uom, 
            $pembeli, 
            $tanggalKeluar, 
            $sparepartDisetujui, 
            $estimasi,
            $penerimaAcc,
            $estimasiPengiriman;

            

    private function resetInputFields(){
        $this->jumlah = null;
        // $this->inputSpareparts = '';
        // $this->penerimaPribadi = ''; 
        $this->partNumberPribadi = null; 
        $this->namaItem = null; 
        $this->qty = null; 
        $this->itemPrice = null; 
        $this->uom = null; 
        // $this->pembeli = ''; 
        $this->tanggalKeluar = null; 
        $this->estimasi = null;
        $this->estimasiPengiriman = null;
        $this->penerimaAcc = null;
        $this->sparepartDisetujui = null;
    }

    public function render()
    {
        $spareparts = DB::table('master_sparepart')->get();
        $users = DB::table('users')->get();
        $sparepartsKeluar = SparepartBarangKeluar::where('tb_tiketing_id', $this->pengaduanId)->get();
        return view('livewire.tindakan', [
            'spareparts' => $spareparts,
            'users' => $users,
            'sparepartsKeluar' => $sparepartsKeluar,
        ]);
    }


    public function storePermintaan() {
        // dd($this->inputSparepart);
        // dd([$this->inputSparepart, $this->jumlah]);

        $unit = Unit::find($this->masterUnitId);
        $sparepart = Sparepart::find($this->inputSparepart);
        
        // status ticket
        Tiket::find($this->pengaduanId)->update([
            'status_ticket' => 1
        ]);

        // barang keluar ke database
        SparepartBarangKeluar::create([
            'master_sparepart_id' => $this->inputSparepart, 
            'master_unit_id' => $this->masterUnitId, 
            'tb_tiketing_id' => $this->pengaduanId, 
            'master_lokasi_id' => $unit->master_lokasi_id, 
            'users_id' => auth()->user()->id, 
            'qty_keluar' => $this->jumlah,
            'status' => 0,
            'penerima' => null,
            'tanggal_keluar' => now(),
            'estimasi_pengiriman' => null,
        ]);

        // chat
        $chat = nl2br("<b>Permintaan Sparepart</b> \n Nama Item: ". $sparepart->nama_item ." \n Part Number: ". $sparepart->part_number." \n Jumlah: ". $this->jumlah);
        
        RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $this->pengaduanId,
            'keterangan' => $chat,
        ]);

        // update status
        // belum


        // reset field dan refresh chat
        $this->showModalPermintaan = true;
        session()->flash('success', 'Permintaan sparepart telah dibuat');
        $this->resetInputFields();
        $this->emit('chatAdded');
    }

    public function storePribadi() {
        // dd($this->penerimaPribadi);
        // dd([$this->inputSparepartsPribadi, $this->jumlah]);

        $unit = Unit::find($this->masterUnitId);
        // $sparepart = Sparepart::find($this->inputSparepartsPribadi);
        $userPenerima = User::find($this->penerimaPribadi);
        $userPembeli = User::find($this->pembeli);
        // barang keluar ke database
        $sparepart = SparepartBarangKeluarPribadi::create([
            'master_unit_id' => $this->masterUnitId, 
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $this->pengaduanId, 
            'part_number' => $this->partNumberPribadi, 
            'nama_item' => $this->namaItem, 
            'qty' => $this->qty, 
            'item_price' => $this->itemPrice, 
            'amount' => $this->qty * $this->itemPrice, 
            'uom' => $this->uom, 
            'status' => 0, 
            'pembeli' => $this->pembeli, 
            'penerima' => $this->penerimaPribadi, 
            'tanggal_keluar' => $this->tanggalKeluar, 
            'estimasi' => $this->estimasi,
        ]);

        $amount = (int)$this->uom * (int)$this->itemPrice;
        // chat
        $chat = nl2br("<b>Pembelian Pribadi Persetujuan Logistik</b> \n Nama Item: ". $this->namaItem ." \n Part Number: ". $this->partNumberPribadi ." \n Jumlah: ". $this->qty ." \n Item Price: ". $this->itemPrice ." \n UOM: ". $this->uom ." \n Amount: ". $sparepart->amount ." \n Estimasi Pengiriman: ". $this->estimasi ." Jam \n Tanggal Keluar: ". now()->parse($this->tanggalKeluar)->format('j F Y') ." \n Pembeli: ". $userPembeli->name ." - ". $userPembeli->jabatan ." \n Penerima: ". $userPenerima->name ." - ". $userPenerima->jabatan);
        
        RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $this->pengaduanId,
            'keterangan' => $chat,
        ]);

        // update status
        // belum


        // reset field dan refresh chat
        session()->flash('success', 'Pembelian mandiri telah dibuat');
        $this->resetInputFields();
        $this->emit('chatAdded');
    }

    public function tutupTicket()
    {
        Tiket::find($this->pengaduanId)->update([
            "status_ticket" => 6
        ]);

        session()->flash('danger', 'Pengaduan telah ditutup');
    }

    public function sendToModalPersetujuan($id)
    {
        $this->sparepartDisetujui = $id;
        // dd($this->sparepartDisetujui);
    }

    public function storeDisetujui()
    {
        // dd($this->sparepartDisetujui);
        $sparepart = SparepartBarangKeluar::find(107);
        $user = User::find($this->penerimaAcc);
        // dd($this->sparepartId);
        // dd($sparepart);
        // menentukan penerima dan estimasi
        $sparepart->update([
            'status' => 2,
            'penerima' => $this->penerimaAcc,
            'estimasi_pengiriman' => $this->estimasiPengiriman,
        ]);

        // chat
        $chat = nl2br("<b>Persetujuan Permintaan Sparepart</b> \n Nama Item: ". $sparepart->sparepart->nama_item ." \n Part Number: ". $sparepart->sparepart->part_number ."\n Penerima: ". $user->name ." - ". $user->jabatan ."\n Estimasi Pengiriman: ". $sparepart->estimasi_pengiriman ." jam");
        
        RiwayatTiket::create([
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $this->pengaduanId,
            'keterangan' => $chat,
        ]);

        // reset field dan refresh chat
        session()->flash('success', 'Permintaan telah disetujui');
        $this->resetInputFields();
        $this->emit('chatAdded');
    }
}

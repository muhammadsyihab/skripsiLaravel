<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Unit;
use App\Models\Sparepart;
use App\Models\RiwayatTiket;
use App\Models\SparepartBarangKeluarPribadi;

class ModalPribadi extends Component
{
    public $pengaduanId, 
            $masterUnitId,
            $penerimaPribadi, 
            $partNumberPribadi, 
            $namaItem, 
            $qty, 
            $itemPrice, 
            $uom, 
            $pembeli, 
            $tanggalKeluar, 
            $estimasi;

    public $inputSparepartsPribadi;

    public function render()
    {
        $spareparts = Sparepart::all();
        $users = User::all();
        return view('livewire.modal-pribadi', [
            'spareparts' => $spareparts,
            'users' => $users,
        ]);
    }

    private function resetInputFields(){
            $this->pengaduanId = null; 
            $this->masterUnitId = null;
            $this->penerimaPribadi = null; 
            $this->partNumberPribadi = null; 
            $this->namaItem = null; 
            $this->qty = null; 
            $this->itemPrice = null; 
            $this->uom = null; 
            $this->pembeli = null; 
            $this->tanggalKeluar = null; 
            $this->estimasi = null;
    }

    public function store() {
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
        $this->resetInputFields();
        $this->emit('chatAdded');
    }
}

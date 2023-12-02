<?php

namespace App\Http\Livewire;
use App\Models\Sparepart;
use App\Models\Unit;
use App\Models\User;
use App\Models\RiwayatTiket;
use App\Models\SparepartBarangKeluar;
use Livewire\Component;

class ModalRequest extends Component
{
    public $jumlah, $estimasiPengiriman, $pengaduanId, $penerima, $masterUnitId;
    public $inputSpareparts;
    
    // public $updateMode = false;

    // private function resetInputFields(){
    //     $this->jumlah = null;
    //     $this->inputSpareparts = null;
    // }

    public function updatedInputSpareparts($value)
    {
        $this->inputSpareparts = $value;
    }

    // public function updatedSelectedItems()
    // {
    //     $this->emit('selectedSparepartsUpdated', $this->inputSpareparts);
    // }

    public function mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }

    public function store() {
        dd($this->inputSpareparts);
        // dd([$this->inputSpareparts, $this->jumlah]);

        $unit = Unit::find($this->masterUnitId);
        $sparepart = Sparepart::find($this->inputSpareparts);
        $user = User::find($this->penerima);
        // barang keluar ke database
        SparepartBarangKeluar::create([
            'master_sparepart_id' => $this->inputSpareparts, 
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
        $this->resetInputFields();
        $this->emit('chatAdded');
    }
    
    public function render()
    {
        $spareparts = Sparepart::all();
        $users = User::all();
        return view('livewire.modal-request', [
            'spareparts' => $spareparts,
            'users' => $users,
        ]);
    }
}

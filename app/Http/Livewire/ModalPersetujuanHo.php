<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sparepart;
use App\Models\SparepartBarangKeluar;
use App\Models\RiwayatTiket;

class ModalPersetujuanHo extends Component
{

    public $sparepartId, $penerima, $estimasiPengiriman, $pengaduanId;

    protected $listeners = ['sparepartId'];

    public function sparepartId($sparepartId)
    {
        $this->sparepartId = $sparepartId;
    }

    public function accLogistik()
    {
       
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.modal-persetujuan-ho', [
            'users' => $users,
        ]);
    }

    private function resetInputFields(){
        $this->penerima = null;
        $this->estimasiPengiriman = null;
    }

    public function store()
    {
        
        $sparepart = SparepartBarangKeluar::find($this->sparepartId);
        $user = User::find($this->penerima);
        // dd($this->sparepartId);
        // dd($sparepart);
        // menentukan penerima dan estimasi
        $sparepart->update([
            'status' => 1,
            'penerima' => $this->penerima,
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
        $this->resetInputFields();
        $this->emit('chatAdded');
        $this->emitSelf('accLogistik');
    }
}

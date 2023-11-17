<?php

namespace App\Http\Livewire;

use App\Models\SparepartBarangKeluar;
use App\Models\User;
use Livewire\Component;

class ModalAccLogistik extends Component
{
    public $sparepart, $pengaduanId;

    public function render()
    {
        $spareparts = SparepartBarangKeluar::where('tb_tiketing_id', $this->pengaduanId)->get();
        return view('livewire.modal-acc-logistik', ['spareparts' => $spareparts, 'pengaduanId' => $this->pengaduanId]);
    }

    public function sendToModal($id) 
    {
        $this->emit('sparepartId', $id);
    }
}

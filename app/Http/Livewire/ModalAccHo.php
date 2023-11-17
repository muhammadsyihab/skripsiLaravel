<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SparepartBarangKeluar;

class ModalAccHo extends Component
{
    public $sparepart, $pengaduanId;

    public function render()
    {
        $spareparts = SparepartBarangKeluar::where('tb_tiketing_id', $this->pengaduanId)->get();
        return view('livewire.modal-acc-ho', ['spareparts' => $spareparts, 'pengaduanId' => $this->pengaduanId]);
    }

    public function sendToModal($id) 
    {
        $this->emit('sparepartId', $id);
    }
}

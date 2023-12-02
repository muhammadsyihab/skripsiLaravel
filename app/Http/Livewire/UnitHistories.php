<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\RiwayatUnit;
use App\Models\Unit;

class UnitHistories extends Component
{
    public $masterUnitId, $keterangan, $histories;

    public function mount($masterUnitId)
    {
        $this->masterUnitId = $masterUnitId;
    }

    public function render()
    {
        $this->histories = DB::table('tb_history_unit')
        ->select('tb_history_unit.*', 'master_unit.no_lambung')
        ->join('master_unit', 'tb_history_unit.master_unit_id', 'master_unit.id')
        ->where('master_unit_id', $this->masterUnitId)
        ->get();
        
        return view('livewire.unit-histories', [
            'masterUnitId' => $this->masterUnitId,
            'histories' => $this->histories,
        ]);
    }

    private function resetInputFields(){
        $this->keterangan = '';
    }

    public function storeRiwayat()
    {
        $unit = Unit::find($this->masterUnitId);
        RiwayatUnit::create([
            'master_unit_id' => $this->masterUnitId,
            'ket_sp' => $this->keterangan,
            'status_sp' => $unit->status_unit,
            'pj_alat' => auth()->user()->name,
        ]);

        $this->histories = DB::table('tb_history_unit')
        ->select('tb_history_unit.*', 'master_unit.no_lambung')
        ->join('master_unit', 'tb_history_unit.master_unit_id', 'master_unit.id')
        ->where('master_unit_id', $this->masterUnitId)
        ->get();

        $this->resetInputFields();
        session()->flash('success', 'History unit telah dibuat');
    }
}

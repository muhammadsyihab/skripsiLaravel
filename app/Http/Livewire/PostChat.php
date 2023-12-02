<?php

namespace App\Http\Livewire;

use App\Models\RiwayatTiket;
use App\Models\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostChat extends Component
{
    use WithFileUploads;

    public $keterangan, $file, $pengaduanId;
    public $updateMode = false;
    
    public function mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }
    
    private function resetInputFields(){
        $this->file = null;
        $this->keterangan = '';
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required',
        ]);
        // dd($this->keterangan);
        $profileImage = null;
        $url = null;

        if (isset($this->file)) {
            $profileImage = date('YmdHis') . "." . $this->file->getClientOriginalExtension();
            $url = $this->file->store('chat', 'publicStore');
        }

        // kirim notif
        // $users = DB::table('users')->where('role', 1)->where('master_lokasi_id', $unit->master_lokasi_id)->orWhere('role', 2)->orWhere('role', 3)->orWhere('role', 0)->get();
        // foreach ($users as $user) {
        //     Notification::create([
        //         'users_id' => $user->id,
        //         'judul' => 'Pengaduan',
        //         'isi' => 'Ada pesan baru di pengaduan #00'. $this->pengaduanId,
        //         'priority' => 1,
        //     ]);
        // }

        $data = [
            'users_id' => auth()->user()->id,
            'tb_tiketing_id' => $this->pengaduanId,
            'keterangan' => $this->keterangan,
            'photo' => $url,
        ];
        
        RiwayatTiket::create($data);
  
        $this->resetInputFields();
        // $this->dispatchBrowserEvent('scrollDown');
        $this->emit('chatAdded');
    }

    public function render()
    {
        return view('livewire.post-chat', [
            'pengaduanId' => $this->pengaduanId,
        ]);
    }
}

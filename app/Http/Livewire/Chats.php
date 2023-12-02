<?php

namespace App\Http\Livewire;

use DB;
use Livewire\Component;

class Chats extends Component
{
    public $pengaduanId;

    protected $listeners = [
        'chatAdded',
    ];

    public function chatAdded()
    {
        
    }

    public function mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }

    public function render()
    {
        $chats = DB::table('tb_history_tiketing')
                    ->select('tb_history_tiketing.*', 'users.name', 'users.role')
                    ->join('users', 'tb_history_tiketing.users_id', 'users.id')
                    ->where('tb_tiketing_id', $this->pengaduanId)
                    ->get();

        return view('livewire.chats', [
            'pengaduanId' => $this->pengaduanId,
            'chats' => $chats,
        ]);
    }
}

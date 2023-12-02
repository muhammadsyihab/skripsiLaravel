<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'no_lambung' => $this->units->no_lambung,
            'judul' => $this->judul,
            'nama_unit' => $this->units->jenis,
            // 'pembuat' => $userPembuat,
            'pembuat' => $this->users->name,
            'status' => 'Ticket Aktif',
            'waktu_insiden' => now()->parse($this->waktu_insiden)->format('l, j F Y'),
        ];
        
    }
}

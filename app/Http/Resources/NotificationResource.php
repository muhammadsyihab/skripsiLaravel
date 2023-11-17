<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $userPembuat = User::where('id', $this->nama_pembuat)->first();
        return [
            // 'users_id' => $this->user->name,
            'nama_unit' => $this->judul,
            'pembuat' => $this->isi,
            'name' => $this->priority,
            'jam' => now()->parse($this->created_at)->format('H:i:s'),
        ];
    }
}

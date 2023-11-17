<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoriesTicket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        if (!empty($this->photo)) {
            // $photo = 'http://103.179.86.78:8000/storage/'. $this->photo;
            $photo = asset('storage/chat/'. $this->photo);
        } else {
            $photo = 'photoNull';
        }

        if (str_contains($photo, '.pdf')) {
            return [
                'keterangan' => $this->keterangan,
                'photo' => $this->photo,
                'user_photo_url' => 'http://103.179.86.78:8000/storage/Register/'. $this->user->photo, 
                'file' => $photo,
                'created_at' => now()->parse($this->created_at)->format('j F Y, H:i a'),
                'name' => $this->user->name,
                'jabatan' => $this->user->jabatan,
            ];
        } else {
            return [
                'keterangan' => $this->keterangan,
                'photo' => $this->photo,
                'user_photo_url' => 'http://103.179.86.78:8000/storage/Register/'. $this->user->photo, 
                'history_photo_url' => $photo,
                'created_at' => now()->parse($this->created_at)->format('j F Y, H:i a'),
                'name' => $this->user->name,
                'jabatan' => $this->user->jabatan,
            ];
        }
        
    }
}

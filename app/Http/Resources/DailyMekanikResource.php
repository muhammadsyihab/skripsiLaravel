<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyMekanikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tagline = $this->jadwalMekanik->tagline->where('jam_kerja_masuk', '<=', now()->parse($this->created_at)->format('Y-m-d H:i:s'))->where('jam_kerja_keluar', '>=', now()->parse($this->created_at)->format('Y-m-d H:i:s'))->first();
        if (!$tagline) {
            $tanggal = 'Jadwal Salah';
        } else {
            $tanggal = now()->parse($tagline->jam_kerja_masuk)->translatedFormat('j F Y, g:i a');
        }
        return [
            'no_lambung' => $this->unit->no_lambung,
            'nama_unit' => $this->unit->jenis,
            'name' => $this->user->name,
            'tanggal' => $tanggal,
            'estimasi_perbaikan_hm' => $this->estimasi_perbaikan_hm,
            'perbaikan_hm' => $this->perbaikan_hm,
            'perbaikan' => $this->perbaikan,
            'status' => $this->status,
        ];
    }
}

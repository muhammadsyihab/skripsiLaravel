<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyOperatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tagline = "Belum Terjadwal";
        if ($this->status == "Mulai") {
            $jadwal = $this->jadwal->tagline_operator->first();
            if (isset($jadwal->jam_kerja_masuk)) {
                $tagline = $jadwal->jam_kerja_masuk;
            }
        } else {
            $jadwal = $this->jadwal->tagline_operator->first();
            if (isset($jadwal->jam_kerja_keluar)) {
                $tagline = $jadwal->jam_kerja_keluar;
            }
        }
        return [
            'no_lambung' => $this->unit->no_lambung,
            'nama_unit' => $this->unit->jenis,
            'name' => $this->user->name,
            'jam_kerja' => $tagline,
            'hm' => $this->hm,
            'status' => $this->status,
        ];
    }
}

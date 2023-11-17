<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->shift_id == 1) {
            $shift = 'Day';
        } else {
            $shift = 'Night';
        }

        if ($this->unitStatus == 0) {
            $status = 'Ready';
        } elseif ($this->unitStatus == 1) {
            $status = 'Working';
        } else {
            $status = 'Breakdown';
        }

        if (auth()->user()->role == 4) {
            return [
                'no_lambung' => $this->no_lambung,
                'shift' => $shift,
                'nama_unit' => $this->jenis,
                'status_unit' => $status,
                'name' => $this->name,
                'judul_jam_kerja' => now()->parse($this->jam_kerja_masuk)->translatedFormat('l, j F Y'),
                'jam_kerja_masuk' => now()->parse($this->jam_kerja_masuk)->translatedFormat('j F Y g:i'),
                'jam_kerja_keluar' => now()->parse($this->jam_kerja_keluar)->translatedFormat('j F Y g:i'),
            ];
        } else {
            return [
                'shift' => $shift,
                'name' => $this->name,
                'judul_jam_kerja' => now()->parse($this->jam_kerja_masuk)->translatedFormat('l, j F Y'),
                'jam_kerja_masuk' => now()->parse($this->jam_kerja_masuk)->translatedFormat('j F Y g:i'),
                'jam_kerja_keluar' => now()->parse($this->jam_kerja_keluar)->translatedFormat('j F Y g:i'),
            ];
        }
    }
}

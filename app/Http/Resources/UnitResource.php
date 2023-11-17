<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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

        return [
            'id_unit' => $this->id,
            'nama_lokasi' => $this->lokasi->nama_lokasi,
            'no_serial' => $this->no_serial,
            'no_lambung' => $this->no_lambung,
            'nama_unit' => $this->nama_unit,
            'status_unit' => $this->status_unit,
            'status_kepemilikan' => $this->status_kepemilikan,
            'total_hm' => $this->total_hm,
            'sisa_hm' => $this->sisa_hm,
            'keterangan' => $this->keterangan,
        ];
    }
}

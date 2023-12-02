<?php

namespace App\Exports;

use App\Models\SparepartBarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBrgMasuk implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SparepartBarangMasuk::select(
            'master_sparepart_id',
            'tanggal_masuk',
            'qty_masuk',
            'status',
            'item_price',
            'amount',
            'vendor'
        )->get();
    }
}
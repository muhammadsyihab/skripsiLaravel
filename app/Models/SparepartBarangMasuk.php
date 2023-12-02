<?php

namespace App\Models;

use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartBarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'lg_brg_msk';
    protected $fillable = [
        'master_sparepart_id',
        'tanggal_masuk',
        'qty_masuk',
        'status',
        'item_price',
        'amount',
        'notes',
        'vendor',
        'nomor_po',
        'penerima',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'master_sparepart_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelSuply extends Model
{
    use HasFactory;
    protected $table = 'fuel_suply';
    protected $fillable = [
        'storage_id',
        'fuel_to_stock_id',
        'storage_id',
        'transporter',
        'no_plat_kendaraan',
        'no_surat_jalan',
        'driver',
        'penerima',
        'tc_storage_sebelum',
        'tc_storage_sesudah',
        'tc_kenaikan_storage',
        'suhu_diterima',
        'qty_by_do',
        'do_datang',
        'do_minus',
    ];

    public function fuelStock() 
    {
        return $this->belongsTo(FuelStock::class, 'fuel_to_stock_id', 'id');
    }

    public function storage() 
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

    public function lokasi() 
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }
}

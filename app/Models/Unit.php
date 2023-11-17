<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'master_unit';
    protected $fillable = [
        'master_lokasi_id',
        'no_serial',
        'no_lambung',
        'nama_unit',
        'status_unit',
        'status_kepemilikan',
        'total_hm',
        'sisa_hm',
        'keterangan',
        'jenis',
    ];

    public function lokasi()
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Tiket::class, 'master_unit_id', 'id');
    }

    public function services()
    {
        return $this->HasMany(Service::class, 'master_unit_id', 'id');
    }

    public function fuelUnit()
    {
        return $this->HasMany(FuelUnit::class, 'master_unit_id', 'id');
    }
}

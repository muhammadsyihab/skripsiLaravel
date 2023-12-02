<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMekanik extends Model
{
    use HasFactory;
    protected $table = 'mekanik_daily';
    protected $fillable = [
        'users_id',
        'master_unit_id',
        'tb_jadwal_mekanik_id',
        'kerusakan',
        'estimasi_perbaikan_hm',
        'perbaikan_hm',
        'perbaikan',
        'status',
        'photo',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

    public function jadwalMekanik()
    {
        return $this->belongsTo(JadwalMekanik::class, 'tb_jadwal_mekanik_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'master_shift_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagline extends Model
{
    use HasFactory;

    protected $table = 'tagline_mekanik';
    protected $fillable = [
        'jadwal_mekanik_id',
        'jam_kerja_masuk',
        'jam_kerja_keluar',
        'updated_at',
        'created_at',
    ];

    public function jadwal_mekanik()
    {
        return $this->belongsTo('App/Models/JadwalMekanik', 'jadwal_mekanik_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    use HasFactory;
    protected $table = 'tb_grup';
    protected $fillable = [
        'nama_grup',
        'master_lokasi_id',
    ];

    public function lokasi()
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }
}

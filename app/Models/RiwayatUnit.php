<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatUnit extends Model
{
    use HasFactory;
    protected $table = 'tb_history_unit';
    protected $fillable = [
        'master_unit_id',
        'ket_sp',
        'status_sp',
        'pj_alat',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }
}

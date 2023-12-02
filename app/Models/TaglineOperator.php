<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaglineOperator extends Model
{
    use HasFactory;
    protected $table = 'tagline_operator';
    protected $fillable = [
        'jadwal_operator_id',
        'jam_kerja_masuk',
        'jam_kerja_keluar',
        'updated_at',
        'created_at',
    ];

   public function jadwal_operator()
    {
        return $this->belongsTo('App/Models/Jadwal', 'jadwal_operator_id', 'id');
    }

}

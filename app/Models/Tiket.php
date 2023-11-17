<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;
    protected $table = 'tb_tiketing';
    protected $fillable = [
        'users_id', 
        'waktu_insiden', 
        'prioritas', 
        'photo', 
        'nama_pembuat', 
        'judul', 
        'master_unit_id',
        'status_ticket',
        'latlong',
    ]; 

    public function histories() {
        return $this->hasMany(RiwayatTiket::class, 'tb_tiketing_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function units() {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

}

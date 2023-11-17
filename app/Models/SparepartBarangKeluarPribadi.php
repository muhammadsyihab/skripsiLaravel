<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartBarangKeluarPribadi extends Model
{
    use HasFactory;
    protected $table = 'lg_brg_klr_prb';
    protected $fillable = [
        'master_unit_id', 
        'users_id',
        'tb_tiketing_id', 
        'part_number', 
        'nama_item', 
        'qty', 
        'item_price', 
        'amount', 
        'uom', 
        'status', 
        'pembeli', 
        'penerima', 
        'tanggal_keluar', 
        'estimasi', 
        'photo', 
    ]; 

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function ticket() {
        return $this->belongsTo(Tiket::class, 'tb_tiketing_id', 'id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }
}

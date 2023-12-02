<?php

namespace App\Models;

use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartBarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'lg_brg_klr';
    protected $fillable = [
        'master_sparepart_id', 
        'master_unit_id', 
        'tb_tiketing_id', 
        'master_lokasi_id', 
        'users_id', 
        'qty_keluar',
        'status',
        'penerima', 
        'hm_odo',
        'tanggal_keluar',
        'estimasi_pengiriman',
        'photo',
    ]; 

    public function sparepart() {
        return $this->belongsTo(Sparepart::class, 'master_sparepart_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function ticket() {
        return $this->belongsTo(Tiket::class, 'tb_tiketing_id', 'id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

    public function lokasi() {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }
}
    
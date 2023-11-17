<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $table = 'storage';
    protected $fillable = [
        'users_id',
        'master_lokasi_id',
        'nama_storage',
        'kapasitas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }

    public function stocks() 
    {
        return $this->hasMany(FuelStock::class, 'storage_id', 'id');
    }
}

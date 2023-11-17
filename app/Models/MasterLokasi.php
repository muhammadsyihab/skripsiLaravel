<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLokasi extends Model
{
    use HasFactory;
    protected $table = 'master_lokasi';
    protected $fillable = [
        'nama_lokasi',
        'lattitude',
        'longtitude',
        'radius',
    ];

    public function storages()
    {
        return $this->hasMany(Storage::class, 'storage_id', 'id');
    }
}

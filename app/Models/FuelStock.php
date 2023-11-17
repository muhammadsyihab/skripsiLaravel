<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelStock extends Model
{
    use HasFactory;
    protected $table = 'fuel_to_stock';
    protected $fillable = [
        'master_lokasi_id',
        'tanggal',
        'stock',
    ];

    public function storage() 
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

    public function fuelSuplies() 
    {
        return $this->hasMany(FuelSuply::class, 'fuel_to_stock_id', 'id');
    }

    public function fuelOuts() 
    {
        return $this->hasMany(FuelUnit::class, 'fuel_to_stock_id', 'id');
    }

    public function fuelUnit() 
    {
        return $this->HasMany(FuelUnit::class, 'master_unit_id', 'id');
    }

    public function lokasi() 
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUnit extends Model
{
    use HasFactory;
    protected $table = 'daily_unit';
    protected $fillable = [
        'users_id',
        'master_unit_id',
        'shift_id',
        'tanggal',
        'start_unit',
        'end_unit',
        'penggunaan_fuel',
        'wh',
        'stb',
        'bd',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

    public function fuelUnits()
    {
        return $this->hasMany(FuelUnit::class, 'daily_unit_id', 'id');
    }

    // untuk pu,ua,ma
    // public function fuelunit()
    // {
    //     return $this->belongsTo(Service::class, 'fuel_to_unit_id', 'id');
    // }
}

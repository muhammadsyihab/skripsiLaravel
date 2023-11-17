<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelUnit extends Model
{
    use HasFactory;
    protected $table = 'fuel_to_unit';
    protected $fillable = [
        'fuel_to_stock_id',
        'daily_unit_id',
        'qty_to_unit',
        'shift',
    ];

    public function dailyUnit()
    {
        return $this->belongsTo(DailyUnit::class, 'daily_unit_id', 'id');
    }

    public function fuelStock()
    {
        return $this->belongsTo(FuelStock::class, 'fuel_to_stock_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;
    protected $table = 'master_sparepart';
    protected $fillable = [
        'nama_item',
        'part_number',
        'master_unit_id',
        'qty',
        'uom',
        'jenis',
        'item_price',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }
}

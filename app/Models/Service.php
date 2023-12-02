<?php

namespace App\Models;

use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'master_service';
    protected $fillable = [
        'master_unit_id',
        'status',
        'hm',
    ];

    public function spareparts() {
        return $this->belongsToMany(Sparepart::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }
}

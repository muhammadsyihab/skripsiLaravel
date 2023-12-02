<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOperator extends Model
{
    use HasFactory;
    protected $table = 'operator_daily'; 
    protected $fillable = [
        'users_id',
        'master_unit_id',
        'tb_jadwal_id',
        'hm',
        'photo_hm',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

    public function jadwal() {
        return $this->belongsTo(Jadwal::class, 'tb_jadwal_id', 'id');
    }
}

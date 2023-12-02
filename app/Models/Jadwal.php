<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'tb_jadwal';
    protected $fillable = [
        'shift_id',
        'master_unit_id',
        'users_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'master_unit_id', 'id');
    }

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function dailyOperator()
    {
        return $this->hasMany(DailyOperator::class, 'tb_jadwal_id', 'id');
    }

    public function tagline_operator()
    {
        return $this->hasMany('App\Models\TaglineOperator', 'jadwal_operator_id');
    }
}

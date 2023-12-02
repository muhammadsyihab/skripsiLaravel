<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMekanik extends Model
{
    use HasFactory;
    protected $table = 'tb_jadwal_mekanik';
    protected $fillable = [
        'shift_id',
        'users_id',
    ];

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

    public function tagline()
    {
        return $this->hasMany('App\Models\Tagline', 'jadwal_mekanik_id');
    }
}

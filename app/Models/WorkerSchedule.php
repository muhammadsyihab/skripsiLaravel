<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSchedule extends Model
{
    use HasFactory;
    protected $table = "tb_jadwal";
    protected $fillable = [
        'shift_id',
        'master_unit_id',
        'users_id',
        'jam_kerja_masuk',
        'jam_kerja_keluar',
        'grup_id'
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTiket extends Model
{
    use HasFactory;
    protected $table = 'tb_history_tiketing';
    protected $fillable = [
        'users_id',
        'tb_tiketing_id',
        'keterangan',
        'photo',
    ];

    public function ticket() {
        return $this->belongsTo(Tiket::class, 'tb_tiketing_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}

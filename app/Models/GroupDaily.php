<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDaily extends Model
{
    use HasFactory;
    protected $table = 'grup_bulan_unit';
    protected $fillable = [
        'master_unit_id',
        'bulan_tahun',
        'total_wh',
        'total_stb',
        'total_bd',
        'pu',
        'ua',
        'ma',
    ];
}

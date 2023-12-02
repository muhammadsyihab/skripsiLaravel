<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileVersion extends Model
{
    use HasFactory;

    protected $table = 'mobile_version';
    protected $fillable = [
        'versi',
    ];
}

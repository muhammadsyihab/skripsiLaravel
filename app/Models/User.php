<?php

namespace App\Models;

use App\Models\JadwalMekanik;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'jabatan',
        'role',
        'no_telp',
        'jenis_kelamin',
        'photo',
        'password',
        'master_lokasi_id',
        'workerschedule',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function lokasi()
    {
        return $this->belongsTo(MasterLokasi::class, 'master_lokasi_id', 'id');
    }
    
    public function sparepartBarangKeluar()
    {
        return $this->hasMany(SparepartBarangKeluar::class, 'users_id', 'id');
    }

    public function tiketUserid()
    {
        return $this->hasMany(RiwayatTiket::class, 'users_id', 'id');
    }

    public function fuelUnit()
    {
        return $this->HasMany(FuelUnit::class, 'master_unit_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'users_id', 'id');
    }

    public function jadwalMekanik()
    {
        return $this->belongsTo(JadwalMekanik::class, 'users_id', 'id');
    }
}

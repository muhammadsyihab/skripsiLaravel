<?php

namespace App\Imports;

use App\Models\User;
use App\Models\MasterLokasi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenggunaExcel implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $lokasiId = MasterLokasi::where('nama_lokasi', $row['lokasi'])->first();

            if($row['jenis_kelamin'] == "L") {
                $row['jenis_kelamin'] = 0;
            } elseif ($row['jenis_kelamin'] == "P") {
                $row['jenis_kelamin'] = 1;
            }

            if($row['role'] == "planner") {
                $row['role'] = 1;
            } elseif ($row['role'] == "operator") {
                $row['role'] = 4;
            } elseif ($row['role'] == "mekanik") {
                $row['role'] = 3;
            } elseif ($row['role'] == "production") {
                $row['role'] = 5;
            } elseif ($row['role'] == "pic") {
                $row['role'] = 0;
            }


            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'jabatan' => $row['jabatan'],
                'role' => $row['role'],
                'no_telp' => $row['no_telp'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'password' => Hash::make($row['password']),
                // 'master_lokasi_id' => $lokasiId->id,
            ]);
        }
        
    }
}

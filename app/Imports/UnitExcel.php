<?php

namespace App\Imports;

use App\Models\Unit;
use App\Models\MasterLokasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitExcel implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $lokasiId = MasterLokasi::where('nama_lokasi', $row['lokasi'])->first();
            if ($row['status'] == 'READY') {
                $row['status'] = 0;
            } elseif ($row['status'] == 'COMPLETED PART') {
                $row['status'] = 1;
            } elseif ($row['status'] == 'BREAKDOWN') {
                $row['status'] = 2;
            }

            Unit::create([
                'jenis' => $row['unit'],
                'master_lokasi_id' => $lokasiId->id,
                'no_serial' => $row['no_serial'],
                'no_lambung' => $row['no_lambung'],
                'status_unit' => $row['status'],
                'status_kepemilikan' => $row['aset'],
                'keterangan' => $row['keterangan'],
                'total_hm' => $row['hm'],
            ]);
        }
        
    }

    //  public function headingRow(): int
    // {
    //     return 0;
    // }

    // public function model(array $row)
    // {
    //     return new Unit([
    //         'jenis' => $row[0],
    //         'master_lokasi_id' => $row[1],
    //         'no_serial' => $row[2],
    //         'no_lambung' => $row[3],
    //         'status_unit' => $row[4],
    //         'status_kepemilikan' => $row[5],
    //         'keterangan' => $row[6],
    //         'total_hm' => $row[7],
    //     ]);
    // }

   
}

<?php

namespace App\Console;

use App\Models\Unit;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\RiwayatTiket;
use Ladumor\OneSignal\OneSignal;
use Illuminate\Support\Facades\DB;
use App\Events\serviceNotifications;
use Illuminate\Support\Facades\Http;
use App\Models\SparepartBarangKeluar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
            

        //     $units = DB::table('master_unit')
        //         ->join('master_lokasi', 'master_unit.master_lokasi_id', '=', 'master_lokasi.id')
        //         ->join('master_service', 'master_service.master_unit_id', '=', 'master_unit.id')
        //         ->join('service_sparepart', 'master_service.id', '=', 'service_sparepart.service_id')
        //         ->join('master_sparepart', 'master_sparepart.id', '=', 'service_sparepart.sparepart_id')
        //         ->select(
        //             'master_unit.*',
        //             'master_lokasi.nama_lokasi',
        //             'master_service.hm as hm_triger',
        //             DB::raw("GROUP_CONCAT(master_sparepart.nama_item SEPARATOR ', ') AS nama_sparepart"),

        //         )
        //         ->orderBy('master_service.hm', 'ASC')
        //         ->limit(1)
        //         ->groupBy('master_service.id')
        //         ->get();

        //         foreach ($units as $unit) {

        //             if (($unit->hm_triger - $unit->total_hm) < 50 && ($unit->hm_triger - $unit->total_hm) > 0) {
        //                 $message = 'Masa service unit dengan no lambung ' . $unit->no_lambung .' masuk kompensasi awal 50 jam menuju service, dengan waktu '. $unit->hm_triger - $unit->total_hm .' jam menuju triger service. Sparepart yang dibutuhkan: '. $unit->nama_sparepart;
                        
        //                 // notifikasi web
        //                 event(new serviceNotifications($message));
                        
        //                 // notifikasi wa
        //                 $users = DB::table('users')->where('role', 1)->where('master_lokasi_id', $unit->master_lokasi_id)->get();
        //                 foreach ($users as $user) {
        //                     Http::post('https://whatsapp.neumediradev.my.id/api/act/send', [
        //                         // 'tujuan' => $user->no_telp,
        //                         'tujuan' => '6285849178190',
        //                         'body' => $message,
        //                         'name' => 'teza',
        //                         'key' => 'lakwmdl2kml12id09ALDIGANTENGn3n09nndl2ndLKNDKNd',
        //                     ]);
        //                 }
        //             }

        //             if (($unit->hm_triger - $unit->total_hm) < 0 && ($unit->hm_triger - $unit->total_hm) > -50) {
        //                 $message = 'Masa service unit dengan no lambung ' . $unit->no_lambung .' masuk kompensasi akhir 50 jam lewat service, dengan waktu '. $unit->total_hm - $unit->hm_triger .' jam melawati triger service. Sparepart yang dibutuhkan: '. $unit->nama_sparepart;
                        
        //                 // notifikasi web
        //                 event(new serviceNotifications($message));
                        
        //                 // notifikasi wa
        //                 $users = DB::table('users')->where('role', 1)->orWhere('role', 2)->orWhere('role', 3)->where('master_lokasi_id', $unit->master_lokasi_id)->get();
        //                 event(new serviceNotifications($users));
        //                 foreach ($users as $user) {
        //                     Http::post('https://whatsapp.neumediradev.my.id/api/act/send', [
        //                         // 'tujuan' => $user->no_telp,
        //                         'tujuan' => '6285849178190',
        //                         'body' => $message,
        //                         'name' => 'teza',
        //                         'key' => 'lakwmdl2kml12id09ALDIGANTENGn3n09nndl2ndLKNDKNd',
        //                     ]);
        //                 }

        //             } 

        //             if(($unit->hm_triger - $unit->total_hm) >= -50) {
        //                 $message = 'Masa service unit dengan no lambung ' . $unit->no_lambung .' melewati kompensasi akhir 50 jam lewat service, dengan waktu '. $unit->total_hm - $unit->hm_triger .' jam melawati triger service. Sparepart yang dibutuhkan: '. $unit->nama_sparepart;
                        
        //                 // notifikasi wa
        //                 $users = DB::table('users')->where('role', 1)->orWhere('role', 2)->orWhere('role', 3)->where('master_lokasi_id', $unit->master_lokasi_id)->get();
        //                 // event(new serviceNotifications($users));
        //                 foreach ($users as $user) {
        //                     Http::post('https://whatsapp.neumediradev.my.id/api/act/send', [
        //                         // 'tujuan' => $user->no_telp,
        //                         'tujuan' => '6285849178190',
        //                         'body' => $message,
        //                         'name' => 'teza',
        //                         'key' => 'lakwmdl2kml12id09ALDIGANTENGn3n09nndl2ndLKNDKNd',
        //                     ]);
        //                 }
        //             }
        //         }









        //     // $units = Unit::with('lokasi', 'services')->get();

        //     // $tiketTriger = 0;
        //     // foreach ($units as $unit) {
        //     //     $unit['hm_service_lewat'] = $unit->services->where('hm', '<=', $unit->total_hm)->where('status', '0');
        //     //     if (isset($unit['hm_service_lewat'])) {
        //     //         foreach ($unit['hm_service_lewat'] as $service) {
        //     //             $unit['sisa_hm_service_lewat'] = $service->min('hm') - $unit->total_hm;
        //     //             if ($unit['sisa_hm_service_lewat'] <= 0) {
        //     //                 $tiketTriger = 1;
        //     //             }
        //     //         }
        //     //     }
        //     // }

        //     // if ($tiketTriger == 1) {
        //     //     // membuat ticket
        //     //     $data = [
        //     //         'waktu_insiden' => now(),
        //     //         'status_ticket' =>  0,
        //     //         'photo' =>  null,
        //     //         'prioritas' =>  0,
        //     //         'judul' =>  'Service Unit',
        //     //         'nama_pembuat' =>  1,
        //     //         'users_id' => 1,
        //     //         'master_unit_id' =>  $unit->id,
        //     //     ];
        //     //     $tiket = Tiket::create($data);

        //     //     // mengubah status unit
        //     //     Unit::find($unit->id)->update([
        //     //         'status_unit' => 2
        //     //     ]);

        //     //     // tambah chat
        //     //     RiwayatTiket::create([
        //     //         'users_id' => 1,
        //     //         'tb_tiketing_id' => $tiket->id,
        //     //         'keterangan' => 'Pengaduan dibuat karena sudah melewati kompensasi service',
        //     //     ]);
        //     // }
            
            
        //     // $warn = 0;
        //     // $unitTrigger = null;
        //     // $warn2 = 0;
        //     // $unitTrigger2 = null;
        //     // foreach ($units as $unit) {
        //     //     $unit['hm_service'] = $unit->services->where('hm', '>=', $unit->total_hm)->where('status', '0');
        //     //     $unit['hm_service_lewat'] = $unit->services->where('hm', '<=', $unit->total_hm)->where('status', '0');

        //     //     if (isset($unit['hm_service'])) {
        //     //         // check ada yang sudah lewat dari triger kada
        //     //         foreach ($unit['hm_service'] as $service) {
        //     //             $unit['sisa_hm_service'] = $service->hm - $unit->total_hm;
        //     //             if ($unit['sisa_hm_service'] <= 100) {
        //     //                 $warn = 1;
        //     //                 $unitTrigger = $unit->no_lambung; 
        //     //             } 
        //     //         }
        //     //     }


                
        //     //     if (isset($unit['hm_service_lewat'])) {
        //     //         foreach ($unit['hm_service_lewat'] as $service) {
        //     //             $unit['sisa_hm_service_lewat'] = $service->min('hm') - $unit->total_hm;
        //     //             if ($unit['sisa_hm_service_lewat'] <= 0) {
        //     //                 $warn2 = 1;
        //     //                 $unitTrigger2 = $unit->no_lambung;
        //     //             }

        //     //             // mengubah status service
        //     //             $service->update([
        //     //                 'status' => 1
        //     //             ]);

        //     //             // sparepart stock
        //     //             $sparepart = Sparepart::find($service->master_sparepart_id);
        //     //             $qty_total = $sparepart->qty - $service->qty_sparepart;
        //     //             $sparepart->update([
        //     //                 'qty' => $qty_total,
        //     //             ]);
                        
        //     //             // sparepart barang keluar
        //     //             $sparepartKeluar = SparepartBarangKeluar::create([
        //     //                 'master_sparepart_id' => $service->master_sparepart_id, 
        //     //                 'master_unit_id' => $service->master_unit_id, 
        //     //                 'tb_tiketing_id' => $tiket->id, 
        //     //                 'master_lokasi_id' => $service->unit->lokasi->id, 
        //     //                 'users_id' => 1, 
        //     //                 'qty_keluar' => $service->qty_sparepart,
        //     //                 'status' => 0,
        //     //                 'penerima' => null, 
        //     //                 'hm_odo' => 0,
        //     //                 'tanggal_keluar' => now(),
        //     //                 'estimasi_pengiriman' => null,
        //     //                 'photo' => null,
        //     //             ]);

        //     //             // tambah chat di ticket
        //     //             $keterangan = 'Request sparepart '. $sparepartKeluar->sparepart->nama_item .' dengan jumlah '. $sparepartKeluar->qty_keluar .' '. $sparepartKeluar->sparepart->uom .' telah ditolak logistik';
        //     //             RiwayatTiket::create([
        //     //                 'users_id' => 1,
        //     //                 'tb_tiketing_id' => $tiket->id,
        //     //                 'keterangan' => $keterangan,
        //     //             ]);
        //     //         }
        //     //     }

        //     // }

        //     // create notif for warning service
        //     // if ($warn == 1) {
        //     //     $message = 'Segera Service '. $unitTrigger .' Karena Melewati Waktu Kompensasi';
        //     //     event(new serviceNotifications($message));
        //     //     // send wa pindah ke event
        //     //     $users = User::where('role', 1)->orWhere('role', 2)->get();
        //     //     foreach ($users as $user) {
        //     //         Http::post('https://whatsapp.neumediradev.my.id/api/act/send', [
        //     //             'tujuan' => $user->no_telp,
        //     //             'body' => $message,
        //     //             'name' => 'teza',
        //     //             'key' => 'lakwmdl2kml12id09ALDIGANTENGn3n09nndl2ndLKNDKNd',
        //     //         ]);
        //     //     }
        //     // }

        //     // create notif ticket telah dibuat karena melewati masa kompensasi
        //     // if ($warn2 == 1) {
        //     //     $message = $unitTrigger2 .' Sudah di Service Karena Melebihi '. $unit['sisa_hm_service_lewat'] .' Dari Waktu Kompensasi';
        //     //     event(new serviceNotifications($message));
        //     //     // send wa pindah ke event
        //     //     $users = User::where('role', 1)->orWhere('role', 2)->get();
        //     //     foreach ($users as $user) {
        //     //         Http::post('https://whatsapp.neumediradev.my.id/api/act/send', [
        //     //             'tujuan' => $user->no_telp,
        //     //             'body' => $message,
        //     //             'name' => 'teza',
        //     //             'key' => 'lakwmdl2kml12id09ALDIGANTENGn3n09nndl2ndLKNDKNd',
        //     //         ]);
        //     //     }
        //     // }
        // })
        // ->everyMinute();

        // sistem membatalkan po
        $schedule->call(function () {
            $po = DB::table('lg_brg_msk')->where('status', 1)->where('tanggal_masuk', '<=', now()->subWeeks(2)->format('Y-m-d'))->update(['status' => 2]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

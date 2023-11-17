<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatLiveWireController extends Controller
{
    public function index()
    {
        return view('pengaduan.index');
    }

    public function show($id)
    {
        $pengaduan = DB::table('tb_tiketing')
        ->select('tb_tiketing.*', 'master_unit.no_lambung', 'master_unit.total_hm', 'users.name')
        ->leftJoin('master_unit', 'tb_tiketing.master_unit_id', '=', 'master_unit.id')
        ->leftJoin('users', 'tb_tiketing.nama_pembuat', '=', 'users.id')
        ->where('tb_tiketing.id', $id)
        ->first();

        $spareparts = DB::table('master_sparepart')->get();

        return view('pengaduan.index', [
            'pengaduan' => $pengaduan,
            'spareparts' => $spareparts,
        ]);
    }
}
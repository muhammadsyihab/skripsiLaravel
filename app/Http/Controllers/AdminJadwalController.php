<?php

namespace App\Http\Controllers;

use App\Models\Grup;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    public function index() {
        $jadwal = Jadwal::all();
        $grup = Grup::all();
        return view('jadwal.index', compact('jadwal', 'grup'));
    }
    
}

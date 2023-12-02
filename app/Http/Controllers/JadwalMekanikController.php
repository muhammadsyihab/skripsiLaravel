<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Grup;
use App\Models\User;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\JadwalMekanik;
use App\Models\Tagline;
use App\Models\TaglineKeluar;
use App\Http\Resources\JadwalMekanikWebResource;
use App\Http\Resources\JadwalOperatorWebResource;
use Carbon\CarbonPeriod;
use DB;

class JadwalMekanikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasi = MasterLokasi::all();

        $mekanik = JadwalMekanik::select('tb_jadwal_mekanik.*', 'users.name', 'users.role', 'shift.waktu')
            ->join('users', 'tb_jadwal_mekanik.users_id', '=', 'users.id')
            ->join('shift', 'tb_jadwal_mekanik.shift_id', '=', 'shift.id')
                // ->where('users.role', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return view('jadwal_mekanik.index', [
            'mekanik' => JadwalMekanikWebResource::collection($mekanik),
            'lokasi' => $lokasi
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Tambah Jadwal";
        $usersall = User::where('role', 3)->get();
        $shift = Shift::all();

        return view('jadwal_mekanik.create', compact('shift', 'title', 'usersall'));
        
    }

    public function createGroup()
    {
        //
        $title = "Tambah Grup";
        $lokasi = MasterLokasi::all();
        return view('jadwal_mekanik.createGroup', compact('lokasi', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required',
            'shift_id' => 'required',
            'jam_kerja_masuk' => 'required',
            'jam_kerja_keluar' => 'required',
        ]);
        
        $jadwal = JadwalMekanik::create([
            'users_id' => $request->users_id,
            'shift_id' => $request->shift_id,
            'jam_kerja_masuk' => $request->jam_kerja_masuk,
            'jam_kerja_keluar' => $request->jam_kerja_keluar,
        ]);

        foreach ($request->jam_kerja_masuk as $key => $value) {
            $tagline = new Tagline;
            $tagline->jadwal_mekanik_id = $jadwal['id'];
            $tagline->jam_kerja_masuk = $value;
            $tagline->jam_kerja_keluar = $request->jam_kerja_keluar[$key];
            $tagline->save();
        }   
            return redirect()->route('jadwal-mekanik')->with('success', 'Data berhasil disimpan');
        }


    public function storeGroup(Request $request)
    {
        //
        $request->validate([
            'master_lokasi_id' => 'required',
            'nama_grup' => 'required|max:255',
        ]);

        Grup::create([
            'master_lokasi_id' => $request->master_lokasi_id,
            'nama_grup' => $request->nama_grup,
        ]);

        return redirect()->route('jadwal-mekanik')->with('pesan', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Show Jadwal";
        $users = User::where('id', $id)->first();
        $shift = Shift::all();
        $jadwal = JadwalMekanik::where('id', $id)->first();
        $tagline = Tagline::where('jadwal_mekanik_id', $jadwal->id)->get();
        
        return view('jadwal_mekanik.show', compact('users', 'shift', 'jadwal', 'title', 'tagline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Jadwal";
        $users = User::where('id', $id)->first();
        $shift = Shift::all();
        $jadwal = JadwalMekanik::where('id', $id)->first();
        $tagline = Tagline::where('jadwal_mekanik_id', $jadwal->id)->get();
        

        return view('jadwal_mekanik.edit', compact('users', 'shift', 'jadwal', 'title', 'tagline'));
    }

    public function editGroup($id)
    {
        //
        $title = "Edit Grup";
        $lokasi = MasterLokasi::all();
        $group = Grup::where('id', $id)->first();

        return view('jadwal_mekanik.editGroup', compact('group', 'lokasi', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'users_id' => 'required',
            'shift_id' => 'required',
            'jam_kerja_masuk' => 'required',
            'jam_kerja_keluar' => 'required',
        ]);

        JadwalMekanik::where('id', $id)->update([
            'users_id' => $request->users_id,
            'shift_id' => $request->shift_id,
        ]);

        foreach($request->jam_kerja_masuk as $key => $value){
            $tagline = Tagline::find($key);
            $tagline->jam_kerja_masuk = $value;
            $tagline->jam_kerja_keluar = $request->jam_kerja_keluar[$key];
            $tagline->save();
        }

        return redirect()->route('jadwal-mekanik')->with('success', 'Data berhasil diubah');
    }

    public function updateGroup(Request $request, $id)
    {
        //
        $request->validate([
            'master_lokasi_id' => 'required',
            'nama_grup' => 'required|max:255',
        ]);

        Grup::where('id', $id)->update([
            'master_lokasi_id' => $request->master_lokasi_id,
            'nama_grup' => $request->nama_grup,
        ]);

        return redirect()->route('jadwal')->with('pesan', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        // JadwalMekanik::where('id', $id)->delete();

        $jadwal = JadwalMekanik::find($id);

        $jadwal->tagline()->delete();

        $jadwal->delete();

        return redirect()->route('jadwal-mekanik')->with('success', 'Data berhasil dihapus');
    }

    public function destroyGroup($id)
    {
        //
        Grup::where('id', $id)->delete();

        return redirect()->route('jadwal')->with('pesan', 'Data berhasil dihapus');
    }

    public function replicate(Request $request)
    {
        // return $request->all();
        $cekData = JadwalMekanik::where('shift_id', $request->shift)->latest()->first();
        $latestTanggal = Carbon::parse($cekData->jam_kerja_masuk)->format('Y-m-d');

        $selected = JadwalMekanik::whereDate('jam_kerja_masuk', $latestTanggal)->where('shift_id', $request->shift)->get();
        foreach ($selected as $fields) {
            $simpan = $fields->replicate()->fill(
                [
                    'jam_kerja_masuk' => $request->jam_kerja_masuk,
                    'jam_kerja_keluar' => $request->jam_kerja_keluar,
                ]
            );
            $simpan->save();
        }
        return redirect()->route('jadwal')->with('success', 'Data berhasil dibuat');
    }

    public function filter()
    {
    }
    public function showPegawai()
    {
    }
    public function repilcatePegawai()
    {
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Grup;
use App\Models\Unit;
use App\Models\User;
use App\Models\Shift;
use App\Models\Jadwal;
use Carbon\CarbonPeriod;
use App\Models\MasterLokasi;
use App\Models\TaglineOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\JadwalMekanikWebResource;
use App\Http\Resources\JadwalOperatorWebResource;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasi = MasterLokasi::all();

        $operator = Jadwal::select('tb_jadwal.*', 'users.name', 'users.role', 'shift.waktu', 'master_unit.no_serial', 'master_unit.no_lambung', 'master_unit.jenis', 'master_unit.status_unit')
            ->join('users', 'tb_jadwal.users_id', '=', 'users.id')
            ->join('shift', 'tb_jadwal.shift_id', '=', 'shift.id')
            ->join('master_unit', 'tb_jadwal.master_unit_id', '=', 'master_unit.id') 
            ->orderBy('users.name', 'DESC')
            // ->where('users.role', 4)ww
            ->get();

        return view('jadwal.index', [
            'operator' => JadwalOperatorWebResource::collection($operator),
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
        $usersall = User::where('role', 4)->get();
        $unit = Unit::where('status_unit', "0")->get();
        $shift = Shift::all();

        return view('jadwal.create', compact('unit', 'shift', 'title', 'usersall'));
    }

    public function createGroup()
    {
        //
        $title = "Tambah Grup";
        $lokasi = MasterLokasi::all();
        return view('jadwal.createGroup', compact('lokasi', 'title'));
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
            'master_unit_id' => 'required',
            'shift_id' => 'required',
            'jam_kerja_masuk' => 'required',
            'jam_kerja_keluar' => 'required',
        ]);
        
        $jadwal = Jadwal::create([
            'users_id' => $request->users_id,
            'master_unit_id' => $request->master_unit_id,
            'shift_id' => $request->shift_id,
            'jam_kerja_masuk' => $request->jam_kerja_masuk,
            'jam_kerja_keluar' => $request->jam_kerja_keluar,
        ]);

        foreach ($request->jam_kerja_masuk as $key => $value) {
            $tagline = new TaglineOperator;
            $tagline->jadwal_operator_id = $jadwal['id'];
            $tagline->jam_kerja_masuk = $value;
            $tagline->jam_kerja_keluar = $request->jam_kerja_keluar[$key];
            $tagline->save();
        }   
            return redirect()->route('jadwal')->with('success', 'Data berhasil disimpan');
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

        return redirect()->route('jadwal')->with('pesan', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
        $title = "Edit Jadwal";
        $jadwal = Jadwal::where('id', $id)->first();
        $users = User::where('id', $jadwal->users_id)->first();
        $unit = Unit::where('status_unit', "0")->get();
        $shift = Shift::all();
        $tagline = TaglineOperator::where('jadwal_operator_id', $jadwal->id)->get();

        return view('jadwal.show', compact('users', 'unit', 'shift', 'jadwal', 'title', 'tagline'));
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
        $jadwal = Jadwal::where('id', $id)->first();
        $users = User::where('id', $jadwal->users_id)->first();
        $unit = Unit::where('status_unit', "0")->get();
        $shift = Shift::all();
        $tagline = TaglineOperator::where('jadwal_operator_id', $jadwal->id)->get();

        return view('jadwal.edit', compact('users', 'unit', 'shift', 'jadwal', 'title', 'tagline'));
    }

    public function editGroup($id)
    {
        //
        $title = "Edit Grup";
        $lokasi = MasterLokasi::all();
        $group = Grup::where('id', $id)->first();

        return view('jadwal.editGroup', compact('group', 'lokasi', 'title'));
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
            'master_unit_id' => 'required',
            'shift_id' => 'required',
            'jam_kerja_masuk' => 'required',
            'jam_kerja_keluar' => 'required',
        ]);

        Jadwal::where('id', $id)->update([
            'users_id' => $request->users_id,
            'shift_id' => $request->shift_id,
            'master_unit_id' => $request->master_unit_id,
        ]);

        foreach($request->jam_kerja_masuk as $key => $value){
            $tagline = TaglineOperator::find($key);
            $tagline->jam_kerja_masuk = $value;
            $tagline->jam_kerja_keluar = $request->jam_kerja_keluar[$key];
            $tagline->save();
        }

        return redirect()->route('jadwal')->with('success', 'Data berhasil diubah');
    }



    public function updateGroup(Request $request, $id)
    {
        //
        $request->validate([
            'master_lokasi_id' => 'required',
            // 'nama_grup' => 'required|max:255',
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
        //
        $jadwal = Jadwal::find($id);

        $jadwal->tagline_operator()->delete();

        $jadwal->delete();

        return redirect()->route('jadwal')->with('success', 'Data berhasil dihapus');
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
        $cekData = Jadwal::where('shift_id', $request->shift)->latest()->first();
        $latestTanggal = Carbon::parse($cekData->jam_kerja_masuk)->format('Y-m-d');

        $selected = Jadwal::whereDate('jam_kerja_masuk', $latestTanggal)->where('shift_id', $request->shift)->get();
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
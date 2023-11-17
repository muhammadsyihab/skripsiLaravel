<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UnitExcel;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Imports\PenggunaExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class RegisterController extends Controller
{
    
    public function index()
    {
        $title = "Pengguna";
        $locations = DB::table('master_lokasi')->get();
        $users = User::with('lokasi')->get();
        $locationFilter = null;
        if (auth()->user()->role == 0) {
            $locations = DB::table('master_lokasi')->get();
            $users = DB::table('users')
                ->leftJoin('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $users = DB::table('users')
                ->leftJoin('master_lokasi', 'users.master_lokasi_id', 'master_lokasi.id')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->where('role', 3)
                ->orWhere('role', 4)
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        }

        return view('user.index', compact('users', 'title', 'locationFilter', 'locations'));
    }

    public function create()
    {
        $title = "Tambah Pengguna";
        $lokasi = MasterLokasi::all();
        return view('user.create', compact('title', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'jabatan' => 'required',
            'role' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required',
            'master_lokasi_id' => 'required',
            'password' => 'required',
        ]);

        if ($request->password_confirmation != $request->password) {
            return redirect()->route('user.index')->with('danger', 'User gagal dibuat karena kesalahan penginputan password');
        }

        $phoneNumber = str_replace("08", "628", $request->no_telp);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'no_telp' => $phoneNumber,
            'jenis_kelamin' => $request->jenis_kelamin,
            'master_lokasi_id' => $request->master_lokasi_id,
            'password' => Hash::make($request->password),
        ];

        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/Register/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $data['photo'] = "$profileImage";
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat');
    }

    public function edit($id)
    {
        $title = "Edit Pengguna";
        $users = User::where('id', $id)->first();
        $lokasi = MasterLokasi::all();
        $password = $users->password;
        return view('user.edit', compact('users', 'title', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'jabatan' => 'required',
            'role' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required',
            'master_lokasi_id' => 'required',
        ]);

        if ($request->password_confirmation != $request->password) {
            return redirect()->route('user.index')->with('danger', 'User gagal diperbaharui karena kesalahan penginputan password');
        }

        $users = User::where('id', $id);
        $phoneNumber = str_replace("08", "628", $request->no_telp);

        if (!empty($request->password)) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'role' => $request->role,
                'no_telp' => $phoneNumber,
                'jenis_kelamin' => $request->jenis_kelamin,
                'photo' => $request->photo,
                'password' => Hash::make($request->password)
            ];
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'role' => $request->role,
                'no_telp' => $phoneNumber,
                'jenis_kelamin' => $request->jenis_kelamin,
                'photo' => $request->photo,
            ];
        }

        if ($photo = $request->file('photo')) {
            $destinationPath = 'storage/Register/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $data['photo'] = "$profileImage";
        } else {
            unset($data['photo']);
        }
        $users->update($data);

        return redirect()->route('user.index')->with('success', 'Berhasil di update');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('user.index')->with('danger', 'User berhasil dihapus');
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'master_lokasi_id' => 'required',
        ]);

        $title = "Pengguna";
        $users = User::with('lokasi')->get();

        $locations = null;
        $locationFilter = null;

        if (auth()->user()->role == 0) {
            $locations = DB::table('master_lokasi')->get();
            $users = DB::table('users')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->where('master_lokasi_id', $request->master_lokasi_id)
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $users = DB::table('users')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->where('role', 3)
                ->orWhere('role', 4)
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        }

        $pdf = PDF::loadView('pdf.user', [
            'users' => $users,
            'title' => $title,
            'locationFilter' => $locationFilter,
            'locations' => $locations,
        ]);

        return $pdf->stream('User.pdf');
    }

    public function excel(Request $request)
    {
        $request->validate([
            'master_lokasi_id' => 'required',
        ]);

        $title = "Pengguna";
        $users = User::with('lokasi')->get();

        $locations = null;
        $locationFilter = null;

        if (auth()->user()->role == 0) {
            $locations = DB::table('master_lokasi')->get();
            $users = DB::table('users')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->where('master_lokasi_id', $request->master_lokasi_id)
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        } else {
            $locationFilter = DB::table('master_lokasi')->where('id', auth()->user()->master_lokasi_id)->select('nama_lokasi', 'id')->first();
            $users = DB::table('users')
                ->join('master_lokasi', 'users.master_lokasi_id', '=', 'master_lokasi.id')
                ->where('master_lokasi_id', auth()->user()->master_lokasi_id)
                ->where('role', 3)
                ->orWhere('role', 4)
                ->select('users.*', 'master_lokasi.nama_lokasi')
                ->get();
        }

        return view('excel.user', [
            'users' => $users,
            'title' => $title,
            'locationFilter' => $locationFilter,
            'locations' => $locations,
        ]);

    }

    public function import(Request $request)
    {
        // validasi
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new PenggunaExcel, $request->file('file'));

        return redirect()->route('user.index')->with('success', 'Berhasil di import');
    }
}

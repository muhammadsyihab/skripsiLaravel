<?php

namespace App\Http\Controllers;

use App\Models\Grup;

use App\Models\Unit;
use App\Models\User;
use App\Models\Shift;
use App\Models\MasterLokasi;
use Illuminate\Http\Request;
use App\Models\WorkerSchedule;
use Illuminate\Support\Collection;

class WorkerScheduleController extends Controller
{
	public function index()
	{
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule', 'users.photo')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$listgrup = Grup::with('lokasi')->get();
		$name = '-';
		$jadwalmasuk = '-';
		$jadwalkeluar = '-';
		$grup = '-';
		$namegrup = '-';
		$photo = '-';
		$html = view('worker_schedule.index', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'namegrup', 'listgrup', 'photo'))->render();
		return $html;
	}

	public function detail($id)
	{
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$detail = User::where('id', $id)->first();
		$listgrup = Grup::all();
		if ($detail->workerschedule == 1) {
			$detail2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule', 'tb_grup.nama_grup', 'users.photo')
				->where('tb_jadwal.users_id', $id)
				->join("users", "tb_jadwal.users_id", "=", "users.id")
				->join("tb_grup", "tb_jadwal.grup_id", "=", "tb_grup.id")
				->first();
		}
		$name = $detail->name;
		if ($detail->workerschedule == 1) {
			$jadwalmasuk = $detail2->jam_kerja_masuk;
			$jadwalkeluar = $detail2->jam_kerja_keluar;
			$grup = $detail2->nama_grup;
		} else {
			$jadwalmasuk = '-';
			$jadwalkeluar = '-';
			$grup = '-';
		}
		$namegrup = '-';
		$photo = $detail->photo;
		$html = view('worker_schedule.index', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'detail', 'namegrup', 'listgrup', 'photo'))->render();
		return $html;
	}

	public function detailgrup($id)
	{
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$detail = User::where('id', $id)->first();
		$listgrup = Grup::all();
		if ($detail->workerschedule == 1) {
			$detail2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule', 'tb_grup.nama_grup', 'users.photo')
				->where('tb_jadwal.users_id', $id)
				->join("users", "tb_jadwal.users_id", "=", "users.id")
				->join("tb_grup", "tb_jadwal.grup_id", "=", "tb_grup.id")
				->first();
		}
		$name = '-';
		if ($detail->workerschedule == 1) {
			$jadwalmasuk = $detail2->jam_kerja_masuk;
			$jadwalkeluar = $detail2->jam_kerja_keluar;
			$grup = $detail2->nama_grup;
		} else {
			$jadwalmasuk = '-';
			$jadwalkeluar = '-';
			$grup = '-';
		}
		$namegrup = 'a';
		$grupidhapus = $id;
		$grupeditid = $id;
		$photo = $detail->photo;
		$html = view('worker_schedule.index', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'detail', 'namegrup', 'listgrup', 'grupidhapus', 'grupeditid', 'photo'))->render();
		return $html;
	}

	public function create($id)
	{
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$grups = Grup::all();
		$shifts = Shift::all();
		$units = Unit::all();
		$detail = User::where('id', $id)->first();
		if ($detail->workerschedule == 1) {
			$detail2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule', 'users.photo')
				->where('tb_jadwal.users_id', $id)
				->join("users", "tb_jadwal.users_id", "=", "users.id")
				->first();
			$grupid = Grup::where('id', $detail2->grup_id)->first();
		}
		$name = $detail->name;
		if ($detail->workerschedule == 1) {
			$jadwalmasuk = $detail2->jam_kerja_masuk;
			$jadwalkeluar = $detail2->jam_kerja_keluar;
			$grup = $detail->name;
		} else {
			$jadwalmasuk = '-';
			$jadwalkeluar = '-';
			$grup = '-';
		}
		$photo = $detail->photo;
		$html = view('worker_schedule.create', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'detail', 'grups', 'photo', 'shifts', 'units'))->render();
		return $html;
	}

	public function creategrup()
	{
		$lokasi = MasterLokasi::all();
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$grups = Grup::all();
		$name = '-';
		$jadwalmasuk = '-';
		$jadwalkeluar = '-';
		$grup = '-';
		$photo = '-';
		$html = view('worker_schedule.creategrup', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'grups', 'photo', 'lokasi'))->render();
		return $html;
	}

	public function store(Request $request, $id)
	{
		$validatedData = $request->validate([
			'shift_id' => 'required|max:255',
			'master_unit_id' => 'required|max:255',
			'jam_kerja_masuk' => 'required|max:255',
			'jam_kerja_keluar' => 'required|max:255',
			'grup' => 'required|max:255',
		]);
		WorkerSchedule::create([
			'shift_id' => $request->shift_id,
			'master_unit_id' => $request->master_unit_id,
			'users_id' => $id,
			'jam_kerja_masuk' => $request->jam_kerja_masuk,
			'jam_kerja_keluar' => $request->jam_kerja_keluar,
			'grup_id' => $request->grup,
		]);

		User::where('id', $id)
			->update([
				'workerschedule' => '1',
			]);

		return redirect()->route('detailjadwalpekerja', $id)->with('success', 'Jadwal Berhasil Ditambahkan');
	}

	public function storegrup(Request $request)
	{
		$validatedData = $request->validate([
			'nama_grup' => 'required|max:255',
			'master_lokasi_id' => 'required',
		]);
		Grup::create([
			'nama_grup' => $request->nama_grup,
			'master_lokasi_id' => $request->master_lokasi_id,
		]);

		return redirect()->route('jadwalpekerja')->with('success', 'Grup Berhasil Ditambahkan');
	}

	public function edit($id)
	{
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$grups = Grup::all();
		$detail = User::where('id', $id)->first();
		if ($detail->workerschedule == 1) {
			$detail2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule', 'tb_grup.nama_grup')
				->where('tb_jadwal.users_id', $id)
				->join("users", "tb_jadwal.users_id", "=", "users.id")
				->join("tb_grup", "tb_jadwal.grup_id", "=", "tb_grup.id")
				->first();
			$grupid = Grup::where('id', $detail2->grup_id)->first();
		}
		$name = $detail->name;
		if ($detail->workerschedule == 1) {
			$jadwalmasuk = $detail2->jam_kerja_masuk;
			$jadwalkeluar = $detail2->jam_kerja_keluar;
		} else {
			$jadwalmasuk = '-';
			$jadwalkeluar = '-';
		}
		$photo = $detail->photo;
		$html = view('worker_schedule.edit', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grups', 'jadwalkeluar', 'detail', 'grupid', 'photo'))->render();
		return $html;
	}

	public function editgrup($id)
	{
		$lokasi = MasterLokasi::all();
		$users1 = User::where('workerschedule', '0')
			->where('role', '5')
			->get();
		$users2 = WorkerSchedule::select('tb_jadwal.*', 'users.name', 'users.workerschedule')
			->where('users.workerschedule', '1')
			->join("users", "tb_jadwal.users_id", "=", "users.id")
			->get();
		$grups = Grup::where('id', $id)->first();
		$name = '-';
		$jadwalmasuk = '-';
		$jadwalkeluar = '-';
		$grup = '-';
		$grupeditid = $id;
		$photo = '-';
		$html = view('worker_schedule.editgrup', compact('users1', 'users2', 'name', 'jadwalmasuk', 'grup', 'jadwalkeluar', 'grups', 'grupeditid', 'photo', 'lokasi'))->render();
		return $html;
	}

	public function update(Request $request, $id)
	{
		$validatedData = $request->validate([
			'jam_kerja_masuk' => 'required|max:255',
			'jam_kerja_keluar' => 'required|max:255',
			'grup' => 'required|max:255',
		]);
		WorkerSchedule::where('users_id', $id)
			->update([
				'jam_kerja_masuk' => $request->jam_kerja_masuk,
				'jam_kerja_keluar' => $request->jam_kerja_keluar,
				'grup_id' => $request->grup,
			]);

		return redirect()->route('detailjadwalpekerja', $id)->with('success', 'Jadwal Berhasil Diedit');
	}

	public function updategrup(Request $request, $id)
	{
		$validatedData = $request->validate([
			'nama_grup' => 'required|max:255',
			'master_lokasi_id' => 'required',
		]);
		Grup::where('id', $id)
			->update([
				'nama_grup' => $request->nama_grup,
				'master_lokasi_id' => $request->master_lokasi_id,
			]);

		return redirect()->route('jadwalpekerja')->with('success', 'Grup Berhasil Diedit');
	}

	public function destroy($id)
	{
		User::where('id', $id)
			->update([
				'workerschedule' => '0',
			]);
		WorkerSchedule::where('users_id', $id)->delete();
		return redirect()->route('jadwalpekerja')->with('success', 'Jadwal Berhasil Dihapus');
	}

	public function destroygrup($id)
	{
		Grup::where('id', $id)->delete();
		return redirect()->route('jadwalpekerja')->with('success', 'Grup Berhasil Dihapus');
	}

	public function destroyall()
	{
		User::where('workerschedule', '1')
			->update([
				'workerschedule' => '0',
			]);
		WorkerSchedule::truncate();
		return redirect()->route('jadwalpekerja')->with('success', 'Semua Jadwal Berhasil Dihapus');
	}
}



<div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#tambahRiwayat">
        Tambah Riwayat
    </button>
    <div wire:ignore.self class="modal fade" id="tambahRiwayat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Riwayat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    @if (session()->has('success'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" placeholder="Keterangan ..." name="keterangan" id="keterangan" wire:model.defer="keterangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="storeRiwayat()">Buat</button>
                    {{-- <button type="submit" class="btn btn-primary" id="btnPostChat">Save changes</button> --}}
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="table-responsive table-responsive-xxl text-nowrap">
        <table class="table table-bordered table-striped" id="datatablesSimpleRiwayat">
            <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Code Unit</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Penanggung Jawab</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td>{{ $history->created_at }}</td>
                        <td>{{ $history->no_lambung }}</td>
                        <td>{{ $history->ket_sp }}</td>
                        @if ($history->status_sp == 0)
                            <td><span class="badge bg-secondary">Ready</span></td>
                        @elseif ($history->status_sp == 2)
                            <td><span class="badge bg-danger">Breakdown</span></td>
                        @endif
                        <td>{{ $history->pj_alat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('script-tambahan')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $('#datatablesSimpleRiwayat').DataTable();
    </script>
@endpush

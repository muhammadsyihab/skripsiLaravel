<div>
    <div class="modal fade" id="persetujuanHO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table-responsive-xxl text-nowrap">
                    <table class="table table-bordered table-striped" id="datatablesSimpleHo">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Area</th>
                                <th class="text-center">Kode Unit</th>
                                <th class="text-center">Nomor Part</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Penerima</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">Harga Satuan (RP)</th>
                                <th class="text-center">Total (RP)</th>
                                <th class="text-center">Remarks / Request By</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($spareparts as $sparepart)
                                @if ($sparepart->qty_keluar * $sparepart->sparepart->item_price >= 2000000)
                                    <tr>
                                        <td>{{ now()->parse($sparepart->tanggal_keluar)->format('j F Y') }}</td>
                                        <td>{{ $sparepart->lokasi->nama_lokasi }}</td>
                                        <td>{{ $sparepart->unit->no_lambung }}</td>
                                        <td>{{ $sparepart->sparepart->part_number }}</td>
                                        <td>{{ $sparepart->sparepart->nama_item }}</td>
                                        <td>{{ $sparepart->penerima }}</td>
                                        <td>{{ $sparepart->qty_keluar }}</td>
                                        <td> {{ $sparepart->sparepart->uom }}</td>
                                        <td>@currency($sparepart->sparepart->item_price)</td>
                                        <td>@currency($sparepart->sparepart->item_price * $sparepart->qty_keluar)</td>
                                        <td>{{ $sparepart->users->name }}</td>
                                        @if ($sparepart->status == 0)
                                            <td><span class="badge bg-warning">Diminta</span></td>
                                        @elseif($sparepart->status == 1)
                                            <td><span class="badge bg-success">Disetujui</span></td>
                                        @elseif($sparepart->status == 2 || $sparepart->status == 4)
                                            <td><span class="badge bg-danger">Ditolak<span></td>
                                        @endif
                                        @if (empty($sparepart->sparepart->photo))
                                            <td class="text-center"><img
                                                    src="{{ asset('storage/camera_default.png') }}" height="60"
                                                    width="60" alt=""></td>
                                        @else
                                            <td><img src="{{ asset('storage/spKeluar/' . $sparepart->sparepart->photo) }}"
                                                    height="50"width="50" alt=""></td>
                                        @endif
                                        <td class="align-middle">
                                            @if ($sparepart->status == 0)
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setujuPermintaanHo" wire:click="sendToModal({{ $sparepart->id }})">
                                                        Disetujui
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakPermintaan">
                                                        Ditolak
                                                    </button>
                                                </div>
                                            @else
                                                <span class="badge bg-success">Telah disetujui oleh logistik<span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Form Persetujuan logistik -->
@livewire('modal-persetujuan-ho', ['pengaduanId' => $pengaduanId])
<!-- End Modal Form Persetujuan logistik -->

@push('script-tambahan')
    <script>
        $('#datatablesSimpleHo').DataTable();
    </script>
@endpush

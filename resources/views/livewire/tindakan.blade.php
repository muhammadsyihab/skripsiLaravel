<div>
    

    {{-- permintaan sparepart --}}
    @planner
    <div wire:ignore.self class="modal fade" id="permintaanSparepart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Permintaan Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form>
                    <div class="modal-body">
                        @if (session()->has('success'))
                            <div class="alert alert-primary" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <div class="mb-5" id="selectSpareparts">
                            <label for="inputSparepart" class="form-label">Jenis Sparepart</label>
                            <select class="form-select pencarian" name="inputSparepart" id="inputSparepart" wire:model.defer="inputSparepart">
                                <option value="" selected disabled>-- Pilih Sparepart --</option>
                                @foreach ($spareparts as $sparepart)
                                    <option value="{{ $sparepart->id }}">{{ $sparepart->nama_item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Jumlah Sparepart</label>
                            <input type="number" class="form-control" placeholder="Jumlah Sparepart ..." name="jumlah" id="jumlah" wire:model.defer="jumlah">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="storePermintaan()" id="btnPermintaan">Buat Permintaan</button>
                        {{-- <button type="submit" class="btn btn-primary" id="btnPostChat">Save changes</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endplanner
    {{-- end permintaan sparepart --}}

    {{-- pembelian pribadi --}}
    <div wire:ignore.self class="modal fade" id="pribadiLogistik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembelian Pribadi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if (session()->has('success'))
                            <div class="alert alert-primary" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <div class="mb-5" id="userPenerima">
                            <label for="penerimaPribadi" class="form-label">Penerima</label>
                            <select class="form-select pencarian" name="penerimaPribadi" id="penerimaPribadi" wire:model.defer="penerimaPribadi">
                                <option value="" selected disabled>-- Pilih Penerima --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5" id="userPembeli">
                            <label for="pembeli" class="form-label">Pembeli</label>
                            <select class="form-select pencarian" name="pembeli" id="pembeli" wire:model.defer="pembeli">
                                <option value="" selected disabled>-- Pilih Pembeli --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Jumlah Sparepart</label>
                            <input type="number" class="form-control" placeholder="Jumlah Sparepart ..." name="qty" id="qty" wire:model.defer="qty">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Part Number</label>
                            <input type="text" class="form-control" placeholder="Part Number ..." name="partNumberPribadi" id="partNumberPribadi" wire:model.defer="partNumberPribadi">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Nama Item</label>
                            <input type="text" class="form-control" placeholder="Nama Item ..." name="namaItem" id="namaItem" wire:model.defer="namaItem">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">UOM</label>
                            <input type="text" class="form-control" placeholder="UOM ..." name="uom" id="uom" wire:model.defer="uom">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Item Price</label>
                            <input type="number" class="form-control" placeholder="Item Price ..." name="itemPrice" id="itemPrice" wire:model.defer="itemPrice">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Tanggal Keluar</label>
                            <input type="date" class="form-control" placeholder="Tanggal Keluar ..." name="tanggalKeluar" id="tanggalKeluar" wire:model.defer="tanggalKeluar">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Estimasi Pengiriman</label>
                            <input type="number" class="form-control" placeholder="Estimasi Pengiriman ..." name="estimasi" id="estimasi" wire:model.defer="estimasi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="storePribadi()" id="btnPribadi">Buat Pembelian Pribadi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end pembelian pribadi --}}

    {{-- acc logistik --}}
    {{-- <div class="modal fade" id="persetujuanLogistik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Persetujuan Permintaan dari planner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-responsive-xxl text-nowrap">
                        <table class="table table-bordered table-striped" id="datatablesSimple">
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
                            @foreach ($sparepartsKeluar as $sparepart)
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
                                                    
                                                    <button type="button" class="btn btn-primary" id="btnSetuju" data-bs-toggle="modal" data-bs-target="#setujuPermintaan{{ $sparepart->id }}">
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

                                    
                                    <div class="modal fade modalPersetujuan" id="setujuPermintaan{{ $sparepart->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Persetujuan</h5>
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
                                                            <label for="exampleFormControlTextarea1" class="form-label">Estimasi Pengiriman</label>
                                                            <input type="number" class="form-control" placeholder="Estimasi Pengiriman ..." name="estimasiPengiriman" id="estimasiPengiriman" wire:model.defer="estimasiPengiriman">
                                                        </div>
                                                        <div class="mb-5" id="selectUsersAcc">
                                                            <label for="penerimaAcc" class="form-label">Penerima</label>
                                                            <select class="form-select pencarian" name="penerimaAcc" id="penerimaAcc" wire:model.defer="penerimaAcc">
                                                                <option value="" selected disabled>-- Pilih Penerima --</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" wire:click.prevent="storeDisetujui()" id="btnSetuju">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
    </div> --}}
    {{-- end acc logistik --}}

    {{-- acc HO --}}
    {{-- <div class="modal fade" id="persetujuanHO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Persetujuan Permintaan dari planner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-responsive-xxl text-nowrap">
                        <table class="table table-bordered table-striped" id="datatablesSimple">
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
                            @foreach ($sparepartsKeluar as $sparepart)
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
                                                    
                                                    <button type="button" class="btn btn-primary" id="btnSetuju" data-bs-toggle="modal" data-bs-target="#setujuPermintaanHO{{ $sparepart->id }}">
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

                                    
                                    <div class="modal fade modalPersetujuan" id="setujuPermintaanHO{{ $sparepart->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Persetujuan</h5>
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
                                                            <label for="exampleFormControlTextarea1" class="form-label">Estimasi Pengiriman</label>
                                                            <input type="number" class="form-control" placeholder="Estimasi Pengiriman ..." name="estimasiPengiriman" id="estimasiPengiriman" wire:model.defer="estimasiPengiriman">
                                                        </div>
                                                        <div class="mb-5" id="selectUsersAcc">
                                                            <label for="penerimaAcc" class="form-label">Penerima</label>
                                                            <select class="form-select pencarian" name="penerimaAcc" id="penerimaAcc" wire:model.defer="penerimaAcc">
                                                                <option value="" selected disabled>-- Pilih Penerima --</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" wire:click.prevent="storeDisetujui()" id="btnSetuju">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
    </div> --}}
    {{-- end acc HO --}}

    @planner
    {{-- tutup ticket --}}
    <div wire:ignore.self class="modal fade" id="tutupTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Apakah Anda Yakin?
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('success'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('danger') }}
                        </div>
                    @endif
                    Pengaduan akan ditutup.
                    Pastikan pengaduan telah selesai dengan benar!
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit" wire:click.prevent="tutupTicket()">Ya, Tutup Pengaduan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end tutup ticket --}}
    @endplanner

    
</div>

@push('script-tambahan')
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
           $(document).ready(function() {
                
                $('#penerimaPribadi').select2({
                    dropdownParent: $('#userPenerima')
                });
                $('#pembeli').select2({
                    dropdownParent: $('#userPembeli')
                });
                $('#penerimaAcc').select2({
                    dropdownParent: $('#selectUsersAcc')
                });
            });

            $('#btnPribadi').on('click', function (e) {
                var user = $('#penerimaPribadi').select2("val");
                var user1 = $('#pembeli').select2("val");
                @this.set('penerimaPribadi', user);
                @this.set('pembeli', user1);
            });

            $('#setujuPermintaan').on('show.bs.modal', function (event) {
                var button = $('#btnSetuju').data('sparepart');
                console.log(button);
                var modal = $(this);
                modal.find('#sparepartDisetujui').val(button);
            })
    </script>
@endpush
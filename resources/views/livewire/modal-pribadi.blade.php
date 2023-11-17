<div>
    <div class="modal fade" id="pribadiLogistik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembelian Pribadi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-5" id="selectSparepartsPribadi">
                            <label for="inputSparepartsPribadi" class="form-label">Jenis Sparepart</label>
                            <select class="form-select" name="inputSparepartsPribadi" id="inputSparepartsPribadi" wire:model.defer="inputSparepartsPribadi">
                                <option value="" selected disabled>-- Pilih Sparepart --</option>
                                @foreach ($spareparts as $sparepart)
                                    <option value="{{ $sparepart->id }}">{{ $sparepart->nama_item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5" id="selectUsers">
                            <label for="penerimaPribadi" class="form-label">Penerima</label>
                            <select class="form-select" name="penerimaPribadi" id="penerimaPribadi" wire:model.defer="penerimaPribadi">
                                <option value="" selected disabled>-- Pilih Penerima --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5" id="selectUsers">
                            <label for="pembeli" class="form-label">Pembeli</label>
                            <select class="form-select" name="pembeli" id="pembeli" wire:model.defer="pembeli">
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="store()" id="btnPostChat">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-tambahan')
<script>
    $(document).ready(function() {
        $('#inputSparepartsPribadi').select2({
            dropdownParent: $('#pribadiLogistik')
        });
        $('#penerimaPribadi').select2({
            dropdownParent: $('#pribadiLogistik')
        });
        $('#pembeli').select2({
            dropdownParent: $('#pribadiLogistik')
        });
    });

    $('#btnPostChat').on('click', function (e) {
        var data = $('#inputSpareparts').select2("val");
        var user = $('#penerimaPribadi').select2("val");
        var user1 = $('#pembeli').select2("val");
        @this.set('inputSpareparts', data);
        @this.set('penerima', user);
        @this.set('pembeli', user1);
    });
</script>
@endpush
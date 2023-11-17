<div>
<style>
.select2-container {
  width: 100% !important;
  max-width: 100% !important;
}

.select2-selection {
  border: 1px solid #ccc !important;
  border-radius: 4px !important;
}

.select2-selection__rendered {
  font-size: 16px !important;
}

</style>
    <div class="modal fade modalPersetujuan" id="setujuPermintaanHo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Persetujuan HO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Estimasi Pengiriman 1</label>
                            <input type="number" class="form-control" placeholder="Estimasi Pengiriman ..." name="estimasiPengiriman" id="estimasiPengiriman" wire:model.defer="estimasiPengiriman">
                        </div>
                        <div class="mb-5" id="selectUsers">
                            <label for="penerima" class="form-label">Penerima</label>
                            <select class="form-select pencarian" name="penerima" id="penerima" wire:model.defer="penerima">
                                <option value="" selected disabled>-- Pilih Penerima --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="store()" id="btnSetuju">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@push('script-tambahan')
    <script>
        $(document).ready(function() {
            $('#penerima').select2({
               dropdownParent: $('#selectUsers')
           });
        });

        $('#btnSetuju').on('click', function (e) {
            var user = $('#penerima').select2("val");
            @this.set('penerima', user);
        });
    </script>
@endpush
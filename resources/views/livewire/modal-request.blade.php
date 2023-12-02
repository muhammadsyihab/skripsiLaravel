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
    <div class="modal fade" id="permintaanSparepart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Permintaan Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form>
                    <div class="modal-body">
                        <div class="mb-5" id="selectSpareparts">
                            <label for="inputSpareparts" class="form-label">Jenis Sparepart</label>
                            <select class="form-select pencarian" name="inputSpareparts" id="inputSpareparts" wire:click="inputSpareparts">
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="store()" id="btnPostChat">Save changes</button>
                        {{-- <button type="submit" class="btn btn-primary" id="btnPostChat">Save changes</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
<div>
    
    <form class="m-0" enctype="multipart/form-data">
        <div class="input-group">
            <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
            <input type="hidden" id="tb_tiketing_id" value="{{ $pengaduanId }}">
            <div class="input-group-text bg-transparent border-0">
                <input type="file" class="form-control" placeholder="File ..." ref="inputFile" name="file" id="file" wire:model="file">
            </div>
            <input type="text" class="form-control border-0" placeholder="Keterangan ..." name="keterangan" id="keterangan" wire:model.defer="keterangan" required>
            <div class="input-group-text bg-transparent border-0">
                <button class="btn btn-light text-primary postChat" id="btnPostChatPengaduan" type="submit" data-id="{{ $pengaduanId }}" wire:click.prevent="store()">
                    <i class="fas fa-share"></i>
                </button>
            </div>
        </div>
    </form>
    
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"></script>
    <script>
        var pengaduanId = {{ $pengaduanId }};
        var userId = {{ auth()->user()->id }};
        var userRole = {{ auth()->user()->role }};
    </script>
    <script src="{{ asset('js/tessocket.js') }}"></script>
</div>
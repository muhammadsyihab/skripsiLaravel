<div id="heightFull">
    @foreach ($chats as $chat)
        <div class="card mb-4" id="chat">
            <div class="card-header bg-white d-flex text-dark justify-content-between d-flex align-items-center">
                <div>
                    {{ $chat->name }}
                    @if ($chat->role == 0)
                        <span class="badge bg-warning">PIC</span>
                    @elseif($chat->role == 1)
                        <span class="badge bg-primary">Planner</span>
                    @elseif($chat->role == 2)
                        <span class="badge bg-success">Warehouse</span>
                    @elseif($chat->role == 3)
                        <span class="badge bg-danger">Mechanic</span>
                    @elseif($chat->role == 4)
                        <span class="badge bg-secondary">Operator</span>
                    @endif
                </div>
                <div>
                    <i class="text-sm text-muted align-end">{{ now()->format('j F Y') }}</i>
                </div>
            </div>
            <div class="card-body p-2">
                @if ($chat->photo == null)
                    <p class="text-lg-start">{!! $chat->keterangan !!}</p>
                @else
                    <div class="row">
                        <div class="col">
                            <p class="text-lg-start">{!! $chat->keterangan !!}</p>
                        </div>
                        <div class="col">
                            @if (str_contains($chat->photo, '.pdf'))
                                <div class="col-md-3 px-0">
                                    <embed src="{{ asset('storage/chat/' . $chat->photo) }}" width="350px"
                                        height="400px" />
                                </div>
                            @else
                                <div class="col-md-3 px-0">
                                    <img src="{{ asset('storage/chat/' . $chat->photo) }}" class="img-fluid">
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"></script>
    <script>
        var pengaduanId = {{ $pengaduanId }};
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const socket = io('192.168.1.17:3030', {
                transports: ['websocket']
            });

            socket.on("connect", () => {
                const namaRoom = 'Ticket - ' + pengaduanId;
                socket.emit('masukRoom', namaRoom);
            });

            socket.on("BerhasilJoin", (data) => {
                console.log('Berhasil Join Ke ' + data)
            });

            socket.on('chatReceived', (data) => {
                console.log(data);
                Livewire.emit('chatAdded'); //refresh
            });

            socket.on('getNotif', (data) => {
                console.log(data);
            });
        });
    </script>

</div>

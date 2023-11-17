const socket = io('192.168.1.17:3030', { transports: ['websocket'] });

socket.on("connect", () => {
    const namaRoom = 'Ticket - ' + pengaduanId;
    console.log(namaRoom);
    // socket.emit('masukRoom', namaRoom);
});

document.getElementById("btnPostChatPengaduan").onclick = () => {
    const namaRoom = 'Ticket - ' + pengaduanId;
    socket.emit('postChat', {
        data: 'success',
        namaRoom: namaRoom,
    });

    socket.emit('pushNotif', {
        data: 'pushNotif',
        userId: userId,
        userRole: 3,
        chat: true,
    });
};

socket.on('chatReceived', (data) => {
    console.log(data);

    Livewire.emit('chatAdded'); //refresh
});

window.addEventListener('livewire:load', function () {
    // Setelah komponen Livewire dimuat
    var element = document.getElementById('heightFull');
    element.scrollTop = element.scrollHeight - element.clientHeight;
});
//const express = require("express")();
//const httpServer = require('http').createServer(express);
//const io = require("socket.io")(httpServer, {
//  cors: {
//    origin: '*',
//    methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
//    allowedHeaders: ['Origin', 'Content-Type', 'X-Auth-Token', 'Authorization']
//  }
//});
//const PORT = 3030;
//httpServer.listen(PORT, '103.179.86.78', () => {
//  console.log('Server listening on http://localhost:3030');
//});
// App setup

//const app = express();
//const server = app.listen(PORT, function () {
//  console.log(`Listening on port ${PORT}`);
//  console.log(`http://localhost:${PORT}`);
//});

// Static files
//httpServer.use(express.static("public"));

// Socket setup
//const io = socket(server);

//const activeUsers = new Set();

//io.on("connection", function (socket) {
//  console.log("Connection");

//  socket.on("postChat", function (data) {
//    console.log(data);
//    io.emit('chatReceived', data);

//  });

// io.set('origins', 'http://192.168.1.17:3030');
// socket.on("disconnect", () => {
//   activeUsers.delete(socket.userId);
//   io.emit("user disconnected", socket.userId);
// });

//   socket.on("chat message", function (data) {
//     io.emit("chat message", data);
//   });

//   socket.on("typing", function (data) {
//     socket.broadcast.emit("typing", data);
//   });

//});

//var app = require('http').createServer(handler)
//var io = require('socket.io')(app)
//var fs = require('fs')

//app.listen(80)

//function handler (req, res) {
//  fs.readFile(__dirname + '/index.html',
//  function (err, data) {
//    if (err) {
//      res.writeHead(500)
//      return res.end('Error loading index.html')
//    }

//    res.writeHead(200)
//    res.end(data)
//  })
//}

//io.on('connection', function (socket) {
//  socket.emit('news', { hello: 'world' })
//  socket.on('my other event', function (data) {
//    console.log(data)
//  })
//})

const app = require('express')();
const server = require('http').createServer(app);
const io = require('socket.io')(server);

// event listener ketika client terkoneksi
io.on('connection', (socket) => {
  console.log('Client terkoneksi');

  socket.on("masukRoom", function (data) {
    console.log(data);
    socket.join(data);
    io.to(data).emit('BerhasilJoin', data);
  });

  socket.on("postChat", function (data) {
    console.log(data);
    io.to(data.namaRoom).emit('chatReceived', {
      data: 'success',
      namaRoom: data.namaRoom,
    });

  });

  socket.on("pushNotif", function (data) {
    console.log(data);
    io.emit('getNotif', data);

  });

  // event listener ketika client mengirim pesan baru
  socket.on('newMessage', (data) => {
    console.log('Pesan baru:', data);
    // mengirim pesan ke semua client yang terkoneksi
    io.emit('newMessage', data);
  });

  // event listener ketika client terputus
  socket.on('disconnect', () => {
    console.log('Client terputus');
  });
});

// menjalankan server pada port 3000
server.listen(3030, () => {
  console.log('Server berjalan pada port 3030');
});
const express = require('express');
const app = express();
const https = require('https');

const { v4: uuidv4 } = require('uuid');

const port = process.env.port || 3030;

app.get('/', (req, res) => {
    res.send('asdasd');
});

const server = app.listen(`${port}`, '0.0.0.0', () => {
    console.log(`Server started on port ${port}`);
});

const io = require('socket.io')(server, {
    cors: { origin: '*' }
});

io.on('connection', socket => {
    console.log('Client Connected!');

    socket.on('disconnected', () => {
        console.log('Client Disonnected!');
    });
});
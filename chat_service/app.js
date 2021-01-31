// 모듈 선언
var http = require('http');
// fs = node 모듈에 file system을 가져온다는 의미
var fs = require('fs');
var socketio = require('socket.io');
var express = require('express');
var app = express();

var cookie = require('cookie-parser');

//내가 추가한 부분
const router = express.Router();
const path = require("path");
const multer = require('multer');
const multerS3 = require('multer-s3');
const AWS = require("aws-sdk");
AWS.config.loadFromPath(__dirname + "/config/awsconfig.json");

let s3 = new AWS.S3();

let upload = multer({
    storage: multerS3({
        s3: s3,
        bucket: "systorybucket",
        key: function (req, file, cb) {
            let extension = path.extname(file.originalname);
            cb(null, Date.now().toString() + extension)
        },
        acl: 'public-read-write',
    })
})
// 내가 추가한 부분 끝

// 원래 있던 부분
// var multer = require('multer');
// const upload = require('./node_modules/multer');
// 원래 있던 부분 종료

// 원래 주석처리된 부분
// var path = require('path');var storage = multer.diskStorage({
//   destination: function (req, file, cb) {
//     cb(null, 'uploads/') // cb 콜백함수를 통해 전송된 파일 저장 디렉토리 설정
//   },
//   filename: function (req, file, cb) {
//     cb(null, file.originalname) // cb 콜백함수를 통해 전송된 파일 이름 설정
//   }
// })
// var upload = multer({ storage: storage })
// 원래 주석처리된 부분

// 웹서버 생성
var server = http.createServer(app);
app.get('/', (request, response) => {
    // 파일 시스템이 HTMLPage.html을 읽는다.
    fs.readFile('HTMLPage.html', (error, data) => {
        response.writeHead(200, { 'Content-Type': 'text/html' });
        response.end(data);
    });
})
// 52273 포트에 서버를 생성
server.listen(52273, () => {
    console.log('Server Running at :52273');
});


// 52273을 듣는다.
var io = socketio.listen(server);
// 소켓을 연결한다
io.sockets.on('connection', (socket) => {
    // 채팅방 이름 초기화
    var roomName = null;
    // 채팅방에 대한 이벤트
    socket.on('join', (data) => {
        roomName = data;
        socket.join(data);

        console.log(data);
    })
    // 기본 메세지 전송에 대한 이벤트
    socket.on('message', (data) => {
        io.sockets.in(roomName).emit('message', data);
        console.log(data);
    });

    // 이미지 전송에 대한 이벤트
    // 'image'라는 이벤트에 연결한다. data는 매개변수
    socket.on('image', (data)=>{
        // 'image'라는 이벤트는 roomName라는 특정 클라이언트를 추출하고,
        // 'image'라는 이벤트를 발생시킨다.
        io.sockets.in(roomName).emit('image', data);
        // data 객체에 담긴 변수들을 콘솔창에 출력한다.
        console.log(data);
    })

});

// 사진 전송시 s3에 이미지 등록하는 코드
app.post( '/image', upload.single("image"), function(req, res, next) {

    try {

        // var file = './uploads' + req.file.filename;
        console.log(req.file)

        var data = req.file;
        res.send(data.location);


    } catch (error) {
        console.error(error);
        next(error);
    }
});

var express = require('express')
var app = require('express')();
var path = require('path');
var http = require('http').createServer(app);
var io = require('socket.io')(http);
var ejs = require('ejs');
var bodyParser = require('body-parser');
var cookieParser = require('cookie-parser');

app.use(cookieParser());
app.use(express.static('public'));
app.use(express.urlencoded({ extended: true }));
// 채팅 관련 기능
app.use(bodyParser.urlencoded({
    extended: true
}));
app.engine('ejs', ejs.renderFile);

var user_id = "";
const rooms = {};
var roomName = {};

////////////// 이미지 출력 코드
var multer = require('multer');
const multerS3 = require('multer-s3');
var fs = require('fs');
var router = express.Router();
var AWS = require("aws-sdk");
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

router.get('/upload', function(req, res, next) {
    res.render('upload')
});

module.exports = router;

app.post('/image', upload.single("image"), function(req, res, next) {
    try {

        var data = req.file;
        console.log(req.file);

        res.send(data.location);
    } catch (error) {
        console.error(error);
        next(error);
    }
});

/////////////////////////////// 이미지 출력 코드 끝

app.get('/', function(req, res, next){
    if (req.cookies.chat_user == undefined || null) {
        res.send('<script type="text/javascript">alert("로그인이 필요합니다.");</script>');
    }

    if (req.cookies.chat_user == 'admin') {
        res.render(__dirname+'/admin.ejs', { rooms: rooms });
        console.log('get admin "/" ');
    } else {
        res.render(__dirname+'/lobby.ejs', { rooms: rooms, userName: req.cookies.chat_user });
        //console.log('rooms:' + rooms)
        console.log('get lobby "/" ');
    }
});

app.post('/room', (req, res) => {

    if (rooms[req.body.room] != null) {
        return res.redirect('/')

    }

    rooms[req.body.room] = { users: {} }
    console.log("rooms1: " + JSON.stringify(rooms))
    res.redirect(req.body.room)
    io.emit('room-created', req.body.room)
    var destination = '/';
    io.emit('redirect', destination);

    // rooms[req.body.room] = { users: {} }
    //
    // res.redirect(req.body.room)
    //io.emit('room-created', req.body.room)

})

app.get('/:room', (req, res) => {
    if (rooms[req.params.room] == null || "") {
        //return res.redirect('/')
        return res.send('<script type="text/javascript">alert("로그인이 필요합니다.");</script>');
    }
    //roomName = req.params.room;

    res.render(__dirname+'/chat.ejs', { roomName: req.params.room})
    console.log('방이름 : ' + req.params.room);

})

var get_user_id = function (req, res, next) {

    user_id = req.cookies.chat_user
    //res.set('Content-Type', 'text/plain')
    res.send({ userName: req.cookies.chat_user})
    console.log('유저이름: '+ req.cookies.chat_user)
    //io.emit('get_user', req.cookies.chat_user)
    //console.log('user_id: 보낸다 ' + req.cookies.chat_user);
};

app.use(get_user_id);

var whoIsOn=[];

io.on('connection', function(socket) {

    socket.emit('find_user', user_id);

    socket.on('new-user', (room, name) => {
        socket.join(room)
        rooms[room].users[socket.id] = name
        io.to(room).emit('user_connected', name)

        console.log("방 접속 성공");



        // 방이름과 사용자 아이디
        // {방이름: rooom1 , 사용자: sinsy}
        whoIsOn.push({room_name: room, user_id: name})
        console.log("whoIsOn : " + JSON.stringify(whoIsOn));
        io.to(room).emit('update_list', whoIsOn)

        console.log("rooms2: " + JSON.stringify(rooms))

        for (var i=0; i<whoIsOn.length; i++ ) {
            if (whoIsOn[i].room_name === "room1") {
                console.log("for whoIsON : " + whoIsOn[i].user_id);
            }
        }

        var json = JSON.stringify(whoIsOn)
        var jData = JSON.parse(json);
        var user = [];


        console.log("length: " + jData.length)
        console.log("jData: " + JSON.stringify(jData))
        console.log("user :" + JSON.stringify(user))


        var clients = io.sockets.adapter.rooms[room].sockets;

        console.log('접속자 목록: ' + Object.keys(clients));
    })

    //클라이언트에서 들어오는 방번호 , 메세지를 판단 해서 각 방에 맞게 방송한다.
    socket.on('chatting', function(msg) { // 클라이언트가 채팅 내용을 보냈을 시
        // 전달한 roomName에 존재하는 소켓 전부에게 broadcast라는 이벤트 emit
        io.to(msg.roomName).emit('broadcast', msg.name + '  :  ' + msg.msg)
        console.log("쿠키 값:" + msg.name)
        console.log("알림:" + msg.roomName +"에 " + msg.name + "이 채팅을 보냈다.")
        //socket.to(room).broadcast.emit('user-connected', name)
    })

    socket.on('image', (data)=> {
        io.to(data.room).emit('image', data);
        console.log("image 이벤트 서버에서 수신");
        console.log(data);
    });


    socket.on('disconnect', () => {
        getUserRooms(socket).forEach(room => {
            io.to(room).emit('user_disconnected', rooms[room].users[socket.id])
            console.log("나간사람 이름: " + rooms[room].users[socket.id])

            // 아이디 배열에서 disconnect 한 유저의 id 만 찾아내서 삭제한다.
            whoIsOn.splice(whoIsOn.findIndex(obj=> obj.user_id == rooms[room].users[socket.id]), 1);
            // console.log("나간사람 whoIsOn : " + whoIsOn)
            io.to(room).emit('update_list', whoIsOn);

            console.log("나간 방.before : " + JSON.stringify(rooms[room].users))
            delete rooms[room].users[socket.id]
            console.log("나간 방.users : " + JSON.stringify(rooms[room].users))

            //
            // 방도 파기해라.

            //socket.leave(room)
            console.log("나간 방 test: " + Object.keys(rooms))

            // 만약 방의 접속자 수가 {} 빈값 이라면,
            if (isEmptyObject(rooms[room].users)) {
                delete rooms[room];
                console.log("방현황: " + Object.keys(rooms))
                var destination = '/';
                io.emit('redirect', destination)
                console.log("redirect 발신");
            }
        })
        // 만약 방의 접속자 수가 0 이라면,
    })



})

function getUserRooms(socket) {
    // object.entries() 메서드는 for... in 와 같은 순서로
    // 주어진 객체 자체의 [key, value] 쌍의 배열을 반환한다.
    //
    return Object.entries(rooms).reduce((names, [name, room]) => {
        if(room.users[socket.id] != null) names.push(name)
        console.log ("getUserRooms : " + JSON.stringify(names))
        return names

    }, [])
}

function isEmptyObject(obj) {
    return JSON.stringify(obj) == '{}';
}



http.listen(3000, function() {
    console.log('listening on localhost:3000');
});

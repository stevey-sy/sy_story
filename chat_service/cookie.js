var http = require('http');
var cookie = require ('cookie');
http.createServer(function(request, response){
    var cookies = {};
    if (request.headers.cookie !== undefined) {
        cookies = cookie.parse(request.headers.cookie);
    }
    console.log(cookies.chat_user);

    response.end('Cookie!!');
}).listen(52273);
var app = require('./app');
var http = require('http');
var https = require('https');


var httpServer = http.createServer(app);
httpServer.listen(9000, function () {
    console.log('HTTP server listening on port ' + 9000);
});

var http = require('http');
var url = requier('url');

function start(){
	http.createServer( function( request, response ){
		var pathname = url.parse( request.url ).pathname;

		console.log("Request for " + pathname + " received.");
	    response.writeHead(200, {"Content-Type": "text/plain"});
	    response.write("Hello World");
	    response.end();	
	} ).listen(8888);
}

export.start = start;

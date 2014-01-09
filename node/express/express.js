var express = require('express');
var app = express();

app.use('/', function(req, res, next){
	console.log('%s %s', req.method, req.url);
	next();
})

app.use(function(req, res){
	res.send('how are you?')
})

app.listen(35695);
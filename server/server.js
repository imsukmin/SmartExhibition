var bodyParser = require('body-parser');
var express = require('express');
var mysql = require('mysql');
var app = express();

app.use(bodyParser()); // pull information from html in POST
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());

app.get('/', function(req, res){
	var msg = req.query.msg;

	res.set('Content-Type', 'text/html');

	if(msg != null){
		res.send('your message is ' + msg );
		console.log('root message Worked');
	} else {
		res.send('Hello world!!');
		console.log('root Worked');
	}
});

app.get('/connect', function(req, res){
	res.send('it work!! Welcome to express.');
	console.log('connect Worked');

});

app.get('/nfc', function(req, res){
	var id = req.query.id;
	var name = req.query.name;

	res.send('I get NFC id No. ' + id + " and name is " + name);
	console.log('nfc Worked');
});

app.get('/ap', function(req, res){
	var level = req.query.level;	
	res.send('I get AP Level [ ' + level + ' ] ');
	console.log('ap Worked');
});

app.get('/json', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = 'select * from BoothInfo';
	if(req.query.q != null){
		query = req.query.q;
	}

	var client = mysql.createConnection({
		user: 'gamjachip',
		password: 'hansung113',
		database: 'gamjachip'	// instead of "client.query('USE gamjachip')"
	});

	client.query(query, function ( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
		console.log('json Worked [' + req.query.q + ']');
	})
	
});

app.get('/200', function(req, res){
	res.send(200);
	console.log('200 Worked');
});

app.get('/404', function(req, res){
	res.send(404);
	console.log('404 Worked');
});

app.get('/500', function(req, res){
	var level = req.query.level;	
	res.send(500);
	console.log('500 Worked');
});

var server = app.listen(43125, function() {
    console.log('Listening on port %d', server.address().port);
});



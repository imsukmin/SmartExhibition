var config = require('./config');
var bodyParser = require('body-parser');var bodyParser = require('body-parser');
var express = require('express');
var mysql = require('mysql');
var app = express();

// connect to Database
var client = mysql.createConnection({
	user: config.db.host,
	password: config.db.password,
	database: config.db.dbname	// instead of "client.query('USE [DBname]')"
});

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

app.get('/GetByNFC', function(req, res){
	var id = req.query.id;
	var name = req.query.name;

	res.send('I get NFC id No. ' + id + " and name is " + name);
	console.log('GetByNFC Worked');
});

app.get('/getAP', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = 'select * from AP';
	if(req.query.q != null){
		query = req.query.q;
	}

	client.query(query, function ( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
		console.log('getAP Worked');
	})
});

app.get('/ExhibitionInfo', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = 'select * from ExhibitionInfo';

	client.query(query, function ( error, result, fields ){
	if(error){
		res.send('query is not correct! query is ' + query + ' and error is ' + error);
	} else {
		res.send(result);
	}
		console.log('ExhibitionInfo Worked [' + req.query.q + ']');
	})
});

app.get('/BoothInfo', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = 'select * from BoothInfo';

	client.query(query, function ( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
		console.log('BoothInfo Worked [' + req.query.q + ']');
	})
});
app.get('/BoothList', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = 'select `index`, `teamName`, `nfcTagId` from BoothInfo';

	client.query(query, function ( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
		console.log('BoothList Sended');
	})
});

app.get('/admin/query', function(req, res){
	res.set('Content-Type', 'text/html');

	var query = req.query.query;

	client.query(query, function ( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
		console.log('Admin-query worked');
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



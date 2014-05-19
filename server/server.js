var config = require('./config');
var bodyParser = require('body-parser');
var express = require('express');
var mysql = require('mysql');
var app = express();

// connect to Database
var client = mysql.createConnection({
	user: config.db.host,
	password: config.db.password,
	database: config.db.dbname	// instead of "client.query('USE [DBname]')"
});

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    return year + "-" + month + "-" + day + " " + hour + ":" + min + ":" + sec;

};

app.use(bodyParser()); // pull information from html in POST
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());
// app.use(express.responseTime());

app.get('/', function(req, res){
	var msg = req.query.msg;

	res.set('Content-Type', 'text/html');

	if(msg != null){
		res.send('your message is ' + msg );
		console.log('root message Worked');
	} else {
		res.send('Hello world!!');
		console.log(getDateTime() + ' root Worked');
	}
});

app.get('/connect', function(req, res){
	res.send('it work!! Welcome to express.');
	console.log(getDateTime() + ' connect Worked');

});

app.get('/GetByNFC', function(req, res){
	var id = req.query.id;
	var name = req.query.name;

	res.send('I get NFC id No. ' + id + " and name is " + name);
	console.log(getDateTime() + ' GetByNFC Worked');
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
		console.log(getDateTime() + ' getAP Worked');
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
		console.log(getDateTime() + ' ExhibitionInfo Worked');
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
		console.log(getDateTime() + ' BoothInfo Worked');
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
		console.log(getDateTime() + ' BoothList Sended');
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
		console.log(getDateTime() + ' Admin-query worked');
	})
});

app.get('/200', function(req, res){
	res.send(200);
	console.log(getDateTime() + ' 200 Worked');
});

app.get('/404', function(req, res){
	res.send(404);
	console.log(getDateTime() + ' 404 Worked');
});

app.get('/500', function(req, res){
	var level = req.query.level;	
	res.send(500);
	console.log(getDateTime() + ' 500 Worked');
});

var server = app.listen(43125, function() {
    console.log(getDateTime() + ' Listening on port %d', server.address().port);
});



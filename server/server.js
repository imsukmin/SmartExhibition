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

function handleDisconnect() {

	client.connect(function(err) {              		// The server is either down
	    if(err) {                                     	// or restarting (takes a while sometimes).
	      	console.log('error when connecting to db:', err);
	      	setTimeout(handleDisconnect, 2000); 		// We introduce a delay before attempting to reconnect,
	    }                                     			// to avoid a hot loop, and to allow our node script to
	});													// process asynchronous requests in the meantime.
                                          				// If you're also serving http, display a 503 error.
	client.on('error', function(err) {
	    console.log('db error', err);
	    if(err.code === 'PROTOCOL_CONNECTION_LOST') { 	// Connection to the MySQL server is usually
	      handleDisconnect();                         	// lost due to either server restart, or a
	    } else {                                      	// connnection idle timeout (the wait_timeout
	      throw err;                                  	// server variable configures this)
	    }
	});              	
}

handleDisconnect();

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();			hour = (hour < 10 ? "0" : "") + hour;
    var min  = date.getMinutes();		min = (min < 10 ? "0" : "") + min;
    var sec  = date.getSeconds();		sec = (sec < 10 ? "0" : "") + sec;
    var year = date.getFullYear();
	var month = date.getMonth() + 1;	month = (month < 10 ? "0" : "") + month;
    var day  = date.getDate();			day = (day < 10 ? "0" : "") + day;

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

app.get('/checkHitCount', function(req, res){

	var index = req.query.index;
	var userID = req.query.userID;

	var query = "SELECT count(*) as count FROM `visitors` WHERE `index` = '" + index + "' and `userID` = '" + userID + "'";
	var checkStatus;
	// check userID existing
	client.query(query, function( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);

		} else {
			checkStatus = JSON.stringify(result).substring(10,11)

			if(checkStatus == '0'){
				query = "INSERT INTO `gamjachip`.`visitors` (`index` ,`userID`) VALUES ( '" + index + "',  '" + userID + "')";

				client.query(query, function( error, result, fields ){
					if(error){
						res.send('query is not correct! query is ' + query + ' and error is ' + error);
					} else {
						query = "INSERT INTO `gamjachip`.`visitors` (`index` ,`userID`) VALUES ( '" + index + "',  '" + userID + "')";
						res.send("Register it!!");
					}
				})
			} else {
				res.send("Already existing! : " + checkStatus);
			}
		}
	})
	console.log('checkHitCount worked.');
})

app.get('/showRanking',function(req, res){

	var query = "SELECT  `index` , COUNT(  `index` ) as count FROM  `visitors` GROUP BY  `index` order by count desc LIMIT 0 , 30";

	client.query(query, function( error, result, fields ){
		if(error){
			res.send('query is not correct! query is ' + query + ' and error is ' + error);
		} else {
			res.send(result);
		}
	})
	console.log('showRanking worked.');
})

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



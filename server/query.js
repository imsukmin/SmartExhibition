var mysql = require('mysql');
var config = require('./config');

var client = mysql.createConnection({
	user: config.db.host,
	password: config.db.password,
	database: config.db.dbname	// instead of "client.query('USE [DBname]')"
});


client.query('select * from Boothinfo', function ( error, result, fields ){
	if(error){
		console.log('query is not correct!');
	} else {
		console.log(result);
	}
})
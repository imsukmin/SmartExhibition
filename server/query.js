var mysql = require('mysql');


var client = mysql.createConnection({
	user: 'gamjachip',
	password: 'hansung113',
	database: 'gamjachip'	// instead of "client.query('USE gamjachip')"
});


client.query('select * from Boothinfo', function ( error, result, fields ){
	if(error){
		console.log('query is not correct!');
	} else {
		console.log(result);
	}
})
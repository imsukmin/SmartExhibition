<?php 
session_cache_expire(30);
session_start();

// config info
$host			= "localhost";
$id			= "root";
$pw			= "apmsetup";
$dbname	= "gamjachip";


## DB connect ##
// $conn= mysql_connect($host, $id, $pw);
// mysql_select_db($dbname);

$conn = @ new Mysqli($host, $id, $pw, $dbname);
$conn->query("set names utf8");

?>
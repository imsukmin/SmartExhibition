<?php
include "common.php";

$index = $_POST['index'];
foreach($_POST as $key => $value) {
	$$key = $value;
}

// // Correct Spceial character
$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$phone = $conn->real_escape_string($phone);
$level = $conn->real_escape_string($level);


if($mode=='new'){
	 $query = "insert into Member (`id`,`password`,`name`,`teamName`, `email`,`phone` ,`level`)
	 values (	'$id', password('$password'), '$name', '$teamName', '$email', '$phone', 'awaiter');";
}else if($mode=='correct'){
	if($password == null) {
		$query = "update `Member` set 
		`id`= '$id', 
		`name`='$name', 
		`teamName`='$teamName', 
		`email`='$email',
		`phone`= '$phone',
		`level`='$level' 
	
		where `index`='$index';";

	} else {
		$query = "update `Member` set 
		`id`= '$id', 
		`password`= password('$password'), 
		`name`='$name', 
		`teamName`='$teamName', 
		`email`='$email',
		`phone`= '$phone',
		`level`='$level' 
		
		where `index`='$index';";
	}	
}else if($mode=='delete'){
	$query = "delete from `Member` where `index`='$index';";
}
// print_r($query);
// print_r($_SESSION);
$conn->query($query); // query문 전송!
if($mode=='new') {
echo "<script>location.href='login.php';</script>"; 
} else {
	echo "<script>location.href='board.php?type=Member';</script>";
}
?>
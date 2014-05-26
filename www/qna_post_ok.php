<?php
include "common.php";

// print_r($_POST);
$editmode = $_POST['editmode'];

// $index = $_POST['index'];
$mode = $_GET['mode'];
foreach($_POST as $key => $value) {
	$$key = $value;
}
// print_r($_POST);
// Correct Spceial character
$title = $conn->real_escape_string($title);
$writer = $conn->real_escape_string($writer);
$content = $conn->real_escape_string($content);
$comment = $conn->real_escape_string($comment);
$type = $conn->real_escape_string($type);


if($mode=='new'){
	$query = "insert into QnA (`title`,`writer`,`date`,`content`,`comment`,`hits`)
	values (	'$title','$writer',	'$date',	'$content',	'$comment',	'$hits');";
}else if($mode =='correct'){
	$query = "update `QnA` set 
	`title`= '$title', 
	`content`='$content', 
	`writer`='$writer', 
	`date`='$date',
	`comment`= '$comment'

	
	where `index`='$index';";
}
else if($mode =='delete'){
	$index = $_GET['no'];

	$query = "delete from `QnA` where `index`='$index';";
}

else if($mode =='reple') {
	$index = $_POST['no'];

	$query = "update `QnA` set 
	`comment`= '$comment'

	where `index`='$index';";
}

if($editmode == 'correct') {

	$index = $_POST['no'];

	$query = "update `QnA` set 
	`comment`= '$comment'

	where `index`='$index';";
}

// else if($mode == 'guest'){
// 		 $query = "insert into QnA (`title`,`writer`,`date`,`content`,`comment`,`hits`)
// 		 values (	'$title','$writer',	'$date',	'$content',	'$comment',	'$hits');";
// // }
// print($query);
$conn->query($query); // query문 전송!
if($mode=='reple' || $editmode == 'correct') {
	echo "<script>location.href='qna_detail.php?no=$index';</script>";
}
else {
echo "<script>location.href='board.php?type=QnA';</script>";
}
// echo "<script>location.replace('qna_detail.php?no=" + $index + "');</script>";
// else {							echo "<script>location.replace('admin_main.php?mode=board');</script>"; }
?>
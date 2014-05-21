<?php
include "common.php";
include "_header.php";



$index = $_POST['index'];

$query = "update `Member` set 
`level`='user' 
where `index`='$index';
";


// $conn->query($query); 
print_r($query);
// echo "<script>location.href='board.php?type=Member';</script>";
?>

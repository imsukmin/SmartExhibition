<!DOCTYPE html5>
<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
</html>
<?php
include "common.php";

//  rst로 abo_user의 query결과 값이 넘어오며  table로 연결이 된다.
$id = addslashes( $_POST['id'] );
$password = addslashes( $_POST['password'] );



$rst= $conn->query("select count(*) as `cnt` from `Member` where `id`='{$id}' and `password`=password('{$password}')");
$getId = $conn->query("select * from `Member` where `id`='{$id}'");
if(!$rst){
	exit("DB 실패");
}
$loginCheck = $rst->fetch_assoc();
// $level = $getLevel->fetch_assoc();
// $member_level = $level;

if($loginCheck['cnt'] > 0){
	/*****************/
           // $_SESSION['user'] = $id;
           $_SESSION['start'] = time(); // Taking now logged in time.
            // Ending a session in 30 minutes from the starting time.
           $_SESSION['expire'] = $_SESSION['start'] + (30 * 60); //(30*60)
           /*****************/

	$rows = $getId->fetch_assoc();
	
	$_SESSION['_gamjachip_id'] = $id;

	// $_SESSION['id']	=$rows['id'];
	$_SESSION['IDlevel']= $rows['level'];

	$_SESSION['IDteamName'] = $rows['teamName'];

	echo "<script>location.href='home.php';</script>";
	// if($_SESSION['level'] == 'admin') {
	// 	echo "<script>location.href='home.php';</script>";

	// }
	// else if($_SESSION['level']== 'user') {
	// 	echo "<script>location.href='home.php';</script>";
	// }
} 
else{
	?>
	<script>alert("로그인에 실패하였습니다. \n아이디와 암호를 확인해주세요.");</script>	
	<?php
	echo "<script>location.href='login.php';</script>";
	
}
?>
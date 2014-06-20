<?php
include "common.php";
?>

<!DOCTYPE html5>
<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link href="bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" media="screen" title="no title" charset="utf-8"/>

	<style>
		body {
			padding-top:10px;
		}
	</style>

	<title>S.M.A.R.T / E.X.H.I.B.I.T.I.O.N</title>
</head>


<body>
	<?php
if(!$_SESSION['_gamjachip_id']){ // 로그인이 되어있지 않은 경우 로그인 페이지로 이동함. 
	?>

	<script>location.href='login.php';</script>
	<?php
} else {
	// include "_header.php";

	$now = time();

	if($now > $_SESSION['expire']) {
		session_destroy();
		?>
		<script>location.href='login.php';</script>
		<?php
	} else {

		if($_SESSION['IDlevel']=='admin') {
			?>

			<div class="containter">

				<nav class="navbar navbar-inverse" role="navigation" style="margin:auto; width:1000px;height:60px;">
					<div  class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="sr-only">Toggle navigation</span>
							<span class="sr-only">Toggle navigation</span>
							<span class="sr-only">Toggle navigation</span>
							<span class="sr-only">Toggle navigation</span>
						</button>
						<a style="margin-left:40px;" class="navbar-brand" href="home.php">홈으로</a>
						<a class="navbar-brand" href="board.php?type=BoothInfo">부스 관리</a>
						<a class="navbar-brand" href="board.php?type=Member">회원 관리</a>
						<a class="navbar-brand" href="board.php?type=ExhibitionInfo">전시회 관리</a>
						<a class="navbar-brand" href="board.php?type=QnA">질의응답</a>
					</div>

					<ul style="margin-right:10px;" class="nav navbar-nav navbar-right">
						<li><a href="logout.php">LOGOUT<span class="glyphicon glyphicon-off"></span></a></li></ul>





						<?php
					} else if($_SESSION['IDlevel']=='user') {
						?>
						<div class="containter">

							<nav class="navbar navbar-inverse" role="navigation" style="margin:auto; width:1000px;height:60px;">
								<div  class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
										<span class="sr-only">Toggle navigation</span>
										<span class="sr-only">Toggle navigation</span>
										<span class="sr-only">Toggle navigation</span>
									</button>
									<a style="margin-left:40px;" class="navbar-brand" href="home.php">홈으로</a>
									<a class="navbar-brand" href="board.php?type=BoothInfo">부스 관리</a>
									<a class="navbar-brand" href="board.php?type=QnA">질의응답</a>
								</div>

								<ul style="margin-right:10px;" class="nav navbar-nav navbar-right">
									<li><a href="logout.php">LOGOUT<span class="glyphicon glyphicon-off"></span></a></li></ul>

									<?php
								}else if($_SESSION['IDlevel']=='awaiter'){
									echo '<script> alert("가입 승인이 되어야 로그인이 가능합니다.\n승인을 기다려주세요.");</script>';


									echo "<script>location.href='login.php';</script>";
								}

							}
						}
						?>

					</nav>
				</div>
				<div style="width:1000px; margin:20px auto;" class="container row">

<!DOCTYPE html5>
<?php
include "common.php";
?>
<html>
<head>
<!-- <meta http-equiv="content-type" content="text/html; charset=utf-8" /> -->
<meta charset="UTF-8">
<link href="bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" media="screen" title="no title" charset="utf-8"/>
<!-- <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8"/> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
	body {
		padding-top:10px;
	}
</style>
<title>S.M.A.R.T / E.X.H.I.B.I.T.I.O.N</title>
</head>
<body>

<?php
if($_SESSION['level']=='admin') {
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
} else if($_SESSION['level']=='user') {
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
}
?>

</nav>
</div>

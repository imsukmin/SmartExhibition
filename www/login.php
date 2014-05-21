<!DOCTYPE html5>

<?php	
include "common.php";

?>

<html>
<head>
<title>S.M.A.R.T / E.X.H.I.B.I.T.I.O.N</title>
<meta charset="UTF-8" lang="ko" http-equiv="" />
<link href="bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" media="screen" title="no title" charset="utf-8"/>

</head>

<body>

<form class="form-horizontal" action="login_ok.php" method="post">
	<fieldset style="width:225px; height:400px; margin:150px auto; ">
	<p align="center"><img src="images/login_logo.png" width="150px" height="180px"/></p>
	
	<fieldset style="width:215px; height:200px; border:2px solid #149c82;">
	
	<div class="control-group">
		
		<label class="control-label" for="login_field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID</label>
		
		<div class="controls">
		<p align="center">
			<input class="input-xlarge" id="login_field" type="text" placeholder="ID" name="id" autofocus value=""/>
		</p>
		</div>
		
	</div>
	
	
	<div class="control-group">
		
		<label class="control-label" for="password">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PASSWORD</label>
		<div class="controls">
		<p align="center">
			<input class="input-xlarge" id="password"  type="password" placeholder="PASSWORD" name="password" />
		</p>
		</div>
		
	</div>
	
	
		
		<div class="form-actions">
			<p align="center">
			<button style="width:86px;" type="submit" class="btn btn-primary">LOGIN</button>
			<input style="width:86px;" class="btn btn-primary" type="button" onclick="location.href='memberJoin.php?mode=new';" value="SIGN IN"/>
				
			</p>
			<!-- <button class="btn btn-primary" onclick="location.replace('memberJoin.php?mode=new');">SIGN IN</button> -->
		</div>
		

	
	</fieldset>
		<!-- &nbsp;&nbsp;&nbsp;<a href="searchID.php">ID/PW 찾기</a></p> -->
	</fieldset>
	
</form>
	
<script src="//code.jquery.com/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/respond.js"></script>
</body>
</html>
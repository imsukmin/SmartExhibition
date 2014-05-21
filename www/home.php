<body>

	<?php	
	include "common.php";


if(!$_SESSION['_gamjachip_id']){ // 로그인이 되어있지 않은 경우 로그인 페이지로 이동함. 
	?>

	<script>location.replace('login.php');</script>
	<?php
} else {
	include "_header.php";

	$now = time();

	if($now > $_SESSION['expire']) {
		session_destroy();
		?>
		<script>location.replace('login.php');</script>
		<?php
	}
	else {

		?>
		<div style="width:1000px; margin:20px auto;" class="container row">
			<div class="col-md-4">
				<div style="width:300px;height:250px;"class="panel panel-info">
					<p style="margin-top:10px;"align="center">
						<img id="gamjachip" style="width:120px; height:120px;" src="images/gamjachip.png" alt="Gamjachip Logo" /> </p>

						<ul style="list-style:none;">
							<li><h3><span class="glyphicon glyphicon-user">Gamjachip</span></h3></li>
							<li>전시회 관리자: 이도경</li>
							<li><a href="mailto:eunido@naver.com" >eunido@naver.com</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-8">
					<div style="width:580px;height:250px;"class="panel panel-primary">
						<div class="panel-heading">
							<div class="panel-title" style="font-weight:bold">부스 관리자 리스트</div>
						</div>
						<div class="panel-body">
							<ul style="list-style:none;">
								<li style="text-align:right;"><a href="board.php?type=BoothInfo">더보기<span class="glyphicon glyphicon-chevron-right"></span></a></li>
								<br/>
								<li><span class="glyphicon glyphicon-hand-right"></span>&nbsp;Never Forgotten 영한사전</li>
								<li><span class="glyphicon glyphicon-hand-right"></span>&nbsp;Game Checker</li>
								<li><span class="glyphicon glyphicon-hand-right"></span>&nbsp;PASS(Proximity-based Advertisement System and Service)</li>
								<li><span class="glyphicon glyphicon-hand-right"></span>&nbsp;우리나라 문화재 관광 안내 어플리케이션</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-10">
				<div style="width:900px;height:250px;"class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title" style="font-weight:bold">한성대 컴퓨터공학과 설계프로젝트 전시회</div>
						</div>
						<div class="panel-body">
							<ul style="list-style:none;">
								<li style="text-align:right;"><a href="board.php?type=ExhibitionInfo">더보기<span class="glyphicon glyphicon-chevron-right"></span></a></li>
								<br/>
								<li><strong>대상:</strong> 한성대 컴퓨터공학과 4학년 학생</li>
								<li><strong>날짜:</strong> 2014년 06월 05일</li>
								<li><strong>장소:</strong> 한성대 미래관 DLC </li>
								<li><strong>전시회 소개:</strong> 한성대학교 컴퓨터공학과 4학년 학생들이 1학기동안 준비한 소프트웨어 결과물들을 볼 수 있습니다.</li>
							</ul>
						</div>
					</div>
				</div>

				<?php
			}
		}
		?>
		</div>
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/respond.js"></script>
</body>
</html>
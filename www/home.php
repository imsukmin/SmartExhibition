<?php	
include "_header.php";
?>
		
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
					<div style="width:580px;height:250px; overflow:scroll;" class="panel panel-primary">
						<div class="panel-heading">
							<div class="panel-title" style="font-weight:bold">부스 관리자 리스트</div>
						</div>
						<div class="panel-body">
							<ul style="list-style:none; padding-left:5px;">
							<?php
							if($_SESSION['IDlevel']=='admin') {
							?>
								<li style="text-align:right;"><a href="board.php?type=BoothInfo">더보기<span class="glyphicon glyphicon-chevron-right"></span></a></li>
							<?php
							} else {}
							?>
								<?php
								$rst= $conn->query("select * from `BoothInfo`");
								while($row = $rst->fetch_assoc()){
							
								?>
								<li><span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;<?php echo $row['productName']?></li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php
				$rst= $conn->query("select * from `ExhibitionInfo`");
				$row = $rst->fetch_assoc();
				?>
				<div class="col-md-10">
				<div style="width:900px;height:250px;"class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title" style="font-weight:bold"><?php echo $row['title']; ?></div>
						</div>
						<div class="panel-body">
							<ul style="list-style:none;">
							<?php
							
							if($_SESSION['IDlevel']=='admin') {
							?>
								<li style="text-align:right;"><a href="board.php?type=ExhibitionInfo">더보기<span class="glyphicon glyphicon-chevron-right"></span></a></li>
								<br/>
							<?php
							} else {
							?>
							<br/>
							<?php

							}
							?>
								<li><strong>대상:</strong>&nbsp;&nbsp;<?php echo $row['host']; ?></li>
								<li><strong>날짜:</strong>&nbsp;&nbsp;<?php echo $row['date']; ?></li>
								<li><strong>장소:</strong>&nbsp;&nbsp;<?php echo $row['place']; ?></li>
								<li><strong>전시회 소개:</strong>&nbsp;&nbsp;<?php echo $row['summary']; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
				<?php 
				include "_footer.php";
				?>
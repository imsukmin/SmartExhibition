
<?php
include_once "_header.php";
$type = $_GET['type'];
$index = $_GET['no'];


$page_size=10;# 한페이지에 보여질 게시물의 수  
$page_list_size=10; #페이지 나누기에 표시될 페이지의 수  
?>



<!--  rst로 abo_board의 query결과 값이 넘어오며  table로 연결이 된다. -->
<?php
if($type == 'ExhibitionInfo'){
	$rst= $conn->query("select * from `ExhibitionInfo`");

	$row = $rst->fetch_assoc();
	?>

	<div class="panel panel-default" >
		<div class="panel-heading">전시회 정보 | 전시회 정보를 담고 있습니다.

		</div>
		<div class="panel-content">
			<div class="col-lg-1">
			</div>
			<div class="col-lg-10">
				<table class="table center">
					<tr>
						<td colspan="2"></td>
					</tr>

					<tr>
						<th style="width:150px;">전시회 이름</th>
						<td><?php echo $row['title']?></td>
					</tr>

					<tr>
						<th style="width:150px;">전시회 주최</th>
						<td><?php echo $row['host']?></td>
					</tr>
					<tr>
						<th style="width:150px;">날짜</th>
						<td><?php echo $row['date']?></td>
					</tr>
					<tr>
						<th style="width:150px;">장소</th>
						<td><?php echo $row['place']?></td>
					</tr>
					<tr>
						<th style="width:150px;">전시회 개요</th>
						<td><?php echo $row['summary']?></td>
					</tr>
					<tr>
						<th style="width:150px;">전시회 구성</th>
						<td><?php echo $row['outline']?></td>

					</tr>
					<tr>
						<th style="width:150px;">전시회 구조</th>
						<td><img src="<?php echo $row['map']; ?>"></td>
					</tr>
					<tr>
						<th style="width:150px;">홈페이지</th>
						<td><a href="<?php echo $row['homepage']?>" target="_blank"><?php echo $row['homepage']?></a></td>
					</tr>
				</table>
			</div>
			<div class="col-lg-2"></div>
			<div class="col-lg-11"></div>
			<div class="col-lg-1">
				<input type="button" class="btn btn-primary btn-sm pull-right" value="수정" onclick="location.href='exhibitionInfo_correct.php';"/>
			</div>
		</div>

		<?php 
	}else if($type == 'BoothInfo'){

			//데이터베이스에서 페이지의 첫 번째 글($no)부터  
			//$page_size만큼의 글을 가져온다.  
		if(!@ $index || @ $index < 0) $no = 0; else $no = $index;  
		$rst= $conn->query("SELECT * FROM `BoothInfo` ORDER BY `index` DESC LIMIT $no, $page_size");

			//총 게시물 수를 구한다.  
		$result_count = $conn->query("SELECT count(*) FROM `BoothInfo`");  
		$result_row=$result_count->fetch_array();  
		$total_row = $result_row[0]; // 결과의 첫 번째 열이 count(*)의 결과다.  


		#총 페이지 계산  
		if($total_row <= 0) $total_row = 0;  
		$total_page = ceil($total_row / $page_size);  

		#현재 페이지 계산  
		$current_page = ceil(($no+1)/$page_size);  
		?>


		<div class="panel panel-default" >
			<div class="panel-heading">부스 관리 | 관리하고 싶은 부스를 등록하세요.</div>

			<table class="table table-striped table-hover">

				<?php
				if($_SESSION['IDlevel']=='admin') {
					?>
					<thead>
						<tr>
							<th style="width:100px;">NO</th>
							<th style="width:200px">팀명</th>
							<th style="width:500px">작품명</th>
							<th style="width:100px">담당교수</th>
						</tr>
					</thead>
					<?php
					while($row = $rst->fetch_assoc()){
						?>
						<tbody>
							<tr>
								<td><?php echo $row['index']?></td>
								<td><?php echo $row['teamName']?></td>
								<td><a href="boothInfo_detail.php?no=<?php echo $row['index']?>"><?php echo $row['productName']?></a></td>
								<td><?php echo $row['professor']?></td>
							</tr>
						</tbody>
						<?
					}
					?>
				</table>
			</div>
			<div class="col-lg-11"></div>
			<div class="col-lg-1">
				<input type="button" class="btn btn-primary btn-sm pull-right" value="쓰기" onclick="location.href='boothInfo_post.php?mode=new';"/>
			</div>

			<?  
						// 페이지 목록에서 시작페이지  
			$start_page = floor(($current_page-1) / $page_list_size) * $page_list_size + 1;  

						// 페이지 목록의 마지막 페이지가 몇 번째 페이지인지 구하는 부분  
			$end_page = $start_page + $page_list_size - 1;  
			if($end_page > $total_page) $end_page = $total_page;  

						// 이전 페이지 존재 여부 판단과 이전페이는 첫 번째 페이지에서 한페이지 감소하면 된다  
						// $page_size를 곱해주는 이유는 글 번호를 표시하기 위해서이다.($no 값으로 사용)  

			?>

			<div style="text-align:center;">

				<? 

				if($start_page > $page_list_size){  
					$prev_list = ($start_page - 2) * $page_size;  
					echo "<a href=board.php?type=BoothInfo&no={$prev_list}>◀</a>";  
				}  

						#페이지 목록을 출력  
				for($i=$start_page;$i<=$end_page;$i++){  
						    $page = ($i-1) * $page_size; // 페이지 값을 no값으로 변환  
						    if($no != $page){ // 현재 페이지가 아닐 경우만 링크 표시  
						    	echo "<a href=board.php?type=BoothInfo&no={$page}>";  
						    }  
						    echo $i;  
						    if($no != $page){  
						    	echo "</a>";  
						    }  
						    echo " ";  
						}  

						# 다음 페이지 목록이 필요할 때는 총 페이지가 마지막 목록이 총페이지 보다 작을때이다.  
						if($end_page < $total_page)  
						{  
							$next_list = $end_page * $page_size;  
							echo "<a href=board.php?type=BoothInfo&no={$next_list}>▶</a>";  
						}  
						?>  
						
					</div>
					<?php


				} else if($_SESSION['IDlevel']=='user') {
					while($row = $rst->fetch_assoc()){
						if($_SESSION['IDteamName']==$row['teamName']) {
							?>
							<script>location.href="boothInfo_detail.php?no=<?php echo $row['index']?>;"</script>
							<?php
						}

					}
				}

				?>



			</table>
		</div>


		<?
		if($_SESSION['IDlevel']=='user') {
			?>


			<div class="col-lg-11"></div>
			<div class="col-lg-1">
				<input type="button" class="btn btn-primary btn-sm pull-right" value="쓰기" onclick="location.href='boothInfo_post.php?mode=new';"/>
			</div>
			<?php
		}
		?>


		<?php

	} else if($type == 'Member'){	
		if(!@ $index || @ $index < 0) $no = 0; else $no = $index;  
		$rst= $conn->query("SELECT * FROM `Member` ORDER BY `index` DESC LIMIT $no, $page_size");

			//총 게시물 수를 구한다.  
		$result_count = $conn->query("SELECT count(*) FROM `Member`");  
		$result_row=$result_count->fetch_array();  
		$total_row = $result_row[0]; // 결과의 첫 번째 열이 count(*)의 결과다.  


		#총 페이지 계산  
		if($total_row <= 0) $total_row = 0;  
		$total_page = ceil($total_row / $page_size);  

		#현재 페이지 계산  
		$current_page = ceil(($no+1)/$page_size);  
		?>
		<div class="panel panel-default">
			<div class="panel-heading">회원 관리 | 회원을 수정하려면 수정 버튼을 눌러 수정해주세요.</div>

			<table class="table table-striped table-hover ">
				<thead>
					<tr>
						<th style="width:50px;">NO</th>
						<th style="width:150px">아이디</th>
						<th style="width:130px">이름</th>
						<th style="width:150px">팀명</th>
						<th style="width:250px">이메일</th>
						<th style="width:100px;">등급</th>
						<th style="width:50px;"></th>
						<th style="width:50px;"></th>


					</tr>
				</thead>
				<?php
				while($row = $rst->fetch_assoc()){
					?>
					<tbody>


						<!-- <input type="hidden" name="no" value="<?php echo $row['index'] ?>"> -->
						<tr>
							<td><?php echo $row['index']?></td>
							<td><?php echo $row['id']?></td>
							<td><?php echo $row['name']?></td>
							<td><?php echo $row['teamName']?></td>
							<td><?php echo $row['email']?></td>
							<td><?php echo $row['level']?></td>
							<td><input type="button" class="btn btn-info btn-sm" value="수정" onclick="location.href='memberJoin.php?mode=correct&no=<?php echo $row['index']?>';"></td>	
							<td><input type="button" class="btn btn-info btn-sm" value="삭제" onclick="location.href='memberJoin.php?mode=delete&no=<?php echo $row['index']?>';"></td>

						</tr>
					</tbody>
					<?php
				}
				?>

			</table>
		</div>

		<?  
						// 페이지 목록에서 시작페이지  
		$start_page = floor(($current_page-1) / $page_list_size) * $page_list_size + 1;  

						// 페이지 목록의 마지막 페이지가 몇 번째 페이지인지 구하는 부분  
		$end_page = $start_page + $page_list_size - 1;  
		if($end_page > $total_page) $end_page = $total_page;  

						// 이전 페이지 존재 여부 판단과 이전페이는 첫 번째 페이지에서 한페이지 감소하면 된다  
						// $page_size를 곱해주는 이유는 글 번호를 표시하기 위해서이다.($no 값으로 사용)  

		?>

		<div style="text-align:center;">

			<? 

			if($start_page > $page_list_size){  
				$prev_list = ($start_page - 2) * $page_size;  
				echo "<a href=board.php?type=Member&no={$prev_list}>◀</a>";  
			}  

						#페이지 목록을 출력  
			for($i=$start_page;$i<=$end_page;$i++){  
						    $page = ($i-1) * $page_size; // 페이지 값을 no값으로 변환  
						    if($no != $page){ // 현재 페이지가 아닐 경우만 링크 표시  
						    	echo "<a href=board.php?type=Member&no={$page}>";  
						    }  
						    echo $i;  
						    if($no != $page){  
						    	echo "</a>";  
						    }  
						    echo " ";  
						}  

						# 다음 페이지 목록이 필요할 때는 총 페이지가 마지막 목록이 총페이지 보다 작을때이다.  
						if($end_page < $total_page)  
						{  
							$next_list = $end_page * $page_size;  
							echo "<a href=board.php?type=Member&no={$next_list}>▶</a>";  
						}  
						?>  






						<?php
					}
					else if($type == 'QnA') {	
						if(!@ $index || @ $index < 0) $no = 0; else $no = $index;  
						$rst= $conn->query("SELECT * FROM `QnA` ORDER BY `index` DESC LIMIT $no, $page_size");

							//총 게시물 수를 구한다.  
						$result_count = $conn->query("SELECT count(*) FROM `QnA`");  
						$result_row=$result_count->fetch_array();  
						$total_row = $result_row[0]; // 결과의 첫 번째 열이 count(*)의 결과다.  


						#총 페이지 계산  
						if($total_row <= 0) $total_row = 0;  
						$total_page = ceil($total_row / $page_size);  

						#현재 페이지 계산  
						$current_page = ceil(($no+1)/$page_size);  
						?>
						<div class="panel panel-default" >
							<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>
							<div><input type="hidden" id="no" value="<?php echo $row['index']?>"></div>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="width:50px">NO</th>
										<th style="width:300px">글제목</th>
										<th style="width:100px">글쓴이</th>
										<th style="width:100px">작성일</th>
									</tr>
								</thead>
								<?php
								while($row = $rst->fetch_assoc()){
									?>
									<tbody>
										<tr>
											<td><?php echo $row['index']?></td>
											<td><a href="qna_detail.php?no=<?php echo $row['index']?>"><?php echo $row['title']?></a></td>
											<td><?php echo $row['writer']?></td>
											<td><?php echo $row['date']?></td>
										</tr> 
									</tbody>
									<?php
								}
								?>

							</table>
						</div>	


						<div class="col-lg-11"></div>
						<div class="col-lg-1">
							<input type="button" class="btn btn-primary btn-sm pull-right" value="쓰기" onclick="location.href='qna_post.php?mode=new';"/>
						</div>

						<?  
						// 페이지 목록에서 시작페이지  
						$start_page = floor(($current_page-1) / $page_list_size) * $page_list_size + 1;  

										// 페이지 목록의 마지막 페이지가 몇 번째 페이지인지 구하는 부분  
						$end_page = $start_page + $page_list_size - 1;  
						if($end_page > $total_page) $end_page = $total_page;  

										// 이전 페이지 존재 여부 판단과 이전페이는 첫 번째 페이지에서 한페이지 감소하면 된다  
										// $page_size를 곱해주는 이유는 글 번호를 표시하기 위해서이다.($no 값으로 사용)  

						?>

						<div style="text-align:center;">

							<? 

							if($start_page > $page_list_size){  
								$prev_list = ($start_page - 2) * $page_size;  
								echo "<a href=board.php?type=QnA&no={$prev_list}>◀</a>";  
							}  

										#페이지 목록을 출력  
							for($i=$start_page;$i<=$end_page;$i++){  
								    $page = ($i-1) * $page_size; // 페이지 값을 no값으로 변환  
								    if($no != $page){ // 현재 페이지가 아닐 경우만 링크 표시  
								    	echo "<a href=board.php?type=QnA&no={$page}>";  
								    }  
								    echo $i;  
								    if($no != $page){  
								    	echo "</a>";  
								    }  
								    echo " ";  
								}  

						# 다음 페이지 목록이 필요할 때는 총 페이지가 마지막 목록이 총페이지 보다 작을때이다.  
								if($end_page < $total_page)  
								{  
									$next_list = $end_page * $page_size;  
									echo "<a href=board.php?type=QnA&no={$next_list}>▶</a>";  
								}  
								?>  

								<?php
							}
							?>



						</div>


						<?php
						include "_footer.php";
						?>
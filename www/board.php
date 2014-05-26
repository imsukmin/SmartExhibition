
<?php
include_once "_header.php";
$type = $_GET['type'];
$index = $_GET['no'];
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
			<div class="col-lg-2">
			</div>
			<div class="col-lg-8">
				<table class="table center">
					<tr>
						<td colspan="2"></td>
						<tr>
							<th style="width:120px;">전시회 이름</th>
							<td><?php echo $row['title']?></td>
						</tr>

						<tr>
							<th style="width:120px;">전시회 주최</th>
							<td><?php echo $row['host']?></td>
						</tr>
						<tr>
							<th style="width:120px;">날짜</th>
							<td><?php echo $row['date']?></td>
						</tr>
						<tr>
							<th style="width:120px;">장소</th>
							<td><?php echo $row['place']?></td>
						</tr>
						<tr>
							<th style="width:120px;">전시회 개요</th>
							<td><?php echo $row['summary']?></td>
						</tr>
						<tr>
							<th style="width:120px;">전시회 구성</th>
							<td><?php echo $row['outline']?></td>

						</tr>
						<tr>
							<th style="width:120px;">전시회 구조</th>
							<td><?php echo $row['map']?></td>
						</tr>
						<tr>
							<th style="width:120px;">홈페이지</th>
							<td><a href="<?php echo $row['homepage']?>" target="_blank"><?php echo $row['homepage']?></a></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-2"></div>
			</div>

			<?php 
		}else if($type == 'BoothInfo'){
			$rst= $conn->query("select * from `BoothInfo`");
				// $rst2=$conn->query("select * from `Member`");
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


							<?php
						}

					} else if($_SESSION['IDlevel']=='user') {
						while($row = $rst->fetch_assoc()){
							if($_SESSION['IDteamName']==$row['teamName']) {
								?>
								<tbody>
									<tr>
										<td>
											<strong>작품명 </strong><?php echo $row['productName']; ?></td>
											<td><strong>팀명 </strong> <?php echo $row['teamName']; ?></td>
										</tr>
										<tr>
											<td><strong>팀원 </strong><?php echo $row['member']; ?></td>
											<td><strong>담당교수 </strong><?php echo $row['professor']; ?></td>
										</tr>
										<tr>
											<td colspan="2"><strong>프로젝트 개요 </strong><?php echo $row['outline']; ?></td>
										</tr>
										<tr>
											<td colspan="2">
												<strong>프로젝트 요약 </strong><?php echo $row['summary']; ?></td>
											</tr>
											<tr>
												<td colspan="2">
													<strong>타겟머신 및 운영체제 </strong><?php echo $row['target']; ?></td>
												</tr>
												<tr>
													<td colspan="2"><strong>홈페이지 </strong><a href="<?php echo $row['homepage']; ?>" target="_blank"><?php echo $row['homepage']; ?></a>
													</td>
												</tr>
												<tr><td colspan="2"><strong>브로셔이미지 </strong></td>
												</tr>
												<div class="thumbnail">
													<tr>
														<td colspan="2"><img src="<?php echo $row['brochure']; ?>"<br /></td>
													</tr>
												</div>

											</tbody>
											<?php
										}

									}
								}

								?>



							</table>
						</div>
						<div class="col-lg-11"></div>
						<div class="col-lg-1">
							<input type="button" class="btn btn-primary btn-sm pull-right" value="쓰기" onclick="location.href='boothInfo_post.php?mode=new';"/>
						</div>
						<?php
					}
					else if($type == 'Member'){	
						$rst= $conn->query("select * from `Member`");
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
							<br/>





						</table>
						<?php
					}
					else if($type == 'QnA') {
						$rst= $conn->query("select * from `QnA`");	
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



						<?php
					}
					?>



				</div>

				<script type="text/javascript" >
					function allowMember() {
						var conf = confirm("정말로 회원을 승인하시겠습니까?");
						if(conf==true) {

							location.href='member_allow.php?no='+'';
						}
					}
				</script>
				<script language="javascript">
					var index = document.getElementsByName("no");
					// alert( index.value);

				</script>

				<?php
				include "_footer.php";
				?>
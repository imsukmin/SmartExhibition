<?php
include "common.php";
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `BoothInfo` where `index`='{$index}'");
$row = $rst->fetch_assoc();

?>

<div style="width:1000px; margin:20px auto;" class="container row">
	<div class="panel panel-default" >
		<div class="panel-heading">부스 관리 | 관리하고 싶은 부스를 등록하세요.</div>

		<div class="col-md-12">
			<table class="table table-striped table-hover ">
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

								<?php
								if($_SESSION['level']=='admin') {
								?>
								<tr>
									<td>
										<strong>ApLevel </strong>&nbsp;&nbsp;<?php echo $row['apLevel'];?>
									</td>
									<td >
										<strong>NFCTagID </strong>&nbsp;&nbsp;<?php echo $row['nfcTagId'];?>
									</td>
								</tr>

								<?php 
								} else if($_SESSION['level']=='user') {

								}
								?>



									<tr><td colspan="2"><strong>브로셔이미지 </strong></td>
									</tr>
									<div class="thumbnail">
									<tr>
										<td colspan="2"><img src="<?php echo $row['brochure']; ?>"<br /></td>
									</tr>
									</div>

								</tbody>
							</table>
							</div>
							
								<div class="col-lg-2">
								<input type="button" class="btn btn-primary btn-sm" value="수정" onclick="location.replace('boothInfo_post.php?mode=correct&no=<?php echo $row['index']?>');"/>
								<input type="button" class="btn btn-primary btn-sm" value="삭제" onclick="deleteBoard();"/>

								</div>
								<div class="col-lg-9"></div>
								<div class="col-lg-1">
								<input type="button" class="btn btn-primary btn-sm" onclick="location.replace('board.php?type=BoothInfo');" value="돌아가기" />
								</div>
							</div>
							</div>

						

			<script type="text/javascript" >
				function deleteBoard() {
					var conf = confirm("정말로 게시글을 삭제하시겠습니까?");
					if(conf==true) {

						location.href='boothInfo_post_ok.php?no=<?php echo $row['index']?>&mode=delete';
					}
				}
			</script>


			<script src="//code.jquery.com/jquery.js"></script>
			<script src="bootstrap/js/bootstrap.min.js"></script>
			<script src="js/respond.js"></script>
		</body>
		</html>
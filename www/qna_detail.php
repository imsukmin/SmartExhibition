<?php
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `QnA` where `index`='{$index}'");
$row = $rst->fetch_assoc();

 //조회수
$hitIndexQuery = $conn->query("SELECT `index` from `QnA` where `index`='$index'");
$hitIndex = $hitIndexQuery->fetch_array();

$hitIndex = $hitIndex[0];

$hitId = $_SESSION['_gamjachip_id'];	

$countQuery = $conn->query("SELECT count(*) as count FROM `hitcount` WHERE `index` = '$hitIndex' and `id` = '$hitId'");
$count = $countQuery->fetch_array();
$count = $count[0];

if($count == 0) {
	$InsertQuery = "INSERT INTO `gamjachip`.`hitcount` (`index` ,`id`) VALUES ( '$index',  '$hitId')";
	$hits = $conn->query($InsertQuery);

} else {}



//조회수
						
// $hitQuery="SELECT * FROM `QnA` WHERE `index`='$index'";
// $hitResult=$conn->query($hitQuery);
// $hitrs=$hitResult->fetch_array();
// $hitUpQuery="UPDATE `QnA` set hits = hits + 1 WHERE `index`='$index'";
// $conn->query($hitUpQuery);
?>


<div class="panel panel-default" >
	<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>

	<div class="col-lg-12">
		<form class="form-horizontal" action="qna_post_ok.php" method="post" >
			<table class="table table-striped table-hover ">
				<thead>

					<tr>
						<td colspan="3" class="col-lg-12"><strong>제목</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['title']; ?></td>
					</tr>
					<tr>
						<td colspan="3" class="col-lg-12"><strong>작성자</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['writer']; ?></td>

					</tr>		

				</thead>
				<tbody>
					<input type="hidden" name="no" value="<?php echo $row['index'];?>">
					<!-- <input type="hidden" name="mode" value="reple"> -->
					<tr>
						<td colspan="3"><strong>내용</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['content']; ?></td>
					</tr>
					<tr>
						<th colspan="3">답변을 달아주세요.</th>
					</tr>
					<?php
					if($_SESSION['IDlevel']=='admin') {

						if($row['comment']==null)  {

							?>
						

							<tr>
								<td class="col-lg-11">
									<input type="hidden" name="editmode" value="correct">

									<textarea style="resize:none;" name="comment" class="form-control" id="comment" placeholder="답변을 달아주세요." rows="3"></textarea></td>
									<td class="col-lg-2"><input type="submit" value="댓글달기" class="btn btn-primary btn-sm" ></td>
								</tr>
								<?php
								

						} else {
							?>
							
							<tr>
								
								<td class="col-lg-10"><strong>답변</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['comment']; ?></td>
								<td class="col-lg-1"><input type="button" value="삭제하기" onclick="location.replace('qna_post_ok.php?no=<?php echo $row['index']?>&editmode=delete');" class="btn btn-primary btn-sm" ></td>
								<input type="hidden" name="editmode" value="correct">

								<td class="col-lg-1"><input type="button" value="수정하기" onclick="show('correct');" class="btn btn-primary btn-sm" >


							</tr>
							
							<tr id="correct" style="display:none;">
								<td class="col-lg-10">
								<!-- <td id="correct" style="display: none;"> -->
								<textarea style="resize:none;" name="comment" id="correct" class="form-control" rows="3"><?php echo $row['comment'];?></textarea>
								</td>
								<td class="col-lg-2">
								<input type="submit" value="등록하기" class="btn btn-primary btn-sm">
								</td>
							</tr>
							
							<?php
						}
						} else {}
						?>
					</tbody>
				</table>
			</form>


		</div>
		<?
		if($row['writer']==$_SESSION['_gamjachip_id']) {
		?>

		<div class="col-lg-2">
			<input type="button" class="btn btn-primary btn-sm" value="수정" onclick="location.href='qna_post.php?mode=correct&no=<?php echo $row['index']?>';"/>
			<input type="button" class="btn btn-primary btn-sm" value="삭제" onclick="deleteBoard();"/>

		</div>
		<div class="col-lg-9"></div>
		<div class="col-lg-1">
			<input type="button" class="btn btn-primary btn-sm" onclick="location.replace('board.php?type=QnA');" value="돌아가기" />

		</div>
		<?
		} else {
			?>
		<div class="col-lg-11"></div>
		<div class="col-lg-1">
			<input type="button" class="btn btn-primary btn-sm" onclick="location.replace('board.php?type=QnA');" value="돌아가기" />

		</div>
			<?
		}
		?>
		
	</div>
</div>



<script type="text/javascript" >
	function show(newItem) {
		var item = document.getElementById(newItem);
		if(item.style.display=='none') {
			item.style.display='block';
		} else {
			item.style.display='none';
		}
	}


	function deleteBoard() {
		var conf = confirm("정말로 게시글을 삭제하시겠습니까?");
		if(conf==true) {
			location.replace('qna_post_ok.php?no=<?php echo $row['index']?>&mode=delete');
		}
	}
</script>


</div>
<?php
include "_footer.php";
?>
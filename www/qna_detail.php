<?php
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `QnA` where `index`='{$index}'");
$row = $rst->fetch_assoc();

?>
	<div class="panel panel-default" >
		<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>

		<div class="col-md-12">
			<form class="form-horizontal" action="qna_post_ok.php" method="post" >
			<table class="table table-striped table-hover ">
				<thead>
				<tr><td></td></tr>
					<tr>
						<td class="col-lg-10"><strong>제목</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['title']; ?></td>
						<td class="col-lg-2"><strong>작성자</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['writer']; ?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2"><strong>내용</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['content']; ?></td>
					</tr>
					<?php
					if($row['comment']==null) {


					if($_SESSION['IDlevel']=='admin') {

						?>
						<tr>
						<th colspan="2">답변을 달아주세요.</th>
						</tr>
						
						<tr>
						<td class="col-lg-10"><input type="hidden" name="mode" value="reple">
						<textarea style="resize:none;" name="comment" class="form-control" id="comment" placeholder="답변을 달아주세요." rows="3"></textarea></td>
						<td class="col-lg-2"><input type="submit" value="댓글달기" class="btn btn-primary btn-sm" ></td>
						
						</tr>
						<?php
					} else {}

				} else {

					?>
					<tr>
						<td colspan="2"><strong>내용</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['comment']; ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			</form>


		</div>


	<div class="col-lg-2">
		<input type="button" class="btn btn-primary btn-sm" value="수정" onclick="location.href='qna_post.php?mode=correct&no=<?php echo $row['index']?>';"/>
		<input type="button" class="btn btn-primary btn-sm" value="삭제" onclick="deleteBoard();"/>

	</div>
	<div class="col-lg-9"></div>
	<div class="col-lg-1">
		<input type="button" class="btn btn-primary btn-sm" onclick="location.replace('board.php?type=QnA');" value="돌아가기" />
		
	</div>
	</div>
</div>


<script type="text/javascript" >
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
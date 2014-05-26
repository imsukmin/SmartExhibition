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

					<tr>
						<td class="col-lg-10"><strong>제목</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['title']; ?></td>
						<td class="col-lg-2"><strong>작성자</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['writer']; ?></td>
					</tr>
				</thead>
				<tbody>
					<input type="hidden" name="no" value="<?php echo $row['index'];?>">
					<input type="hidden" name="mode" value="reple">
					<tr>
						<td colspan="2"><strong>내용</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['content']; ?></td>
					</tr>
					<?php
					if($_SESSION['IDlevel']=='admin') {

						if($row['comment']==null)  {

							?>
							<tr>
								<th colspan="2">답변을 달아주세요.</th>
							</tr>

							<tr>
								<td class="col-lg-10">
									<textarea style="resize:none;" name="comment" class="form-control" id="comment" placeholder="답변을 달아주세요." rows="3"></textarea></td>
									<td class="col-lg-2"><input type="submit" value="댓글달기" class="btn btn-primary btn-sm" ></td>
								</tr>
								<?php
							

						} else {
							?>
							<input type="hidden" name="editmode" value="correct">
							<tr>
								<td class="col-lg-10"><strong>답변</strong>&nbsp;&nbsp;&nbsp;<?php echo $row['comment']; ?></td>
								<td class="col-lg-2"><input type="button" value="수정하기" onclick="show('correct');" class="btn btn-primary btn-sm" ></td>

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
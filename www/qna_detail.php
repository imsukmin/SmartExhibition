<?php
include "common.php";
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `QnA` where `index`='{$index}'");
$row = $rst->fetch_assoc();

?>
<div style="width:1000px; margin:20px auto;" class="container row">
	<div class="panel panel-default" >
		<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>

		<div class="col-md-12">
			<table class="table table-striped table-hover ">
				<thead>
				<tr><td></td></tr>
					<tr>
						<td class="col-lg-8"><strong>제목 </strong><?php echo $row['title']; ?></td>
						<td class="col-lg-2"><strong>작성자 </strong><?php echo $row['writer']; ?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2"><?php echo $row['content']; ?></td>
					</tr>
				</tbody>
			</table>


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

<script src="//code.jquery.com/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/respond.js"></script>
</body>
</html>
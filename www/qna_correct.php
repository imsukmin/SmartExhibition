<?php
include "common.php";
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `QnA` where `index`='{$index}'");
$row = $rst->fetch_assoc();

?>

<form action="qna_post_ok.php" method="post">
	<input type="hidden" name="mode" value="correct" />
	<input type="hidden" name="index" value="<?php echo $index;?>" />
	<input type="hidden" name="type" id="type" value="<?php echo $row['type'];?>" />
	<tr><td>제목</td><td><input type="text" name="title" id="title" value="<?php echo $row['title'];?>" required="required"  /></td></tr>
	<tr><td>작성자</td><td><input type="text" name="writer" id="writer" value="<?php echo $row['writer'];?>" required="required"  /></td></tr>
	<tr><td>작성일</td><td><input type="text" nme="date" id="date" value="<?php echo $row['date'];?>" required="required"  /></td></tr>
	<tr><td>내용</td><td><input type="text" name="content" id="content" value="<?php echo $row['content'];?>" required="required"  /></td></tr>
	<tr><td>답변</td><td><input type="text" name="comment" id="comment" value="<?php echo $row['comment'];?>" required="required"  /></td></tr>
	<tr><th>정말로 글 내용을 수정하시려면<br/>수정버튼을 눌러주세요.</th><th><input type="submit" value="수정" />
	<input type="button" onclick="location.replace('board.php?type=QnA');" value="취소" /></th></tr>
</form>


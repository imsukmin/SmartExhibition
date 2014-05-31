<?
include "common.php";

$id=$_GET['id'];
$query="select * from `Member` where id='$id'";
$result=$conn->query($query);
$cnt=$result->fetch_assoc();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">

function useID(v){
	opener.document.all.checkid.value=1;
	opener.document.all.id.value=v;
	window.close();
}

function chkId(){
	var id=document.all.id.value;
	if(id){
		url="idcheck.php?id="+id;
		location.href=url;
	}
	else{
		alert("ID를 입력하세요!");
	}
}
</script>
<? if($cnt){ ?>
	<?=$id?> 는 사용하실 수 없는 ID입니다 <br />
	<form>
		<input type=text name="id">
		<input type=button value="ID중복확인" onClick="chkId();">
	</form>
<?} else{ ?>
	<?=$id?>는 사용가능한 ID입니다.<br />
	<a href="#" onClick="useID('<?=$id?>');">사용하기</a> <a href="#" onClick="window.close();">닫기</a>
<?}?>
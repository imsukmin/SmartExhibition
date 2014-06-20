<?php
include "_header.php";

$index = $_GET['no'];
$rst = $conn->query("select * from `ExhibitionInfo`");
$row = $rst->fetch_assoc();
?>

<form class="form-horizontal" action="exhibitionInfo_post_ok.php" method="post" enctype='multipart/form-data'>

	<div class="panel panel-default" >
		<div class="panel-heading">전시회 정보 | 전시회 정보를 담고 있습니다.</div>
		<fieldset>
			<br/>
			<div class="form-group">
				<input type="hidden" name="mode" value="correct" />
				<label for="title" class="col-lg-2 control-label">전시회 이름</label>
				<div class="col-lg-10">
					<input type="text" name="title" class="form-control" id="title" value="<?php echo $row['title']?>"style="width:500px;" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="host" class="col-lg-2 control-label">전시회 주최</label>
				<div class="col-lg-10">
					<input type="text" name="host" class="form-control" id="host" value="<?php echo $row['host']?>" style="width:500px;" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="date" class="col-lg-2 control-label">날짜</label>
				<div class="col-lg-10">
					<input type="text" name="date" class="form-control" id="date" value="<?php echo $row['date']?>" style="width:500px;" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="place" class="col-lg-2 control-label">장소</label>
				<div class="col-lg-10">
					<input type="text" name="place" class="form-control" id="place" value="<?php echo $row['place']?>" style="width:500px;" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="summary" class="col-lg-2 control-label">전시회 개요</label>
				<div class="col-lg-10">
					<textarea style="resize:none;" name="summary" class="form-control" id="summary" rows="3" required="required"><?php echo $row['summary']?></textarea>
					<span class="help-block">전시회가 어떤 것을 보여주는지 쓰시오.</span>
				</div>
			</div>
			<div class="form-group">
				<label for="outline" class="col-lg-2 control-label">전시회 구성</label>
				<div class="col-lg-10">
					<textarea style="resize:none;"  name="outline" class="form-control" id="outline" rows="3" required="required"><?php echo $row['outline']?></textarea>
					<span class="help-block">전시회의 순서가 어떻게 되는지 쓰시오.</span>
				</div>
			</div>

			<div class="form-group">
				<label for="map" class="col-lg-2 control-label">전시회 구조</label>
				<div class="col-lg-10">
					<input type="hidden" name="map" value ="<?php echo $row['map'];?>"/>
					<input type="file"  name="map" id="map" value="파일 업로드" class="hide ie_show">

				</div>
				<div class="input-append ie_hide">
					<div class="col-lg-4">
						<input id="map-input" class="form-control" type="text" onclick="$('input[id=map]').click();">
					</div>

					<a class="btn btn-info btn-sm" onclick="$('input[id=map]').click();">파일 업로드 <span class="glyphicon glyphicon-upload"></span></a>
					<div class="col-lg-10">
						<span style="margin-left:165px;"class="help-block">파일형식을 .gif 또는 .png 또는 .jpg 또는 .jpeg 형식으로 올리시오.</span>
						<span style="margin-left:165px;" class="help-block">파일크기를 500KB 미만으로 올리시오.</span>
						<span style="margin-left:165px;" class="help-block">파일크기를 500*800 이내로 하시오.</span>	
					</div>
				</div>
			</div>


			<div class="form-group">
				<label for="Exhomepage" class="col-lg-2 control-label">홈페이지</label>
				<div class="col-lg-10">
					<input type="text" name="homepage" class="form-control" id="Exhomepage" value="<?php echo $row['homepage']?>" style="width:500px;" required="required">
				</div>
			</div>

			<hr style="border-top:2px solid #2c3e50;" size="80%">
			<div class="col-lg-5"></div>
			<div class="col-lg-2">
				<input type="submit" class="btn btn-primary btn-sm" value="등록">
			</div>
			<div class="col-lg-4"></div>
			<div class="col-lg-1">
				<input type="button" class="btn btn-primary btn-sm" onclick="location.href='board.php?type=ExhibitionInfo';" value="돌아가기" />
			</div>

		</fieldset>
	</div>
</form>

<script src="//code.jquery.com/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/respond.js"></script>
<script type="text/javascript">
	$('input[id=map]').change(function() {
		$('#map-input').val($(this).val().href="C:\\fakepath\\", ""));
});
</script>
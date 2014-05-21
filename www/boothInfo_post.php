<?php
include_once "_header.php";
?>

<form class="form-horizontal" action="boothInfo_post_ok.php" method="post" enctype='multipart/form-data'>

	<?php
	if($_GET['mode'] == 'new') {
		?>

		<div style="width:1000px; margin:20px auto;" class="container row">
			<div class="panel panel-default" >
				<div class="panel-heading">부스 관리 | 관리하고 싶은 부스를 등록하세요.</div>
				<fieldset>
				<br/>
					<div class="form-group">
						<input type="hidden" name="mode" value="new" />
						<input type="hidden" name="index" value="index" />
						<input type="hidden" name="type" value="BoothInfo"/> 
						<label for="teamName" class="col-lg-2 control-label">팀명</label>
						<div class="col-lg-10">
							<input type="text" name="teamName" class="form-control" id="teamName" placeholder="팀명" style="width:500px;" required="required">
						</div>
					</div>
					<div class="form-group">
						<label for="productName" class="col-lg-2 control-label">작품명</label>
						<div class="col-lg-10">
							<input type="text" name="productName" class="form-control" id="productName" placeholder="작품명" style="width:500px;" required="required">
						</div>
					</div>
					<div class="form-group">
						<label for="professor" class="col-lg-2 control-label">담당교수</label>
						<div class="col-lg-10">
							<input type="text" name="professor" class="form-control" id="professor" placeholder="담당교수" style="width:500px;" required="required">
						</div>
					</div>
					<div class="form-group">
						<label for="member" class="col-lg-2 control-label">팀원</label>
						<div class="col-lg-10">
							<input type="text" name="member" class="form-control" id="member" placeholder="팀원" style="width:500px;" required="required">
						</div>
					</div>
					<div class="form-group">
						<label for="outline" class="col-lg-2 control-label">프로젝트 개요</label>
						<div class="col-lg-10">
							<textarea style="resize:none;" name="outline" class="form-control" id="outline" placeholder="프로젝트 개요" rows="3" required="required"></textarea>
							<span class="help-block">프로젝트가 어떤 목적으로, 어떻게 사용되는지 쓰시오.</span>
						</div>
					</div>
					<div class="form-group">
						<label for="summary" class="col-lg-2 control-label">프로젝트 요약</label>
						<div class="col-lg-10">
							<textarea style="resize:none;"  name="summary" class="form-control" id="summary" placeholder="프로젝트 요약" rows="3" required="required"></textarea>
							<span class="help-block">개발도구, 개발언어 등에 대하여 쓰시오.</span>
						</div>
					</div>
					<div class="form-group">
						<label for="target" class="col-lg-2 control-label">타겟머신 및 운영체제</label>
						<div class="col-lg-10">
							<textarea style="resize:none;" name="target" class="form-control" id="target" placeholder="타겟머신 및 운영체제" rows="1" required="required"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="homepage" class="col-lg-2 control-label">홈페이지</label>
						<div class="col-lg-10">
							<input type="text" name="homepage" class="form-control" id="homepage" placeholder="홈페이지" style="width:500px;" required="required">
						</div>
					</div>

					<?php
					if($_SESSION['level']=='admin') {
						?>
						<div class="form-group">
							<label for="apLevel" class="col-lg-2 control-label">ApLevel</label>
							<div class="col-lg-4">
								<textarea style="resize:none;"  name="apLevel" class="form-control" id="apLevel" placeholder="ApLevel" rows="1" required="required"></textarea>

							</div>
							<label for="nfcTagId" class="col-lg-2 control-label">NfcTagID</label>
							<div class="col-lg-4">
								<textarea style="resize:none;"  name="nfcTagId" class="form-control" id="nfcTagId" placeholder="NFCTagID" rows="1" required="required"></textarea>

							</div>
						</div>
						<?php
					} else if($_SESSION['level']=='user') {

					}
					?>

					<div class="form-group">
						<label for="myFile" class="col-lg-2 control-label">브로셔 이미지</label>
						<div class="col-lg-10">
							<input type="file"  name="myFile" id="myFile" value="파일 업로드" class="hide ie_show">

						</div>
						<div class="input-append ie_hide">
							<div class="col-lg-4">
								<input id="pretty-input" class="form-control" type="text" onclick="$('input[id=myFile]').click();">
							</div>

							<a class="btn btn-info btn-sm" onclick="$('input[id=myFile]').click();">파일 업로드 <span class="glyphicon glyphicon-upload"></span></a>
							<div class="col-lg-10">
								<span style="margin-left:165px;"class="help-block">파일형식을 .gif 또는 .png 또는 .jpg 또는 .jpeg 형식으로 올리시오.</span>
								<span style="margin-left:165px;" class="help-block">파일크기를 500KB 미만으로 올리시오.</span>
								<span style="margin-left:165px;" class="help-block">파일크기를 500*800 이내로 하시오.</span>	
							</div>
						</div>
					</div>
					<hr style="border-top:2px solid #2c3e50;" size="80%">
					<div class="col-lg-5"></div>
					<div class="col-lg-2">
						<input type="submit" class="btn btn-primary btn-sm" name="send" id="send" value="등록">
					</div>
					<div class="col-lg-4"></div>
					<div class="col-lg-1">
						<input type="button" class="btn btn-primary btn-sm" onclick="location.href='board.php?type=BoothInfo';" value="돌아가기" />
					</div>





					<?php	
				}else if($_GET['mode'] == 'correct') {


					$index = $_GET['no'];
					$rst = $conn->query("select * from `BoothInfo` where `index`='{$index}'");
					$row = $rst->fetch_assoc();
					?>


					<div style="width:1000px; margin:20px auto;" class="container row">
					<div class="panel panel-default" >
					<div class="panel-heading">부스 관리 | 관리하고 싶은 부스를 등록하세요.</div>
				
						<fieldset>
						<br/>
							<div class="form-group">
								<input type="hidden" name="mode" value="correct" />
								<input type="hidden" name="brochure" value ="<?php echo $row['brochure'];?>"/>
								<input type="hidden" name="index" value="<?php echo $row['index'];?>" />
								<input type="hidden" name="type" value="BoothInfo"/> 
								<label for="teamName" class="col-lg-2 control-label">팀명</label>
								<div class="col-lg-10">
									<input type="text" name="teamName" class="form-control" id="teamName" value="<?php echo $row['teamName'];?>" style="width:500px;" required="required">
								</div>
							</div>
							<div class="form-group">
								<label for="productName" class="col-lg-2 control-label">작품명</label>
								<div class="col-lg-10">
									<input type="text" name="productName" class="form-control" id="productName" value="<?php echo $row['productName'];?>" style="width:500px;" required="required">
								</div>
							</div>
							<div class="form-group">
								<label for="professor" class="col-lg-2 control-label">담당교수</label>
								<div class="col-lg-10">
									<input type="text" name="professor" class="form-control" id="professor" value="<?php echo $row['professor'];?>" style="width:500px;" required="required">
								</div>
							</div>
							<div class="form-group">
								<label for="member" class="col-lg-2 control-label">팀원</label>
								<div class="col-lg-10">
									<input type="text" name="member" class="form-control" id="member" value="<?php echo $row['member'];?>" style="width:500px;" required="required">
								</div>
							</div>
							<div class="form-group">
								<label for="outline" class="col-lg-2 control-label">프로젝트 개요</label>
								<div class="col-lg-10">
									<textarea style="resize:none;" name="outline" class="form-control" id="outline" rows="3" required="required"><?php echo $row['outline'];?></textarea>
									<span class="help-block">프로젝트가 어떤 목적으로, 어떻게 사용되는지 쓰시오.</span>
								</div>
							</div>
							<div class="form-group">
								<label for="summary" class="col-lg-2 control-label">프로젝트 요약</label>
								<div class="col-lg-10">
									<textarea style="resize:none;"  name="summary" class="form-control" id="summary" rows="1" required="required"><?php echo $row['summary'];?></textarea>
									<span class="help-block">개발도구, 개발언어 등에 대하여 쓰시오.</span>
								</div>
							</div>
							<div class="form-group">
								<label for="target" class="col-lg-2 control-label">타겟머신 및 운영체제</label>
								<div class="col-lg-10">
									<textarea style="resize:none;" name="target" class="form-control" id="target" style="width:500px;" required="required"><?php echo $row['target'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="homepage" class="col-lg-2 control-label">홈페이지</label>
								<div class="col-lg-10">
									<input type="text" name="homepage" class="form-control" id="homepage" value="<?php echo $row['homepage'];?>" style="width:500px;" required="required">
								</div>
							</div>

							<?php
							if($_SESSION['level']=='admin') {
								?>
								<div class="form-group">
									<label for="apLevel" class="col-lg-2 control-label">ApLevel</label>
									<div class="col-lg-4">
										<textarea style="resize:none;"  name="apLevel" class="form-control" id="apLevel" placeholder="ApLevel" rows="1" required="required"><?php echo $row['apLevel'];?></textarea>

									</div>
									<label for="nfcTagId" class="col-lg-2 control-label">NfcTagID</label>
									<div class="col-lg-4">
										<textarea style="resize:none;"  name="nfcTagId" class="form-control" id="nfcTagId" placeholder="NFCTagID" rows="1" required="required"><?php echo $row['nfcTagId'];?></textarea>

									</div>
								</div>
								<?php
							} else if($_SESSION['level']=='user') {

							}
							?>

							<div class="form-group">
								<label for="myFile" class="col-lg-2 control-label">브로셔 이미지</label>
								<div class="col-lg-10">
									<input type="file"  name="myFile" id="myFile" value="파일 업로드" class="hide ie_show">

								</div>
								<div class="input-append ie_hide">
									<div class="col-lg-4">
										<input id="pretty-input" class="form-control" type="text" onclick="$('input[id=myFile]').click();">
									</div>

									<a class="btn btn-info btn-sm" onclick="$('input[id=myFile]').click();">파일 업로드 <span class="glyphicon glyphicon-upload"></span></a>
									<div class="col-lg-10">
										<span style="margin-left:165px;"class="help-block">파일형식을 .gif 또는 .png 또는 .jpg 또는 .jpeg 형식으로 올리시오.</span>
										<span style="margin-left:165px;" class="help-block">파일크기를 500KB 미만으로 올리시오.</span>
										<span style="margin-left:165px;" class="help-block">파일크기를 500*800 이내로 하시오.</span>	
									</div>
								</div>
							</div>
							<hr style="border-top:2px solid #2c3e50;" size="80%">
							<div class="col-lg-5"></div>
							<div class="col-lg-2">
								<input type="submit" class="btn btn-primary btn-sm" name="send" id="send" value="등록">
							</div>
							<div class="col-lg-4"></div>
							<div class="col-lg-1">
								<input type="button" class="btn btn-primary btn-sm" onclick="location.replace('boothInfo_detail.php?no=<?php echo $row['index']?>');" value="돌아가기" />
							</div>

							<?php
						}?>

						<script src="//code.jquery.com/jquery.js"></script>
						<script src="bootstrap/js/bootstrap.min.js"></script>
						<script src="js/respond.js"></script>
						<script type="text/javascript">
							$('input[id=myFile]').change(function() {
								$('#pretty-input').val($(this).val().replace("C:\\fakepath\\", ""));
							});
						</script>
					</fieldset>
				</div>
			</div>
		</form>

	</div>
</body>
</html>
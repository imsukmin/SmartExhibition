<?php
include "_header.php";
?>
<form class="form-horizontal" action="qna_post_ok.php" method="post" enctype='multipart/form-data'>

	<?php
	if($_GET['mode'] == 'new') {
		?>

			<div class="panel panel-default" >
				<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>
				<fieldset>
					<br/>
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="form-group">
							<input type="hidden" name="mode" value="new" />
							<input type="hidden" name="index" value="index" />
							<input type="hidden" name="type" value="QnA"/> 
							<!-- <input type="hidden" name="hits" value="hits"/>  -->
							<input type="hidden" name="date" value=""/>
							<input type="hidden" name="mode" value="new" />

							<label class="control-label" for="title">글제목</label>
							<input class="form-control input-sm" type="text" name="title" id="title" placeholder="글제목" required="required">
						</div>
						<div class="form-group">
							<label class="control-label" for="writer">글쓴이</label>
							<input class="form-control input-sm" type="text" name="writer" id="writer" placeholder="글쓴이" value="<?php echo $_SESSION['_gamjachip_id']?>" readonly="readonly">
						</div>
						<div class="form-group">
							<label class="control-label" for="content">내용</label>
							<textarea style="resize:none;" class="form-control input-sm" rows="7" name="content" id="content" placeholder="내용" required="required"></textarea>
						</div>

						<hr style="border-top:2px solid #2c3e50;" size="100%">
						<div class="col-lg-5"></div>
						<div class="col-lg-2">
							<input type="submit"  class="btn btn-primary btn-sm" value="등록" />
						</div>
						<div class="col-lg-4">
						</div>
						<div class="col-lg-1">
							<input type="button" class="btn btn-primary btn-sm" onclick="location.href='board.php?type=QnA';" value="돌아가기" />
						</div>
					</div>
				</div>
				</fieldset>
				</div>
				
				<?php	

			}else if($_GET['mode'] == 'correct') {


				$index = $_GET['no'];
				$rst = $conn->query("select * from `QnA` where `index`='{$index}'");
				$row = $rst->fetch_assoc();
				?>

					<div class="panel panel-default" >
						<div class="panel-heading">질의응답 | 질문이 있으면 올려주세요.</div>
						<fieldset>
							<br/>
							<div class="col-lg-1"></div>
							<div class="col-lg-10">
								<div class="form-group">
									<input type="hidden" name="mode" value="correct" />
									<input type="hidden" name="index" value="<?php echo $row['index'];?>" />
									<input type="hidden" name="type" value="QnA"/> 
									<input type="hidden" name="hits" value="hits"/> 
									<input type="hidden" name="date" value=""/>

									<label class="control-label" for="title">글제목</label>
									<input class="form-control input-sm" type="text" name="title" id="title" value="<?php echo $row['title'];?>"  required="required">
								</div>
								<div class="form-group">
									<label class="control-label" for="writer">글쓴이</label>
									<input class="form-control input-sm" type="text" name="writer" id="writer" value="<?php echo $_SESSION['_gamjachip_id']?>" readonly="readonly" required="required">
								</div>
								<div class="form-group">
									<label class="control-label" for="content">내용</label>
									<textarea style="resize:none;" class="form-control input-sm" rows="7" name="content" id="content" required="required"><?php echo $row['content'];?></textarea>
								</div>

								<hr style="border-top:2px solid #2c3e50;" size="100%">
								<div class="col-lg-5"></div>
								<div class="col-lg-2">
									<input type="submit"  class="btn btn-primary btn-sm" value="등록" />
								</div>
								<div class="col-lg-4">
								</div>
								<div class="col-lg-1">
									<input type="button" class="btn btn-primary btn-sm" onclick="location.href='qna_detail.php?no=<?php echo $row['index'];?>';" value="돌아가기" />
								</div>
							</p>
						</div>
					</div>



				</fieldset>
			</div>
		
	</form>
	</div>

	<?php

}
include "_footer.php"
?>


<?php
include "common.php";
?>

<!DOCTYPE html5>
<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link href="bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" media="screen" title="no title" charset="utf-8"/>
</head>
<body>

	<form class="form-horizontal" action="memberJoin_ok.php" method="post">
		<div style="width:1000px; margin:20px auto;" class="container row">

			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<div class="form-group">
					<input type="hidden" name="mode" value="new" />
					<label class="control-label" for="id">ID</label>
					<input class="form-control input-sm" type="text" name="id" id="id" placeholder="ID" required="required">
				</div>
				<div class="form-group">
					<label class="control-label" for="password">PW</label>
					<input class="form-control input-sm" type="password" name="password" id="password" placeholder="PW" required="required">
					<span class="help-block">영문, 숫자 포함 3~16 문자.</span>
				</div>
				<div class="form-group">
					<label class="control-label" for="name">Name</label>
					<input class="form-control input-sm" type="text" name="name" id="name" placeholder="Name" required="required">
				</div>
				<div class="form-group">
					<label class="control-label" for="teamName">TeamName</label>
					<select class="form-control" id="teamName" name="teamName" onchange="insertInput(this.value)">

						<option value="">::선택하세요::</option>
						<option value="etc">직접입력</option>
						<?php
						$rst= $conn->query("select * from `BoothInfo`");
						while($row = $rst->fetch_assoc()){		
							?>
							<option value="<?php echo $row['teamName']?>"><?php echo $row['teamName']?></option>
							<?php
						}
						?>
					</select>
					</select>
					<input class="form-control input-sm"  type="text" name="teamName" ID="input" placeholder="내용을 넣어주세요.">

				</div>
				<div class="form-group">
					<label class="control-label" for="email">E-Mail</label>
					<input class="form-control input-sm" type="text" name="email" id="email" placeholder="E-Mail" required="required">
				</div>
				<div class="form-group">
					<label class="control-label" for="phone">Cell Phone</label>
					<input class="form-control input-sm" type="text" name="phone" id="phone" placeholder="Cell Phone" required="required">
					<span class="help-block">예) 01012345678</span>
				</div>

				<div class="form-actions">
					<p align="center">
						<input type="submit"  class="btn btn-primary btn-sm" value="가입" />
						<input type="button" class="btn btn-primary btn-sm" onclick="location.href='login.php';" value="돌아가기" /></th></tr>
					</p>
				</div>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</form>

	<script type="text/javascript">
		function insertInput(str) {
			if (str != "etc") {
				document.getElementById("input").value = str;
				document.getElementById("input").readOnly = true;
				document.getElementById("input").style.background = "#DFDFDF";
			} else {
				document.getElementById("input").value = "";
				document.getElementById("input").readOnly = false;
				document.getElementById("input").style.background = "#FFFFFF";
				document.getElementById("input").focus();
			}
		} 
	</script>

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
// <![CDATA[
jQuery( function($) {

	// 정규식을 변수에 할당
	// 변수 이름을 're_'로 정한것은 'Reguar Expression'의 머릿글자
	var re_id = /^[a-z0-9]{3,16}$/; // 아이디 검사식
	var re_pw = /^[a-z0-9]{6,18}$/; // 비밀번호 검사식
	var re_mail = /^([\w\.-]+)@([a-z\d\.-]+)\.([a-z\.]{2,6})$/; // 이메일 검사식
	var re_tel = /^[0-9]{8,11}$/; // 전화번호 검사식
	
	// 선택할 요소를 변수에 할당
	// 쉼표를 이용해서 여러 변수를 한 번에 선언할 수 있다
	var 
	form = $('form'), 
	id = $('#id'), 
	pw = $('#password'), 
	email = $('#email'), 
	tel = $('#phone');

	// 선택한 form에 서밋 이벤트가 발생하면 실행한다
	// if (사용자 입력 값이 정규식 검사에 의해 참이 아니면) {포함한 코드를 실행}
	// if 조건절 안의 '정규식.test(검사할값)' 형식은 true 또는 false를 반환한다
	// if 조건절 안의 검사 결과가 '!= true' 참이 아니면 {...} 실행
	// 사용자 입력 값이 참이 아니면 alert을 띄운다
	// 사용자 입력 값이 참이 아니면 오류가 발생한 input으로 포커스를 보낸다
	// 사용자 입력 값이 참이 아니면 form 서밋을 중단한다
	form.submit( function() {
		if (re_id.test(id.val()) != true) { // 아이디 검사
			alert('[ID 입력 오류] 유효한 ID를 입력해 주세요.');
			id.focus();
			return false;
		} else if(re_pw.test(pw.val()) != true) { // 비밀번호 검사
			alert('[PW 입력 오류] 유효한 PW를 입력해 주세요.');
			pw.focus();
			return false;
		} else if(re_mail.test(email.val()) != true) { // 이메일 검사
			alert('[Email 입력 오류] 유효한 이메일 주소를 입력해 주세요.');
			email.focus();
			return false;
		} else if(re_tel.test(tel.val()) != true) { // 전화번호 검사
			alert('[Tel 입력 오류] 유효한 전화번호를 입력해 주세요.');
			tel.focus();
			return false;
		}
	});
	
	// #id, #pw 인풋에 입력된 값의 길이가 적당한지 알려주려고 한다
	// #id, #pw 다음 순서에 경고 텍스트 출력을 위한 빈 strong 요소를 추가한다
	$('#id, #password').after('<strong></strong>');
	
	// #uid 인풋에서 onkeyup 이벤트가 발생하면
	id.keyup( function() {
		var s = $(this).next('strong'); // strong 요소를 변수에 할당
		if (id.val().length == 0) { // 입력 값이 없을 때
			s.text(''); // strong 요소에 포함된 문자 지움
		} else if (id.val().length < 3) { // 입력 값이 3보다 작을 때
			s.text('[너무 짧아요.] '); // strong 요소에 문자 출력
		} else if (id.val().length > 16) { // 입력 값이 16보다 클 때
			s.text('[너무 길어요.] '); // strong 요소에 문자 출력
		} else { // 입력 값이 3 이상 16 이하일 때
			s.text('[적당해요.] '); // strong 요소에 문자 출력
		}
	});
	
	// #upw 인풋에서 onkeyup 이벤트가 발생하면
	pw.keyup( function() {
		var s = $(this).next('strong'); // strong 요소를 변수에 할당
		if (pw.val().length == 0) { // 입력 값이 없을 때
			s.text(''); // strong 요소에 포함된 문자 지움
		} else if (pw.val().length < 6) { // 입력 값이 6보다 작을 때
			s.text('[너무 짧아요.] '); // strong 요소에 문자 출력
		} else if (pw.val().length > 18) { // 입력 값이 18보다 클 때
			s.text('[너무 길어요.] '); // strong 요소에 문자 출력
		} else { // 입력 값이 6 이상 18 이하일 때
			s.text('[적당해요.] '); // strong 요소에 문자 출력
		}
	});
	
	// #tel 인풋에 onkeydown 이벤트가 발생하면
	// 하이픈(-) 키가 눌렸는지 확인
	// 하이픈(-) 키가 눌렸다면 입력 중단
	tel.keydown( function() {
		if(event.keyCode==109 || event.keyCode==189) {
			return false;
		}
	});
});

</script>


<?php
include "_footer.php";
?>
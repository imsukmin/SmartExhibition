<?php
include "common.php";

$index = $_POST['index'];
$mode = $_POST['mode'];
foreach($_POST as $key => $value) {
	$$key = $value;
}

$map = $conn->real_escape_string($map);

$oldPath = $map;
$save_dir = "upload/";
$isError=null;
if($mode == 'correct') {
	if( $_FILES["map"]["size"] == 0 )
	{
   // echo "업로드한 파일명 : ".$_FILES["map"]["name"] ."<br />";
   // echo "업로드한 파일의 크기 : ".$_FILES["map"]["size"] ."<br />";
   // echo "업로드한 파일의 MIME Type : ".$_FILES["map"]["type"] ."<br />";
   // echo "임시 디렉토리에 저장된 파일명 : ".$_FILES["map"]["tmp_name"]."<br />";



		$map = $oldPath;

	}
	else {
		$map = $save_dir . $_FILES["map"]["name"];

    // echo "파일이 업로드되었을 때, mapination은 $map";

		if($_FILES["map"]["error"]>0) {
			$isError = "'파일을 지정한 디렉토리에 저장하는데 실패했습니다.'";
		} else if(    ($_FILES["map"]["type"] != "image/gif") &&
			($_FILES["map"]["type"] !=  "image/png") &&
			($_FILES["map"]["type"] !=  "image/jpg") &&
			($_FILES["map"]["type"] != "image/jpeg") ) {
			$isError = "'파일형식을 .gif 또는 .png 또는 .jpg 또는 .jpeg 형식으로 올리시오.'";
		}  else if($_FILES["map"]["size"]>512000) {
			$isError = "'파일크기를 500KB 미만으로 올리시오.'";
		} else {
			$sizeInfo = getimagesize($_FILES["map"]["tmp_name"]);

			if($sizeInfo[0]>500 || $sizeInfo[1]>800) { 
				$isError="'파일크기를 500*800 이내로 하시오.'";
			} else {

				move_uploaded_file($_FILES["map"]["tmp_name"], $map);
			}
		}
	}
// echo $isError;
	if($isError ==null) {
		echo '<script> alert("사진을 성공적으로 업로드하였습니다.");</script>';
	}else {
		?> 
		<script> 
			var string = <?php echo $isError; ?>;
			alert(string);  
			history.back();
		</script>
		<?php
	}
}

if($mode =='correct'){

	$query = "update `ExhibitionInfo` set 
	`title`= '$title', 
	`host`='$host', 
	`date`='$date', 
	`place`='$place',
	`summary`= '$summary',
	`outline`='$outline', 
	`map`='$map', 
	`homepage`='$homepage'

	";
}


$conn->query($query); // query문 전송!
echo "<script>location.href='board.php?type=ExhibitionInfo';</script>";
?>
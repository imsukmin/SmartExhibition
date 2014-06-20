
<?php
include "common.php";

$index = $_POST['index'];
$mode = $_GET['mode'];
foreach($_POST as $key => $value) {
  $$key = $value;
}
// print_r($_POST);
// print_r($_GET);
// print($mode);
// print_r($_FILES);
// Correct Spceial character
$teamName = $conn->real_escape_string($teamName);
$productName = $conn->real_escape_string($productName);
$professor = $conn->real_escape_string($professor);
$member = $conn->real_escape_string($member);
$outline = $conn->real_escape_string($outline);
$target = $conn->real_escape_string($target);
$homepage = $conn->real_escape_string($homepage);
$brochure = $conn->real_escape_string($brochure);
$nfcTagId = $conn->real_escape_string($nfcTagId);
$apLevel = $conn->real_escape_string($apLevel);
$summary = $conn->real_escape_string($summary);


$type = $conn->real_escape_string($type);
$oldPath = $brochure;
$save_dir = "upload/";
$isError=null;
if($mode == 'new' || $mode == 'correct') {
if( $_FILES["myFile"]["size"] == 0 )
{
   // echo "업로드한 파일명 : ".$_FILES["myFile"]["name"] ."<br />";
   // echo "업로드한 파일의 크기 : ".$_FILES["myFile"]["size"] ."<br />";
   // echo "업로드한 파일의 MIME Type : ".$_FILES["myFile"]["type"] ."<br />";
   // echo "임시 디렉토리에 저장된 파일명 : ".$_FILES["myFile"]["tmp_name"]."<br />";



      $dest = $oldPath;

}
else {
    $dest = $save_dir . $_FILES["myFile"]["name"];
    $sizeInfo = getimagesize($_FILES["myFile"]["tmp_name"]);
    // echo "파일이 업로드되었을 때, destination은 $dest";

    if($_FILES["myFile"]["error"]>0) {
    $isError = "'파일을 지정한 디렉토리에 저장하는데 실패했습니다.'";
    } else if(    ($_FILES["myFile"]["type"] != "image/gif") &&
                     ($_FILES["myFile"]["type"] !=  "image/png") &&
                     ($_FILES["myFile"]["type"] !=  "image/jpg") &&
                     ($_FILES["myFile"]["type"] != "image/jpeg") ) {
      $isError = "'파일형식을 .gif 또는 .png 또는 .jpg 또는 .jpeg 형식으로 올리시오.'";
    }  else if($_FILES["myFile"]["size"]>512000) {
      $isError = "'파일크기를 500KB 미만으로 올리시오.'";
    } else if($sizeInfo[0]>500 || $sizeInfo[1]>800){
        
               $isError="'파일크기를 500*800 이내로 하시오.'";
     } else {
              $isError="success";
              move_uploaded_file($_FILES["myFile"]["tmp_name"], $dest);

     }
      
}
// echo $isError;
if($isError =='success') {
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
if($mode=='new'){

$query = "insert into BoothInfo (`teamName`,`productName`,`professor`,`member`,`outline`,`target`,`homepage`,`brochure`,`nfcTagId`,`apLevel`,`summary`)
values ( '$teamName','$productName', '$professor',  '$member', '$outline', '$target', '$homepage', '$dest', '$nfcTagId', '$apLevel', '$summary');";

}


else if($mode =='correct'){

$query = "update `BoothInfo` set 
`teamName`= '$teamName', 
`productName`='$productName', 
`professor`='$professor', 
`member`='$member',
`outline`= '$outline',
`target`='$target', 
`homepage`='$homepage', 
`brochure`='$dest', 
`nfcTagId`='$nfcTagId',
`apLevel`='$apLevel', 
`summary`='$summary'


where `index`='$index';";
}
else if($mode =='delete'){
  $index = $_GET['no'];
  $query = "delete from `BoothInfo` where `index`='$index';";
}
// else if($mode == 'guest'){
//     $query = "insert into QnA (`title`,`writer`,`date`,`content`,`comment`,`hits`)
//     values ( '$title','$writer', '$date',  '$content', '$comment', '$hits');";
// }
// echo $query;
// echo $dest;
// echo $_FILES["myFile"]["name"];
$conn->query($query); // query문 전송!
echo "<script>location.href='board.php?type=BoothInfo';</script>";
// echo "<script>location.replace('qna_detail.php?no=" + $index + "');</script>";
// else {             echo "<script>location.replace('admin_main.php?mode=board');</script>"; }
?>
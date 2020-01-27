<?php
session_start();
include_once("../include/config.php");

if(empty($_SESSION['ent_email']) || empty($_SESSION['ent_pass'])){
	$api->go("login.php");
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ระบบการตัดสินใจการจับคู่และคัดกรองตำแหน่งงานของผู้หางานในจังหวัดนครสวรรค์ สำหรับผู้ประกอบการ</title>
<link href="style/main.css" rel="stylesheet" type="text/css">
<link href="style/menu.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="../js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<!-- jQuery -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- MenuMaker Plugin -->
<script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
   <script src="script.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body><?php include_once("header_menu.php"); ?>
	<div class="content">
		<div style="width: 100%; align-content: center;">
		<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ลำดับ</th>
      <th scope="col">ชื่อผู้สมัคร</th>
      <th scope="col">สถานะ</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $c = 1;
	  $apply_sql = $sql->prepare("SELECT  ApplyJob.status, Student.stu_id, Student.stu_firstname, Student.stu_lastname, ApplyJob.app_id FROM ApplyJob INNER JOIN Student ON Student.stu_id = ApplyJob.stu_id WHERE ApplyJob.ann_id = :p1 ORDER BY ApplyJob.status ASC");
	  $apply_sql->BindParam(":p1",$_GET['id']);
	  $apply_sql->execute();
	  while($apply = $apply_sql->fetch(PDO::FETCH_ASSOC)){
		  echo '
	  <tr>
      <th scope="row">'.$c++.'</th>
      <td>'.$apply['stu_firstname'].' '.$apply['stu_lastname'].'</td>
      <td>'.$api->ApplyStatus($apply['status']).'</td>
	  <td><a href="stuinfo.php?id='.$apply['app_id'].'&work='.$_GET['id'].'">ดูรายละเอียดผู้สมัคร</a></td>
    </tr>';
	  }
	  ?>
	  
  </tbody>
</table>
		</div>
	</div>

<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
	
</body>
</html>
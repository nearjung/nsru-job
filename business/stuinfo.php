<?php
session_start();
include_once("../include/config.php");

if(empty($_SESSION['ent_email']) || empty($_SESSION['ent_pass'])){
	$api->go("login.php");
	exit();
}

// Student
$student_sql = $sql->prepare("SELECT Student.*, Faculty.*, Branch.*, ApplyJob.stu_id as StudentID FROM ApplyJob INNER JOIN Student ON Student.stu_id = ApplyJob.stu_id  INNER JOIN Faculty ON Faculty.faculty_id = Student.stu_faculty INNER JOIN Branch ON Branch.branch_id = Student.stu_branch WHERE ApplyJob.app_id = :p1");
$student_sql->BindParam(":p1",$_GET['id']);
$student_sql->execute();
$student = $student_sql->fetch(PDO::FETCH_ASSOC);

// Apply Information
$apply_sql = $sql->prepare("SELECT ApplyJob.*, Portfolio.port_file FROM ApplyJob INNER JOIN Portfolio ON Portfolio.port_id = ApplyJob.port_id WHERE ApplyJob.ann_id = :p1 AND ApplyJob.stu_id = :p2");
$apply_sql->BindParam(":p1",$_GET['work']);
$apply_sql->BindParam(":p2",$student['stu_id']);
$apply_sql->execute();
$apply = $apply_sql->fetch(PDO::FETCH_ASSOC);

// Update Status
$num1 = 1;
$status_sql = $sql->prepare("UPDATE ApplyJob SET status = :p1 WHERE stu_id = :p2 AND ann_id = :p3");
$status_sql->BindParam(":p1",$num1);
$status_sql->BindParam(":p2",$student['StudentID']);
$status_sql->BindParam(":p3",$_GET['work']);
$status_sql->execute();
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
		  <table width="100%">
		    <tbody>
		      <tr>
		        <td width="35%" align="right" valign="top"><img style="border-style:groove;" src="../student/avatar/<?php echo $student['stu_picture']; ?>"  width="135" height="135" class="rounded"><br>
		        <a target="_blank" href="../student/pdf/<?php echo $apply['port_file']; ?>">&lt;&lt; คลิ๊กเพื่อดู Resume &gt;&gt;</a></td>
		        <td width="65%" valign="top"><div style="margin-left: 10px;"><strong>ชื่อ-นามสกุล :</strong> <?php echo $student['stu_firstname']; ?> <?php echo $student['stu_lastname']; ?><br>
		        <strong>รหัสนักศึกษา :</strong> <?php echo $student['stu_number']; ?><br>
		        <strong>อีเมล :</strong> <?php echo $student['stu_email']; ?><br>
		        <strong>เบอร์โทรศัพท์ :</strong> <?php echo $student['stu_telephone']; ?><br>
		        <strong>รหัสบัตรประชาชน :</strong> <?php echo substr($student['stu_idcode'],0,9); ?>xxxx
		        <br>
		        <strong>ที่อยู่ :</strong> <?php echo $student['stu_address']; ?><br>
		        <strong>วันเกิด :</strong> <?php echo $student['stu_birthday']; ?><br>
		        <strong>คณะ :</strong> <?php echo $student['faculty_name']; ?><br>
		        <strong>สาขา :</strong> <?php echo $student['branch_name']; ?><br></div></td>
	          </tr>
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
<?php
session_start();
include_once("../include/config.php");

if(empty($_SESSION['ent_email']) || empty($_SESSION['ent_pass'])){
	$api->go("login.php");
	exit();
}

// GET Enterprise Information
$ent_sql = $sql->prepare("SELECT * FROM Enterprise WHERE ent_email = :p1 AND ent_pass = :p2");
$ent_sql->BindParam(":p1",$_SESSION['ent_email']);
$ent_sql->BindParam(":p2",$_SESSION['ent_pass']);
$ent_sql->execute();
$ent = $ent_sql->fetch();
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
    <div class="row">
      <div class="col-xl">
        <fieldset>
          <legend>แก้ไขข้อมูลบริษัท</legend>
          <hr>
          <form class="was-validated" name="editenterprise" action="" method="post">
            <div class="row">
              <div class="col">
              <div class="form-group">
              <label for="ent_name">ชื่อบริษัท</label>
                <input value="<?php echo $ent['ent_name']; ?>" class="form-control is-invalid" type="text" name="ent_name" placeholder="ชื่อบริษัท" required>
              </div>
              </div>
              <div class="col">
              <div class="form-group">
              <label for="ent_office_branch">สาขาบริษัท</label>
                <input value="<?php echo $ent['ent_office_branch']; ?>" class="form-control is-invalid" type="text" name="ent_office_branch" placeholder="สาขาบริษัท" required>
              </div>
              </div>
              <div class="col">
              <div class="form-group">
              <label for="ent_telephone">เบอร์โทรศัพท์ติดต่อ</label>
                <input value="<?php echo $ent['ent_telephone']; ?>" class="form-control is-invalid" type="tel" name="ent_telephone" placeholder="เบอร์โทรศัพท์ติดต่อ" required>
              </div>
              </div>
            </div>
              <div class="row">
                <div class="col">
                <div class="form-group">
                <label for="ent_address">ที่อยู่บริษัท</label>
                <textarea class="form-control is-invalid" name="ent_address" placeholder="ที่อยู่บริษัท" class="form-control" required><?php echo $ent['ent_address']; ?></textarea>
                </div>
              </div>
            </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                  <label for="ent_taxid">หมายเลขผู้เสียภาษี</label>
                    <input value="<?php echo $ent['ent_taxid']; ?>" class="form-control is-invalid" name="ent_taxid" placeholder="หมายเลขผู้เสียภาษี" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                  <label for="ent_coordinator">ชื่อผู้ติดต่อ</label>
                    <input value="<?php echo $ent['ent_coordinator']; ?>" class="form-control is-invalid" name="ent_coordinator" placeholder="ชื่อผู้ติดต่อ" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="custom-file">
                    <input type="file" name="files" class="custom-file-input" id="validatedCustomFile" required>
                    <label class="custom-file-label" for="validatedCustomFile">เลือกรูปภาพ...</label>
                    <div class="invalid-feedback">รูปภาพโลโก้บริษัท รองรับไฟล์ jpg ขนาดไม่เกิน 512kb</div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                    <img width="130px" src="../image/Logo/<?php echo $ent['ent_logo']; ?>" class="img-thumbnail">
                  </div>
                </div>
              <div class="row">
                <div class="col">
                <button type="submit" name="submit" class="btn btn-success btn-lg btn-block">แก้ไขข้อมูลบริษัท</button>
                </div>
              </div>
          </form>
          <?php
            if(isset($_POST['submit'])){
              if(empty($_POST['ent_name']) || empty($_POST['ent_address']) || empty($_POST['ent_taxid']) || empty($_POST['ent_office_branch'])
              || empty($_POST['ent_coordinator']) || empty($_POST['ent_telephone'])){
                $api->popup("กรุณากรอกข้อมูลให้ครบทุกช่อง");
              } else {
                if(is_uploaded_file($_FILES['files']['tmp_name'])){
                  $array = explode('.', $_FILES['files']['name']);
                  $ext = end($array);
                  if($_FILES['files']['size'] > 512000){
                    $api->popup("ขนาดไฟล์ต้องไม่เกิน 512kb");
                  } else if($ext != "jpg"){
                    $api->popup("ไฟล์รูปภาพต้องมีนามสกุล jpg เท่านั้น");
                  } else {
                      $time = time();
                      $filename = "".strtoupper(substr(md5($time),0,12)."-".md5($_FILES["files"]["name"]).".jpg");
                      move_uploaded_file($_FILES["files"]["tmp_name"],"../image/Logo/".$filename."");
                  }
                } else {
                  $filename = $ent['ent_logo'];
                }
                
                $update = $sql->prepare("EXEC dbo.UpdateEnterprise :p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8");
                $update->BindParam(":p1",$ent['ent_id']);
                $update->BindParam(":p2",$_POST['ent_name']);
                $update->BindParam(":p3",$_POST['ent_address']);
                $update->BindParam(":p4",$_POST['ent_taxid']);
                $update->BindParam(":p5",$_POST['ent_office_branch']);
                $update->BindParam(":p6",$_POST['ent_coordinator']);
                $update->BindParam(":p7",$_POST['ent_telephone']);
                $update->BindParam(":p8",$filename);
                $update->execute();
                if(!$update){
                  $api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
                } else {
                  $api->popup("บันทึกข้อมูลสำเร็จ");
                  $api->go("editbusiness.php");
                }
            }
          }
          ?>
      </fieldset></div>
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
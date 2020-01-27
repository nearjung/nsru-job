<?php
session_start();
include_once("../include/config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="tis620">
<title>Sign In with NSRU Account</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="../js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
</head>
<style>
	
body{
	background-color: rgb(43,62,80);
	background-image: url(../../image/bg02-02.jpg);
	background-repeat:no-repeat;
	background-position:top;
}
	</style>
<body>
	<div id="wrapper">

<div id="div_center_login">
	<div style="color: #FFF;"><center>
	  <div style="font-size: 32px; "><strong>Business Account</strong></div>
<div style="font-size: 25px; font-weight: lighter;">For business only</div>
<div style="font-size: 15px; font-weight: lighter; margin-bottom: 20px;"><strong>Sign in to Continue to <a href="#" style="color:rgb(26,188,156)" data-toggle="tooltip" title="ระบบจัดหางาน มหาวิทยาลัยราชภัฏนครสวรรค์">"NSRU JOB"</a></strong></div>
		<div id="div_login">
		  <div style="width: 310px; margin: 10px auto;">
			<p><form method="post" action="" enctype="multipart/form-data">
				<hr>
				<div class="input-group mb-2 mr-sm-2">
					<input name="name" type="text" class="form-control" placeholder="ชื่อบริษัท">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<textarea name="address" class="form-control" placeholder="ที่อยู่บริษัท"></textarea>
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="taxid" type="text" class="form-control" placeholder="หมายเลขผู้เสียภาษี">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="office" type="text" class="form-control" placeholder="สาขาบริษัท">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="coordinator" type="text" class="form-control" placeholder="ชื่อผู้ประสานงาน">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="telephone" type="text" class="form-control" placeholder="เบอร์โทรศัพท์ติดต่อ">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
 					<font color="#000000" size="-1"><input name="file" class="form-control-file" data-browse="เลือกโลโก้" type="file">[เลือกโลโก้บริษัท รองรับไฟล์ jpg ขนาดไม่เกิน 512kb]</font>
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="email" type="email" class="form-control" placeholder="อีเมล">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="password" type="password" class="form-control" placeholder="รหัสผ่าน">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
					<input name="repassword" type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน">
				</div>
			  
				<div class="input-group mb-2 mr-sm-2">
				  <button type="submit" name="submit" class="btn btn-info" style="width: 100%; margin-bottom: 5px;">Sign up</button>
				</div>
			  <div style="color:#333333; font-size: 12px;"><a href="login.php">Login</a> | <a href="forgotpass.php">Forgot password ?</a></div>&nbsp;
			  </form></p>
				<?php
				if(isset($_POST['submit'])){
					$array = explode('.', $_FILES['file']['name']);
					$ext = end($array);
					// Chk
					$chk_sql = $sql->prepare("SELECT ent_email FROM Enterprise WHERE ent_email = :p1");
					$chk_sql->BindParam(":p1",$_POST['email']);
					$chk_sql->execute();
					$chk = $chk_sql->fetch(PDO::FETCH_ASSOC);
					if(!$chk){
						if(empty($_POST['name']) || empty($_POST['address']) || empty($_POST['taxid']) || empty($_POST['office']) || empty($_POST['coordinator']) || empty($_POST['telephone']) || empty($_POST['email']) || empty($_POST['password'])){
							$api->popup("กรุณากรอกข้อมูลให้ครบทุกช่อง");
						} else if($_POST['password'] != $_POST['repassword']){
							$api->popup("กรุณากรอกรหัสผ่านให้ตรงกันค่ะ");
						} else if(!is_uploaded_file($_FILES['file']['tmp_name'])){
							$api->popup("กรุณาเลือกรูปโลโก้บริษัทด้วยค่ะ");
						} else if($_FILES['file']['size'] > 512000) {
							$api->popup("ขนาดไฟล์โลโก้ต้องไม่เกิน 512kb");
						} else if($ext != "jpg"){
							$api->popup("ไฟล์รูปภาพต้องมีนามสกุล jpg เท่านั้น");
						} else {
							$time = time();
							$filename = "".strtoupper(substr(md5($time),0,12)."-".md5($_FILES["file"]["name"]).".jpg");
							if(move_uploaded_file($_FILES["file"]["tmp_name"],"../image/Logo/".$filename."")){
								$signup = $sql->prepare("EXEC dbo.SignUpBusiness :p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9");
								$signup->BindParam(":p1",$_POST['name']);
								$signup->BindParam(":p2",$_POST['address']);
								$signup->BindParam(":p3",$_POST['taxid']);
								$signup->BindParam(":p4",$_POST['office']);
								$signup->BindParam(":p5",$_POST['coordinator']);
								$signup->BindParam(":p6",$_POST['telephone']);
								$signup->BindParam(":p7",$filename);
								$signup->BindParam(":p8",md5($_POST['password']));
								$signup->BindParam(":p9",$_POST['email']);
								$signup->execute();
								if(!$signup){
									$api->popup("เกิดข้อผิดพลาดขณะส่งข้อมูล");
								} else {
									$api->popup("ระบบได้ทำการสมัครสมาชิกให้ท่านเรียบร้อยแล้ว กรุณารออีเมลยืนยันจากทางเราค่ะ");
									$api->sendMail($email_user,$email_pass,$_POST['email'],"ยินดีต้อนรับเข้าสู่บริการจัดหางานมหาวิทยาลัยนครสวรรค์",'business_reg');
									$api->go("login.php");
								}
							}
						}
					} else {
						$api->popup("E-mail นี้ใช้ในการสมัครไปแล้ว");
					}
				}
				?>
			</div>
		</div>
		</center></div>
	<p align="center" style="color: #FFF; font-size: 12px; margin-top: 50px;">© 2019 Phakaikaeo Khammak, Amonpan Puangthong</p>
	</div>
	
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
            });
    </script>
	</div>

</body>
</html>
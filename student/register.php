<?php
session_start();
include_once("../include/config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Up with NSRU Account</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="../js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
</head>
<style>
	
body{
	background-color: rgb(43,62,80);
	background-image: url(../../image/bg01-01.jpg);
	background-repeat:no-repeat;
	background-position:top;
}
	</style>
<body>
	<div id="wrapper">

<div id="div_center_register">
	<div style="color: #FFF;"><center>
	  <div style="font-size: 32px; "><strong>NSRU IT Account</strong></div>
<div style="font-size: 25px; font-weight: lighter;">One account for all Services</div>
<div style="font-size: 15px; font-weight: lighter; margin-bottom: 20px;"><strong>Sign up to Continue to <a href="#" style="color:rgb(26,188,156)" data-toggle="tooltip" title="ระบบจัดหางาน มหาวิทยาลัยราชภัฏนครสวรรค์">"NSRU JOB"</a></strong></div>
		<div id="div_login">
		<img src="../image/avatar_2x.png" style="margin-top: 50px; margin-bottom: 30px;" width="96" class="rounded-circle">
			<div style="width: 310px; margin: 0 auto;">
			<form method="post" action="">
				<label class="sr-only" for="inlineFormInputGroupUsername2">Email Address</label>
  <div class="input-group mb-2 mr-sm-2">
    
    <input type="text" name="email" class="form-control" id="inlineFormInputGroupUsername2" placeholder="อีเมล" autocomplete="off"><div class="input-group-prepend">
      <div class="input-group-text">@nsru.ac.th</div>
    </div>
  </div>
				<div class="input-group mb-2 mr-sm-2">
					<input name="password" type="password" class="form-control" placeholder="รหัสผ่าน">
				</div>
				
				<div class="input-group mb-2 mr-sm-2">
					<input name="password2" type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน">
				</div>
				
				<div class="input-group mb-2 mr-sm-2">
				<div class="form-row">
				<div class="col">
				  <input type="text" name="firstname" class="form-control" placeholder="ชื่อ">
				</div>
				<div class="col">
				  <input type="text" name="lastname" class="form-control" placeholder="นามสกุล">
				</div>
			  	</div>
				</div>
				
				<div class="input-group mb-2 mr-sm-2">
					<input name="stu_number" type="tel" class="form-control" placeholder="รหัสนักศึกษา">
				</div>
				
				<div class="input-group mb-2 mr-sm-2">
					<input name="telephone" type="tel" class="form-control" placeholder="เบอร์โทรศัพท์">
				</div>
				
				
				<div class="input-group mb-2 mr-sm-2">
				  <button type="submit" name="signup" class="btn btn-info" style="width: 100%; margin-bottom: 5px;">Sign up</button>
				</div>
			  <div style="color:#333333; font-size: 12px;"><a href="login.php">Login</a> | <a href="../business/">Business Login</a></div>&nbsp;
			</form>
				<?php
				if(isset($_POST['signup'])){
					if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['stu_number']) || empty($_POST['telephone'])){
						$api->popup("กรุณากรอกข้อมูลให้ครบทุกช่องค่ะ");
					} else if($_POST['password'] != $_POST['password2']){
						$api->popup("รหัสผ่านไม่ตรงกันค่ะ");
					} else if(!preg_match('/^[a-zA-Z0-9.-_]+$/',$_POST['email']) || !preg_match('/^[a-zA-Z0-9]+$/',$_POST['password'])){
						$api->popup("อีเมลและรหัสผ่านจะต้องเป็นตัวอักษร a-Z หรือตัวเลข 0-9 เท่านั้นค่ะ");
					} else {
						// EXEC Insert
						$pass = md5($_POST['password2']);
						$email = "".$_POST['email']."@nsru.ac.th";
						$signup = $sql->prepare("EXEC dbo.SignUpStudent :p1,:p2,:p3,:p4,:p5,:p6");
						$signup->BindParam(":p1",$_POST['stu_number']);
						$signup->BindParam(":p2",$_POST['firstname']);
						$signup->BindParam(":p3",$_POST['lastname']);
						$signup->BindParam(":p4",$email);
						$signup->BindParam(":p5",$pass);
						$signup->BindParam(":p6",$_POST['telephone']);
						$signup->execute();
						if(!$signup){
							$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล (96)");
						} else {
							// Send Mail
							$api->sendMail($email_user,$email_pass,$email,"ยินดีต้อนรับเข้าสู่บริการจัดหางานมหาวิทยาลัยราชภัฏนครสวรรค์",'student_reg');
							$api->popup("การสมัครสมาชิกสำเร็จค่ะ ระบบจะส่งอีเมลไปเพื่อทำการยืนยันตัวตนค่ะ");
							$api->go("login.php");
						}
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
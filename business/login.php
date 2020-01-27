<?php
session_start();
include_once("../include/config.php");

if(!empty($_SESSION['ent_email']) || !empty($_SESSION['ent_pass'])){
	$api->go("index.php");
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
		<img src="../image/avatar_2x.png" style="margin-top: 50px; margin-bottom: 30px;" width="96" class="rounded-circle">
			<div style="width: 310px; margin: 0 auto;">
			<form method="post" action="">
				<label class="sr-only" for="inlineFormInputGroupUsername2">Email Address</label>
  <div class="input-group mb-2 mr-sm-2">
    
    <input type="email" name="email" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Email Address" autocomplete="off"><div class="input-group-prepend">
    </div>
  </div>
				<div class="input-group mb-2 mr-sm-2">
					<input name="password" type="password" class="form-control" placeholder="Password">
				</div>
				<div class="input-group mb-2 mr-sm-2">
				  <button type="submit" name="submit" class="btn btn-info" style="width: 100%; margin-bottom: 5px;">Sign in</button>
				</div>
			  <div style="color:#333333; font-size: 12px;"><a href="register.php">Register</a> | <a href="forgotpass.php">Forgot password ?</a></div>&nbsp;
			</form>
				<?php
				if(isset($_POST['submit'])){
					// Login
					$login_sql = $sql->prepare("SELECT ent_email, ent_pass, ent_status FROM Enterprise WHERE ent_email = :p1 AND ent_pass = :p2");
					$login_sql->BindParam(":p1",$_POST['email']);
					$login_sql->BindParam(":p2",md5($_POST['password']));
					$login_sql->execute();
					$login = $login_sql->fetch(PDO::FETCH_ASSOC);
					if(!$login){
						$api->popup("ชื่ออีเมลหรือรหัสผ่านผิดพลาด");
					} else {
						if($login['ent_status'] == 0){
							$api->popup("บัญชีนี้ยังไม่ผ่านการยืนยัน");
						} else {
							$_SESSION['ent_email'] = $login['ent_email'];
							$_SESSION['ent_pass'] = $login['ent_pass'];
							session_write_close();
							$api->go("index.php");
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
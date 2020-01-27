<?php
session_start();
include_once("../include/config.php");
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
	background-image: url(../../image/bg01-01.jpg);
	background-repeat:no-repeat;
	background-position:top;
}
	</style>
<body>
	<div id="wrapper">

<div id="div_center_login">
	<div style="color: #FFF;"><center>
	  <div style="font-size: 32px; "><strong>NSRU IT Account</strong></div>
<div style="font-size: 25px; font-weight: lighter;">One account for all Services</div>
<div style="font-size: 15px; font-weight: lighter; margin-bottom: 20px;"><strong>Sign in to Continue to <a href="#" style="color:rgb(26,188,156)" data-toggle="tooltip" title="ระบบจัดหางาน มหาวิทยาลัยราชภัฏนครสวรรค์">"NSRU JOB"</a></strong></div>
		<div id="div_login">
		<img src="../image/avatar_2x.png" style="margin-top: 50px; margin-bottom: 30px;" width="96" class="rounded-circle">
			<div style="width: 310px; margin: 0 auto;">
			<form method="post" action="">
				<label class="sr-only" for="inlineFormInputGroupUsername2">Email Address</label>
  <div class="input-group mb-2 mr-sm-2">
    
    <input type="text" name="email" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Email Address" autocomplete="off"><div class="input-group-prepend">
      <div class="input-group-text">@nsru.ac.th</div>
    </div>
  </div>
				<div class="input-group mb-2 mr-sm-2">
					<input name="password" type="password" class="form-control" placeholder="Password">
				</div>
				<div class="input-group mb-2 mr-sm-2">
				  <button type="submit" name="login" class="btn btn-info" style="width: 100%; margin-bottom: 5px;">Sign in</button>
				</div>
			  <div style="color:#333333; font-size: 12px;"><a href="register.php">Register</a> | <a href="forgotpass.php">Forgot password ?</a></div>&nbsp;
			</form>
				<?php
				if(isset($_POST['login'])){
					$email = "".$_POST['email']."@nsru.ac.th";
					$api->student_login($email,$_POST['password']);
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
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
			<p>
                <?php
                    // Update Status
                    $num = 1;
                    $update = $sql->prepare("UPDATE Enterprise SET ent_status = :p1 WHERE ent_email = :p2");
                    $update->BindParam(":p1",$num);
                    $update->BindParam(":p2",$_GET['email']);
                    $update->execute();
                    if(!$update){
                        $api->errortxt("เกิดข้อผิดพลาดขณะรันข้อมูล");
                    } else {
                        $api->successtxt("ยืนยันอีเมลสำเร็จ ท่านสามารถเข้าสู่ระบบเพื่อใช้งานแล้ว");
                        $api->wait("login.php", 5000);
                    }
                ?>
            </p>
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
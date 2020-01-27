<?php
session_start();
include_once("../include/config.php");
if(empty($_SESSION['stu_email']) || empty($_SESSION['stu_password'])){
	$api->go("login.php");
	exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ระบบการตัดสินใจการจับคู่และคัดกรองตำแหน่งงานของผู้หางานในจังหวัดนครสวรรค์</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
<link href="./main.css" rel="stylesheet"></head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include_once("assets/header.php"); ?>
		<div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
        </div>        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    
					<?php
						include_once("menu_left.php");
					?>
                </div>    <div class="app-main__outer">
                    <div class="app-main__inner">
                                    
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
									
									<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Resume</th>
      <th scope="col">Update Date &nbsp;&nbsp;
      <th scope="col"><a href="addresume.php"><img src="assets/images/plus.png" width="20" height="20"></a></th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $c = 1;
	  $file_sql = $sql->prepare("SELECT * FROM Portfolio WHERE stu_id = :p1");
	  $file_sql->BindParam(":p1",$member['stu_id']);
	  $file_sql->execute();
	  while($file = $file_sql->fetch(PDO::FETCH_ASSOC)){
		  if($member['stu_port'] == $file['port_id']){
			  echo '
		<tr style="color:green;">
		  <th scope="row">'.$c++.'</th>
		  <td><a href="pdf/'.$file['port_file'].'" target="_blank">'.$file['port_name'].'</a></td>
		  <td>'.$file['port_date'].'</td>
		  <td>เรซูเมหลัก</td>
		</tr>';
		  } else {
			  echo '
		<tr>
		  <th scope="row">'.$c++.'</th>
		  <td><a href="pdf/'.$file['port_file'].'" target="_blank">'.$file['port_name'].'</a></td>
		  <td>'.$file['port_date'].'</td>
		  <td><a href="myresume.php?a=use&id='.$file['port_id'].'">ตั้งเป็นเรซูเมหลัก</a></td>
		</tr>';
		  }
	  }
	  if($_GET['a'] == "use"){
		  if(empty($_GET['id'])){
			  $api->popup("ไม่พบรหัส");
			  $api->go("myresume.php");
		  } else {
			  // Update
			  $update = $sql->prepare("UPDATE Student SET stu_port = :p1 WHERE stu_id = :p2");
			  $update->BindParam(":p1",$_GET['id']);
			  $update->BindParam(":p2",$member['stu_id']);
			  $update->execute();
			  if(!$update){
				  $api->popup("เกิดข้อผิดพลาดขณะอัพเดทข้อมูล");
				  $api->go("myresume.php");
			  } else {
				  $api->popup("เลือกเรซูเม่หลักเรียบร้อยแล้ว");
				  $api->go("myresume.php");
			  }
		  }
	  }
	  ?>
	  
  </tbody>
</table>

									
                                </div>
                            </div>
                        </div>
                        
                    </div>
                        </div>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        </div>
    </div>
<script type="text/javascript" src="./assets/scripts/main.js"></script></body>
</html>

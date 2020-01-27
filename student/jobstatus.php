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
									<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">ชื่องาน</th>
      <th scope="col">ตำแหน่ง</th>
      <th scope="col">วันที่สมัคร</th>
      <th scope="col">สถานะการสมัคร</th>
    </tr>
  </thead>
  <tbody>
	  
	  <?php
	  $c = 1;
	  $job_sql = $sql->prepare("EXEC ListJobApply :p1");
	  $job_sql->BindParam(":p1",$member['stu_id']);
	  $job_sql->execute();
	  while($job = $job_sql->fetch(PDO::FETCH_ASSOC)){
		  echo '
    <tr>
      <th scope="row">'.$c++.'</th>
      <td>'.$job['title'].' ['.$job['ent_name'].']</td>
      <td>'.$job['job_position'].'</td>
      <td>'.$job['app_date'].'</td>
      <td>'.$api->JobStatus($job['status']).'</td>
    </tr>';
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

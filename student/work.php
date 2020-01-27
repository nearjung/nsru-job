<?php
session_start();
include_once("../include/config.php");
if(empty($_SESSION['stu_email']) || empty($_SESSION['stu_password'])){
	$api->go("login.php");
	exit();
}

if(empty($member['stu_picture'])){
	$api->popup("กรุณาตั้งค่าประวัติส่วนตัวก่อนทำรายการทุกครั้งค่ะ");
	$api->go("setting.php");
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
									<?php
									if(empty($_GET['b'])){
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE work_id = :p1 ORDER BY ann_id DESC");
										$job_sql->BindParam(":p1",$_GET['id']);
									} else if($_GET['b'] == 2) {
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE max_salary < 10000 ORDER BY ann_id DESC");
									} else if($_GET['b'] == 3) {
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE max_salary BETWEEN 10000 AND 20000 ORDER BY ann_id DESC");
									} else if($_GET['b'] == 4) {
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE max_salary BETWEEN 20001 AND 45000 ORDER BY ann_id DESC");
									} else if($_GET['b'] == 5) {
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE max_salary > 45000 ORDER BY ann_id DESC");
									} else if($_GET['b'] == 6){
										$job_sql = $sql->prepare("SELECT * FROM Annoucement WHERE branch = :p1 OR second_branch = :p2 OR third_branch = :p3");
										$job_sql->BindParam(":p1",$member['stu_branch']);
										$job_sql->BindParam(":p2",$member['stu_branch']);
										$job_sql->BindParam(":p3",$member['stu_branch']);
									}
									$job_sql->execute();
									while($job = $job_sql->fetch(PDO::FETCH_ASSOC)){
										// Company
										$com_sql = $sql->prepare("SELECT * FROM Enterprise WHERE ent_id = :p1");
										$com_sql->BindParam(":p1",$job['ent_id']);
										$com_sql->execute();
										$com = $com_sql->fetch(PDO::FETCH_ASSOC);
                                    echo '<table width="98%" align="center">
  <tbody>
    <tr>
      <td width="10%" rowspan="4"><img src="../image/Logo/'.$com['ent_logo'].'" alt="" width="100" height="40"/></td>
      <td width="70%" valign="top"><div style="color=#0a13cd;"><strong>'.$job['title'].'</strong></div></td>';
	?>
      <td width="20%" rowspan="2" valign="bottom" align="center"><a onclick="return confirm('คุณต้องการที่จะส่งไปสมัครหรือไม่ ?\nคุณกำลังใช้ Port : <?php echo $api->GetPortName($member['stu_id']); ?>')" href="index.php?a=apply&id=<?php echo $job['ann_id']; ?>"><button class="mb-2 mr-2 btn btn-success">ส่งใบสมัคร</button></a></td>
									<?php echo '
    </tr>
    <tr>
      <td valign="top">ตำแหน่ง : '.$job['job_position'].'</td>
    </tr>
    <tr>
      <td valign="top">เงินเดือน : '.number_format($job['min_salary']).' - '.number_format($job['max_salary']).' บาท</td>
	  ';
									?>
      <td rowspan="2" valign="middle" align="center"><a onclick="return confirm('คุณต้องการที่จะจัดเก็บงานหรือไม่ ?')" href="index.php?a=cart&id=<?php echo $job['ann_id']; ?>"><button class="mb-2 mr-2 btn btn-warning">จัดเก็บงาน</button></a></td>
								<?php echo '	
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">สาขาที่ต้องการ : '.$api->branch($job['branch']).'';
      if($job['second_branch']){
          echo ', '.$api->branch($job['second_branch']).'';
      }
      if($job['third_branch']){
          echo ', '.$api->branch($job['third_branch']).'';
      }
      echo '</td>
      <td valign="top">&nbsp;</td>
    </tr>
  </tbody>
</table><hr>';
									}
									
									$a = @($_GET['a']);
									if($a == "cart"){
										if(empty($_GET['id'])){
											$api->popup("รหัสผิดพลาด");
										} else {
											// INSERT INTO
											$cart = $sql->prepare("INSERT INTO Cart(stu_id,ann_id) VALUES(:p1,:p2)");
											$cart->BindParam(":p1",$member['stu_id']);
											$cart->BindParam(":p2",$_GET['id']);
											$cart->execute();
											if(!$cart){
												$api->popup("ไม่สามารถเพิ่มได้");
											} else {
												$api->go("index.php");
											}
										}
									} else if($a == "apply"){
										
										// Check if already
										$chk_sql = $sql->prepare("SELECT * FROM ApplyJob WHERE ann_id = :p1 AND stu_id = :p2");
										$chk_sql->BindParam(":p1",$_GET['id']);
										$chk_sql->BindParam(":p2",$member['stu_id']);
										$chk_sql->execute();
										$chk = $chk_sql->fetch(PDO::FETCH_ASSOC);
										if(!$chk){
											if(empty($_GET['id'])){
												$api->popup("รหัสผิดพลาด");
											} else if(empty($member['stu_port'])){
												$api->popup("กรุณาเลือก Resume ของคุณก่อน");
												$api->go("myresume.php");
											} else {
												$apply = $sql->prepare("EXEC InsertApplyJob :p1,:p2,:p3");
												$apply->BindParam(":p1",$member['stu_id']);
												$apply->BindParam(":p2",$_GET['id']);
												$apply->BindParam(":p3",$member['stu_port']);
												$apply->execute();
												if(!$apply){
													$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
												} else {
													$api->popup("ส่งใบสมัครเรียบร้อยแล้ว");
												}

											}
										} else {
											$api->popup("คุณได้ทำการยื่นใบสมัครสำหรับงานนี้ไปแล้ว");
										}
									}
									?>

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

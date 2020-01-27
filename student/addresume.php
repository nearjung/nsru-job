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
									<form name="addresume" action="" style="margin: 10px;" method="post" enctype="multipart/form-data">
										<p><input name="port_name" class="form-control" placeholder="ชื่อเรซูเม" type="text"></p>
										<p><textarea name="port_info" class="form-control" placeholder="รายละเอียดเรซูเม"></textarea></p>
										<p><input name="file" class="form-control-file" type="file"> [รองรับไฟล์ pdf เท่านั้น]</p>
										<p><input name="submit" class="btn btn-primary btn-lg btn-block" value="บันทึกเรซูเม" type="submit"></p>
									</form>
									<?php
									if(isset($_POST['submit'])){
										$array = explode('.', $_FILES['file']['name']);
										$ext = end($array);
										if(empty($_POST['port_name']) || empty($_POST['port_info'])){
											$api->popup("กรุณากรอกกรอกข้อมูลให้ครบทุกช่องค่ะ");
										} else if(!is_uploaded_file($_FILES['file']['tmp_name'])){
											$api->popup("กรุณาเลือกไฟล์ pdf ด้วยค่ะ");
										} else if($_FILES['file']['size'] > 8145728){
											$api->popup("ไฟล์ pdf ต้องมีขนาดไม่เกิน 8MB");
										} else if($ext != "pdf"){
											$api->popup("กรุณาเลือกไฟล์ pdf เท่านั้น");
										} else {
											$time = time();
											$filename = "".strtoupper(substr(md5($time),0,12)."-".md5($_FILES["file"]["name"]).".pdf");
											if(move_uploaded_file($_FILES["file"]["tmp_name"],"pdf/".$filename."")){
												// Add Resume
												$add = $sql->prepare("EXEC dbo.InsertResume :p1,:p2,:p3,:p4");
												$add->BindParam(":p1",$member['stu_id']);
												$add->BindParam(":p2",$_POST['port_name']);
												$add->BindParam(":p3",$_POST['port_info']);
												$add->BindParam(":p4",$filename);
												$add->execute();
												if(!$add){
													$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
												} else {
													$api->popup("เพิ่มเรซูเมสำเร็จ");
													$api->go("myresume.php");
												}
											} else {
												$api->popup("เกิดปัญหากับทาง FTP");
												$api->go("addresume.php");
											}
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

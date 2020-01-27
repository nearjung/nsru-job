<?php
session_start();
include_once("../include/config.php");
if(empty($_SESSION['stu_email']) || empty($_SESSION['stu_password'])){
	$api->go("login.php");
	exit();
}

// Job Info
$info_sql = $sql->prepare("EXEC dbo.GetJobInfo :p1");
$info_sql->BindParam(":p1",$_GET['id']);
$info_sql->execute();
$info = $info_sql->fetch(PDO::FETCH_ASSOC);
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
									<div style="margin: 10px;">
									<div align="center"><h3><?php echo $info['title']; ?></h3>
										<hr style="width:90%;">
										<div style="width:90%">
										<img src="../image/Logo/<?php echo $info['ent_logo']; ?>"><br><a onclick="return confirm('คุณต้องการที่จะส่งไปสมัครหรือไม่ ?\nคุณกำลังใช้ Port : <?php echo $api->GetPortName($member['stu_id']); ?>')" href="index.php?a=apply&id=<?php echo $info['ann_id']; ?>"><button class="mb-2 mr-2 btn btn-success">ส่งใบสมัคร</button></a><a onclick="return confirm('คุณต้องการที่จะส่งไปสมัครหรือไม่ ?')" href="index.php?a=cart&id=<?php echo $info['ann_id']; ?>"><button class="mb-2 mr-2 btn btn-warning">จัดเก็บงาน</button></a> <br>
											<?php echo $info['description']; ?><hr>
											<table>
											<tr>
												<td align="right">ตำแหน่งที่ต้องการ :</td>
												<td><?php echo $info['job_position']; ?></td>
											</tr>
											<tr>
												<td align="right">จำนวนคนที่ต้องการ : </td>
												<td><?php echo $info['need_stu']; ?></td>
											</tr>
											<tr>
												<td align="right">วุฒิการศึกษา :</td>
												<td><?php echo $info['branch_name']; ?></td>
											</tr>
											<tr>
												<td align="right">เงินเดือน :</td>
												<td><?php echo ''.number_format($info['min_salary']).'-'.number_format($info['max_salary']); ?></td>
											</tr>
											<tr>
												<td align="right">สถานที่ทำงาน :</td>
												<td><?php echo $info['location']; ?></td>
											</tr>
											<tr>
												<td align="right">ชื่อบริษัท :</td>
												<td><?php echo $info['ent_name']; ?></td>
											</tr>
											<tr>
												<td align="right">ที่ตั้งบริษัท :</td>
												<td><?php echo $info['ent_address']; ?></td>
											</tr>
											<tr>
												<td align="right">ชื่อผู้ติดต่อ :</td>
												<td><?php echo $info['ent_coordinator']; ?></td>
											</tr>
											<tr>
												<td align="right">เบอร์ติดต่อ :</td>
												<td><?php echo $info['ent_telephone']; ?></td>
											</tr>
											<tr>
												<td align="right">วันประกาศรับสมัคร :</td>
												<td><?php echo $info['start_date']; ?></td>
											</tr>
											<tr>
												<td align="right"></td>
												<td></td>
											</tr>
											</table>
										</div>
										</div>
									</div>
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

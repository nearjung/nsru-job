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
      <th scope="col">ชื่อบริษัท</th>
      <th scope="col">ตำแหน่ง</th>
      <th scope="col">เงินเดือน</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $c = 1;
	  $cart_sql = $sql->prepare("SELECT Annoucement.Job_position,Annoucement.ann_id,Enterprise.ent_name,Cart.cart_id,Annoucement.min_salary,Annoucement.max_salary FROM Cart INNER JOIN Annoucement ON Cart.ann_id = Annoucement.ann_id INNER JOIN Enterprise ON Annoucement.ent_id = Enterprise.ent_id WHERE Cart.stu_id = :p1");
	  $cart_sql->BindParam(":p1",$member['stu_id']);
	  $cart_sql->execute();
	  while($cart = $cart_sql->fetch(PDO::FETCH_ASSOC)){
    echo '<tr>
      <th scope="row">'.$c++.'</th>
      <td><a href="jobinfo.php?id='.$cart['ann_id'].'">'.$cart['ent_name'].'</a></td>
      <td>'.$cart['Job_position'].'</td>
      <td>'.$cart['min_salary'].' - '.$cart['max_salary'].'</td>';
		  ?>
      <td><a href="jobcart.php?id=<?php echo $cart['cart_id']; ?>" style="color:red;" onclick="return confirm('คุณต้องการที่จะลบหรือไม่ ?')">ลบ</a></td>
	  <?php echo '
    </tr>';
	  }
	  if(!empty($_GET['id'])){
		  // DELETE
		  $delete = $sql->prepare("DELETE FROM Cart WHERE cart_id = :p1");
		  $delete->BindParam(":p1",$_GET['id']);
		  $delete->execute();
		  if(!$delete){
			  $api->popup("ไม่สามารถลบข้อมูลได้");
		  } else {
			  $api->go("jobcart.php");
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

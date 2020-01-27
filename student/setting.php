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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="./main.css" rel="stylesheet"></head>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '1960:2029'
    });
  } );
  </script>	
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
									<form style="margin: 15px;" name="updateaccount" action="" method="post" enctype="multipart/form-data">
									  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">ชื่อจริง</label>
      <input type="text" name="firstname" value="<?php echo $member['stu_firstname']; ?>" class="form-control" id="inputEmail4" placeholder="ชื่อจริง">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">นามสกุล</label>
      <input type="text" name="lastname" class="form-control" id="inputPassword4" placeholder="นามสกุล" value="<?php echo $member['stu_lastname']; ?>">
    </div>
  </div>
										
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">รหัสนักศึกษา</label>
      <input type="tel" name="stu_number" value="<?php echo $member['stu_number']; ?>" class="form-control" id="inputEmail4" placeholder="รหัสนักศึกษา">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">เบอร์โทรศัพท์</label>
      <input type="tel" name="telephone" class="form-control" id="inputPassword4" placeholder="เบอร์โทรศัพท์" value="<?php echo $member['stu_telephone']; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">รหัสบัตรประชาชน</label>
      <input name="idcard" type="tel" class="form-control" id="inputPassword4" placeholder="รหัสบัตรประชาชน" value="<?php echo $member['stu_idcode']; ?>" maxlength="13">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">วัน/เดือน/ปี เกิด</label>
      <input type="text" name="birthday" class="form-control" id="datepicker" placeholder="วัน/เดือน/ปี เกิด" value="<?php echo $member['stu_birthday']; ?>">
    </div>
  </div>
										
  <div class="form-group">
    <label for="inputAddress">ที่อยู่ปัจจุบัน</label>
    <input type="text" name="address" class="form-control" id="inputAddress" placeholder="ที่อยู่ปัจจุบัน" value="<?php echo $member['stu_address']; ?>">
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputState">คณะที่จบ</label>
      <select id="filter" name="faculty" class="form-control">
		  <?php
		  $faculty_sql = $sql->prepare("SELECT * FROM Faculty");
		  $faculty_sql->execute();
		  while($faculty = $faculty_sql->fetch(PDO::FETCH_ASSOC)){
			  if($faculty['faculty_id'] == $member['stu_faculty']){
				  echo "<option selected value=".$faculty['faculty_name'].">".$faculty['faculty_name']."</option>";
			  } else {
				  echo "<option value=".$faculty['faculty_name'].">".$faculty['faculty_name']."</option>";
			  }
		  }
		  ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputCity">สาขาที่จบ</label>
      <select id="states" name="branch" class="form-control">
		<?php
		  $faculty_sql = $sql->prepare("SELECT * FROM Faculty");
		  $faculty_sql->execute();
		  while($faculty = $faculty_sql->fetch(PDO::FETCH_ASSOC)){
			  $branch_sql = $sql->prepare("SELECT * FROM Branch WHERE faculty_id = :p1");
			  $branch_sql->BindParam(":p1",$faculty['faculty_id']);
			  $branch_sql->execute();
			  echo '<optgroup label="'.$faculty['faculty_name'].'">';
			  while($branch = $branch_sql->fetch(PDO::FETCH_ASSOC)){
				  if($branch['branch_id'] == $member['stu_branch']){
					  echo '<option selected value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  } else {
					  echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  }
			  }
				echo '</optgroup>';
		  }
		  ?>
		  
      </select>
    </div>
	  
    <div class="form-group col-md-2">
      <label for="inputZip">ระดับการศึกษา</label>
      <select id="inputState" name="degree" class="form-control">
		  <?php
		  $degree_sql = $sql->prepare("SELECT * FROM Degree");
		  $degree_sql->execute();
		  while($degree = $degree_sql->fetch(PDO::FETCH_ASSOC)){
			  if($member['stu_education'] == $degree['degree_id']){
				  echo '<option selected value="'.$degree['degree_id'].'">'.$degree['name'].'</option>';
			  } else {
				  echo '<option value="'.$degree['degree_id'].'">'.$degree['name'].'</option>';
			  }
		  }
		  ?>
      </select>
    </div>
	  
  </div>
										
  <div class="form-group">
    <label for="inputAddress">รูปโปรไฟล์</label>
    <div class="custom-file">
  <input type="file" name="picture" class="custom-file-input" id="customFileLangHTML">
  <label class="custom-file-label" for="customFileLangHTML" data-browse="เลือกไฟล์">เลือกรูปโปรไฟล์</label>
</div>
	  <img src="avatar/<?php echo $member['stu_picture']; ?>" width="100" height="150" alt=""/> </div>
										
  <button type="submit" name="submit" class="btn btn-primary">บันทึกการแก้ไข</button>

									</form>
									<?php
									if(isset($_POST['submit'])){
										// Faculty Number
										$fa_sql = $sql->prepare("SELECT * FROM Faculty WHERE faculty_name = :p1");
										$fa_sql->BindParam(":p1",$_POST['faculty']);
										$fa_sql->execute();
										$fa = $fa_sql->fetch(PDO::FETCH_ASSOC);
										if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['stu_number']) || empty($_POST['telephone'])
										  || empty($_POST['idcard']) || empty($_POST['birthday']) || empty($_POST['address']) || empty($_POST['faculty']) ||
										   empty($_POST['branch']) || empty($_POST['degree'])){
											$api->popup("กรุณากรอกข้อมูลให้ครบทุกช่อง");
										} else {
											if(is_uploaded_file($_FILES['picture']['tmp_name'])){
												$array = explode('.', $_FILES['picture']['name']);
												$ext = end($array);
												if($_FILES['picture']['size'] > 3145728){
													$api->popup("ขนาดไฟล์รูปภาพต้องมีขนาดไม่เกิน 3MB");
												} else if($ext != "jpg"){
													$api->popup("ไฟล์รูปภาพต้องมีนามสกุล jpg เท่านั้น");
												} else {
													$time = time();
													$filename = "".strtoupper(substr(md5($time),0,12)."-".md5($_FILES["picture"]["name"]).".jpg");
													move_uploaded_file($_FILES["picture"]["tmp_name"],"avatar/".$filename."");
													
													// Update
													$update = $sql->prepare("EXEC dbo.UpdateDetailStudent :p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12");
													$update->BindParam(":p1",$member['stu_id']);
													$update->BindParam(":p2",$_POST['firstname']);
													$update->BindParam(":p3",$_POST['lastname']);
													$update->BindParam(":p4",$_POST['stu_number']);
													$update->BindParam(":p5",$_POST['telephone']);
													$update->BindParam(":p6",$_POST['idcard']);
													$update->BindParam(":p7",$_POST['birthday']);
													$update->BindParam(":p8",$_POST['address']);
													$update->BindParam(":p9",$fa['faculty_id']);
													$update->BindParam(":p10",$_POST['branch']);
													$update->BindParam(":p11",$_POST['degree']);
													$update->BindParam(":p12",$filename);
													$update->execute();
													if(!$update){
														$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
													} else {
														$api->popup("บันทึกข้อมูลสำเร็จ");
														$api->go("setting.php");
														exit();
													}
												}
											} else {
												// Update
												$update = $sql->prepare("EXEC dbo.UpdateDetailStudent :p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12");
												$update->BindParam(":p1",$member['stu_id']);
												$update->BindParam(":p2",$_POST['firstname']);
												$update->BindParam(":p3",$_POST['lastname']);
												$update->BindParam(":p4",$_POST['stu_number']);
												$update->BindParam(":p5",$_POST['telephone']);
												$update->BindParam(":p6",$_POST['idcard']);
												$update->BindParam(":p7",$_POST['birthday']);
												$update->BindParam(":p8",$_POST['address']);
												$update->BindParam(":p9",$fa['faculty_id']);
												$update->BindParam(":p10",$_POST['branch']);
												$update->BindParam(":p11",$_POST['degree']);
												$update->BindParam(":p12",$member['stu_picture']);
												$update->execute();
												if(!$update){
													$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
												} else {
													$api->popup("บันทึกข้อมูลสำเร็จ");
													$api->go("setting.php");
													exit();
												}
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
<script type="text/javascript" src="./assets/scripts/main.js"></script>
	<script>
	$("#filter").on("change", function() {
    $states = $("#states");
    $states.find("optgroup").hide().children().hide();
    $states.find("optgroup[label='" + this.value + "']").show().children().show();
    $states.find("optgroup[label='" + this.value + "'] option").eq(0).prop("selected", true);
});
	</script>
	</body>
</html>

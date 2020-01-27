<?php
session_start();
include_once("../include/config.php");

if(empty($_SESSION['ent_email']) || empty($_SESSION['ent_pass'])){
	$api->go("login.php");
	exit();
}

// Annouce Information
$annouce_sql = $sql->prepare("SELECT * FROM Annoucement WHERE ann_id = :p1");
$annouce_sql->BindParam(":p1",$_GET['id']);
$annouce_sql->execute();
$annouce = $annouce_sql->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ระบบการตัดสินใจการจับคู่และคัดกรองตำแหน่งงานของผู้หางานในจังหวัดนครสวรรค์ สำหรับผู้ประกอบการ</title>
<link href="style/main.css" rel="stylesheet" type="text/css">
<link href="style/menu.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="../js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="ckeditor/ckeditor.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<!-- jQuery -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- MenuMaker Plugin -->
<script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
   <script src="script.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body><?php include_once("header_menu.php"); ?>
	<div class="content">
		<div style="width: 100%; align-content: center;">
		<form name="addnotice" action="" method="post" enctype="multipart/form-data">
			<p><input class="form-control" type="text" name="title" placeholder="*หัวข้อประกาศ" value="<?php echo $annouce['title']; ?>"/></p>
			<p><input class="form-control" type="text" name="job_position" placeholder="*ตำแหน่งที่ต้องการ" value="<?php echo $annouce['job_position']; ?>"/></p>
			<p><textarea name="description" rows="10" id="txtDescription"><?php echo $annouce['description']; ?></textarea>
		<script>
			CKEDITOR.env.isCompatible = true;
			CKEDITOR.replace( 'txtDescription');
		</script></p>
			<p><input class="form-control" type="number" name="min_salary" placeholder="*กำหนดรายได้ขั้นต่ำ" value="<?php echo $annouce['min_salary']; ?>"/></p>
			<p><input class="form-control" type="number" name="max_salary" placeholder="*กำหนดรายได้สูงสุด" value="<?php echo $annouce['max_salary']; ?>"/></p>
			<p><input class="form-control" type="number" name="need_stu" placeholder="*จำนวนพนักงานที่ต้องการ" value="<?php echo $annouce['need_stu']; ?>"/></p>
			<p><input class="form-control" type="text" name="location" placeholder="*สถานที่ทำงาน" value="<?php echo $annouce['location']; ?>"/></p>
			<p><input class="form-control" type="text" name="googlemap" placeholder="ลิ้ง GoogleMap" value="<?php echo $annouce['googlemap']; ?>"/></p>
			<p><select id="filter" name="work_id" class="form-control">
				<option value="0">กรุณาเลือกหมวดหมู่งาน</option>
				<?php
				$work_sql = $sql->prepare("SELECT * FROM WorkCategory");
				$work_sql->execute();
				while($work = $work_sql->fetch(PDO::FETCH_ASSOC)){
					if($annouce['work_id'] == $work['work_id']){
						echo '<option selected value="'.$work['work_id'].'">- '.$work['name'].'</option>';
					} else {
						echo '<option value="'.$work['work_id'].'">- '.$work['name'].'</option>';
					}
				}
				?>
				</select></p>
			<p><fieldset><legend>เลือกสาขาที่ต้องการรับเข้างาน</legend><div class="form-row"><div class="form-group col-md-4">
      <label for="inputState">*คณะที่จบ</label>
      <select id="filter" name="faculty" class="form-control">
		  <?php
		  $faculty_sql = $sql->prepare("SELECT * FROM Faculty");
		  $faculty_sql->execute();
		  while($faculty = $faculty_sql->fetch(PDO::FETCH_ASSOC)){
			  echo "<option value=".$faculty['faculty_name'].">".$faculty['faculty_name']."</option>";
		  }
		  ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputCity">*สาขาที่จบ</label>
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
				  if($branch['branch_id'] == $annouce['branch']){
					  echo '<option selected value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  } else {
					  echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  }
			  }
				echo '</optgroup>';
		  }
		  ?>
		  
      </select>
			</div></div>
			
			<div class="form-row"><div class="form-group col-md-4">
      <label for="inputState">คณะที่จบ</label>
      <select id="filter2" name="faculty" class="form-control">
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
      <select id="states2" name="branch2" class="form-control">
		<?php
		  $faculty_sql = $sql->prepare("SELECT * FROM Faculty");
		  $faculty_sql->execute();
		  while($faculty = $faculty_sql->fetch(PDO::FETCH_ASSOC)){
			  $branch_sql = $sql->prepare("SELECT * FROM Branch WHERE faculty_id = :p1");
			  $branch_sql->BindParam(":p1",$faculty['faculty_id']);
			  $branch_sql->execute();
			  echo '<optgroup label="'.$faculty['faculty_name'].'">';
			  while($branch = $branch_sql->fetch(PDO::FETCH_ASSOC)){
				  if($branch['branch_id'] == $annouce['second_branch']){
					  echo '<option selected value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  } else {
					  echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  }
			  }
				echo '</optgroup>';
		  }
		  ?>
		  
      </select>
			</div></div>
			
			<div class="form-row"><div class="form-group col-md-4">
      <label for="inputState">คณะที่จบ</label>
      <select id="filter3" name="faculty" class="form-control">
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
      <select id="states3" name="branch3" class="form-control">
		<?php
		  $faculty_sql = $sql->prepare("SELECT * FROM Faculty");
		  $faculty_sql->execute();
		  while($faculty = $faculty_sql->fetch(PDO::FETCH_ASSOC)){
			  $branch_sql = $sql->prepare("SELECT * FROM Branch WHERE faculty_id = :p1");
			  $branch_sql->BindParam(":p1",$faculty['faculty_id']);
			  $branch_sql->execute();
			  echo '<optgroup label="'.$faculty['faculty_name'].'">';
			  while($branch = $branch_sql->fetch(PDO::FETCH_ASSOC)){
				  if($branch['branch_id'] == $annouce['third_branch']){
					  echo '<option selected value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  } else {
					  echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
				  }
			  }
				echo '</optgroup>';
		  }
		  ?>
		  
      </select>
			</div></div>
			<p align="center"><button type="submit" name="submit" class="btn btn-primary">แก้ไขประกาศรับสมัครงาน</button></p>
			</fieldset></p>
			<p></p>
			</form>
		<?php
		if(isset($_POST['submit'])){
			if(empty($_POST['title']) || empty($_POST['job_position']) || empty($_POST['description']) || empty($_POST['min_salary']) || empty($_POST['max_salary']) || empty($_POST['need_stu']) || empty($_POST['location']) || empty($_POST['branch']) ){
				$api->popup("กรุณากรอกข้อมูลให้ครบทุกช่องด้วยค่ะ");
			} else {
				// Insert
				$num2 = 2;
				$insert = $sql->prepare("EXEC dbo.InsertAnnouce :p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15");
				$insert->BindParam(":p1",$business['ent_id']);
				$insert->BindParam(":p2",$_POST['job_position']);
				$insert->BindParam(":p3",$_POST['branch']);
				$insert->BindParam(":p4",$_POST['title']);
				$insert->BindParam(":p5",$_POST['description']);
				$insert->BindParam(":p6",$_POST['min_salary']);
				$insert->BindParam(":p7",$_POST['max_salary']);
				$insert->BindParam(":p8",$_POST['need_stu']);
				$insert->BindParam(":p9",$_POST['location']);
				$insert->BindParam(":p10",$_POST['googlemap']);
				$insert->BindParam(":p11",$_POST['work_id']);
				$insert->BindParam(":p12",$_POST['branch2']);
				$insert->BindParam(":p13",$_POST['branch3']);
				$insert->BindParam(":p14",$num2);
				$insert->BindParam(":p15",$_GET['id']);
				$insert->execute();
				if(!$insert){
					$api->popup("เกิดข้อผิดพลาดขณะรันข้อมูล");
				} else {
					$api->popup("บันทึกการแก้ไขสำเร็จแล้ว !");
					$api->go("index.php");
					exit();
				}
			}
		}
		?>
		</div>
	</div>

<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
	
<script type="text/javascript" src="./assets/scripts/main.js"></script>
	<script>
	$("#filter").on("change", function() {
    $states = $("#states");
    $states.find("optgroup").hide().children().hide();
    $states.find("optgroup[label='" + this.value + "']").show().children().show();
    $states.find("optgroup[label='" + this.value + "'] option").eq(0).prop("selected", true);
});
	</script>
	<script>
	$("#filter2").on("change", function() {
    $states = $("#states2");
    $states.find("optgroup").hide().children().hide();
    $states.find("optgroup[label='" + this.value + "']").show().children().show();
    $states.find("optgroup[label='" + this.value + "'] option").eq(0).prop("selected", true);
});
	</script>
	<script>
	$("#filter3").on("change", function() {
    $states = $("#states3");
    $states.find("optgroup").hide().children().hide();
    $states.find("optgroup[label='" + this.value + "']").show().children().show();
    $states.find("optgroup[label='" + this.value + "'] option").eq(0).prop("selected", true);
});
	</script>
</body>
</html>
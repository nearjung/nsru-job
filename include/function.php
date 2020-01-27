<?php
// สร้าง Class ไว้ใช้งาน
class API
{	
	public function popup($text)
	{
		echo "<script>alert('".$text."');</script>";
	}
	
	public function go($link)
	{
		echo "<script>location='".$link."';</script>";
	}
	
	public function wait($link,$time)
	{
		echo '<script> window.setTimeout(function(){
        window.location.href = "'.$link.'"; }, '.$time.');</script>';
	}
	
	public function errortxt($text)
	{
		echo '<div class="animated fadeIn"><div style="color: red;">'.$text.'</div></div>';
	}
	
	public function successtxt($text)
	{
		echo '<div class="animated fadeIn"><div style="color: green;">'.$text.'</div></div>';
	}
	
	public function student_login($email,$pass)
	{
		global $sql;
		$password = md5($pass);
		$login_sql = $sql->prepare("EXEC dbo.StudentLogin :email, :pass");
		$login_sql->BindParam(":email",$email);
		$login_sql->BindParam(":pass",$password);
		$login_sql->execute();
		$login = $login_sql->fetch(PDO::FETCH_ASSOC);
		if(!$login){
			$this->popup("อีเมลหรือรหัสผ่านผิดพลาด");
		} else if($login['stu_status'] == 0){
			$this->popup("คุณไม่สามารถเข้าใช้งานระบบได้ค่ะ");
			$this->go("login.php");
		} else {
			$_SESSION['stu_email'] = $login['stu_email'];
			$_SESSION['stu_password'] = $login['stu_password'];
			session_write_close();
			$this->go("index.php");
		}
	}
	
	public function faculty($id){
		global $sql;
		$fa_sql = $sql->prepare("EXEC dbo.GetFaculty :p1");
		$fa_sql->BindParam(":p1",$id);
		$fa_sql->execute();
		$fa = $fa_sql->fetch(PDO::FETCH_ASSOC);
		return $fa['faculty_name'];
	}
	
	public function branch($id){
		global $sql;
		$ba_sql = $sql->prepare("EXEC dbo.GetBranch :p1");
		$ba_sql->BindParam(":p1",$id);
		$ba_sql->execute();
		$ba = $ba_sql->fetch(PDO::FETCH_ASSOC);
		return $ba['branch_name'];
	}
	
	public function CountList($id,$mode){
		global $sql;
		$cnt_sql = $sql->prepare("EXEC dbo.WorkCount :p1,:p2");
		$cnt_sql->BindParam(":p1",$id);
		$cnt_sql->BindParam(":p2",$mode);
		$cnt_sql->execute();
		$cnt = $cnt_sql->fetchColumn();
		return $cnt;
	}
	
	public function JobStatus($status){
		global $sql;
		$num = array("ยังไม่ตรวจสอบ","อ่านใบสมัครแล้ว");
		return $num[$status];
	}
	
	public function GetPortName($stu_id){
		global $sql;
		$info = $sql->prepare("SELECT Student.stu_port, Portfolio.port_name FROM Student INNER JOIN Portfolio ON Portfolio.port_id = Student.stu_port WHERE Student.stu_id = :p1");
		$info->BindParam(":p1",$stu_id);
		$info->execute();
		$in = $info->fetch(PDO::FETCH_ASSOC);
		return $in['port_name'];
	}
	
	public function ApplyStatus($id){
		switch ($id) {
			case 0: $job = "<font color='red'>ยังไม่ได้อ่าน</font>"; break;
			case 1: $job = "<font color='green'>อ่านแล้ว</font>"; break;
			default: $job = "ยังไม่ได้อ่าน"; break;
		}
		
		return $job;
	}

	public function sendMail($email,$pass,$mailto,$subject,$content){
		global $nodeserver;
		$data = file_get_contents(''.$nodeserver.'/users/sendmail?email='.$email.'&pass='.$pass.'&sendto='.$mailto.'&subject='.$subject.'&content='.$content.'');
		if(strpos($data,'Success') === FALSE){
			$this->errortxt("ไม่สามารถเชื่อมต่อ Mail Server");
		}
	}
}

?>
<?php
ini_set('display_errors', 0);
// SQL Server
$mssql_host	=	"103.13.30.185"; // ชื่อโฮส SQL
$mssql_user	=	"vindictus"; // ชื่อยูสเซอร์ SQL
$mssql_pass	=	"ThisisaVindictusPassword19111"; // รหัสผ่าน SQL
$mssql_db	=	"JobSearch"; // ชื่อฐานข้อมูลที่ใช้งาน

$nodeserver	=	"http://103.13.30.185:9000"; // Server ของ node.js

$email_user	=	"prakaykarw.w@gmail.com"; // ชื่อบัญชี Email
$email_pass	=	"59114672013"; // รหัสผ่าน Email

///////////////////// ห้ามแก้ไข //////////////////
#คำสั่งเชื่อมต่อฐานข้อมูล
date_default_timezone_set('Asia/Bangkok');
$sql = new PDO("sqlsrv:server=".$mssql_host.";Database=".$mssql_db,$mssql_user,$mssql_pass);
include_once("function.php");
$api = new API(true);
$datetimes = date("d/m/Y");

if(!empty($_SESSION['stu_email']) || !empty($_SESSION['stu_password'])){
	$member_sql = $sql->prepare("EXEC dbo.GetStudentInfo :p1,:p2");
	$member_sql->BindParam(":p1",$_SESSION['stu_email']);
	$member_sql->BindParam(":p2",$_SESSION['stu_password']);
	$member_sql->execute();
	$member = $member_sql->fetch(PDO::FETCH_ASSOC);
	
}

if(!empty($_SESSION['ent_email']) || !empty($_SESSION['ent_pass'])){
	$business_sql = $sql->prepare("SELECT * FROM Enterprise WHERE ent_email = :p1 AND ent_pass = :p2");
	$business_sql->BindParam(":p1",$_SESSION['ent_email']);
	$business_sql->BindParam(":p2",$_SESSION['ent_pass']);
	$business_sql->execute();
	$business = $business_sql->fetch(PDO::FETCH_ASSOC);
}
?>
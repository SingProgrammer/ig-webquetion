<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
//header("location:update.html");exit();
$hostname_ConnGGGS = "localhost";//ที่อยู่โฮสของฐานข้อมูล
$database_ConnGGGS = "q_ig";//ชื่อฐานข้อมูล
$username_ConnGGGS = "root";//ชื่อผู้ใช้ฐานข้อมูล
$password_ConnGGGS = "";//รหัสผ่านเชื่อมต่อฐานข้อมูล

$con = mysqli_connect($hostname_ConnGGGS,$username_ConnGGGS,$password_ConnGGGS,$database_ConnGGGS);
mysqli_select_db($con,$database_ConnGGGS);
$con->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_general_ci'");
error_reporting (E_ALL ^ E_NOTICE);
?>

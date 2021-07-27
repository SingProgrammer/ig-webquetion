<?php
include("conne.php");
session_start();
$m_link=$_GET["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        header("location:index2.php");
        exit();
    }
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
$m_name=$re_sql["m_name"];//ชื่อเจ้าของคำถาม
$m_point=$re_sql["m_point"];//คะแนน
$m_show=$re_sql["m_show"];//การแสดงเฉลย
$m_pw=$re_sql["m_pw"];//รหัสผ่าน
$m_finish=$re_sql["m_finish"];//เสร็จมั้ย

if($_COOKIE['ck_mq'][$m_id]==$m_id){
    include("in_admin.php");
}else{
    include("in_mem.php");
}

?>
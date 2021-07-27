<?php
include("conne.php");
session_start();
$ma_id=$_GET["id"];
$m_link=$_GET["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        header("location:index2.php");
        exit();
    }
$re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม

if($_COOKIE['ck_mq'][$m_id]==$m_id){
    $sql="SELECT * FROM `member_ans` WHERE m_id='".$m_id."' AND ma_id='".$ma_id."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)!=0){
        $sql="DELETE FROM `member_ans` WHERE ma_id='".$ma_id."'";
        mysqli_query($con,$sql);
        $sql="DELETE FROM `ma_detail` WHERE ma_id='".$ma_id."'";
        mysqli_query($con,$sql);

    }
        header("location:index.php?l=".$m_link);
        exit();
    
}else{
    header("location:index.php?l=".$m_link);
}







?>
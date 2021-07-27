<?php
include("conne.php");
$m_link=$_POST["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        header("location:index2.php");
        exit();
    }
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
if($_COOKIE['ck_mq'][$m_id]!=$m_id){
    header("location:index2.php");
    exit();
}


    $sql="SELECT * FROM `quetion` WHERE q_id='".$_POST["q_id"]."' AND q_type='q2'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        header("location:play_c.php?l=".$_POST['l']);
        exit();
    }
$re_sql=mysqli_fetch_array($que_sql);

$sql2="INSERT INTO `quetion`(`q_detail`, `q_pic`, `q_type`) VALUES ('".$re_sql["q_detail"]."','".$re_sql["q_pic"]."','".$_POST["q_id"]."')";

mysqli_query($con,$sql2);
$q_id=mysqli_insert_id($con);

$sql_qf="INSERT INTO `qt_formember`(`m_id`, `q_id`) VALUES ('".$m_id."','".$q_id."')";
mysqli_query($con,$sql_qf);
$qtf_id=mysqli_insert_id($con);


for($i=1;$i<=5;$i++){
  $sql_ans="INSERT INTO `ans_question`(`a_detail`, `q_id`) VALUES ('".$_POST["txt_name".$i]."','".$q_id."')";
  mysqli_query($con,$sql_ans);
    $a_id=mysqli_insert_id($con);
    
    if($_POST["txt_yn".$i]==1){
     $sql_af="INSERT INTO `ans_formember`(`qtf_id`, `a_id`) VALUES ('".$qtf_id."','".$a_id."')";
        mysqli_query($con,$sql_af);
    }

}
header("location:play_c.php?l=".$_POST['l']);












?>
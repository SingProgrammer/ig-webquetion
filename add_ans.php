<?php
include("conne.php");
$m_link=$_POST["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        exit();
    }
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
if($_COOKIE['ck_mq'][$m_id]!=$m_id){
    exit();
}
$q_id=$_POST['q_id'];

$sql="SELECT * FROM qt_formember WHERE q_id='".$q_id."' AND m_id='".$m_id."'";
$que_sql=mysqli_query($con,$sql);
$n_row=mysqli_num_rows($que_sql);
if($n_row!=0){ //หากมีข้อคำถามนี้แล้ว หยุดทำ
    exit();
}











$e=explode("|", $_POST['ans']);

for($i=0;$i<count($e);$i++){
    $add_sql.=" OR a_id='".$e[$i]."'";
}


$sql="SELECT * FROM ans_question WHERE q_id='".$q_id."' AND (0 ".$add_sql.")";
$que_sql=mysqli_query($con,$sql);
$n_row=mysqli_num_rows($que_sql);




if($n_row==count($e)){
    echo "ครบถ้วน".$n_row;
    $sql="INSERT INTO `qt_formember`(`m_id`, `q_id`) VALUES('".$m_id."','".$q_id."')";
    mysqli_query($con,$sql);
    $qtf_id=mysqli_insert_id($con);
    
            $add_sql="('".$qtf_id."','".$e[0]."')";
            for($i=1;$i<count($e);$i++){
            $add_sql.=",('".$qtf_id."','".$e[$i]."')";
        }
    $sql="INSERT INTO ans_formember(`qtf_id`, `a_id`) VALUES ".$add_sql;
    mysqli_query($con,$sql);
    
    
    
    $sql_ma="SELECT * FROM qt_formember WHERE m_id='".$m_id."'";
        $que_ma=mysqli_query($con,$sql_ma);
        $q_num=mysqli_num_rows($que_ma);
    //หากครบข้อแบ้วไป Go Go
    if($q_num==10){
    $sql="UPDATE `member_qt` SET `m_finish` = '1' WHERE `m_id` ='".$m_id."'";
    mysqli_query($con,$sql);
    }
    
    
    
}else{
    echo "เกิดข้อผิดพลาด".$n_row;
}



?>
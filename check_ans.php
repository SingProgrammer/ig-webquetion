<?php
include("conne.php");
session_start();


$m_link=$_POST["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        exit();
    }
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
$m_show=$re_sql["m_show"];//เฉลยมั้ย


//ตรวจสอบว่าทำไปยัง
$sql_ma="SELECT member_ans.m_id,ma_detail.q_id,member_ans.ma_id FROM `member_ans` RIGHT JOIN `ma_detail` ON member_ans.ma_id=ma_detail.ma_id WHERE member_ans.m_id='".$m_id."' AND member_ans.ma_id='".$_COOKIE["ck_id"][$m_id]."' AND ma_detail.q_id='".$_POST['q_id']."'";
        $que_ma=mysqli_query($con,$sql_ma);
        $q_num=mysqli_num_rows($que_ma);
if($q_num!=0){
    echo"stop";
    exit();
}

$sql="SELECT * FROM `member_ans` WHERE m_id='".$m_id."' AND ma_id='".$_COOKIE["ck_id"][$m_id]."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
    setcookie("ck_id[".$m_id."]","", time()+0, "/");
        echo "your_cancel";
        exit();
        
    }




$sqls="SELECT ans_formember.a_id,qt_formember.m_id,qt_formember.q_id  FROM `ans_formember` LEFT JOIN qt_formember ON  ans_formember.qtf_id=qt_formember.qtf_id WHERE ans_formember.a_id='".$_POST['a_id']."' AND qt_formember.m_id='".$m_id."' AND qt_formember.q_id='".$_POST['q_id']."'";
$que_sqls=mysqli_query($con,$sqls);    
$num=mysqli_num_rows($que_sqls);

$sql="INSERT INTO ma_detail(ma_id,q_id,a_id,mad_score)VALUES('".$_COOKIE["ck_id"][$m_id]."','".$_POST['q_id']."','".$_POST['a_id']."','".$num."')";
mysqli_query($con,$sql);




$sql_ma="SELECT member_ans.m_id,ma_detail.q_id,member_ans.ma_id FROM `member_ans` RIGHT JOIN `ma_detail` ON member_ans.ma_id=ma_detail.ma_id WHERE member_ans.m_id='".$m_id."' AND member_ans.ma_id='".$_COOKIE["ck_id"][$m_id]."'";
        $que_ma=mysqli_query($con,$sql_ma);
        $q_num=mysqli_num_rows($que_ma);

if($q_num==10){
    
    $sqls2="SELECT sum(ma_detail.mad_score) as sum_score FROM ma_detail LEFT JOIN member_ans ON ma_detail.ma_id=member_ans.ma_id WHERE ma_detail.ma_id='".$_COOKIE["ck_id"][$m_id]."' group by ma_detail.ma_id";
        $que_sqls2=mysqli_query($con,$sqls2); 
            $re_sqls2=mysqli_fetch_array($que_sqls2);
    
    $sql="UPDATE `member_ans` SET `ma_finish` = '1',`ma_score`='".$re_sqls2["sum_score"]."' WHERE `member_ans`.`ma_id` ='".$_COOKIE["ck_id"][$m_id]."'";
    mysqli_query($con,$sql);
}


//ส่วนของเฉลย
if($m_show=="1"){
    

$sqls="SELECT ans_formember.a_id,qt_formember.m_id,qt_formember.q_id  FROM `ans_formember` LEFT JOIN qt_formember ON  ans_formember.qtf_id=qt_formember.qtf_id WHERE qt_formember.m_id='".$m_id."' AND qt_formember.q_id='".$_POST['q_id']."'";
$que_sqls=mysqli_query($con,$sqls);
$re_sql=mysqli_fetch_array($que_sqls);echo $re_sql["a_id"];
while($re_sql=mysqli_fetch_array($que_sqls)){
    echo "|".$re_sql["a_id"];
    }
}else{
    echo "amnot";
}
?>
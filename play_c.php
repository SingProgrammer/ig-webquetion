<?php
include("conne.php");
session_start();
$m_link=$_GET["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($que_sql)==0){
        header("location:index.php");
        exit();
    }
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
$m_name=$re_sql["m_name"];//ชื่อเจ้าของคำถาม

if($_COOKIE['ck_mq'][$m_id]!=$m_id){
        ?>
    <script>
        alert('คุณไม่มีสิทธิเข้าใช้งาน');
        location.href='create.php';
    </script>
<?
        exit();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>คุณรู้อะไรเกี่ยวกับไอ้นี่บ้าง<?php echo $_COOKIE["ck_name"];?></title></head>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
    
    

  
    
    
    
<body>
<?php
            $sql_ma="SELECT * FROM qt_formember LEFT JOIN `quetion` ON qt_formember.q_id=`quetion`.q_id  WHERE m_id='".$m_id."'";
        $que_ma=mysqli_query($con,$sql_ma) or die(mysql_error());
        $q_num=mysqli_num_rows($que_ma);
    //หากครบข้อแบ้วไป Go Go
    if($q_num==10){
     header("location:index.php?l=".$_GET['l']);
        exit();
    }
        while($re_ma=mysqli_fetch_array($que_ma)){
           
           if($re_ma["q_type"]!='q1' AND $re_ma["q_type"]!='q2'){
               $add_sql.=" AND `quetion`.`q_id`!='".$re_ma["q_type"]."'";
           }else{
           $add_sql.=" AND `quetion`.`q_id`!='".$re_ma["q_id"]."'";
           }
        }
    
    
if($_GET["qs_id"]!=""){
   $sqls="SELECT * FROM `quetion` RIGHT JOIN `qt_group` ON `quetion`.q_id=`qt_group`.q_id WHERE 1".$add_sql." AND qs_id='".$_GET["qs_id"]."'  AND q_type LIKE 'q%' ORDER BY RAND()"; 
}else{
    $sqls="SELECT * FROM `quetion` WHERE 1 ".$add_sql." AND q_type LIKE 'q%' ORDER BY RAND()"; 
}    
    

$que_sqls=mysqli_query($con,$sqls) or die(mysql_error);    
    $re_sqls=mysqli_fetch_array($que_sqls);
    $str_q=str_replace("|name|",'คุณ',$re_sqls["q_detail"]);
    $q_type=$re_sqls["q_type"];
    $q_id=$re_sqls["q_id"];
    $q_multi_ans=$re_sqls["q_multi_ans"];//คำตอบมากกว่า 1 ข้อหรือไม่
?>
 <script src="jquery-1.9.0.js"></script>
  <script language="javascript">
      var sen_ans='';
      var multi_ans='<?php echo $q_multi_ans;?>';
function tt_check_ans(js_l,js_a_id,js_q_id){
$(function(){
	   
		      if(multi_ans!=1){
                  
                   $("#alert_a_id"+sen_ans).removeClass("alert alert-primary"); 
                    $("#alert_a_id"+sen_ans).addClass("alert alert-light");
                  sen_ans='';
                    $("#alert_a_id"+js_a_id).removeClass("alert alert-light"); 
                    $("#alert_a_id"+js_a_id).addClass("alert alert-primary");
                  sen_ans=js_a_id;
                  return;
              }
    
    
                //ถ้ายังไม่เลือกให้ทำ..    
                if($("#alert_a_id"+js_a_id).hasClass("alert alert-light")){
                    $("#alert_a_id"+js_a_id).removeClass("alert alert-light"); 
                    $("#alert_a_id"+js_a_id).addClass("alert alert-primary");
                        if(sen_ans==''){
                            sen_ans=js_a_id;
                        }else{
                            sen_ans+='|'+js_a_id;
                        }
                }else{//ถ้าเลือกแล้วให้ทำ
                    $("#alert_a_id"+js_a_id).removeClass("alert alert-primary"); 
                    $("#alert_a_id"+js_a_id).addClass("alert alert-light");
                                        var n = sen_ans.split('|');
                    sen_ans='';
                    
                    for( var i=0; i<n.length; i++ ) {
                        if(n[i]!=js_a_id){
                            if(sen_ans==''){
                                sen_ans=n[i];
                            }else{
                                sen_ans+='|'+n[i];
                            }
                        }
                    
                }
                }
            
            
		});
    
	

}
      
      
function tt_submit_ans(){
$(function(){
	
		var num = 0;//ถูกหรือผิด
		$.post("add_ans.php",{ans:sen_ans,q_id:'<?php echo $re_sqls['q_id'];?>',l:'<?php echo $_GET['l'];?>'},function(data){        
            
            window.location.reload();
		});
    
	

});
}   
      
function check_box(){
    
    if(form1.txt_name1.value=="" || form1.txt_name2.value=="" || form1.txt_name3.value=="" || form1.txt_name4.value=="" || form1.txt_name5.value==""){
        alert('กรุณาใส่คำตอบให้ครบ');
        return false;
    }
    
        if(form1.txt_yn1.value!="0" || form1.txt_yn2.value!="0" || form1.txt_yn3.value!="0" || form1.txt_yn4.value!="0" || form1.txt_yn5.value!="0"){
        
        }else{
        alert('ต้องมีข้อถูกอย่างน้อย 1 ข้อ');
        return false;
    }
    
}      
      
</script>     
    
    
<div class="row">
  <div class="col-md-6 offset-md-3 bg-success">
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?php echo $q_num;?>0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
    
</div>
    
      <?php include("in_top_pc.php");?>
      <div class="alert alert-success" role="alert">
  <b>ชุดคำถาม : </b>
          <a href="play_c.php?l=<?php echo $_GET['l'];?>"><button type="button" class="<?php if(""==$_GET["qs_id"]){echo "btn btn-dark";}else{echo "btn btn-outline-dark";}?>">ทั้งหมด</button></a>
          <?php
          $qset_sql="SELECT * FROM `question_set`";
          $qset_query=mysqli_query($con,$qset_sql);
          while($re_qset=mysqli_fetch_array($qset_query)){
          ?>
          
      <a href="play_c.php?l=<?php echo $_GET['l'];?>&qs_id=<?php echo $re_qset["qs_id"];?>"><button type="button" class="<?php if($re_qset["qs_id"]==$_GET["qs_id"]){echo "btn btn-dark";}else{echo "btn btn-outline-dark";}?>"><?php echo $re_qset["qs_name"];?></button></a>
          <?php } ?>
</div>
    <center>
      <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
<?php if($q_multi_ans==1){?><span class="badge badge-danger">ตอบได้มากกว่า 1</span><?php }?>
  <div class="card-header">คำถามข้อ <?php echo $q_num+1;?>/10</div>
          
  <div class="card-body">
    <h5 class="card-title"><?php echo $str_q;?></h5>
    <p class="card-text"><?php if($re_sqls['q_pic']!=""){?><img src="<?php echo $re_sqls['q_pic'];?>" width="100%"><?php }?></p>
      <a href='#'><span class="badge badge-warning" onclick="location.reload();">สุ่มคำถามอีกครั้ง</span></a> 
  </div>
</div>
        
        
        
        
        
        
        <?php
        if($q_type!='q2'){
        ?>
        
        <div class="row">
        <?php
        $sqls="SELECT * FROM ans_question WHERE q_id='".$re_sqls['q_id']."'";
        $que_sqls=mysqli_query($con,$sqls);    
        while($re_sqls=mysqli_fetch_array($que_sqls)){
        ?>
        <div class="col-6">
        <div id="alert_a_id<?php echo $re_sqls['a_id'];?>" class="alert alert-light" role="alert" onclick="tt_check_ans('<?php echo $_GET['l'];?>','<?php echo $re_sqls['a_id'];?>','<?php echo $re_sqls['q_id'];?>');">
            
            
            
        <?php if($re_sqls['a_pic']!=""){?>  
            
            
                <figure class="figure">
  <img src="<?php echo $re_sqls['a_pic'];?>" width="100%" alt="...">
  <figcaption class="figure-caption text-center"><?php echo $re_sqls['a_detail'];?></figcaption>
</figure>
                
        <?php }else{?>
            
       <button type="button" class="btn btn-secondary btn-lg btn-block"><?php echo $re_sqls["a_detail"];?></button>
        <?php }?>  
            
            
        </div>
      
      </div>
        <?php }?>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="tt_submit_ans();">บันทึก</button>
            </div>
        </div>
        <hr> 
        <?php }else{?>
        <form name="form1" action="add_ans2.php" method="post" onsubmit="return check_box();">
            <input name="l" value="<?php echo $_GET["l"]?>" type="hidden">
            <input name="q_id" value="<?php echo $q_id?>" type="hidden">
            <input name="l" value="<?php echo $_GET["l"]?>" type="hidden">
        <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">ชื่อ</th>
      <th scope="col" width="100px">Ans.</th>
    </tr>
  </thead>
  <tbody>
      <?php 
    $r_yn=rand(1,5);        
    for($i=1;$i<=5;$i++){?>
    <tr>
      <th scope="row"><?php echo $i;?></th>
      <td><input name="txt_name<?php echo $i;?>" class="form-control" type="text" placeholder="ใส่ชื่อแล้วเลิกคำตอบ"></td>
      <td>
          
         <?php
          if($q_multi_ans==0){
              if($i==$r_yn){
                  echo "ถูก(1)";
                  echo "<input name='txt_yn".$i."' type='hidden' value='1'>";
              }else{
                    echo "ผิด(0)";
                    echo "<input name='txt_yn".$i."' type='hidden' value='0'>";
              }
          }else{
          ?> 
        <select class="form-control" name="txt_yn<?php echo $i;?>">
          <option value="1">ถูก</option>
          <option value="0" selected>ผิด</option>
        </select>
         <?php } ?> 
          
      </td>
    </tr>
      <?php }?>
  </tbody>
</table>
            <button type="submit" class="btn btn-primary">บันทึก</button>
 </form>       
   <hr>     
<?php }?>
            
     
        
    </center> 
     โฆษณา       
  <div id="SC_TBlock_628234" class="SC_TBlock">loading...</div>  
      <?php include("p_under.html");?>
    </div>
    </div>
    
    
     <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>   
    
 
 <script type="text/javascript">
  (sc_adv_out = window.sc_adv_out || []).push({
    id : "628234",
    domain : "n.ads1-adnow.com"
  });
</script>
<script type="text/javascript" src="//st-n.ads1-adnow.com/js/a.js"></script>   
    

</body>

</html>
<?php
include("conne.php");
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

session_start();
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
            $sql_ma="SELECT member_ans.m_id,ma_detail.q_id,member_ans.ma_id FROM `member_ans` RIGHT JOIN `ma_detail` ON member_ans.ma_id=ma_detail.ma_id WHERE member_ans.m_id='".$m_id."' AND member_ans.ma_id='".$_COOKIE["ck_id"][$m_id]."'";
        $que_ma=mysqli_query($con,$sql_ma);
        $q_num=mysqli_num_rows($que_ma);
    //หากครบข้อแบ้วไป Go Go
    if($q_num==10){
     header("location:show_score.php?l=".$_GET['l']);
        exit();
    }
        while($re_ma=mysqli_fetch_array($que_ma)){
           $add_sql.=" AND `qt_formember`.`q_id`!='".$re_ma["q_id"]."'";
        }
    
    
    
$sqls="SELECT qt_formember.q_id,quetion.q_detail,quetion.q_pic FROM qt_formember LEFT JOIN quetion ON qt_formember.q_id=quetion.q_id WHERE m_id='".$m_id."'".$add_sql;
$que_sqls=mysqli_query($con,$sqls) or die(mysql_error);    
    $re_sqls=mysqli_fetch_array($que_sqls);
    $str_q=str_replace("|name|",$m_name,$re_sqls["q_detail"]);
?>
 <script src="jquery-1.9.0.js"></script>
  <script language="javascript">
function tt_check_ans(js_l,js_a_id,js_q_id){
$(function(){
	
		var num = 0;//ถูกหรือผิด
		$.post("check_ans.php",{l:js_l,a_id:js_a_id,q_id:js_q_id},function(data){ 
            if(data=="your_cancel"){
               alert('ไม่มีสิทธิเข้าใช้งาน โปรดลองอีกครั้ง \n ผู้ตั้งคำถามอาจลบคุณ');
               location.href="index.php?l=<?php echo $_GET["l"];?>";
                return;
               }
            
            if(data=="stop"){
               return;
               }else if(data=="amnot"){
            $("#alert_a_id"+js_a_id).removeClass("alert alert-light");
            $("#alert_a_id"+js_a_id).addClass("alert alert-dark");
            window.location.reload();
            return;
        }
            var n = data.split('|');
                for( var i=0; i<n.length; i++ ) {
                    if(n[i]==js_a_id){
                        num=1;
                    }
            $("#alert_a_id"+n[i]).removeClass("alert alert-light");
            $("#alert_a_id"+n[i]).addClass("alert alert-success");
                }
            
            //สีข้อที่ผิด
            if(num!=1){
            $("#alert_a_id"+js_a_id).removeClass("alert alert-light");
            $("#alert_a_id"+js_a_id).addClass("alert alert-danger");
            }
            setTimeout("window.location.reload()",700);
            
		});
    
	

});
}
</script>     
    
    
<div class="row">
  <div class="col-md-6 offset-md-3 bg-success">
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?php echo $q_num;?>0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
      <?php include("in_top_pc.php");?>
    <center>
      <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
  <div class="card-header">คำถามข้อ <?php echo $q_num+1;?>/10</div>
          
  <div class="card-body">
    <h5 class="card-title"><?php echo $str_q;?></h5>
    <p class="card-text"><?php if($re_sqls['q_pic']!=""){?><img src="<?php echo $re_sqls['q_pic'];?>" width="100%"><?php }?></p>
  </div>
</div>
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
        <?php }else{?>
            
       <button type="button" class="btn btn-secondary btn-lg btn-block"><?php echo $re_sqls["a_detail"];?></button>
        <?php }?>  
            
            
        </div>
      
      </div>
        <?php }?>
        </div>
    </center>
    
 <hr>

        <?php include("p_under.html");?>
      
    </div>
    </div>
    
    
    
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  
    
    
</body>
</html>
<?php
include("conne.php");
session_start();
$m_link=$_GET["l"];

    $sql="SELECT * FROM member_qt WHERE m_link='".$m_link."'";
    $que_sql=mysqli_query($con,$sql);
    $re_sql=mysqli_fetch_array($que_sql);
$m_id=$re_sql["m_id"];//รหัสเจ้าของคำถาม
$m_name=$re_sql["m_name"];//ชื่อเจ้าของคำถาม


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>สร้างคำถามของฉัน</title></head>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>   
<script language="javascript"> 
       function check_name(){   
  if(document.form1.txtname.value == "" ){ 
      
     alert('กรุณากรอก ชื่อของคุณด้วย');
    
     document.form1.txtname.focus();  
     return false;  
  }else{
      document.form1.txt_submit.value++;
  }
           if(document.form1.txt_submit.value>1){
               return false;  
           }
           
       }
    </script>
<body>
<div class="row">
  <div class="col-md-6 offset-md-3 bg-success">    
    <?php include("ban_lada.php");?>
    <?php include("ban_ni.php");?>
    <form action="start_create.php" method="post" name="form1" onsubmit="return check_name();">
        <input type="hidden" name="txtm_from_id" value="<?php echo $m_id;?>">
        <input type="hidden" name="txt_submit" value="0">
            <div class="jumbotron">
  <h1 class="display-4"><?php if((date('H')+6)>15){ echo "สวัสดีตอนเย็น";}else{echo "สวัสดีตอนเช้า";}?></h1>
  <p class="lead">คุณได้เดินทางเข้ามาแล้ว 555</p>
  <hr class="my-4">
  <p>ผมไม่สนหรอกว่าคุณจะรู้จักเว็บไซต์เราได้อย่างไร แต่เมื่อคุณเข้ามาแล้ว ลองมาตั้งคำถามให้เพื่อน ๆ ของคุณได้ทายกันดีกว่า จะได้รู้ว่าเพื่อนของคุณนั้น รู้จักคุณมากแค่ไหน</p>
    <h4 class="text-primary">หากพร้อมแล้ว ใส่ชื่อของคุณ แล้วกดเริ่มได้เลยยย..</h4>
  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">ใส่ชื่อของคุณ</span>
  </div>
  <input name="txtname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="เช่น 'ป๊อปอาย'">
</div>      
  <input class="btn btn-primary btn-lg" role="button" type="submit" value="เริ่ม">
</div>
        </form>

      
      โฆษณา
    <div id="SC_TBlock_628212" class="SC_TBlock">loading...</div> 
      <?php include("p_under.html");?>
    </div>
    </div>
  
    
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>    
    
    
<script type="text/javascript">
  (sc_adv_out = window.sc_adv_out || []).push({
    id : "628212",
    domain : "n.ads1-adnow.com"
  });
</script>
<script type="text/javascript" src="//st-n.ads1-adnow.com/js/a.js"></script>
</body>

    
</html>
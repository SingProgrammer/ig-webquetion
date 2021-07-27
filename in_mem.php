<?php
if($_COOKIE["ck_id"][$m_id]!=""){
    header("location:play.php?l=".$_GET['l']);
    exit();
    
}
if($m_finish==0){
    ?>
<script>
    alert('เจ้าของคำถามยังสร้างไม่เสร็จ');
    history.back();
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
<title>คุณรู้อะไรเกี่ยวกับ<?php echo $m_name;?>บ้าง</title></head>
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
<div class="modal fade" id="Modal_sulogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดยืนยันรหัสผ่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="form2" action="su_pass.php" method="post">
            
            <input type="hidden" name="l" value="<?php echo $_GET['l']?>">
          <div class="form-group">
            <label for="message-text" class="col-form-label">รหัสผ่าน 4 ตัว:</label>
            
            <input type="password" value="" name="txt_pass" maxlength="4">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="form2.submit();">Login</button>
      </div>
    </div>
  </div>
</div>    
    
    
    
    
    
    
    
<div class="row">
  <div class="col-md-6 offset-md-3 bg-success">    
    
    <?php include("ban_lada.php");?>
    <form action="start_play.php" method="post" name="form1" onsubmit="return check_name();">
        <input name="l" value="<?php echo $_GET['l'];?>" type="hidden">
        <input type="hidden" name="txt_submit" value="0">
            <div class="jumbotron">
  <h1 class="display-4"><?php if((date('H')+6)>15){ echo "สวัสดีตอนเย็น";}else{echo "สวัสดีตอนเช้า";}?></h1>
  <p class="lead">คุณได้เดินทางเข้ามาแล้ว 555</p>
  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal_sulogin">ฉันเป็นเจ้าของคำถามชุดนี้</button>
  <hr class="my-4">
  <p>อยากรู้จังคุณรู้จัก <font size='5px'><?php echo $m_name;?></font> ดีแค่ไหน มาลองตอบคำถามกันดูสิ ลงชื่อของคุณได้เลย..</p>
  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">ใส่ชื่อของคุณ</span>
  </div>
  <input name="txtname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="เช่น 'ป๊อปอาย'">
</div>      
  <input class="btn btn-primary btn-lg" role="button" type="submit" value="เริ่ม">
</div>
        </form>
		<?php include("ban_ni.php");?>
<center><h3>คะแนนของแต่ละคน</h3></center>
      
<table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">คะแนน</th>
      <th scope="col">ตอบกลับจาก<?php echo $m_name;?></th>
    </tr>
   <tbody>
    <?php
        $sqls="SELECT * FROM member_ans WHERE m_id='".$m_id."' ORDER BY ma_id DESC";
        $que_sqls=mysqli_query($con,$sqls);    
        while($re_sqls=mysqli_fetch_array($que_sqls)){
                        if($re_sqls['ma_score']=="" AND $re_sqls['ma_finish']==1){
                $sqls2="SELECT sum(ma_detail.mad_score) as sum_score FROM ma_detail LEFT JOIN member_ans ON ma_detail.ma_id=member_ans.ma_id WHERE ma_detail.ma_id='".$re_sqls["ma_id"]."' group by ma_detail.ma_id";
        $que_sqls2=mysqli_query($con,$sqls2); 
            $re_sqls2=mysqli_fetch_array($que_sqls2);
            
            $sql="UPDATE member_ans SET `ma_score`='".$re_sqls2["sum_score"]."' WHERE `ma_id`='".$re_sqls["ma_id"]."'";
             mysqli_query($con,$sql);
                
            }
            /* $sqls2="SELECT sum(ma_detail.mad_score) as sum_score FROM ma_detail LEFT JOIN member_ans ON ma_detail.ma_id=member_ans.ma_id WHERE ma_detail.ma_id='".$re_sqls["ma_id"]."' group by ma_detail.ma_id";
        $que_sqls2=mysqli_query($con,$sqls2); 
            $re_sqls2=mysqli_fetch_array($que_sqls2);*/
        ?>
    <tr>
      <td><?php echo $re_sqls['ma_name'];?></td>
      <td><center><?php if($re_sqls['ma_score']=="" AND $re_sqls['ma_finish']==0){echo '🕑';}else if($re_sqls['ma_score']=="" AND $re_sqls['ma_finish']==1){echo $re_sqls2["sum_score"];}else{echo $re_sqls['ma_score'];}?></center></td>
      <td><?php echo $re_sqls['ma_guess'];?></td>
    </tr>
    <?php }?>
  </tbody>
</table>       
      
 <hr>

      <?php include("p_under.html");?>
    </div>
    </div>
    

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    
    
</body>

</html>
<?php
if($m_finish=="0"){
    header("location:play_c.php?l=".$m_link);
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
<script>
    function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("คัดลอกเรียบร้อย : " + copyText.value);
}
</script>
  <script src="jquery-1.9.0.js"></script>
  <script language="javascript">
function view_yn(js_name_ma,js_ma_id){
$(function(){
        document.getElementById("div_yn").innerHTML= "กำลังโหลด..";
        document.getElementById("name_ma").innerHTML= js_name_ma;
		$.post("show_yn.php",{m_id:'<?php echo $m_id;?>',ma_id:js_ma_id},function(data){ 
        document.getElementById("div_yn").innerHTML= data;
            
		});
    
	

});
}
      
function cge_h(scr_name){
    document.getElementById("lb_h").innerHTML= "("+scr_name+")";
}      
</script>        
    
    
<body>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ตอบกลับ <label id="lb_h">ff</label></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="form1" action="save_msg.php" method="post">
            <input type="hidden" name="l" value="<?php echo $_GET['l']?>">
            <input type="hidden" name="ma_id" value="">
          <div class="form-group">
            <label for="message-text" class="col-form-label">ข้อความ:</label>
            <textarea class="form-control" id="message-text" name="txt_msg"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="form1.submit();">บันทึก</button>
      </div>
    </div>
  </div>
</div>
    
        <!--ถูกผิดข้อไหนบ้าง -->
<div class="modal fade" id="Modal_yn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><div id="name_ma">name</div></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <div id="div_yn"></div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

<?php
if($m_pw==""){   
?>   
<!-- กำหนดรหัสผ่าน -->    
<div class="modal fade show" id="Modal_setpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: block;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดตั้งรหัสผ่าน 4 ตัวเพื่อความปลอดภัย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="form_setp" action="set_pass.php" method="post">
            
            <input type="hidden" name="l" value="<?php echo $_GET['l']?>">            
          <div class="form-group">
            <label for="message-text" class="col-form-label">รหัสผ่าน 4 ตัว:</label>
            
            <input type="text" value="" name="txt_pass" maxlength="4">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="form_setp.submit();">บันทึก</button>
      </div>
    </div>
  </div>
</div>       
<?php }?>   
    
    
<?php
    $sql_lug="SELECT * FROM member_qt WHERE m_from_id='".$m_id."'";
    $que_lug=mysqli_query($con,$sql_lug);
    $lug_num=mysqli_num_rows($que_lug);
?>
    
<!--ลูกข่าย -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ลูกข่าย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <?php
            while($re_lug=mysqli_fetch_array($que_lug)){
                echo "<a href='"."http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?l=".$re_lug["m_link"]."'>".$re_lug["m_name"]."</a><br>";
            }  
            ?>
            
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>    
    
    
    
    
    
    
    
<div class="row">
  <div class="col-md-6 offset-md-3 bg-success">
      
 <?php include("ban_lada.php");?>
      
<div class="jumbotron">
                
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
  ลูกข่าย <span class="badge badge-light"><?php echo $lug_num;?></span>
  <span class="sr-only">unread messages</span>
</button>
                
 <button type="button" class="btn btn-primary">
  Point <span class="badge badge-light"><?php echo $m_point;?></span>
  <span class="sr-only">unread messages</span>
</button>               
                
  <h1 class="display-4"><?php if((date('H')+6)>15){ echo "สวัสดีตอนเย็น";}else{echo "สวัสดีตอนเช้า";}?></h1>
  <p class="lead"><h3>คุณ <?php echo $m_name;?></h3></p>
  <hr class="my-4">
  <p><h5>คุณได้สร้างคำถามของคุณเรียบร้อยแล้ว แชร์ลิงค์ของคุณให้เพื่อน ๆ เข้ามาเล่นสิ</h5></p>
    <!-- The text field -->
<input type="text" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>" id="myInput">

<!-- The button used to copy the text -->
<button onclick="myFunction()">คัดลอก</button>
    <br><h5>การเฉลยคำตอบ<a href="swit_yn.php?l=<?php echo $_GET['l'];?>"><img src="sys/sh<?php echo $m_show;?>.png"></h5></a>
</div>
<?php include("ban_ni.php");?>
<center><h3>คะแนนของแต่ละคน</h3></center>
    <table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">คะแนน</th>
      <th scope="col">ตอบกลับจากคุณ</th>
      <th scope="col" width="15px">ลบ</th>
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
      <td><a data-toggle="modal" data-target="#Modal_yn" onclick="view_yn('<?php echo $re_sqls['ma_name'];?>','<?php echo $re_sqls['ma_id'];?>');">💡<?php echo $re_sqls['ma_name'];?></a></td>
      <td><center><?php if($re_sqls['ma_score']=="" AND $re_sqls['ma_finish']==0){echo '🕑';}else if($re_sqls['ma_score']=="" AND $re_sqls['ma_finish']==1){echo $re_sqls2["sum_score"];}else{echo $re_sqls['ma_score'];}?></center></td>
      <td data-toggle="modal" data-target="#exampleModal" onmousedown="form1.ma_id.value='<?php echo $re_sqls['ma_id'];?>';cge_h('<?php echo $re_sqls['ma_name'];?>');" onclick="form1.txt_msg.value='<?php echo $re_sqls['ma_guess'];?>';"><?php echo $re_sqls['ma_guess'];?></td>
    <td><a href="del_mem_ans.php?l=<?php echo $_GET['l'];?>&id=<?php echo $re_sqls['ma_id'];?>" onclick="return confirm('คุณต้องการลบไอ้เหี้ยนี่หรือไม่ (<?php echo $re_sqls['ma_name'];?>)');">❌</a></td>
    </tr>
    <?php }?>
  </tbody>
</table>   
  
<hr>    
    <?php include("p_under.html");?>
    </div>
    </div>
 




<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>


</html>
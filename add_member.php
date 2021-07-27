<?php require_once('Connections/speo.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$file=$_FILES["filephoto"];
	$file_name=$file["name"];
	$file_size=$file["size"];
	$file_type=$file["type"];
	if($file_size!=0)
	{
		copy($_FILES["filephoto"]["tmp_name"],"pic_member/".$file_name);
		$_POST["pic"]="pic_member/".$file_name;	
	}
	else
	{
		$_POST["pic"]='nopic.jpg';
		}

	
  $insertSQL = sprintf("INSERT INTO member (username, password, name, sur_name, nink_name, birthday, age, sex, `add`, phone, education, Occupations, office, email, pic) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['sur_name'], "text"),
                       GetSQLValueString($_POST['nink_name'], "text"),
                       GetSQLValueString($_POST['yy']."-".$_POST['mm']."-".$_POST['dd'], "date"),
                       GetSQLValueString($_POST['age'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['add'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['education'], "text"),
                       GetSQLValueString($_POST['Occupations'], "text"),
                       GetSQLValueString($_POST['office'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['pic'], "text"));

  mysql_select_db($database_speo, $speo);
  $Result1 = mysql_query($insertSQL, $speo) or die(mysql_error());

  $insertGoTo = "susess_member.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
 <script src="jquery-1.9.0.js"></script>
<script language="javascript">
$(function(){
	$("#username").change(function(){
		var num = $('#username').val();
		$.post("check_username.php",{username:num},function(data){
			$('#showResult').html(data);
			$('#check_user').val(data);
			if(data!="")
			{
			alert('ssss');
			top.frames['frame1'].location.href='home.php';
			}
		});
	});
	
		$("#page1").click(function(){
		$.post("check_username.php",function(data){
			if(data=="0")
			{
			alert('กรุณาเข้าสู่ระบบ');
			//top.frames['frame1'].location.href='home.php';
			}
			else
		{
			top.frames['frame1'].location.href='home.php';
		}
		
		});
	});
});
</script>
<script language="javascript">
function check_addmember()
{
	if(document.form1.check_user.value!="")
	{
		alert('username ถูกใช้งานแล้ว');
		return false
	}
	else if(document.form1.password.value!=document.form1.password2.value)
	{
		alert('คุณกรอกรหัสผ่าน 2ช่องไม่ตรงกัน กรุณากรอกรหัสผ่านใหม่');
		return false
	}
	else if(document.form1.name.value=="")
	{
		alert('กรุณาใส่ชื่อของคุณ');
		document.form1.name.focus()
		return false
	}
	else if(document.form1.sur_name.value=="")
	{
		alert('กรุณาใส่นามสกุลของคุณ');
		document.form1.sur_name.focus()
		return false
	}	
	else if(document.form1.sex.value=="")
	{
		alert('กรุณาระบุเพศของคุณ');
		return false
	}
	else if(document.form1.password.value=="")
	{
		alert('กรุณาใส่รหัสผ่านของคุณ');
		return false
	}
}
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="img/images/admem_01.gif" width="900" height="79" /></td>
  </tr>
  <tr>
    <td background="img/images/admem_02.gif"><div align="center"><br />
    </div>
      <div align="center"></div>
      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <table width="500" align="center" cellspacing="5">
          <tr valign="baseline">
            <td colspan="2" nowrap="nowrap"><img src="img/komon.jpg" width="500" height="50" /><br />
            <br /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username :
              <label for="check_user"></label>
            <input type="hidden" name="check_user" id="check_user" /></td>
            <td><label for="username"></label>
            <input name="username" type="text" id="username" size="32" /><div id="showResult" style="color:#F00"></div></td>
          </tr>
          <tr valign="baseline">
            <td valign="baseline" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password :</td>
            <td valign="baseline"><p>
              <input type="text" name="password" value="" size="32" />

            </p></td>
          </tr>
          <tr >
            <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ยืนยัน&nbsp;Password :</td>
            <td ><input type="text" name="password2" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td colspan="2" nowrap="nowrap"><p><img src="img/samak.jpg" width="500" height="50" /><br />
              <br />
            </p></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="page1" >&nbsp;ชื่อ :</a></td>
            <td><input type="text" name="name" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;นามสุล :</td>
            <td><input type="text" name="sur_name" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อเล่น:</td>
            <td><input type="text" name="nink_name" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วัน/เดือน/ปีเกิด :</td>
            <td><label for="dd"></label>
              <select name="dd" id="dd">
              <?php for($i=1;$i<=31;$i++){?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
              <label for="mm"></label>
              <select name="mm" id="mm">
                <option value="01">มกราคม</option>
                <option value="02">กุมภาพันธ์</option>
                <option value="03">มีนาคม</option>
                <option value="04">เมษายน</option>
                <option value="05">พฤษภาคม</option>
                <option value="06">มิถุนายน</option>
                <option value="07">กรกฎาคม</option>
                <option value="08">สิงหาคม</option>
                <option value="09">กันยายน</option>
                <option value="10">ตุลาคม</option>
                <option value="11">พฤศจิกายน</option>
                <option value="12">ธันวาคม</option>
            </select>
              <label for="yy"></label>
              <select name="yy" id="yy">
              <?php for($i=0;$i<=100;$i++){?>
                <option value="<?php echo (date('Y')-$i); ?>"><?php echo (date('Y')-$i)+543; ?></option>
                <?php } ?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อายุ :</td>
            <td><input type="text" name="age" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพศ :</td>
            <td><p>
              <label>
                <input type="radio" name="sex" value="1" id="sex_0" />
                เพศชาย</label>
              <br />
              <label>
                <input type="radio" name="sex" value="2" id="sex_1" />
                เพศหญิง</label>
              <br />
            </p></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ที่อยู่ :</td>
            <td><input type="text" name="add" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เบอร์โทร :</td>
            <td><input type="text" name="phone" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การศึกษา :</td>
            <td><input type="text" name="education" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อาชีพ :</td>
            <td><input type="text" name="Occupations" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ที่ทำงาน :</td>
            <td><input type="text" name="office" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email :</td>
            <td><input type="text" name="email" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รูปภาพ :</td>
            <td><input type="hidden" name="pic" value="" size="32" />
              <label for="filephoto"></label>
              <input type="file" name="filephoto" id="filephoto" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><br />
              <input type="submit" value="ตกลง" onclick="return check_addmember();" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" name="Reset" id="button" value="ยกเลิก" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><img src="img/images/admem_03.gif" width="900" height="22" /></td>
  </tr>
</table>
</body>
</html>
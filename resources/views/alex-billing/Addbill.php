<?php 
include("check.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Bill Info</title>
<script src="calendar.js"></script>
<link href="images/cea.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="images/calendar.css" />

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p><?php 
  if($_POST['button']){
  $type=$_POST['type']; 
  $descr=$_POST['descr'];
$descr=$_POST['descr'];
$program=$_POST['program'];
$form=$_POST['form'];
$subProg=$_POST['subProg'];
$boarding=$_POST['boarding'];
$amount=$_POST['amount'];

$sql="insert into bill values('','$type','$descr','$program','$form','$subProg','$boarding','$amount','$stu','','')";

mysql_query($sql) or die (mysql_error());  
  
  }
  
  
  ?>&nbsp;</p>
  <table width="408" border="0" bgcolor="#DDE3FF">
    <tr>
      <td bgcolor="#DDE3FF">Type</td>
      <td bgcolor="#DDE3FF"><select     name="type" id="type">
        <option  >Academic</option>
        <option > PTA</option>
        <option >Others</option>
      </select></td>
    </tr>
    <tr>
      <td width="133" bgcolor="#DDE3FF">Description</td>
      <td width="265" bgcolor="#DDE3FF"><label>
        <input name="descr" type="text" id="descr" size="40" />
      </label></td>
    </tr>
    <tr>
      <td>Amount</td>
      <td><label>
        <input type="text" name="amount" id="amount" />
      </label></td>
    </tr>
    <tr>
      <td>Students</td>
      <td><textarea name="stu" cols="6" rows="2" id="stu"><?php echo $r[stu];?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#DDE3FF">Program</td>
      <td bgcolor="#DDE3FF"><label>
      <select name="program" id="program">
        <option value="" >ALL COURSES</option>

        <?php $sql=mysql_query("select distinct program from classcode ");
		  while($c=mysql_fetch_array($sql)){
		  ?>
        <option  ><?php echo $c['program']; ?></option>
        <?php }?>
      </select>
      </label></td>
    </tr>
    <tr>
      <td>Form</td>
      <td><label>
        <select name="form" id="form">
          <option value="">ALL FORMS</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Sub Form</td>
      <td><select name="subProg" id="subProg">
        <option value="">ALL SUB FORMS</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
      </select></td>
    </tr>
    <tr>
      <td>Boarding / Day</td>
      <td><label>
        <select name="boarding" id="boarding">
          <option value="">ALL</option>
          <option>Day</option>
          <option>Boarding</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2"><label>
        <div align="center">
          <input type="submit" name="button" id="button" value="Submit" />
        </div>
        </label></td>
    </tr>
  </table>
</form>
</body>
</html>

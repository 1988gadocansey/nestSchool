<?php 
$beef="TE@";

ob_start();
include 'check.php';


if($_GET['type']){
if($_GET['type']=='all'){$_SESSION[t]='';}else
$_SESSION[t]=$_GET['type'];
}

if($_GET['stuType']){
if($_GET['stuType']=='all'){$_SESSION['stuType']='';}else
$_SESSION['stuType']=$_GET['stuType'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Students</title>
<style type="text/css">
<!--
-->
</style>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="images/ajax.js"></script>
<link rel="stylesheet" href="images/ajax.css" type="text/css" />

<script src="calendar.js"></script>

<style type="text/css">
<!--
.style8 {color: #FF0000}
.style9 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>

<body> 
<?php include ('bar.php');?>
<table width="1020" height="528" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <td height="120" background="images/banner.png" style="background-repeat:no-repeat" scope="row">&nbsp; </td>
  </tr>
  <tr  background="images/body.png">
    <td height="268" valign="top" scope="row"><table  align="center"width="92%" height="183" border="0"  class="container" cellpadding="0" cellspacing="0">
      <tr>
        <td width="549" height="53" valign="top"><form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div align="center">
              <table width="599"  border="0" cellpadding="1" cellspacing="1" background="images/back.png">
                <tr>
                  <td background="images/back1.png"><div align="right"></div>
                      <div align="center">
                        <select     name="classes3" id="classes3" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?stuType='+escape(this.value);">
                          <option value="all" >ALL</option>
                          <option value="Fresh" <?php if($_SESSION['stuType']=='Fresh'){echo 'selected="selected"';}?> >Fresh Students</option>
                          <option value="Continuing" <?php if($_SESSION['stuType']=='Continuing'){echo 'selected="selected"';}?>> Continuing Students</option>
                        </select>
                        <select     name="classes" id="classes" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?id='+escape(this.value);">
                      <option value="" >ALL</option>
                      <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
?>
                      <option  <?php if($_GET['id']==$r['code']){echo 'selected="selected"'; }?> ><?php echo $r['code'];?></option>
                      <?php }?>
                    </select>
                    <?php if($_GET[todelete]){
					  $deleter=$_GET[todelete];
					  if($deleter>0){
					  mysql_query("delete from bill where id='$deleter'") or die (mysql_error());
					  }}
					  ?></div></td>
                  <td background="images/back1.png"><select     name="classes2" id="classes2" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?type='+escape(this.value);">
                    <option value="all" >ALL</option>
                    <option <?php if($_SESSION['t']=='Academic'){echo 'selected="selected"';}?> >Academic</option>
                  <option <?php if($_SESSION['t']=='PTA'){echo 'selected="selected"';}?>> PTA</option>
                  <option <?php if($_SESSION['t']=='Boarding'){echo 'selected="selected"';}?>>Boarding</option>
                  <option <?php if($_SESSION['t']=='Others'){echo 'selected="selected"';}?>>Others</option>

                 </select></td>
                  <td><img src="images/new.png" alt="ff" width="51" height="29" onclick="MM_openBrWindow('Addbill.php','','scrollbars=yes,resizable=yes,width=600,height=300')" /></td>
                  <td><img src="images/print.png" alt="sa" width="33" height="24" onclick="MM_openBrWindow('billreport.php?id=<?php echo $_GET['id']; ?>','','menubar=yes,scrollbars=yes,resizable=yes,width=950,height=900')" /></td>
                </tr>
              </table>
            </div>
        </form>
            <div align="center"><span class="style8">
              <?php 
				  
echo "Scores for $_GET[course] in $_GET[form]";				  
				   
				 
				 if($_POST[Edit]){
		  $upper=$_POST['upper'];
		   $upper;
		  for($i=1;$i<$upper;$i++){
		  $cla="class$i";
		  $descr="descr$i";
		  $program="program$i";
		  $form="form$i";
		  $subProg="subProg$i";
		  $boarding="boarding$i";
		  $amount="amount$i";
			$type="type$i";		  
			$stuType="stuType$i";		  
			$stu="stu$i";		  
			$sex="sex$i";		  
		  $classes=$_POST[$cla];
		  $descr=$_POST[$descr];
		  $program=$_POST[$program];
		  $form=$_POST[$form];
		  $subProg=$_POST[$subProg];
		  $boarding=$_POST[$boarding];
		  $amount=$_POST[$amount];
		  $type=$_POST[$type];
		  $stuType=$_POST[$stuType];
		  $sex=$_POST[$sex];

		  $stu=$_POST[$stu];

		  if($teacher=="SELECT CLASS TEACHER old"){echo "<script> alert('PLEASE FILL ALL FIELDS')</script>";}else{
		  mysql_query("update bill set descr='$descr',type='$type' ,program='$program', form='$form', subProg='$subProg', boarding='$boarding',amount='$amount',stu='$stu',stuType='$stuType',sex='$sex' where  id='$classes' ") or die(mysql_error());}
		  
		  
		  }
				} 
				  ?>
          </span>          </div></td>
      </tr>
      <tr>
      
      
        <td valign="top"><form id="form2" name="form2" method="post" action="">
          <div align="center">
            <table width="90%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F9EBE6" class="deco">
                <td width="28">&nbsp;</td>
                <td width="184">Student Type</td>
                <td width="184">Type</td>
                <td width="185"><strong>Description</strong></td>
                <td width="112"><div align="center"><strong>Program</strong></div></td>
                <td width="112">Students</td>
                <td width="59"><strong>Form</strong></td>
                <td width="77"><strong>Sub Form</strong></td>
                <td width="102"><strong>Day/Boarding</strong></td>
                <td width="102">Sex</td>
                <td width="71"><strong>Amount</strong></td>
              </tr>
              <?php 
//include 'connect.php';
if($_GET['id'] and $_GET['id']!="ALL"){
$id=$_GET['id'];

$w=mysql_query("select * from classcode where code='$id'");
while($r=mysql_fetch_array($w)){
$program=$r['program'];
$form=$r['form'];
$subProg=$r['subProg'];}
$inser=" (program='$program' or program='' ) and (form='' or form='$form') and (subProg='' or subProg='$subProg')";
}

if($_SESSION['t']){$type=$_SESSION['t'];$newinsert="( type='$type' or type='')";}

if($_SESSION['stuType']){$stuType=$_SESSION['stuType']; $stuinsert="(stuType='$stuType' or stuType='' )";}
if($inser or $newinsert){$before="and";}
if($inser){$after="and";}

if($_SESSION['t'] or $_GET['id'] or $_SESSION['stuType']){$inswhere='where';}
 $counter=1;
$query="SELECT * FROM bill $inswhere $inser $after $newinsert $before $stuinsert ";		  
//include('pageno.php');
$sql = mysql_query($query) or die (mysql_error());
//echo mysql_num_rows($sql)." Records Returned";
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?todelete=<?php echo $r[id];?>"><img onclick="return confirm('DO YOU REALLY WANT TO DELETE THIS ITME?')" src="images/delete.png" alt="gfg" /></a><a href="<?php echo $_SERVER['PHP_SELF']; ?>?todelete=<?php echo $r[id];?>">
                  <?php 
				  
				   $thecounter=$counter++ ?>
                </a></td>
                <td><select     name="stuType<?php echo $thecounter ?>" id="stuType<?php echo $thecounter ?>" >
                  <option value="" >ALL</option>
                  <option <?php if($r['stuType']=='Fresh'){echo 'selected="selected"';}?>>Fresh</option>
                  <option <?php if($r['stuType']=='Continuing'){echo 'selected="selected"';}?>>Continuing</option>
                </select></td>
                <td><select     name="type<?php echo $thecounter ?>" id="type<?php echo $thecounter ?>" >
                  <option value="" >ALL</option>
                  <option <?php if($r['type']=='Academic'){echo 'selected="selected"';}?> >Academic</option>
                  <option <?php if($r['type']=='PTA'){echo 'selected="selected"';}?>> PTA</option>
                  <option <?php if($r['type']=='Boarding'){echo 'selected="selected"';}?>>Boarding</option>
                  <option <?php if($r['type']=='Others'){echo 'selected="selected"';}?>>Others</option>
                </select></td>
                <td>
                  <label>
                  <div align="center">
                    <input name="descr<?php echo $thecounter ?>" type="text" id="descr<?php echo $thecounter ?>" value="<?php echo $r[descr];?>" size="20" />
                    <input type="hidden" name="class<?php echo $thecounter ?>" id="class<?php echo $thecounter ?>" value="<?php echo $r[id];?>" />
                  </div>
                  </label></td>
                <td >
                  <select name="program<?php echo $thecounter ?>" id="program<?php echo $thecounter ?>">
                    <option value="" >ALL </option>
                    <?php $sqli=mysql_query("select distinct program from classcode ");
		  while($c=mysql_fetch_array($sqli)){
		  ?>
                    <option <?php if($r['program']==$c['program']){echo 'selected="selected"';} ?>  ><?php echo $c['program']; ?></option>
                    <?php }?>
                  </select></td>
                <td ><textarea name="stu<?php echo $thecounter ?>" cols="6" rows="2" id="stu<?php echo $thecounter ?>"><?php echo $r[stu];?></textarea></td>
                <td ><label>
                  <select name="form<?php echo $thecounter ?>" id="form<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r['form']=="1"){echo 'selected="selected"';} ?>>1</option>
                    <option <?php if($r['form']=="2"){echo 'selected="selected"';} ?>>2</option>
                    <option <?php if($r['form']=="3"){echo 'selected="selected"';} ?>>3</option>
                    <option <?php if($r['form']=="4"){echo 'selected="selected"';} ?>>4</option>
                  </select>
                  </label></td>
                <td ><label>
                  <select name="subProg<?php echo $thecounter ?>" id="subProg<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r[subProg]=="1"){echo 'selected="selected"';} ?>>1</option>
                    <option <?php if($r[subProg]=="2"){echo 'selected="selected"';} ?>>2</option>
                  </select>
                  </label></td>
                <td ><label>
                  <select name="boarding<?php echo $thecounter ?>" id="boarding<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r[boarding]=="Day"){echo 'selected="selected"';} ?>>Day</option>
                    <option <?php if($r[boarding]=="Boarding"){echo 'selected="selected"';} ?>>Boarding</option>
                  </select>
                  </label>
                  <label></label></td>
                <td ><label>
                  <select  name="sex<?php echo $thecounter ?>" id="sex<?php echo $thecounter ?>">
                    <option value="" >ALL</option>
                    <option <?php if($r['sex']=='F'){echo 'selected="selected"';}?>>F</option>
                    <option <?php if($r['sex']=='M'){echo 'selected="selected"';}?>>M</option>
                  </select>
                </label></td>
                <td >
                  <label>
                  <input name="amount<?php echo $thecounter ?>" type="text" id="amount<?php echo $thecounter ?>" size="5" value="<?php echo $r[amount];?>" />
                 <?php $total+=$r[amount];?>
                  </label></td>
              </tr> <?php 
				  
								  } ?>
              <tr bordercolor="#AED7FF" >
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" ><div align="center" class="style9">Total</div></td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" ><div align="center"><strong><?php echo number_format($total, 2, '.', ',') ?>&nbsp;</strong></div></td>
              </tr>
            </table>
            <p><strong>
              <label >
              <input type="hidden" name="upper" value="<?php  echo $counter++;?>" id="upper" />
              <input type="submit" name="Edit" id="Edit" value="      UPDATE   " />
              </label>
              <label>
              <input type="submit" name="refresh" id="refresh" value="refresh" />
              </label>
            </strong></p>
            </div>
                    </form>            <p align="center"><strong>
                    <label ></label>
                    </strong></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <th background="images/footer.png"  style="background-repeat:no-repeat"scope="row"><p>&nbsp;</p>
    <p>&nbsp;</p></th>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>

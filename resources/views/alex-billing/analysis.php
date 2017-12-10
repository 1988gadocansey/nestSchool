<?php 
$beef="AD@";

include 'check.php';

if($_GET[id]){
$_SESSION[classes]=$_GET[id];
}


if($_GET[show]){
$_SESSION[show]=$_GET[show];}elseif(!$_SESSION[show]){$_SESSION[show]=3;}


if($_GET[year]){
$_SESSION[year]=$_GET[year];
}

if($_GET[ter]){
$_SESSION[ter]=$_GET[ter];
}
if($_SESSION[year]){}else{$_SESSION[year]=$_SESSION[currentyear];}
if($_SESSION[ter]){}else{$_SESSION[ter]=$_SESSION[currentterm];}

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
<script src="calendar.js"></script>
<style type="text/css">
<!--
.style12 {
	font-family: tahoma;
	font-weight: bold;
}
.style13 {font-family: tahoma;
font-size:12px;}
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
              <table width="90%"  border="0" cellpadding="1" cellspacing="1" background="images/back1.png">
                <tr>
                  <td width="9"><div align="left"></div></td>
                  <td width="256"><select     name="classes" id="classes" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?id='+escape(this.value);">
                    <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
?>
                    <option <?php if($_SESSION[classes]==$r[code]){echo 'selected="selected"'; }?> ><?php echo $r[code];?></option>
                    <?php }?>
                  </select>
                    <select     name="classes3" id="classes3" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);">
                      <?php 
//include 'connect.php';


?>
                      <option <?php if($_SESSION[year]=='2009/2010'){echo 'selected="selected"'; }?> >2009/2010</option>
                      <option <?php if($_SESSION[year]=='2010/2011'){echo 'selected="selected"'; }?> >2010/2011</option>
                      <option <?php if($_SESSION[year]=='2011/2012'){echo 'selected="selected"'; }?> >2011/2012</option>
                     <option <?php if($_SESSION[year]=='2012/2013'){echo 'selected="selected"'; }?> >2012/2013</option>
                  <option <?php if($_SESSION[year]=='2013/2014'){echo 'selected="selected"'; }?> >2013/2014</option>
                   <option <?php if($_SESSION[year]=='2014/2015'){echo 'selected="selected"'; }?> >2014/2015</option>
                    </select>
                    <select     name="classes4" id="classes4" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?ter='+escape(this.value);">
                      <?php 
//include 'connect.php';


?>
                      <option <?php if($_SESSION[ter]=='1'){echo 'selected="selected"'; }?> >1</option>
                      <option <?php if($_SESSION[ter]=='2'){echo 'selected="selected"'; }?> >2</option>
                      <option <?php if($_SESSION[ter]=='3'){echo 'selected="selected"'; }?> >3</option>
                    </select></td>
                  <td width="257"><select name="level2" id="level2" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?show='+escape(this.value);">
                    <option <?php if($_SESSION[show]=='1'){echo 'selected="selected"'; }?> value="1">Graph and Table</option>
                    <option <?php if($_SESSION[show]=='2'){echo 'selected="selected"'; }?> value="2">Graph Only</option>
                    <option  <?php if($_SESSION[show]=='3'){echo 'selected="selected"'; }?> value="3">Table Only</option>
                  </select></td>
                  <td width="256"><input name="search" type="text" size="10" />
                    <input type="submit" name="Submit" value="  Search "  /></td>
                  <td width="51"><div align="center"><img src="images/print.png" alt="print" width="35" height="29" onclick="MM_openBrWindow('printanalysis.php','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></div></td>
                </tr>
              </table>
              <table width="95%" height="167" border="0">
                <tr>
                  <td><p class="style9"> <strong>
                    <?php
				$subs=array(); 
				 $hj="select shortcode,courses.id as cid from subjects,courses where  subjects.name=courses.name and classId='$_SESSION[classes]' ";
				$hh=mysql_query($hj)or die(mysql_error());
				while($s=mysql_fetch_array($hh)){
					// $s[id];
					 $subs["$s[cid]"]=$s['shortcode'];
					}
					//print_r($subs);
					if($_REQUEST[search]){$search=$_REQUEST[search];
					$incl=" and (surname like '%$search%'  or othernames like '%$search%' or students.id = '$search' or position like '%$search%') ";
					}

					
				 $cc="select distinct students.id as id,surname,othernames,position from students,classmems where classmems.stuId=students.id $incl and classmems.term= '$_SESSION[ter]'  and classmems.year='$_SESSION[year]' and 	cname='$_SESSION[classes]' order by total desc";
				$quer=mysql_query($cc) or die(mysql_error());
 while ($v=@mysql_fetch_array($quer)){
 echo "<strong><br/> Name: $v[surname] $v[othernames] <br/> Position:$v[position] ID:$v[id]</strong>";
  $aa="select courseId ,quiz1,quiz2,quiz3,exam,total from grades where grades.stuId='$v[id]' and grades.year='$_SESSION[year]' and grades.term='$_SESSION[ter]' order by courseId asc";

		  	$sub=mysql_query($aa);
$t=mysql_num_rows($sub);
$subject=array();
$quiz1=array();
$quiz2=array();
$quiz3=array();
$exam=array();
while($r = @mysql_fetch_array($sub))

{
 $subid=$r['courseId'];
 $subject[]=$r['courseId'];
$quiz1[]=$r['quiz1'];
$quiz2[]=$r['quiz2'];
$quiz3[]=$r['quiz3'];
$exam[]=$r['exam'];
 }
 
				?>
                  </p>
                    <?php 
				 if($_SESSION[show]==1 or $_SESSION[show]==3){ $tc=array(); ?>
                    <table width="100%" height="119" border="0" cellspacing="3">
                      <tr bgcolor="#F7F0DB" class="deco" >
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                        <?php foreach($subject as $subId){ ?>
                        <td bgcolor="#FFFFFF"><?php echo $subs[$subId]; ?></td>
                        <?php }?>
                        <td bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td width="122">Quiz 1</td>
                        <?php foreach($quiz1 as $quiz){  ?>
                        <td><?php  $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq1+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i='';?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td >Quiz 2</td>
                        <?php foreach($quiz2 as $quiz){ ?>
                        <td ><?php $i++; $tc[$i]+=$quiz; $trow+=$quiz; $totq2+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i=''?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td>Quiz 3</td>
                        <?php foreach($quiz3 as $quiz){ ?>
                        <td><?php $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq3+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i=''?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td>Exam</td>
                        <?php foreach($exam as $quiz){ ?>
                        <td><?php  $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq3+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow='';$i='' ?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td><strong>Total</strong></td>
                        <?php foreach($quiz3 as $quiz){ ?>
                        <td><strong>
                          <?php $i++; $ttc+=$tc[$i]; echo $tc[$i]; ?>
                        </strong></td>
                        <?php }?>
                        <td><strong><?php echo  $ttc; $ttc=0; $i='';$ttrow='';?></strong></td>
                      </tr>
                    </table>
                    <?php }?>
                    <?php if($_SESSION[show]==2 or $_SESSION[show]==1){ ?>
                    <p> <img src="graph.php?id=<?php echo $v[id] ?>" alt="gfg" width="97%"  height="346"/>
                      <?php }}?>
                    </p>
                    <p>&nbsp; </p>
                    <p>&nbsp;</p></td>
                </tr>
              </table>
              <p>
                <input type="hidden" name="upper" value="<?php echo $counter++;?>" id="upper" />
              </p>
            </div>
        </form>
            <div align="center"></div></td>
      </tr>
      <tr>
      <script>
      function check(ids){
	  if(document.getElementById(ids).value >10 ){
	  
	  alert('Score can not be greater than 10');
	  document.getElementById(ids).value="";
	  				document.getElementById(ids).focus();
					//                document.getElementById(ids).select()

return false;
	  }
	  
	  }
      
      </script>
      
        <td valign="top"><p align="center"><strong>
              <?php include('pagelabel.php') ?>
          </strong></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <th background="images/footer.png"  style="background-repeat:no-repeat"scope="row">&nbsp;</th>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>

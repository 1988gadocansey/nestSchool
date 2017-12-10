<?php 
$beef="AD@";
include 'check.php';

if($_GET[id]){
$_SESSION[classes1]=$_GET[id];
}

if($_GET[year1]){
$_SESSION[year1]=$_GET[year1];
}

if($_GET[ter]){
$_SESSION[term]=$_GET[ter];
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
<script src="calendar.js"></script>

<style type="text/css">
<!--
.style20 {	font-size: 9pt;
	font-weight: bold;
}
.style37 {font-size: 9pt}
.style8 {font-weight: bold}
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
                  <td width="436"><select     name="classes1" id="classes1" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?id='+escape(this.value);">
                    <option >All Classes</option>
                    <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
?>
                    <option <?php if($_SESSION[classes1]==$r[code]){echo 'selected="selected"'; }?> ><?php echo $r[code];?></option>
                    <?php }?>
                  </select>
                    <select     name="classes3" id="classes3" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year1='+escape(this.value);">
                      <option >All Years</option>
                      <?php 
//include 'connect.php';


?>
                      <option <?php if($_SESSION[year1]=='2009/2010'){echo 'selected="selected"'; }?> >2009/2010</option>
                      <option <?php if($_SESSION[year1]=='2010/2011'){echo 'selected="selected"'; }?> >2010/2011</option>
                      <option <?php if($_SESSION[year1]=='2011/2012'){echo 'selected="selected"'; }?> >2011/2012</option>
                     <option <?php if($_SESSION[year1]=='2012/2013'){echo 'selected="selected"'; }?> >2012/2013</option>
                  <option <?php if($_SESSION[year1]=='2013/2014'){echo 'selected="selected"'; }?> >2013/2014</option>
                   <option <?php if($_SESSION[year1]=='2014/2015'){echo 'selected="selected"'; }?> >2014/2015</option>
                    </select>
                    <select     name="classes4" id="classes4" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?ter='+escape(this.value);">
                      <option >All Terms</option>
                      <?php 
//include 'connect.php';


?>
                      <option <?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?> >1</option>
                      <option <?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?> >2</option>
                      <option <?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?> >3</option>
                    </select></td>
                  <td width="334"><input name="search" type="text" size="10" />
                    <input type="Submit" name="Submit" value="  Search "  /></td>
                  <td width="51"><div align="center"><img src="images/print.png" alt="print" width="35" height="29" onclick="MM_openBrWindow('printversion.php','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></div></td>
                </tr>
              </table>
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
      
        <td valign="top"><div align="center">
            <table width="99%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="17">&nbsp;</td>
                <td width="195"><div align="center" class="style20">Student Name</div></td>
                <td width="39"><strong>Year</strong></td>
                <td width="41"><strong>Term</strong></td>
                <td width="61"><span class="style20">Total Score</span></td>
                <td width="63"><span class="style20">Position in Class</span></td>
                <td width="74"><div align="center" class="style20">Attendance</div></td>
                <td width="67"><div align="center" class="style20">Conduct</div></td>
                <td width="54"><div align="center" class="style20">Attitude</div></td>
                <td width="49"><div align="center"><span class="style20">Interest</span></div></td>
                <td width="81"><div align="center" class="style20">
                    <p>Form master Report</p>
                </div></td>
                <td width="83"><div align="center"><strong><span class="style37">Head master Report</span></strong></div></td>
                <td width="64" ><div align="center" class="style20">Promoted To</div></td>
              </tr>
              <?php 



			  
if($_GET[cus]){$cus=$_GET[cus];}
$search=$_POST[search];
$it=$_POST[it];
$date1=$_POST[date1];
$date2=$_POST[date2];
if(!$_POST[Submit]){

if($_GET[search]){$search=$_GET[search];}
}
//$_SESSION[currentterm]="";
//include 'connect.php';

  $id=$_SESSION[classes1];
  $ter=$_SESSION[term];
 $year1=$_SESSION[year1];



if($ter=="All Terms"){ $term=""; }else {$term=" and classmems.term = '$ter' "  ;}
if($year1=="All Years"){ $ins=""; }else {$ins=" and classmems.year = '$year1' "  ;}
if($id=="All Classes"){ $in=""; }else {$in=" and classmems.cname = '$id' "  ;}
/*
echo $term;
echo $ins;
echo $in;
*/


$query="SELECT *,classmems.id as id,students.id as idd from classmems,students  where classmems.stuId=students.id $term $ins $in ";		

if($search){$query.=" and ( students.surname = '$search' or students.othernames = '$search' or position='$search' )";}

$show="&search=$search&date1=$date1&date2=$date2&it=$it";

$query=$query." ORDER BY total desc,students.surname asc";

//echo $query;
include('pageno.php');

$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{
?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td ><strong><?php echo $thecounter=$counter++ ?></strong></td>
                <td><?php echo $r[surname].", ".$r[othernames];?>
                    <input type="hidden" name="stu<?php echo $thecounter ?>" id="stu<?php echo $thecounter ?>" value="<?php echo $r[sid];?>" />
                    <input type="hidden" name="idd<?php echo $thecounter ?>" id="idd<?php echo $thecounter ?>" value="<?php echo $r[id];?>" /></td>
                <td><?php echo $r[year]; ?></td>
                <td><?php echo $r[term]; ?></td>
                <td><?php echo ($r[total]); ?></td>
                <td><div align="center"><strong><?php echo $r[position]; ?> </strong></div>
                    <strong>
                    <label></label>
                  </strong></td>
                <td ><strong>
                  <label> </label>
                  </strong>
                    <label><?php echo $r[attendance] ?> </label></td>
                <td ><strong>
                  <label> </label>
                  </strong>
                    <label><?php echo $r[conduct]; ?> </label></td>
                <td ><strong>
                  <label> </label>
                  </strong>
                    <label><?php echo $r[attitude]; ?></label></td>
                <td ><div align="center"><span class="style8"><strong>
                    <label> </label>
                    </strong>
                          <label></label>
                    </span>
                        <label><?php echo $r[interest]; ?> </label>
                </div></td>
                <td ><strong>
                  <label> </label>
                  </strong>
                    <label><?php echo $r[form_mast_report]; ?> </label></td>
                <td ><div align="center"> <?php echo $r[head_mast_report]; ?></div></td>
                <td ><strong>
                  <label> </label>
                  </strong>
                    <label><?php echo $r[cname]?> </label></td>
              </tr>
              <?php 
				  
								  } ?>
            </table>
            <p>
              <input type="hidden" name="upper" value="<?php echo $counter++;?>" id="upper" />
              <label></label>
              <label></label>
            </p>
          </div>          <p align="center"><strong>
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

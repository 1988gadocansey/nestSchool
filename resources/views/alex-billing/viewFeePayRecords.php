<?php 
ob_start();
$beef="AD@";

include 'check.php';

if($_GET[id]){
$_SESSION[choo]=$_GET[id];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Members</title>
<style type="text/css">
<!--
-->
</style>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="calendar.js"></script>

<style type="text/css">
<!--
.style8 {color: #FF0000}
-->
</style>
</head>

<body> 
<?php //include ('bar.php');?>
<table width="1020" height="528" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <td height="120" background="images/banner.png" style="background-repeat:no-repeat" scope="row">&nbsp; </td>
  </tr>
  <tr  background="images/body.png">
    <td height="268" valign="top" scope="row"><table  align="center"width="92%" height="183" border="0"  class="container" cellpadding="0" cellspacing="0">
      <tr >
        <td width="549" height="53" valign="top"><form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div align="center">
              <table width="90%"  border="0" cellpadding="1" cellspacing="1" background="images/back.png">
                <tr>
                  <td width="113"><div align="left"></div></td>
                  <td width="817"><strong>
                    <select     name="classes" id="classes" onchange="document.location.href='viewStudents.php?id='+escape(document.getElementById('classes').value);">
                      <option >ALL</option>
                      <?php 
//include 'connect.php';


$query="SELECT  name FROM classes";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
?>
                      <option <?php if($_SESSION[choo]==$r[name]){echo 'selected="selected"'; }?> ><?php echo $r[name];?></option>
                      <?php }?>
                    </select>
                    </strong>
                    <input name="search" type="text" size="10" />
                    in
                    <input type="submit" name="Submit" value="  Search "  />
                    <strong>between</strong>
                    <input name="date1" type="text" id="date1" size="10"  onfocus="cal.showCal(this)"/>
                    <strong>and</strong>
                    <input name="date2" type="text" id="date2" size="10" onfocus="cal.showCal(this)" /></td><td width="51"><div align="center"><img src="images/print.png" alt="print" width="35" height="29" onclick="MM_openBrWindow('printversion.php','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></div></td>
                </tr>
              </table>
                          </div>
        </form>
            <div align="center"><span class="style8">
              <?php 
				  
				  if($_POST[search])echo "SEARCH OF students BY $_POST[search]";
				  elseif($_GET[cus]) echo "PURCHASE RECORDS FOR classes ($_GET[cus])" ;
				  
				   
				  ?>
          </span></div></td>
      </tr>
      <tr>
        <td valign="top"><div align="center">
            <table width="93%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="17">&nbsp;</td>
                <td width="231"><strong>Name</strong></td>
                <td width="60"><strong>Class</strong></td>
                <td width="65"><strong>Picture</strong></td>
                <td width="65"><strong>Sex</strong></td>
                <td width="86"><strong>Religion</strong></td>
                <td width="79">Date of Birth</td>
                <td>Place of residence</td>
                <td><strong>Fees Paid(GH&cent;) </strong></td>
                <td width="85"><strong>Outstanding  Fees(GH&cent;) </strong></td>
              </tr>
              <?php 
//include 'connect.php';

$na=$_SESSION[choo];

if($na=="ALL"){$na=""; $inse='';}else {$inse="classmems.cname like '%$na%' and";}
if($_GET[cus]){$cus=$_GET[cus];}
$search=$_POST[search];
$date1=datetoT($_POST[date1]);
$date2=datetoT($_POST[date2]);
if(!$_POST[Submit]){
if($_GET[search]){$search=$_GET[search];}
if($_GET[date1]){$date1=$_GET[date1];}
if($_GET[date2]){$date2=$_GET[date2];}
//$it like '%$search%'
}
$query="SELECT * ,students.id as id FROM students,classmems where  students.id=classmems.stuId and $inse classmems.year='$years'";		  

if ($search and !$date1 and !$date2){ $query="SELECT * FROM students where classes like '%$na%' and (vehicleNo='$search' or couponNo='$search' or item like '%$search%') " ; $show="&search=$search";
}elseif ($search and $date1 and $date2) {$query="SELECT * FROM students where classes like '%$na%' and (vehicleNo='$search' or couponNo='$search' or item like '%$search%'or dates like '%$search%' ) and dates > '$date1' and dates < '$date2' "; $show="&search=$search&date1=$date1&date2=$date2";} 
elseif ($search and $date1 and !$date2){ $query="SELECT * FROM students where classes like '%$na%' and (vehicleNo='$search' or couponNo='$search' or item like '%$search%'or dates like '%$search%') and dates='$date1'";
 $show ="&search=$search&date1=$date1&date1";}
elseif (!$search and $date1 and !$date2){ $query="SELECT * FROM students where classes like '%$na%' and dates = '$date1' "; $show="&date1=$date1";
}
elseif (!$search and $date1 and $date2){ $query="SELECT * FROM students where classes like '%$na%' and dates >= '$date1' and dates <= '$date2'"; $show="&date1=$date1&date2=$date2";}
elseif($cus) {$query="SELECT*FROM students where classes='$cus' "; $show="&cus=$cus";}


//$query=$query."dates > '$date1' and dates < '$date2' ";
//$query=$query." ORDER BY  students.id DESC";


include('pageno.php');

//$query="SELECT*,SUM()FROM students where";
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td height="62"><?php echo $counter++ ?></td>
                <td><?php echo $r[surname].' , '.$r[othernames];?></td>
                <td ><?php echo $r[cname];?></td>
                <td ><a href="singlestudent.php?id=<?php echo $r[id]; ?>"><img height="50" width="61"   src="studentPics/<?php echo $r[id]?>.jpg" alt="Insert Picture" /></a></td>
                <td bordercolor="#F7F0DB" ><?php echo $r[sex];?></td>
                <td ><?php echo $r[dates];?></td>
                <td ><?php echo $r[dob];?></td>
                <td width="77" ><?php echo $r[placeOfResidence];?></td>
                <td width="75" ><?php echo  number_format($r[paid], 2, '.', ',');?></td>
                <td ><?php echo  number_format($r[amount]-$r[paid], 2, '.', ',');?></td>
              </tr>
              <?php 
				  
								  } ?>
              <tr bordercolor="#ECE9D8" bgcolor="#FBFBFD" onmousemove="bgcolor="#Cfffff"">
                <td colspan="7"><div align="right" class="style7">
                    <div align="center">
                      <?php if($lastpage==1){echo "TOTAL : "; } ?>
                    </div>
                </div></td>
                <td colspan="2"><span class="style7">
                  <?php 
				
				
				
					  if($lastpage==1){
				$sql = mysql_query($lastquery) or die (mysql_error());
				while($r = mysql_fetch_array($sql))
				{
				  $stotal=$stotal+$r[total];
				  $samount=$samount+$r[amount];
				  if($search){$tquant=$tquant+$r[quant];}

				
				}
				if($search){ echo $tquant;}
				}
					  
			
				
				?>
                </span></td>
                <td><span class="style7">
                  <?php  if($lastpage==1){echo number_format($samount, 2, '.', ',');}?>
                </span></td>
              </tr>
            </table>
        </div>
            <p align="center"><strong>
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

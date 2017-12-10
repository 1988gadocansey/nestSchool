<?php 
ob_start();
$beef="FI@AD";

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
<title>School Management System ::Students</title>
<style type="text/css">
<!--
-->
</style>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="nullifier.js" ></script>

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
<?php include ('bar.php');?>
<table width="1020" height="528" class="content" align="center" cellspacing="0" bordercolor="#0000FF">
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
                  <td width="113" background="images/headback.png"><div align="left"></div></td>
                  <td width="817" background="images/back1.png"><strong>
                    <select     name="classes" id="classes" onchange="document.location.href='feePayRecords.php?id='+escape(this.value);">
                      <option >ALL</option>
                      <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
?>
                      <option <?php if($_SESSION[choo]==$r[code]){echo 'selected="selected"'; }?> ><?php echo $r[code];?></option>
                      <?php }?>
                    </select>
                    </strong>
                    <input name="search" type="text" size="10" />
                    in
                    <span class="style8">
                    <select name="it" id="it">
                      <option value="students.id">Student ID</option>
                      <option value="type">Payment Type</option>
                      <option value="receiptno">Receipt No</option>

                      <option value="surname">surname</option>
                      <option value="othernames">othernames</option>
                       <option value="sex">sex</option>
					<option value="dob">Date of Birth</option>
                      <option value="nationality">nationality</option>
                      <option value="prevschool">Previous school</option>
                      <option value="religion">religion</option>
                      <option value="classAdmited">class Admited</option>
                      <option value="placeOfResidence">place Of Residence</option>
                      <option value="houseNo">House No</option>
                      <option value="contactAddress">Contact Address</option>
                    </select>
                    </span>
                    <input type="submit" name="Submit" value="  Search "  />
                    <strong>between</strong>
                    <input name="date1" type="text" onfocus="cal.showCal(this)" id="date1" size="10" />
                    <strong>and</strong>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
                    <input name="date2" type="text" id="date2" onfocus="cal.showCal(this)" size="10" /></td>
                  <td width="51"><div align="center"><img src="images/print.png" alt="print" width="35" height="29" onclick="MM_openBrWindow('printversion.php','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></div></td>
                </tr>
              </table>
                          </div>
        </form>
            <div align="center"><span class="style8">
              <?php 
				  
				  if($_POST[search])echo "SEARCH OF fee Payment Records BY $_POST[search]";
				  elseif($_GET[cus]) echo "PURCHASE RECORDS FOR classes ($_GET[cus])" ;
				  
				   
				  ?>
          </span></div></td>
      </tr>
      <tr>
        <td valign="top"><div align="center">
            <table width="98%" border="0" cellpadding="1" cellspacing="1" >
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="49">Worker</td>
                <td width="89"><strong>Date</strong></td>
                <td width="34"><strong>Type</strong></td>
                <td width="71">Student ID</td>
                <td width="137"><strong>Name</strong></td>
                <td width="50"><strong>Class</strong></td>
                <td width="67"><strong>Receipt No</strong></td>
                <td width="64"><strong>Draft No</strong></td>
                <td>B/F <strong>(GH&cent;) </strong></td>
                <td><strong>Paid (GH&cent;) </strong></td>
                <td width="53"><strong> Balance (GH&cent;) </strong></td>
                <td width="41">Invalid</td>
                <td width="40">&nbsp;</td>
              </tr>
              <?php 
//include 'connect.php';

$na=$_SESSION[choo];

if($na=="ALL"){$na=""; $inse='';}else {$inse=" and feepayrecord.classes like '%$na%' ";}
if($_GET[cus]){$cus=$_GET[cus];}
$search=$_POST[search];
$it=$_POST[it];
$date1=datetoT($_POST[date1]);
$date2=datetoT($_POST[date2]);
if(!$_POST[Submit]){
$it=$_GET[it];
if($_GET[search]){$search=$_GET[search];}
if($_GET[date1]){$date1=datetoT($_GET[date1]);}
if($_GET[date2]){$date2=datetoT($_GET[date2]);}
//$it like '%$search%'
}
 $query="SELECT * ,students.id as id,feepayrecord.id as fid FROM students,feepayrecord where  students.id=feepayrecord.stuId $inse ";		  

if($search){$query.=" and $it like '%$search%' ";}
if($date1 and !$date2){$query.="and feepayrecord.dates ='$date1'";}elseif($date1 and $date2){$query.="and feepayrecord.dates >='$date1'";}
if($date2){$query.="and feepayrecord.dates <='$date2'";}
$show="&search=$search&date1=$date1&date2=$date2&it=$it";
$query=$query." ORDER BY  feepayrecord.id DESC";

//echo $query;
include('pageno.php');

//$query="SELECT*,SUM()FROM students where";
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td><?php echo $r['worker'];?></td>
                <td height="23"><?php echo Ttodate($r[dates]) ?></td>
                <td><?php echo $r['type'];?></td>
                <td><?php echo $r[id];?></td>
                <td><?php echo $r[surname].' , '.$r[othernames];?></td>
                <td ><?php echo $r[classes];?></td>
                <td ><?php echo $r[receiptno];?></td>
                <td  ><?php echo $r[chequeno];?></td>
                <td width="71" ><?php echo $r[oldbalance];?></td>
                <td width="65" ><?php  echo  number_format($r[paid]+$r[nullvalue], 2, '.', ',');?></td>
                <td ><?php echo  number_format($r[curbalace], 2, '.', ',');?></td>
                <td ><label>
                  <input  name="<?php echo $r[fid] ?>"   type="checkbox" id="<?php echo $r[fid] ?>"  onchange="changeprice(this)"  <?php if($r[nullified]=='yes'){echo 'checked="checked"'."".'disabled="disabled"'  ;} ?>  />
                </label></td>
                <td ><img src="images/print.png" alt="print" width="23" height="20" 
                
               
                
                
                onclick="MM_openBrWindow('reprintreceipt.php?paid=<?php echo $r[paid] ?>&stuid=<?php echo $r[id]; ?>&receipt=<?php echo $r[receiptno]; ?>&type=<?php echo $r[type]; ?>&dates=<?php echo $r[dates]; ?>&out=<?php echo  number_format($r[curbalace], 2, '.', ',');?>&classes=<?php echo $r[classes];?>','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></td>
              </tr>
              <?php 
				  
								  } ?>
              <tr bordercolor="#ECE9D8" bgcolor="#FBFBFD" onmousemove="bgcolor="#Cfffff"">
                <td colspan="8"><div align="right" class="style7">
                    <div align="center">
                      <?php if($lastpage==1){echo "TOTAL : "; } ?>
                    </div>
                </div></td>
                <td><span class="style7">
                  <?php 
				
				
				
					  if($lastpage==1){
				$sql = mysql_query($lastquery) or die (mysql_error());
				while($r = mysql_fetch_array($sql))
				{
				  $spaid+=$r[paid];
					
				
				}
				}
					  
			
				
				?>
                </span></td>
                <td><span class="style9">
                  <?php  if($lastpage==1){echo number_format($spaid, 2, '.', ',');}?></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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

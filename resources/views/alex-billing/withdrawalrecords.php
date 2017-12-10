<?php 
$beef="AD@FI";

ob_start();
include 'check.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Withdrawal Records</title>
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
.style7 {font-size: 12px; font-weight: bold; }
.style8 {color: #FF0000}
-->
</style>
</head>

<body> 
<?php include ('bar.php');?>
<table width="1020" height="532" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <th height="124" background="images/banner.png" style="background-repeat:no-repeat" scope="row">&nbsp; </th>
  </tr>
  <tr  background="images/body.png">
    <td height="268" valign="top" scope="row"><table width="91%" border="0" align="center" class="content">
      <tr>
        <th align="center" valign="top" scope="row"><form id="form1" method="post" action="">
              <div align="center">
                <div align="center">
                  <table width="599" border="0" cellpadding="1" cellspacing="1" background="images/back1.png">
                    <tr>
                      <td><div align="center" class="style8">
                          <input name="search" type="text" size="10" />
                          <input type="submit" name="Submit" value="  Search  "  />
                          <strong>between</strong>
                          <input name="date1" type="text" id="date1" size="5"  onfocus="cal.showCal(this)"/>
                          <strong>and</strong>
                          <input name="date2" type="text" id="date2" size="5" onfocus="cal.showCal(this)" />
                      </div></td>
                      <td><img src="images/print.png" alt="print" width="35" height="29" onclick="MM_openBrWindow('printversion.php','','menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=2000')" /></td>
                    </tr>
                  </table>
                  <span class="style8">
                  <?php 
				  
				  if($_POST[search])echo "SEARCH OF WithdrawalS BY $_POST[search]";
				  
				   
				  ?>
                  </span></div>
                <table width="99%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
                  <tr bgcolor="#E4E7F3" class="deco">
                    <td width="20">&nbsp;</td>
                    <td width="159"><strong>Date</strong></td>
                    <td width="130"><strong>Bank</strong></td>
                    <td width="127"><strong>Withdrawn BY </strong></td>
                    <td><strong>Check No </strong></td>
                    <td><strong>Previous Balance </strong></td>
                    <td width="109"><strong>Amount Withdrawn </strong></td>
                    <td width="132"><strong>Resulting Balance </strong></td>
                  </tr>
                  <?php 
//include 'connect.php';

$search=$_POST[search];
$date1=datetoT($_POST[date1]);
$date2=datetoT($_POST[date2]);
if(!$_POST[Submit]){
if($_GET[bank]){$bank=$_GET[bank];}
if($_GET[search]){$search=$_GET[search];}
if($_GET[date1]){$date1=$_GET[date1];}
if($_GET[date2]){$date2=$_GET[date2];}

}
$query="SELECT*FROM operations where operation='Withdrawal'";		  

if ($search and !$date1 and !$date2){ $query="SELECT*FROM operations where operation='Withdrawal' and (bank='$search' or operatorsname='$search' or checkno='$search' or amount='$search')" ; $show="&search=$search";
}elseif ($search and $date1 and $date2) {$query="SELECT*FROM operations where operation='Withdrawal' and (bank='$search' or operatorsname='$search' or checkno='$search' or amount='$search') and dates > '$date1' and dates < '$date2'"; $show="&search=$search&date1=$date1&date2=$date2";} 
elseif ($search and $date1 and !$date2){ $query="SELECT*FROM operations where operation='Withdrawal' and (bank='$search' or operatorsname='$search' or checkno='$search' or amount='$search') and dates='$date1'";
 $show ="&search=$search&date1=$date1";}
elseif (!$search and $date1 and !$date2){ $query="SELECT*FROM operations where operation='Withdrawal' and dates = '$date1' "; $show="&date1=$date1";
}
elseif (!$search and $date1 and $date2){ $query="SELECT*FROM operations where operation='Withdrawal' and dates > '$date1' and dates < '$date2' "; $show="&date1=$date1&date2=$date2";}
elseif($bank) {$query="SELECT*FROM operations where operation='Withdrawal' and bank='$bank'"; $show="&bank=$bank";}


//$query=$query."dates > '$date1' and dates < '$date2' ";
$query=$query." ORDER BY  id DESC";


include('pageno.php');
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
                  <tr bordercolor="#AED7FF" class="content style16" bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo Ttodate($r[dates]);?></td>
                    <td><a href="withdrawalrecords.php?bank=<?php echo $r[bank];?>"><?php echo $r[bank];?></a></td>
                    <td><?php echo $r[operatorsname];?></td>
                    <td width="96"><?php echo $r[checkno];?></td>
                    <td width="113"><?php echo number_format($r[prevbalance], 2, '.', ',')?></td>
                    <td><?php echo number_format($r[amount], 2, '.', ',');?></td>
                    <td><?php echo  number_format($r[curbalance], 2, '.', ',');?></td>
                  </tr>
                  <?php 
			  } ?>
                  <tr bordercolor="#ECE9D8" bgcolor="#FBFBFD" onmousemove="bgcolor="#Cfffff"">
                    <td colspan="4"><div align="right" class="style7">
                        <div align="center">
                          <?php if($lastpage==1){echo "TOTAL : "; } ?>
                        </div>
                    </div></td>
                    <td colspan="2">&nbsp;</td>
                    <td><span class="style7">
                      <?php 
					
				if($lastpage==1){
				$sql = mysql_query($lastquery) or die (mysql_error());
				
				while($r = mysql_fetch_array($sql))
				{
				 $stotal=$stotal+$r[amount];
				
				}
				
				echo number_format($stotal, 2, '.', ',');
				}
				
				
				 ?>
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
                </form>
          <strong>
          <?php include('pagelabel.php') ?>
          </strong>&nbsp;</th>
      </tr>
    </table>
    </td>
  </tr>
  <tr >
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

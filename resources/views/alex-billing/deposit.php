<?php 
ob_start();
$beef="AD@FI";

include 'check.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="calendar.js"></script>

    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Deposit </title>
<style type="text/css">
<!--
-->
</style>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
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
</head>

<body> 
<?php include ('bar.php');?>
<table width="1020" height="548" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <th height="125" background="images/banner.png" scope="row">&nbsp; </th>
  </tr>
  <tr  background="images/body.png">
    <td height="268" scope="row"><table width="91%" border="0" align="center" class="content">
      <tr>
        <th align="center" valign="top" scope="row"><form id="form1" method="post" action="">
            <div align="center">
              <table width="555" height="362" border="0" align="center" cellpadding="1" cellspacing="1">
                <tr>
                  <td width="589" valign="top"><div align="center">
                      <p>ALL FIELDS MARKED * ARE MANDATORY
                        <?php
  //require ("connect.php");
  //$checker=1;
  if($_POST['submit'])
  {
   $bank= $_POST[bank];
   $depositby= $_POST[depositby];
   $checkno= $_POST[checkno];
   $deposited= $_POST[deposited];
   $dates= datetoT($_POST[dates]);
   
 
   if ($bank=='SELECT BANK' or !$depositby or !$checkno or !$dates or !$deposited){ echo '<script>alert ("PLEASE FILL ALL FIELDS")</script>';} else{
   
			
  $sql= mysql_query("select * from banks where bname='$bank'") or die(mysql_error());
 while ($result=(mysql_fetch_array($sql)))
{
$oldbalance=$result[currentbalance];
$olddeposits=$result[totaldeposits];
}
$newtotaldeposit=$deposited+$olddeposits;
$newbalance=$oldbalance+$deposited;

//echo "new: $newtotal,$newpaid,$newoutstanding";
//echo "old: $oldtotal,$oldpaid,$oldoutstanding";

$sql="UPDATE banks SET totaldeposits = '$newtotaldeposit', currentbalance='$newbalance' WHERE bname='$bank'";
$result=mysql_query($sql) or die (mysql_error()); 
if (!$result)  { $checker=9;}
$operation="Deposit";
  $sql= mysql_query("INSERT INTO operations VALUES ('','$bank','$operation','$depositby','$checkno','$oldbalance','$deposited','$newbalance','$dates')") or die (mysql_error());
if($result){
header("location: $_SERVER[PHP_SELF]");
						exit();
						ob_end_flush();
}

else {echo "<script> alert ('item  not successfullu sold') </script>" ;}
echo mysql_error();
}

										ob_end_flush();

  
  }?>
                      </p>
                    </div>
                      <table width="528" height="168" border="0" align="center" cellpadding="1" cellspacing="8">
                        <tr>
                          <td width="232"><div align="right">Bank * </div></td>
                          <td width="268" valign="middle"><div align="justify">
                              <select name="bank" id="bank">
                                <option>SELECT BANK</option>
                                <?php 
//include 'connect.php';


$query="SELECT * FROM banks";		  
$sql = mysql_query($query) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{

?>
                                <option><?php echo $r[bname];?></option>
                                <?php }?>
                              </select>
                              <img src="images/new.png" alt="" width="37" height="19" onclick="MM_openBrWindow('addbank.php','customer','width=500,height=400')" /> </div></td>
                        </tr>
                        <tr>
                          <td><div align="right">Amount Deposited *</div></td>
                          <td><input name="deposited" type="text" id="deposited" />
                            (Gh Cedis )</td>
                        </tr>
                        <tr>
                          <td><div align="right">Deposited By </div></td>
                          <td><div align="justify">
                              <input name="depositby" type="text" id="depositby"  onkeyup="calc()"/>
                          </div></td>
                        </tr>
                        <tr>
                          <td><div align="right">Check No(if chech) </div></td>
                          <td><div align="justify">
                              <input name="checkno" type="text" id="checkno"  onkeyup="calc()" value="Cash"/>
                          </div></td>
                        </tr>
                        <tr>
                          <td><div align="right">Date * </div></td>
                          <td><div align="justify">
                              <input type="text" name="dates" onfocus="cal.showCal(this)" />
                          </div></td>
                        </tr>
                      </table>
                      <p align="center"><input name="submit" type="submit" id="submit" value="    Submit    " />
                    <input name="cancel" type="submit" class="left-box" id="cancel" value="Cancel" /></p></td>
                </tr>
              </table>
            </div>
          </form>
          </th>
      </tr>
    </table>
    </td>
  </tr>
  <tr >
    <th background="images/footer.png" scope="row">&nbsp;</th>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>

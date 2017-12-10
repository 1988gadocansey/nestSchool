<?php 
ob_start();
$beef="FI@AD";

include 'check.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="calendar.js"></script>

    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Fee Payment</title>
<style type="text/css">
<!--
-->
</style>
<script type="text/javascript" src="images/ajax.js"></script>
 <link href="images/ajax.css"  rel="stylesheet" type="text/css">
 <script src="studInfo.js" ></script>

<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
</style>
</head>

<body onload="document.getElementById('stuid').focus();"> 
<?php include ('bar.php');
?>
<table width="1020" height="548" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <th height="125" background="images/banner.png" scope="row">&nbsp; </th>
  </tr>
  <tr  background="images/body.png">
    <td height="268" scope="row"><table width="91%" border="0" align="center" class="content">
      <tr>
        <th align="center" valign="top" scope="row"><form id="form1" method="post" action="">
            <div align="center">
              <table width="681" height="362" border="0" align="center" cellpadding="1" cellspacing="1">
                <tr>
                  <td width="677" valign="top"><div align="center">
                      <p>ALL FIELDS MARKED * ARE MANDATORY
                        <?php
  //require ("connect.php");
  //$checker=1;
 
  if($_POST['submit'])
  {
   $classes= $_POST['form'];
   $stuId= $_POST['stuid'];
   $checkno= $_POST['checkno'];
   $paid= $_POST['paid'];
   $dates= datetoT(date('d/m/Y'));
   $type=$_POST['type'];
   $paid=0-$paid;
 
   if (!$stuId   or !$paid or !$checkno){ echo '<script>alert ("PLEASE FILL ALL FIELDS")</script>';} else{
  
   
  $sql= mysql_query("select paid, outstanding from students where id='$stuId'") or die(mysql_error());
 while ($result=(mysql_fetch_array($sql)))
{
$oldpaid=$result[paid];
$outstanding=$result[outstanding];
}
$newoutstanding=$outstanding-$paid;

$sql="UPDATE students SET outstanding='$newoutstanding' WHERE id='$stuId'";
$result=mysql_query($sql) or die (mysql_error()); 
if (!$result)  { $checker=9;}
  $sql= mysql_query("INSERT INTO feePayRecord VALUES ('','$stuId','$outstanding','$paid','$newoutstanding','','$checkno','$_SESSION[currentyear]','$_SESSION[currentterm]','$classes','$dates','$type','$_SESSION[name]','','')") or die (mysql_error());
if($result){
header("location: $_SERVER[PHP_SELF]");
						exit();
						ob_end_flush();
}

echo mysql_error();
}

										ob_end_flush();

  
  }?>
                      </p>
                    </div>
                      <table width="849" height="168" border="0" align="center" cellpadding="1" cellspacing="8">
                        <tr>
                          <td><label>
                            <div align="right">
                              <label></label>
                            </div>                          </td>
                          <td valign="middle">&nbsp;</td>
                          <td width="33" valign="middle">&nbsp;</td>
                          <td valign="middle">Picture</td>
                          <td valign="middle"><img      src="studentPics/<?php echo $r[id] ?>.jpg" alt="Insert Picture" name="stu" width="149" height="144" id="stu" /></td>
                        </tr>
                        <tr>
                          <td width="115"><div align="right">
                            <div align="right"></div>
                            <label></label>
                          </div></td>
                          <td valign="middle"><div align="justify"></div></td>
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">Name</td>
                          <td valign="middle"><input name="na1" type="text" id="na1" size="50" />
                          <input type="hidden" name="na" id="na" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Student ID</div></td>
                          <td valign="middle"><input type="text"  onkeydown="sent(this,'studajax.php')" tabindex="1" autocomplete="off"  name="stuid" id="stuid" onblur="showreading();document.getElementById('stu').src='studentPics/'+this.value+'.jpg';" /></td>
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">Class</td>
                          <td valign="middle"><input type="text" name="ss" id="ss" />
                          <input type="hidden" name="form" id="form" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Withdrawal Type</div></td>
                          <td width="214" valign="middle"><select name="type"  tabindex="2" id="type">
                            <option></option>
                            <option>Cash withdrawal</option>
                            <option>Cash Advance</option>
                          </select></td>
                          <td valign="middle"><div align="right"></div></td>
                          <td width="108" valign="middle"><div align="left">Boarding  Outstanding</div></td>
                          <td width="321" valign="middle"><input type="text" name="boardoutstanding1" id="boardoutstanding1" />
                            <input type="hidden" name="boardoutstanding" id="boardoutstanding" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Amount Involved*</div></td>
                          <td valign="middle"><label>
                            <input name="paid" type="text" tabindex="3" id="paid" />
(Gh Cedis )</label></td>
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">PTA Outstanding</td>
                          <td valign="middle"><input type="text" name="ptaoutstanding1" id="ptaoutstanding1" />
                          <input type="hidden" name="ptaoutstanding" id="ptaoutstanding" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Cheque/Cash</div></td>
                          <td><input name="checkno" tabindex="4" type="text" id="checkno"  onkeyup="calc()"/></td>
                          <td>&nbsp;</td>
                          <td>Academc Outstanding</td>
                          <td><input type="text" name="outstanding1" id="outstanding1" />
                          <input type="hidden" name="outstanding" id="outstanding" /></td>
                        </tr><script>
                  
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}      
						
function printpage()
{
     var type=document.getElementById("type").value;

		 if(type==''){
		 alert('Please choose the type of PAYMENT');
		  return false; 
		 }

   pay=document.getElementById("paid").value;
   stuid=document.getElementById("stuid").value;
   receipt=document.getElementById("receiptno").value;
	  
   out=document.getElementById("outstanding").value;
      ptaout=document.getElementById("ptaoutstanding").value;
	     boardout=document.getElementById("boardoutstanding").value;
		 

url="printreceipt.php?paid="+pay+"&stuid="+stuid+"&receipt="+receipt+"&type="+type+"&out="+out+"&ptaout="+ptaout+"&boardout="+boardout;
MM_openBrWindow(url,'receipt','menubar=yes,width=500,height=400');
 
            return true;

}
                        </script>
                      </table>
                      <p align="center"><input name="submit" type="submit" id="submit" tabindex="20"     value="    Submit    " />
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
    <th background="images/footer.png" style="background-repeat:no-repeat" scope="row"><p>&nbsp;</p>
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

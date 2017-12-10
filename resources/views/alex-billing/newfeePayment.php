<?php 
ob_start();
$beef="FI@AD";

include 'check.php';
$indexno=$_GET['index'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<script type="text/javascript" src="images/jquery_002.js"></script>
<script type="text/javascript" src="images/jquery.js"></script>
<script type="text/javascript" src="images/jquery_003.js"></script>
<link rel="stylesheet" type="text/css" 
href="images/jquery.css">
<script type="text/javascript">
$().ready(function() {

   $('#stuid').autocomplete('AjaxstudentFee.php', {
width: 360,
height: 960,
       minChars:1,
       delay:400,
       cacheLength:100,
       matchContains:true,
       max:10,
       formatItem:function(item, index, total, query){
           return "<img height='50' width='50' src='" + item.pic + " '/> "+ item.name + '( ' + item.id+' )' + '( ' + item.outstand+' )'+ '( ' + item.form+' )';
       },
       formatMatch:function(item){
           return item.name+" "+item.id;
       },
       formatResult:function(item){
           return item.id;
       },
       dataType:'json',
       parse:function(data) {
                       return $.map(data, function(item) {
                               return {
                                       data: item,
                                       value: item.id,
                                       result: item.id
                               }
                       });
               }});

});
</script>






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
tr td {
	font-size: 14px;
}
tr td {
	font-size: 16px;
}
-->
</style>
</head>

<body onload="document.getElementById('paid').focus();"> 
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
                      <p><?php
  //require ("connect.php");
  //$checker=1;
 if($_POST['cancel']){
	 header("location:feepay.php");
	 
	 }
 
  if($_POST['submit'])
  {
   $classes= $_POST['form'];
   $stuId= $_POST['stuid'];
   $checkno= $_POST['checkno'];
if(!$checkno){$checkno='cash';}
   $paid= $_POST['paid'];
   $receiptno=$_POST['receiptno'];
   $dates= datetoT(date('d/m/Y'));
   $type=$_POST['type'];
   
   $ptaoutstanding=number_format($_POST['ptaoutstanding'], 2, '.', ',');
$outstanding=number_format($_POST['outstanding'], 2, '.', ',');
//$boardoutstanding=number_format($_POST['boardoutstanding'], 2, '.', ',');

$paybal=$paid;
  if (!$stuId or !$receiptno  or !$paid or !$checkno){ echo '<script>alert ("PLEASE FILL ALL FIELDS")</script>';} else{
$ptapay=$paybal;
$paybal=$paybal-$ptaoutstanding;
if($paybal>0){$ptapay=$ptaoutstanding; 
 }

if($paybal>0 and $outstanding >0){
$acapay=$paybal;
$paybal=$paybal-$outstanding;
if($paybal>0){$acapay=$outstanding;}
$acabal=$outstanding-$acapay;

//insert records into feepayment
$sql= mysql_query("INSERT INTO feePayRecord VALUES ('','$stuId','$outstanding','$acapay','$acabal','$receiptno','$checkno','$_SESSION[currentyear]','$_SESSION[currentterm]','$classes','$dates','Academic','$_SESSION[name]','','')") or die (mysql_error());

//update fee records
$sql="UPDATE students SET paid = (paid+'$acapay'),outstanding='$acabal' WHERE id='$stuId'";
$result=mysql_query($sql) or die (mysql_error()); 


}


if($paybal>0){
	$ptapay=$ptapay+$paybal;
	}

$ptabal=$ptaoutstanding-$ptapay;

//insert records into feepayment
$sql= mysql_query("INSERT INTO feePayRecord VALUES ('','$stuId','$ptaoutstanding','$ptapay','$ptabal','$receiptno','$checkno','$_SESSION[currentyear]','$_SESSION[currentterm]','$classes','$dates','PTA','$_SESSION[name]','','')") or die (mysql_error());

//update fee records
$sql="UPDATE students SET paid = (paid+'$ptapay'),ptaoutstanding='$ptabal' WHERE id='$stuId'";
$result=mysql_query($sql) or die (mysql_error()); 


//start sms
  $sql= mysql_query("select * from students where id='$stuId'") or die(mysql_error());
 while ($res=(mysql_fetch_array($sql)))
{

$outstanding=$res['outstanding']+$res['ptaOutstanding'];
$parentphone=$res['gTel'];
$hassub=$res['sms'];
$sname=$res['surname'].", ".$res['othernames'];
}
if($parentphone and $hassub){
$s="Your Ward $sname just paid an amount of $paid GHc  as school fees leaving a balance of $outstanding. Thank You. ACADEMY";
 
mysql_query("INSERT INTO outbox (
    DestinationNumber,
    TextDecoded,
    CreatorID,
    Coding,
	DeliveryReport 

) VALUES (
    '$parentphone', 
    '$s', 
    'fee_receipt',
    'Default_No_Compression',
	'yes'
)");


//echo $output[0];

}






//header("location: $_SERVER[PHP_SELF]");
	//					exit();
		//				ob_end_flush();


echo mysql_error();
}
 header("location:feepay.php");


										ob_end_flush();

  }?>
                      </p>
                    </div>
                      <table width="849"  border="0" align="center" cellpadding="1" cellspacing="8">
                        <tr>
                          <td width="222"><div align="right">
                            <div align="right">
                              <?php 
				
					 $q=mysql_query("select * from receiptno");
					 while($p=mysql_fetch_array($q))
					 {
					 
					$in=str_pad($p['no'], 8, "0", STR_PAD_LEFT);
					 }
					 mysql_query("update receiptno set no=('$in'+1)");

					 
					 
					 
					 
  
  
					?>
                              Receipt No                            </div>
                            <label></label>
                          </div></td>
                          <td valign="middle"><div align="justify"><?php echo $in; ?>
                            <input name="receiptno" id="receiptno" type="hidden" value="<?php echo $in; ?>"/>
                          </div></td>
                          <td width="326" colspan="3" rowspan="6" align="center" valign="middle"><div align="right"><img <?php picture("studentPics/$indexno.jpg",191)?>  src="<?php echo file_exists("studentPics/$indexno.jpg")? "studentPics/$indexno.jpg":"images/Bdefault.png";?>" alt=" Picture of Student Here" /></div>                            <div align="right"></div></td>
                        
                        </tr>
                        
                        <?php 
						 $sql="select * from students where id='$indexno'";
						$h=mysql_query($sql);
						while ($r=mysql_fetch_array(($h))){
							
							
							
						?>
                        <tr>
                          <td class="style7"><div align="right">Student ID</div></td>
                          <td valign="middle"><?php echo $indexno ?>&nbsp;
                          <input name="stuid" id="stuid" type="hidden" value="<?php echo $indexno; ?>"/></td>
                        </tr>
                        <tr>
                          <td height="21" class="style7"><div align="right">Name</div></td>
                          <td width="263" valign="middle"><?php echo $r['surname']. " ".$r['othernames']; ?><input type="hidden" name="na" id="na" /></td>
                        </tr>
                        <tr>
                          <td align="right" class="style7">form</td>
                          <td valign="middle"><input type="hidden" name="form" id="form" value="<?php echo $r['form']; ?>"/><?php echo $r['form']; ?></td>
                        </tr>
                        <tr>
                          <td class="style7"><div align="right">PTA Outstanding</div></td>
                          <td valign="middle"><input type="hidden" name="ptaoutstanding" id="ptaoutstanding" value="<?php echo $r['ptaOutstanding']; ?>" />
                          <?php echo $r['ptaOutstanding']; ?> (Gh Cedis )</td>
                        </tr>
                        <tr>
                          <td height="30" align="right" class="style7">Academc Outstanding</td>
                          <td><input type="hidden" name="outstanding" id="outstanding" value="<?php echo $r['outstanding']; ?>" />
                            <?php echo $r['outstanding'];} ?> (Gh Cedis )</td>
                        </tr>
                        <tr>
                          <td height="30" align="right" class="style7">&nbsp;</td>
                          <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="30" align="right" class="style7">Amount Paid *</td>
                          <td colspan="4"><input name="paid" type="text" class="style9" id="paid" tabindex="3" />
                          (Gh Cedis )</td>
                        </tr>
                        <tr>
                          <td height="30" align="right" class="style7"> Bank Draft No</td>
                          <td colspan="4"><input name="checkno" type="text" class="style9" id="checkno" tabindex="4"  /></td>
                        </tr>
                        <script>
                  
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}      
						
function printpage()
{


   pay=document.getElementById("paid").value;
   stuid=document.getElementById("stuid").value;
   receipt=document.getElementById("receiptno").value;
	  
   out=document.getElementById("outstanding").value;
      ptaout=document.getElementById("ptaoutstanding").value;
	     boardout=document.getElementById("boardoutstanding").value;
		 

url="printreceipt.php?paid="+pay+"&stuid="+stuid+"&receipt="+receipt+"&out="+out+"&ptaout="+ptaout+"&boardout="+boardout;
MM_openBrWindow(url,'receipt','menubar=yes,width=500,height=400');
 
            return true;

}
                        </script>
                      </table>
                      <p align="center">&nbsp;</p>
                      <p align="center">
                        <input name="submit" type="submit" id="submit" tabindex="20"    onclick="return printpage()" value="    Submit    " />
                        <input name="cancel" type="submit" class="left-box" id="cancel" value="Cancel" />
                    </p></td>
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

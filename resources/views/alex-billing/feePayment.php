<?php 
//ob_start();
$beef="FI@AD";

include 'check.php';
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
   $receiptno=$_POST['receiptno'];
   $dates= datetoT(date('d/m/Y'));
   $type=$_POST['type'];
   
   $ptaoutstanding=number_format($_POST['ptaoutstanding'], 2, '.', ',');
$outstanding=number_format($_POST['outstanding'], 2, '.', ',');
//$boardoutstanding=number_format($_POST['boardoutstanding'], 2, '.', ',');

$paybal=$paid;
  if (!$stuId or !$receiptno  or !$paid or !$checkno){ echo '<script>alert ("PLEASE FILL ALL FIELDS")</script>';} else{
$acapay=$paybal;
$paybal=$paybal-$outstanding;
if($paybal>0){$acapay=$outstanding; 
 }

if($paybal>0 and $ptaoutstanding >0){
$ptapay=$paybal;
$paybal=$paybal-$ptaoutstanding;
if($paybal>0){$ptapay=$ptaoutstanding;}
$ptabal=$ptaoutstanding-$ptapay;

//insert records into feepayment
$sql= mysql_query("INSERT INTO feePayRecord VALUES ('','$stuId','$ptaoutstanding','$ptapay','$ptabal','$receiptno','$checkno','$_SESSION[currentyear]','$_SESSION[currentterm]','$classes','$dates','PTA','$_SESSION[name]','','')") or die (mysql_error());

//update fee records
$sql="UPDATE students SET paid = (paid+'$ptapay'),ptaoutstanding='$ptabal' WHERE id='$stuId'";
$result=mysql_query($sql) or die (mysql_error()); 


}

if($paybal>0){
	$acapay=$acapay+$paybal;
	}

$acabal=$outstanding-$acapay;

//insert records into feepayment
$sql= mysql_query("INSERT INTO feePayRecord VALUES ('','$stuId','$outstanding','$acapay','$acabal','$receiptno','$checkno','$_SESSION[currentyear]','$_SESSION[currentterm]','$classes','$dates','Academic','$_SESSION[name]','','')") or die (mysql_error());

//update fee records
$sql="UPDATE students SET paid = (paid+'$acapay'),outstanding='$acabal' WHERE id='$stuId'";
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

						//				ob_end_flush();

  
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
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">Picture</td>
                          <td valign="middle"><img      src="studentPics/<?php echo $r[id] ?>.jpg" alt="Insert Picture" name="stu" width="149" height="144" id="stu" /></td>
                        </tr>
                        <tr>
                          <td width="109"><div align="right">
                            <div align="right">
                              <?php 
				
				if($_POST['getid']){
					 $q=mysql_query("select * from receiptno");
					 while($p=mysql_fetch_array($q))
					 {
					 
					$in=str_pad($p['no'], 8, "0", STR_PAD_LEFT);
					 }
					 mysql_query("update receiptno set no=('$in'+1)");
					  //str_pad(9135, 4, "0", STR_PAD_LEFT);  // produces "-=-=-Alien"

					 
					 
					 
					 
  
  }
					?>
                              Receipt No
  <input name="receiptno" id="receiptno" type="hidden" value="<?php echo $in; ?>"/>
                            </div>
                            <label></label>
                          </div></td>
                          <td valign="middle"><div align="justify">
                            <input type="text" name="receiptno2"  style="color:#000000"  id="receiptno2" value=" <?php echo $in?>"  <?php if($in){echo 'disabled="disabled"'; }?>/>
                          </div></td>
                          <td valign="middle"><?php if(!$in){ ?>
                            <input type="submit" tabindex="21" name="getid"    id="getid" value="Get No" />
                          <?php }?></td>
                          <td valign="middle">Name</td>
                          <td valign="middle"><input name="na1" type="text" id="na1" size="50" />
                          <input type="hidden" name="na" id="na" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Student ID</div></td>
                          <td valign="middle"><input type="text"  tabindex="1" autocomplete="off"  name="stuid" id="stuid" onblur="showreading();document.getElementById('stu').src='studentPics/'+this.value+'.jpg';" /></td>
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">Class</td>
                          <td valign="middle"><input type="text" name="ss" id="ss" />
                          <input type="hidden" name="form" id="form" /></td>
                        </tr>
                        <tr>
                          <td><div align="right">Amount Paid *</div></td>
                          <td width="174" valign="middle"><input name="paid" type="text" tabindex="3" id="paid" />
(Gh Cedis )</td>
                          <td valign="middle"><div align="right"></div></td>
                          <td width="77" valign="middle">PTA Outstanding</td>
                          <td width="144" valign="middle"><input type="text" name="ptaoutstanding1" id="ptaoutstanding1" />
                          <input type="hidden" name="ptaoutstanding" id="ptaoutstanding" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"> Bank Draft No</div></td>
                          <td valign="middle"><input name="checkno" tabindex="4" type="text" id="checkno"  /></td>
                          <td valign="middle">&nbsp;</td>
                          <td valign="middle">Academc Outstanding</td>
                          <td valign="middle"><input type="text" name="outstanding1" id="outstanding1" />
                          <input type="hidden" name="outstanding" id="outstanding" /></td>
                        </tr><script>
                  
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
		 

url="printreceipt.php?paid="+pay+"&stuid="+stuid+"&receipt="+receipt+"&out="+out+"&ptaout="+ptaout;
MM_openBrWindow(url,'receipt','menubar=yes,width=500,height=400');
 
            return true;

}
                        </script>
                      </table>
                      <p align="center"><input name="submit" type="submit" id="submit" tabindex="20"    onclick="return printpage()" value="    Submit    " />
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

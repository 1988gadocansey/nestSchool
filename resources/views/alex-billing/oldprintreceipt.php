<?php 
$beef="FI@AD";

include 'check.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style3 {
	font-size: 14px;
	font-weight: bold;
}
.style4 {font-size: 18px; font-weight: bold; }
.style6 {font-size: 24px; font-weight: bold; }
-->
</style>
</head>

<body style="font-family:tahoma" onload="window.print();">
<table width="847" height="242" border="0" cellspacing="5">
 <?php for($i=1;$i<3;$i++){?> 
 <tr>
  
    <td><table width="200" border="0">
        <tr>
          <td   style="border:dashed; text-align: left;"><table width="738" height="451" border="0" cellspacing="1">
            <tr>
              <td colspan="4"><table width="663" height="139" border="0">
                    <tr>
                      <td width="167" rowspan="3"><div align="right"><img src="images/crest.jpg" alt="crest" width="105" height="94" /></div></td>
                      <td width="515" height="33"><div align="center" class="style1">Methodist Senior High School</div></td>
                    </tr>
                    <tr>
                      <td><div align="center" class="style3">P.O. Box SP 192 Saltpond</div></td>
                    </tr>
                    <tr>
                      <td><div align="center" class="style4"><span class="style6">Official Receipt</span></div>                        <div align="center"></div></td>
                    </tr>
                    </table>                  
                </td>
            </tr>
            <tr>
              <td><div align="right"><strong>
                <?php 
		$receipt=$_GET['receiptno'];
		$stuid=$_GET['stuid'];
		
		$query="select * from students where id=$stuid";
		$result=mysql_query($query);
		while($r=mysql_fetch_array($result)){
		
		
		?>
                Date</strong></div></td>
              <td style="border-bottom-style:dotted"><?php echo date('D, d/m/Y, g:i a') ?>&nbsp;</td>
              <td><div align="right"><strong>Receitpt No</strong></div></td>
              <td style="border-bottom-style:dotted"><?php echo $_GET['receipt']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><strong>Year</strong></td>
              <td style="border-bottom-style:dotted"><?php echo $_SESSION['currentyear']; ?></td>
              <td><div align="right"><strong>&nbsp;Student ID</strong></div></td>
              <td style="border-bottom-style:dotted"><?php echo $r['id']; ?></td>
            </tr>
            <tr>
              <td width="143" align="right"><strong>Term</strong></td>
              <td style="border-bottom-style:dotted"><?php echo ($_SESSION['currentterm']); ?></td>
              <td width="157"><div align="right"><strong>Form</strong></div></td>
              <td width="135" style="border-bottom-style:dotted"><?php echo $r['form']; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="3" >&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Name</strong></td>
              <td colspan="3" style=" border-bottom-style:dotted"><strong><?php echo $r['surname']." , ".$r['othernames'] ?></strong></td>
            </tr>
            <tr>
              <td><strong>Bill</strong></td>
              <td colspan="3" style=" border-bottom-style:dotted">&nbsp;GH¢<span style="border-bottom-style:dotted">
                <?php  echo abs(number_format($_GET['ptaout']+$_GET['out']+$_GET['boardout'], 2, '.', ','));?>
              </span></td>
            </tr>
            <tr>
              <td><strong>Amount Paid</strong></td>
              <td colspan="3" style=" border-bottom-style:dotted"><span >GH¢ <?php echo $_GET['paid']; ?>&nbsp;(<span ><?php echo convert($_GET['paid']);  ?></span> )</td>
            </tr>
            <tr>
              <td><strong>Being </strong></td>
              <td colspan="3" style="border-bottom-style:dotted"><?php 
			//url="printreceipt.php?paid="+pay+"&stuid="+stuid+"&receipt="+receipt+"&type="+type+"&out="+out+"&ptaout="+ptaout+"&boardout="+boardout;

			
			  if($_GET['type']=="PTA"){$sele=$_GET['ptaout'];}elseif($_GET['type']=="Academic"){$sele=$_GET['out'];}elseif($_GET['type']=="Boarding"){$sele=$_GET['boardout'];}
			  
			  if($_GET['ptaout']+$_GET['out']+$_GET['boardout']-$_GET['paid']>0){echo "Part Payment ";}else {echo "Full Payment ";}?>
                of  School Fees</td>
            </tr>
            <tr>
              <td><strong>   Balance</strong></td>
              <td style="border-bottom-style:dotted" colspan="3">GH¢ <?php  echo abs(number_format($_GET['ptaout']+$_GET['out']+$_GET['boardout']-$_GET['paid'], 2, '.', ','));?>&nbsp;
                  <strong>
                  <?php if($_GET['ptaout']+$_GET['out']+$_GET['boardout']-$_GET['paid']<0){echo "(Credit)";}elseif($_GET['ptaout']+$_GET['out']+$_GET['boardout']-$_GET['paid']<0){echo "(Credit)";} ?></strong>
                  <?php }?></td>
            </tr>
            <tr>
              <td height="79">&nbsp;</td>
              <td colspan="2" valign="top" style="border-bottom-style:dotted"><p><img src="workerSig/<?php echo $_SESSION['wid'] ?>.jpg" alt="ff" width="159" height="54" /><br/>Accountant</p></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  
  </tr><?php }?>
</table>
</body>
</html>

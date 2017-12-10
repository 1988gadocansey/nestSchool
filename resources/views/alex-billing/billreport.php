<?php 
$beef="AD@";

include ('check.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Terminal Report</title>
<script src="sorttable.js"></script>
<style type="text/css">
<!--


@media print
{
table .breaker{page-break-after:always}
}
#apDiv1 {
	position:absolute;
	left:770px;
	top:661px;
	width:550px;
	height:242px;
	z-index:99999;
}
.style11 {font-size: 16px; }
.style12 {
	font-size: 24;
	font-weight: bold;
}
.style13 {
	font-size: 18px;
	/*
	font-weight: bold;
*/
}
-->
</style>
</head>

<body  style="font-family:Tahoma"><table width="900" height="209" border="0">
  <tr>
    <td width="3287">
    <?php 
	
	$theclass=$_GET['id'];
	
	
	
	$gg=$_SESSION['currentterm']%3; 
$newterm= ++$gg;
$newyear=$_SESSION['currentyear'];

if($newterm==1){$newyear=nextyear($_SESSION['currentyear']);
$fs=mysql_query("select nextClass from classcode where code='$theclass'");
while($v=mysql_fetch_array($fs)){
$newclass=$v['nextClass'];

}
}else{$newclass=$theclass;}

	
	if($_SESSION['t']=='Boarding'){$board=1;
	$insert=" and boarding='Boarding' ";
	}
	$ee=mysql_query("select students.id as sid,boardOutstanding,ptaOutstanding,surname,othernames,outstanding,boarding,sex,classcode.program,classcode.form as thestage,classcode.subProg as sub from students,classcode where students.form='$theclass' and students.form=classcode.code $insert  order by surname asc,othernames asc ")or die (mysql_error());
	
	while($t=mysql_fetch_array($ee)){
	
	$stuid=$t['sid'];
	$sex=$t['sex'];
	$thenew="and (bill.stu='' or bill.stu like '%$$stuid%') and (bill.sex='' or bill.sex = '$sex') and (bill.stuType='' or bill.stuType = 'Continuing') ";
	
	?>
    <table width="900" height="1099" border="0">
      <tr>
        <td width="900" align="center" valign="top"><table class="breaker" width="100%" height="27" border="0" style="font-family:tahoma ; font-size:13px;" align="center">
          <tr>
            <th height="121" align="center" valign="top" scope="row"><p><img src="images/BILLBANNER.png" alt="BILLBANNER" width="810" height="113" /></p>              </th>
          </tr>
          <tr>
            <th height="47" align="center" valign="top" scope="row"><div align="center">
                <table  width="851" height="112" border="0" cellspacing="1">
                  <tr>
                    <th height="21" align="center" valign="middle" scope="row"><p align="right" class="style11"><kbd>NAME OF STUDENT: </kbd></p></th>
                    <th height="21" align="center" valign="middle" scope="row"><div align="left">
                        <?php 
 echo $t['surname'].", ".$t['othernames'];

?>
                    </div></th>
                    <th width="23%" align="center" valign="middle" scope="row"><div align="right" class="style11"><kbd>Day/ Boarding: </kbd></div></th>
                    <th align="center" valign="middle" scope="row"><div align="left"><?php echo $t['boarding']; ?></div></th>
                  </tr>
                  <tr>
                    <th scope="row"><div align="right" class="style11"><kbd>FORM: </kbd></div></th>
                    <th scope="row"><div align="left"><?php echo $newclass; ?></div></th>
                    <th scope="row"><div align="right" class="style11"><kbd>TERM: </kbd></div></th>
                    <th width="19%" scope="row"><div align="left"><?php echo $newterm; ?></div></th>
                  </tr>
                  <tr>
                    <th height="45" scope="row"><div align="right" class="style11"><kbd>YEAR:</kbd></div></th>
                    <th height="45" scope="row"><div align="left"><?php echo $newyear; ?></div></th>
                    <th scope="row"><div align="right" class="style11"><kbd>DATE:</kbd></div></th>
                    <th scope="row"><div align="left"><?php echo date('D, d/m/Y') ?></div></th>
                  </tr>
                  <tr>
                    <th width="24%" scope="row"><div align="right" class="style11"><kbd>PROGRAMME:</kbd></div></th>
                    <th scope="row"><div align="left"><?php echo $t[program]; ?></div></th>
                    <th scope="row"><div align="right" class="style11"><kbd>NEXT TERM BEGINS: </kbd></div></th>
                    <th scope="row"><div align="left">
                      <?php $gg=$_SESSION['currentterm']%3; 
$newterm= ++$gg;
if($newterm==1){$newyear=nextyear($_SESSION['currentyear']);}
else{ $newyear=$_SESSION['currentyear'];}
 
 $uu=mysql_query("select dates1 from calendar where year='$newyear' and semester='$newterm'") or die (mysql_error());
 while($w=mysql_fetch_array($uu)){
 echo Ttodate($w['dates1']);
 }
 ?>
                      &nbsp;</div></th>
                  </tr>
                </table>
              <hr/>
                <table width="696" height="100" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF"  class="sortable">
                  <thead style="background-color:#CCCCCC; text-align: center;">
                    <tr>
                      <td height="22" colspan="3" bgcolor="#FFFFFF"><div align="left">Academic Bill</div></td>
                      </tr>
                    <tr>
                      <td  width="460" height="22">Description</td>
                      <td width="121" ><div align="center">Debt</div></td>
                      <td width="105" >Credit</td>
                      </tr>
                  </thead>
                  <tbody>
		  
		  
		   
                    <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
                      <td  >Arrears From Last Term
                        <ae></td>
                      <td ><div align="center">&nbsp;</div></td>
                      <td ><?php if($_SESSION['t']=='Boarding'){ echo $t['boardOutstanding']; $total=$t['boardOutstanding']; } else{echo $t['outstanding']; $total=$t['outstanding'];} ?></td>
                      </tr>
                    <?php 
					  if($_SESSION['t']=='Boarding'){$inner=" and type='Boarding'";}else{ $inner=" and type='Academic'";}
					  $g="SELECT * FROM bill where (program='$t[program]' or program='' ) and (form='' or form='$t[thestage]') and (subProg='' or subProg='$t[sub]') and (boarding='' or boarding='$t[boarding]')  $inner $thenew order by descr asc";
					  $query=mysql_query($g);
					
					while($u=mysql_fetch_array($query)){
					?>
                    <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
                      <td  ><div align="left"><?php echo $u[descr] ?></div></td>
                      <td ><div align="center">
                        <?php $total+=$u['amount']; echo $u['amount']; ?>
                        &nbsp;</div></td>
                      <td >&nbsp;</td>
                      <?php 
				  
								  } ?>
                    </tr>
                    <tr bgcolor="#CCCCCC"  >
                      <td bgcolor="#FFFFFF"  ><div align="right">Total</div></td>
                      <td ><div align="center" class="style12"><strong><?php $thetotal = $total; echo number_format($total, 2, '.', ',') ?></strong></div></td>
                      <td >&nbsp;</td>
                      </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>
                  <tfoot>
                  </tfoot>
                </table><?php if($_SESSION['t']!='Boarding'){?>
                <table width="697" height="100" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF"  class="sortable">
                  <thead style="background-color:#CCCCCC; text-align: center;">
                    <tr>
                      <td height="22" colspan="3" bgcolor="#FFFFFF"><div align="left">PTA  Bill</div></td>
                      </tr>
                    <tr>
                      <td  width="462" height="22">Description</td>
                      <td width="123" ><div align="center">Debt</div></td>
                      <td width="102" >Credit</td>
                      </tr>
                  </thead>
                  <tbody>
                    <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
                      <td  >Arrears From Last Term
                        <ae></td>
                      <td ><div align="center">&nbsp;</div></td>
                      <td ><?php echo $t['ptaOutstanding']; $total=$t['ptaOutstanding'];?></td>
                      </tr>
                    <?php $query=mysql_query("SELECT * FROM bill where (program='$t[program]' or program='' ) and (form='' or form='$t[thestage]') and (subProg='' or subProg='$t[sub]') and (boarding='' or boarding='$t[boarding]') and type='PTA' $thenew order by descr asc");
					
					while($u=mysql_fetch_array($query)){
					?>
                    <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
                      <td  ><div align="left"><?php echo $u[descr] ?></div></td>
                      <td ><div align="center">
                          <?php $total+=$u['amount']; echo $u['amount'] ?>
                        &nbsp;</div></td>
                      <td >&nbsp;</td>
                      <?php 
				  
								  } ?>
                    </tr>
                    <tr bgcolor="#CCCCCC"  >
                      <td bgcolor="#FFFFFF"  ><div align="right">Total (GH<strong>¢</strong>)</div></td>
                      <td ><div align="center" class="style12"><strong><?php $thetotal +=$total; echo number_format($total, 2, '.', ',') ?></strong></div></td>
                      <td >&nbsp;</td>
                      </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>
                  <tfoot>
                  </tfoot>
                </table>
                <?php 
				if(mysql_num_rows(mysql_query("SELECT * FROM bill where (program='$t[program]' or program='' ) and (form='' or form='$t[thestage]') and (subProg='' or subProg='$t[sub]') and (boarding='' or boarding='$t[boarding]')and (stu='' or stu like '%$stuid%') and type='Others' $thenew order by descr asc"))>0){
				
				?>
<table width="697" height="100" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF"  class="sortable">
                  <thead style="background-color:#CCCCCC; text-align: center;">
                    <tr>
                      <td height="22" colspan="3" bgcolor="#FFFFFF"><div align="left">Others</div></td>
                    </tr>
                    <tr>
                      <td  width="460" height="22">Description</td>
                      <td width="124" ><div align="center">Debt</div></td>
                      <td width="103" >Credit</td>
                      </tr>
                  </thead>
                  <tbody>

                    <?php $query=mysql_query("SELECT * FROM bill where (program='$t[program]' or program='' ) and (form='' or form='$t[thestage]') and (subProg='' or subProg='$t[sub]') and (boarding='' or boarding='$t[boarding]')and (stu='' or stu like '%$stuid%') and type='Others' order by descr asc");
					$totalothers=0;
					while($u=mysql_fetch_array($query)){
					?>
                    <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
                      <td  ><div align="left"><?php echo $u[descr] ?></div></td>
                      <td ><div align="center">
                          <?php $totalothers+=$u['amount']; echo $u['amount'] ?>
                        &nbsp;</div></td>
                      <td >&nbsp;</td>
                      <?php 
				  
								  } ?>
                    </tr>
                    <tr bgcolor="#CCCCCC"  >
                      <td bgcolor="#FFFFFF"  ><div align="right">Total (GH<strong>¢</strong>)</div></td>
                      <td ><div align="center" class="style12"><strong>
                        <?php $thetotal +=$totalothers; echo number_format($totalothers, 2, '.', ',') ?>
                      </strong></div></td>
                      <td >&nbsp;</td>
                    </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>
                  <tfoot>
                  </tfoot>
                </table>
                <p><?php }?>&nbsp;                  </p>
                <p>
                  <?php }?>
                </p>
                <table width="687" height="12" border="0">
                  <tr>
                    <td width="175">GRAND TOTAL(GH<strong>¢</strong>):</td>
                    <td width="141" bgcolor="#CCCCCC"><span class="style13">
                      <?php  echo number_format($thetotal, 2, '.', ',') ?></span></td>
                    <td width="357" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>TOTAL AMOUNT IN WORDS :</td>
                    <td colspan="2"><span class="sortable"><?php echo convert(abs($thetotal));if($thetotal<0){echo " (Credit)";}  ?></span></td>
                  </tr>
                </table>
                <hr/>
                <p align="left">NB: All payments must be made by PAYMENT ORDER</p>
                <p align="left">THIS BILL IS SUBJECT TO REVIEW</p>
                <table width="200" border="0" align="left">
                  <tr>
                    <td height="61" valign="top"><img src="images/ACCOUNT.jpg" alt="F" width="228" height="59" /></td>
                  </tr>
                  <tr>
                    <td><div align="center">PRIN. ACCOUNTANT</div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <p align="left"></p>
                <p>&nbsp;</p>
            </div></th>
          </tr>
          <tr>
            <th align="center" valign="top" scope="row"> </th>
          </tr>
        </table>
          <p align="left">&nbsp;</p>
          </td>
      </tr>
    </table>
    <p>
      <?php  } ?>
    </p></td>
  </tr>
</table>
</body>
</html>
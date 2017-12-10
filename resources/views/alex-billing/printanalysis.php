<?php include('check.php')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Broadsheet</title>
<style type="text/css">
<!--
.style12 {	font-family: tahoma;
	font-weight: bold;
}
.style13 {font-family: tahoma;
font-size:12px;}
.style14 {font-weight: bold}
-->
</style>
</head>

<body>
<p align="center"><img src="images/printout.png" width="700" height="111" alt="BANNER" /></p>
<p align="center" class="style12">Form: <?php echo $_SESSION['classes']; ?> Year:<?php echo $_SESSION['year']; ?> Term:<?php echo $_SESSION['ter']; ?> </p>
<p align="center" class="style12"><table  align="center"width="92%" height="183" border="0"  class="container" cellpadding="0" cellspacing="0">
      <tr>
        <td width="549" height="53" valign="top"><form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div align="center">
              <table width="95%" height="167" border="0">
                <tr>
                  <td><p class="style9"> <strong>
                    <?php
				$subs=array(); 
				 $hj="select shortcode,courses.id as cid from subjects,courses where  subjects.name=courses.name and classId='$_SESSION[classes]' ";
				$hh=mysql_query($hj)or die(mysql_error());
				while($s=mysql_fetch_array($hh)){
					// $s[id];
					 $subs["$s[cid]"]=$s['shortcode'];
					}
					//print_r($subs);
					if($_REQUEST[search]){$search=$_REQUEST[search];
					$incl=" and (surname like '%$search%'  or othernames like '%$search%' or students.id = '$search' or position like '%$search%') ";
					}

					
				 $cc="select distinct students.id as id,surname,othernames,position from students,classmems where classmems.stuId=students.id $incl and classmems.term= '$_SESSION[ter]'  and classmems.year='$_SESSION[year]' and 	cname='$_SESSION[classes]' order by total desc";
				$quer=mysql_query($cc) or die(mysql_error());
 while ($v=@mysql_fetch_array($quer)){
 echo "<strong><br/> Name: $v[surname] $v[othernames] <br/> Position:$v[position] ID:$v[id]</strong>";
  $aa="select courseId ,quiz1,quiz2,quiz3,exam,total from grades where grades.stuId='$v[id]' and grades.year='$_SESSION[year]' and grades.term='$_SESSION[ter]' order by courseId asc";

		  	$sub=mysql_query($aa);
$t=mysql_num_rows($sub);
$subject=array();
$quiz1=array();
$quiz2=array();
$quiz3=array();
$exam=array();
while($r = @mysql_fetch_array($sub))

{
 $subid=$r['courseId'];
 $subject[]=$r['courseId'];
$quiz1[]=$r['quiz1']*10;
$quiz2[]=$r['quiz2']*10;
$quiz3[]=$r['quiz3']*10;
$exam[]=$r['exam']*100/70;
 }
 
				?>
                  </p>
                    <?php 
				 if($_SESSION[show]==1 or $_SESSION[show]==3){ $tc=array(); ?>
                    <table width="100%" height="119" border="0" cellspacing="3">
                      <tr bgcolor="#F7F0DB" class="deco" >
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                        <?php foreach($subject as $subId){ ?>
                        <td bgcolor="#FFFFFF"><?php echo $subs[$subId]; ?></td>
                        <?php }?>
                        <td bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td width="122">Quiz 1</td>
                        <?php foreach($quiz1 as $quiz){  ?>
                        <td><?php  $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq1+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i='';?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td >Quiz 2</td>
                        <?php foreach($quiz2 as $quiz){ ?>
                        <td ><?php $i++; $tc[$i]+=$quiz; $trow+=$quiz; $totq2+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i=''?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td>Quiz 3</td>
                        <?php foreach($quiz3 as $quiz){ ?>
                        <td><?php $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq3+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow=''; $i=''?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td>Exam</td>
                        <?php foreach($exam as $quiz){ ?>
                        <td><?php  $i++;  $tc[$i]+=$quiz; $trow+=$quiz; $totq3+=$quiz; echo $quiz; ?></td>
                        <?php }?>
                        <td><strong>
                          <?php $ttrow+=$trow; echo $trow;$trow='';$i='' ?>
                        </strong></td>
                      </tr>
                      <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'">
                        <td><strong>Total</strong></td>
                        <?php foreach($quiz3 as $quiz){ ?>
                        <td><strong>
                          <?php $i++; $ttc+=$tc[$i]; echo $tc[$i]; ?>
                        </strong></td>
                        <?php }?>
                        <td><strong><?php echo  $ttc; $ttc=0; $i='';$ttrow='';?></strong></td>
                      </tr>
                    </table>
                    <?php }?>
                    <?php if($_SESSION[show]==2 or $_SESSION[show]==1){ ?>
                    <p> <img src="graph.php?id=<?php echo $v[id] ?>" alt="gfg" width="97%"  height="346"/>
                      <?php }}?>
                    </p>
                    <p>&nbsp; </p>
                    <p>&nbsp;</p></td>
                </tr>
              </table>
              <p>
                <input type="hidden" name="upper" value="<?php echo $counter++;?>" id="upper" />
              </p>
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
      
        <td valign="top"><p align="center"><strong>
              <?php include('pagelabel.php') ?>
          </strong></p></td>
      </tr>
    </table>&nbsp;</p>
</body>
</html>

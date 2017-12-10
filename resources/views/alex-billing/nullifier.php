<?php

//A date in the past
$name=$_GET[name];
$valu=$_GET[value];
//$name='ALWAYS PAD';
include ('connect.php');
$q="select * from feepayrecord where id='$name'";
$d=mysql_query($q);
while($ff=mysql_fetch_array($d)){
$type=$ff['type'];
$nullvalu=$ff['paid'];
if($type=="Academic"){$out="outstanding";}
     
	  if($type=="PTA"){$out="ptaOutstanding";}
      if($type=="Boarding"){$out="boardOutstanding";}
      if($type=="Cash withdrawal"){$out="outstanding";}
	  
      if($type=="Cash Advance"){$out="outstanding";}

echo $v="update students set $out=$out+$ff[paid] where id='$ff[stuId]'";
mysql_query($v) or die(mysql_error());
}



echo $sql="UPDATE feepayrecord SET nullified = '$valu',paid='',nullvalue='$nullvalu' WHERE id ='$name'";
$result = mysql_query($sql)or die(mysql_error());

?>

<?php

//header('Content-Type: text/xml');
//header("Cache-Control: no-cache, must-revalidate");
//A date in the past
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$name=$_GET[name];
$valu=$_GET[value];
$reason=$_GET['type'];
//$name='ALWAYS PAD';
include ('check.php');
$who=explode(_,$name);

 $type=$who[0];
$id=$who[1];

if($type=="outstanding"){$feetype="School Fees";}elseif($type=="ptaOutstanding"){$feetype="PTA Dues";}

$ss=mysql_query("select form,$type from students where id='$id'");
while($d=mysql_fetch_array($ss)){
$form=$d['form'];		
$thetype=$d[$type];		
	}

$year=$_SESSION['currentyear'];
$term=$_SESSION['currentterm'];
$user=$_SESSION['name'];
$dates=datetoT(date('d/m/Y'));
$curbalance=$thetype-$valu;

$sql1="INSERT INTO feeadjustment (`stuId`, `oldbalance`, `change`, `curbalance`, `type`, `dates`, `classes`, `year`, `term`, `worker`,`comment`) VALUES ('$id', '$thetype', '$curbalance', '$valu', '$feetype', '$dates', '$form', '$year', '$term', '$user','$reason')";
$result = mysql_query($sql1) or die(mysql_error());


$sql="UPDATE students SET $type = '$valu' WHERE id ='$id'";
$result = mysql_query($sql);
?>

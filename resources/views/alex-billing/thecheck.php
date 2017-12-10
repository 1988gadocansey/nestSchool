
<?php 
session_start() ;
$_SESSION[wid];
$beefer=explode("@",$beef);
if($beefer[0]=="AD"){$locate1="administrator";}if($beefer[1]=="AD"){$locate2="administrator";}if($beefer[2]=="AD"){$locate3="administrator";}
if($beefer[0]=="TE"){$locate1="Teacher";}if($beefer[1]=="TE"){$locate2="Teacher";}if($beefer[2]=="TE"){$locate3="Teacher";}
if($beefer[0]=="FI"){$locate1="Financial Administrator";}if($beefer[1]=="FI"){$locate2="Financial Administrator";}if($beefer[2]=="FI"){$locate3="Financial Administrator";}

if($_SERVER['HTTP_REFERER']==""){header("location:index1.php");}
if (!$_SESSION[name]) header("location:index.php");
if(!$_SESSION[level]) header("location:index.php");
//if($_SESSION[level]!=$locate1 and $_SESSION[level]!=$locate2 and $_SESSION[level]!=$locate3) header("location:index.php");

header( 'refresh: 1200; url=index.php' );

if($_GET['y']){ $_SESSION['currentyear']=$_GET['y'];}
if($_GET['t']){ $_SESSION['currentterm']=$_GET['t'];}


if((time()-$_SESSION['oldtime'])>(60*20)){			
$_SESSION="";
session_destroy();
header("location:index.php");
}
$_SESSION['oldtime']=time();


include ('connect.php');
date_default_timezone_set('GMT');
function datetoT($date){
//$dates     = explode("/", date("m/d/Y"));
$dates=explode("/",$date);
$month     = $dates['1'];
$day       = $dates['0'];
$year      = $dates['2'];
$yesterday = @mktime(0,0,0,$month,$day,$year);
//echo $yesterday;
return $yesterday;
//$notification = date('d/m/Y',$yesterday);
}

function sqldate($date){
//$dates     = explode("/", date("m/d/Y"));

if($date==""){return ;}
$dates=explode("/",$date);
$month     = $dates['1'];
$day       = $dates['0'];
$year      = $dates['2'];
$yester = "$year-$month-$day";
//echo $yesterday;
return $yester;
//$notification = date('d/m/Y',$yesterday);
}

function Ttodate($T){
$day = @date('D, d/m/Y',$T);
return $day;
}
 //echo Ttodate('1245711600');
 
 //echo datetoT('23/06/2009');

function picture($path,$target){
	if(file_exists($path)){
	$mypic = getimagesize($path);

 $width=$mypic[0];
	$height=$mypic[1];

if ($width > $height) {
$percentage = ($target / $width);
} else {
$percentage = ($target / $height);
}

//gets the new value and applies the percentage, then rounds the value
 $width = round($width * $percentage);
$height = round($height * $percentage);

echo "width=\"$width\" height=\"$height\"";

 
	
	}else{}}
	
	
function nextyear($currenyear){
$pp=explode("/",$currenyear);
//echo $pp[0];

return $pp[1]."/".($pp[1]+1);
}


function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function convert_number($number)
{
if (($number < 0) || ($number > 999999999))
{
return "$number";
}

$Gn = floor($number / 1000000); /* Millions (giga) */
$number -= $Gn * 1000000;
$kn = floor($number / 1000); /* Thousands (kilo) */
$number -= $kn * 1000;
$Hn = floor($number / 100); /* Hundreds (hecto) */
$number -= $Hn * 100;
$Dn = floor($number / 10); /* Tens (deca) */
$n = $number % 10; /* Ones */

$res = "";

if ($Gn)
{
$res .= convert_number($Gn) . " Million";
}

if ($kn)
{
$res .= (empty($res) ? "" : " ") .
convert_number($kn) . " Thousand";
}

if ($Hn)
{
$res .= (empty($res) ? "" : " ") .
convert_number($Hn) . " Hundred";
}

$ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
"Nineteen");
$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
"Seventy", "Eigthy", "Ninety");

if ($Dn || $n)
{
if (!empty($res))
{
$res .= " and ";
}

if ($Dn < 2)
{
$res .= $ones[$Dn * 10 + $n];
}
else
{
$res .= $tens[$Dn];

if ($n)
{
$res .= "-" . $ones[$n];
}
}
}

if (empty($res))
{
$res = "zero";
}

return $res;

//$thea=explode(".",$res);

}

function convert($amt){
//$amt = "190120.09" ;

 $amt = number_format($amt, 2, '.', '');
$thea=explode(".",$amt);

//echo $thea[0];


$words=convert_number($thea[0])." Ghana Cedis ";
if($thea[1]>0){$words.= convert_number($thea[1]) ." Pesewas";}

return $words;
}
?>

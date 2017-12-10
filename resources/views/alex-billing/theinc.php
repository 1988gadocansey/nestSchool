<?php
function read(){ 
$file = 'news.php' ; 
// open file 
$fh = @fopen($file, 'r'); 
// read file contents 
$data = @fread($fh, filesize($file)) ; 
fclose($fh); 
//echo $data; 
//echo "<br/>";
return $data;


}

function read1(){

session_write_close();

exec("hostname", $output);
session_start();
// echo $mac;
//echo "<br/>";
return $output[0];
}

session_start();


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
function Ttodate($T){
$day = @date('d/m/Y',$T);
return $day;
}
				 
				  date_default_timezone_set('GMT');
				  $date=date("j F, Y, g:i a");
				 $dates=datetoT(date("d/m/Y"));


if(read()){
		  
//@rename('screen.php','promotions.php');

				  if ($_POST[Submit]){


				  if($_POST['user'] and $_POST['pass']){
				  require("connect.php");
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
				 
				 

				 
				  $user=mysql_prep($_POST['user']); $pass=mysql_prep($_POST['pass']);
				  $userip=$_SERVER[REMOTE_ADDR];
				  $pass=md5($pass);
				  $query="select workers.id as wid,workers.Name as na,workers.title as title,level  from log,workers where user='$user' and pass='$pass' and active='Enabled' and workers.id=log.name and (ip like '%$userip%' or ip='ANY')";
				  $result=mysql_query($query)or die(mysql_error());
				  if (mysql_num_rows($result)==1){
				 while($r=mysql_fetch_array($result)){
				 $_SESSION['name']=$r['title']." ".$r['na'];
				 $_SESSION['level']=$r['level'];
				 $_SESSION['wid']=$r['wid'];
				 $_SESSION['oldtime']=time();

				 } 
				 
				 
				 $query="select * from year";
				 $result=mysql_query($query);
				while($r=mysql_fetch_array($result)){
				$_SESSION['currentyear']=$r[year];
				  $_SESSION['currentterm']=$r[term];


				}
		
		
		mysql_query("insert into userlog values('','$dates','$_SERVER[REMOTE_ADDR] -$_SESSION[name] LOGGED IN the system at $date ') ");

				   header("location:viewStudents.php");

				  }				 
				  else{ 
				  				mysql_query("insert into userlog values('','$dates','$_SERVER[REMOTE_ADDR] - system DENIED access to user with username:$user and password:$pass at $date') ");

				  echo "<script> alert(' WRONG USERNAME OR PASSWORD')</script>";
				  }
				  
				  }else echo "<script> alert(' PLEASE ENTER  USERNAME OR PASSWORD')</script>";
				  }
}elseif($_SERVER['REMOTE_ADDR']=="127.0.0.1"){}else{}
 

?>
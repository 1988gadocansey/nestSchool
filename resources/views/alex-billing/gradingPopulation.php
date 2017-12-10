<?php 
$beef="AD@FI@TE";

include 'connect.php';
$term=$_SESSION['currentterm'];

if($specialId){
$inner="where id='$specialId'";
}

$st=mysql_query("select students.id as stuid,form,Combination from students $inner ") or die (mysql_error()) ;
while($d=mysql_fetch_array($st)){



if($d['Combination']!=""){
$cos=explode("|",$d['Combination']);
$st1=mysql_query("select courses.id as courseid from courses,subjects where classId='$d[form]' and courses.name=subjects.name and subjects.type='elective' and (subjects.shortcode='$cos[0]' or subjects.shortcode='$cos[1]' or subjects.shortcode='$cos[2]' or subjects.shortcode='$cos[3]') ") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$_SESSION[currentyear]' and term='$term'"))>0){}else
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$_SESSION[currentyear]','$term','','$d[form]')") or die(mysql_error());
}



$st1=mysql_query("select courses.id as courseid from courses,subjects where classId='$d[form]' and courses.name=subjects.name and subjects.type='core'") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$_SESSION[currentyear]' and term='$term'"))>0){}else
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$_SESSION[currentyear]','$term','','$d[form]')") or die(mysql_error());
}


}else{
				
$st1=mysql_query("select courses.id as courseid from courses where classId='$d[form]' ") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$_SESSION[currentyear]' and term='$term'"))>0){}else
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$_SESSION[currentyear]','$term','','$d[form]')") or die(mysql_error());
}

}
}





 ?>
<?php 
ob_start();
$beef="AD@";include ('check.php');
   $dates= datetoT(date('d/m/Y'));
 


//select promoton status of students lastyear last term

$gg=$_SESSION['currentterm']%3; 
$newterm= ++$gg;

if($newterm==1){
$newyear=nextyear($_SESSION['currentyear']);
}
else {$newyear=$_SESSION['currentyear'];}
//GET THE NEXT CLASS AND STUDENT IDs 
 $sql="select promotedTo,stuId from classmems where year='$_SESSION[currentyear]' and term='$_SESSION[currentterm]' and promotedTo !='ALUMNI'";
$pro=mysql_query($sql) or die(mysql_error());
 mysql_num_rows($pro);
while($q=mysql_fetch_array($pro)){

	set_time_limit(500);

//IF THE NEXT CLASS IS AN ALUMNI CLASS  
				
				//echo "GET THE BOARDING STATUS AND FORM OF STUDENTS WHO HAVE NOT COMPLETED";
				$ww=mysql_query("select id,form,boarding,sex,outstanding,ptaOutstanding,boardOutstanding from students  where id='$q[stuId]' and dateofcompletion=''")or die(mysql_error());  while($e=mysql_fetch_array($ww)){
			 	 $board=$e['boarding'];
				 $for=$e['form'];
				$sex=$e['sex'];
				$id=$e['id'];
				$outstanding=$e['outstanding'];
//			echo "Old Balance=".$outstanding;
	//		echo "<br/>";
				$ptaOutstanding=$e['ptaOutstanding'];
				$boardOutstanding=$e['boardOutstanding'];
				}
				
				if($q['promotedTo']==''){$theform=$for;}else {$theform=$q['promotedTo']; }
				
				$acafee='';
				$ptafee='';
				$boardingfee='';
				
				//search for the fee for the class
				
				//search for the fee for the class
	set_time_limit(500);
				
				//$query=mysql_query("SELECT sum(amount) as total FROM bill,classcode where (bill.program=classcode.program or bill.program='' ) and (bill.form='' or bill.form=classcode.form) and (bill.subProg='' or bill.subProg=classcode.subProg) and (bill.boarding='' or bill.boarding='$board') and (bill.stu='' or bill.stu like '%$id%')  and (bill.sex='' or bill.sex = '$sex') and (bill.stuType='' or bill.stuType = 'Continuing')   and classcode.code='$theform' and (type='academic' or type='Others' or type='others')  order by descr asc")or die(mysql_error());
					
					//while($u=mysql_fetch_array($query)){
				//$acafee=$u['total'];
	
	}
	 //$query=mysql_query("SELECT sum(amount) as total FROM bill,classcode where (bill.program=classcode.program or bill.program='' ) and (bill.form='' or bill.form=classcode.form) and (bill.subProg='' or bill.subProg=classcode.subProg) and (bill.boarding='' or bill.boarding='$board') and (bill.stu='' or bill.stu like '%$id%')  and (bill.sex='' or bill.sex = '$sex') and (bill.stuType='' or bill.stuType = 'Continuing') and classcode.code='$theform' and type='PTA' order by descr asc")or die(mysql_error());
					
		//			while($u=mysql_fetch_array($query)){
			//		 $ptafee=$u['total'];
	
	//}
	
		//		$acapay=0;
			//	$ptapay=0;
				//$boardpay=0;
				/*			
if($outstanding<0){
$paybal=$outstanding;
$acapay=$paybal;
$paybal=$paybal+$acafee;
	set_time_limit(500);

if($paybal<0){$acapay=-($acafee); 
 }
if($paybal<0 and $ptafee >0){
$ptapay=$paybal;
$paybal=$paybal+$ptafee;
if($paybal<0){$ptapay=-($ptafee);}
$ptabal=$ptafee+$ptapay;
}


if($paybal<0 and $boardingfee>0){
$boardpay=$paybal;

$paybal=$paybal+$boardingfee;
if($paybal<0){$boardpay=-($boardingfee);}
$boardbal=$boardingfee+$boardpay;
}
  
	set_time_limit(500);

if($paybal<0){
	$acapay=$acapay+$paybal;
	}

$acabal=$acafee+$acapay;
$outstanding=0;
 $academic="outstanding=$acafee+$acapay";
			}else{
				*/
//$acabal=$outstanding+$acafee+$acapay;

 //$academic="outstanding=outstanding+".$acafee;
	//			}
				
//echo $fee;echo "{}";


			//promote students accordingly
		//	$pat=$ptafee+$ptapay;
			$dd="update students set form='$theform' where id='$q[stuId]'";
		mysql_query($dd) or die(mysql_error());

//$acapay=abs($acapay);
 //$bb="INSERT INTO feePayRecord VALUES ('','$q[stuId]','$outstanding','$acapay','$acabal','','$checkno','$newyear','$newterm','$theform','$dates','Academic Bill','$_SESSION[name]','','','$acafee')";
//$sql= mysql_query($bb) or die (mysql_error());


//$ptabal=$ptaOutstanding+$ptafee+$ptapay;
//$ptapay=abs($ptapay);
 //$bb="INSERT INTO feePayRecord VALUES ('','$q[stuId]','$ptaOutstanding','$ptapay','$ptabal','','$checkno','$newyear','$newterm','$theform','$dates','PTA Bill','$_SESSION[name]','','','$ptafee')";
//$sql= mysql_query($bb) or die (mysql_error());


//}
echo "FEE UPDATE COMPLETE!<br\>";

	
	/*
			$thestu=mysql_query("select * from students where form='ALUMNI'")or die(mysql_error());
while ($stu=mysql_fetch_array($thestu)){
//get the id
$stId=$stu[id];
//insert into the alumni table this item
$aluInsert=mysql_query("INSERT INTO alumni 
VALUES ('', '$stu[surname]', '$stu[othernames]', '$stu[indexno]', '$stu[sex]', '$stu[tel]', '$stu[dob]', '$stu[nationality]', '$stu[prevschool]', '$stu[dates]', '$stu[classAdmited]', '$stu[religion]', '$stu[placeOfResidence]', '$stu[houseNo]', '$stu[homeTown]', '$stu[contactAddress]', '$stu[region]', '$stu[gName]', '$stu[gAddress]', '$stu[gOccupation]', '$stu[gTel]', '$stu[gRelationshiptoStudent]', '$stu[program]', '$stu[level]', '$stu[subProg]', '$stu[house]', '$stu[boarding]', '$stu[email]', '', '$_SESSION[currentyear]', '', '', '', '')");
//get the id of the last item inserted into alu table
$getid=mysql_query("select id from alumni where id=LAST_INSERT_ID()")or die(mysql_error());
while($theid=mysql_fetch_array($getid)){$ppp=$theid[id];}
//use the 2 ids to move student picture from student folder to alumni folder
@rename("studentSig/$stId.jpg", "aluPics/$ppp.jpg");
//delete this item from students 
mysql_query("delete from students where id='$stId'")or die(mysql_error());

}  

*/
//start student coursese tobe taken population
$st=mysql_query("select students.id as stuid,form,Combination from students where dateofcompletion=''") or die (mysql_error()) ;

//$st=mysql_query("select students.id as stuid,form from students ") or die (mysql_error()) ;

while($d=mysql_fetch_array($st)){			

mysql_query("insert into classmems(cname,stuId,year,term) values('$d[form]','$d[stuid]','$newyear','$newterm')");

	set_time_limit(500);


if($d['Combination']!=""){
$cos=explode("|",$d['Combination']);
$st1=mysql_query("select courses.id as courseid from courses,subjects where classId='$d[form]' and courses.name=subjects.name and subjects.type='elective' and (subjects.shortcode='$cos[0]' or subjects.shortcode='$cos[1]' or subjects.shortcode='$cos[2]' or subjects.shortcode='$cos[3]') ") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$newyear' and term='$newterm'"))>0){}else{
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$newyear','$newterm','','$d[form]')") or die(mysql_error());}

}


$st1=mysql_query("select courses.id as courseid from courses,subjects where classId='$d[form]' and courses.name=subjects.name and subjects.type='core'") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$newyear' and term='$newterm'"))>0){}else
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$newyear','$newterm','','$d[form]')") or die(mysql_error());
}
}

else{
	set_time_limit(500);
				
$st1=mysql_query("select courses.id as courseid from courses where classId='$d[form]' ") or die (mysql_error());
//echo mysql_num_rows($st1);
while($ds=mysql_fetch_array($st1)){

if(mysql_num_rows(mysql_query("select * from grades where courseId='$ds[courseid]' and stuId='$d[stuid]' and year='$newyear' and term='$newterm'"))>0){}else {
mysql_query("insert into grades values('','$ds[courseid]','$d[stuid]','','','','','','','','$newyear','$newterm','','$d[form]')") or die(mysql_error());}
}

}
}
//echo "courses set";
mysql_query("update year set year='$newyear',term='$newterm'");

$_SESSION['currentyear']=$newyear;
$_SESSION['currentterm']=$newterm;			
				   header("location:viewStudents.php");
			
			
			
			
			
			//SELECT promotedTo,STUID IN classmems WHERE YEAR=CURRENTYEAR AND TERM=CURRENTTERM AND promotedTo!='ALUNI' 
				//PRONOTE STUDENTS SET FORN='promotedTo'
				
				// INSERT INTO CLASNENS 
			//insert into the courses the courses for each student
			//
			
			//$now= "insert into classmems(cname,stuId,year,term) values('$form','$studentid','$_SESSION[currentyear]','$_SESSION[currentterm]')";}
		
			
			
			
		  
		  
		  
		  ?>
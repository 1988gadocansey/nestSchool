<?php 
include ('check.php');
 $query=$_SESSION[query];

if($_SESSION[caller]=='viewStudents.php'){ $table='STUDENTS INFORMATON';}
if($_SESSION[caller]=='feePayRecords.php'){ $table='STUDENTS FEE PAYMENT RECORDS';}
if($_SESSION[caller]=='viewcourses.php'){ $table='SUBJECTS AND THEIR TEACHERS';}
if($_SESSION[caller]=='prepareReport.php'){ $table='STUDENTS\' REPORT';}
if($_SESSION[caller]=='ViewGrades.php'){ $table='ASSESSMENT RECORDS';}
if($_SESSION[caller]=='enterGrades.php'){ $table='ASSESSMENT RECORDS';}
if($_SESSION[caller]=='viewStudentsFinancial.php'){ $table='STUDENTS FINANCIAL RECORDS';}
if($_SESSION[caller]=='sumbill.php'){ $table='BILL SUMMARY ';}


if($_SESSION[date1]){ $date1=Ttodate($_SESSION[date1]);}
if($_SESSION[date2]){ $date2=Ttodate($_SESSION[date2]);}
$search=$_SESSION[search];

if($search and !$date1 and !$date2){ $table=" Search For  $search In $table";}
if($search and $date1 and !$date2){ $table =" Search For $search In $table On $date1";}
if($search and $date1 and $date2){ $table=" Search For  $search In $table Between $date1 And $date2";}
if(!$search and $date1 and $date2){ $table.="  Between $date1 And $date2";}
if(!$search and $date1 and !$date2){ $table.="  on $date1";}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php  echo $_SESSION[head] ?></title>
<style type="text/css">
<!--
.style7 {font-size: 12px; font-weight: bold; }
body{ font-family:tahoma, Times, serif;
font-size:13px}

input:textbox{
	
	width:auto;}
#small{
font-size:11px
}
.style9 {
	font-size: 18px;
	font-weight: bold;
}


-->

</style>

<script src="sorttable.js"></script>
</head>

<body style="font-family:tahoma"> 
<div align="center">
  <p><img src="images/printout.png" width="878" height="145" /></p>
  <p><strong><?php echo $table;
//echo $query;
 $_SESSION[caller];
?></strong>


    <?php if($_SESSION[caller]=='viewStudentsFinancial.php'){;?>
  </p>
<table width="68%" border="1" class="content" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
<tr bgcolor="#F7F0DB" class="deco">
                <td width="17">&nbsp;</td>
                <td width="247"><strong>Name</strong></td>
                <td width="78"><strong>Class</strong></td>
                <td width="65"><strong>Residential Status</strong></td>
      <td width="129"><strong>Total Outstanding</strong></td>
    </tr>
              <?php 
//include 'connect.php';
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  >
                <td height="22"><?php echo $r['id'] ?></td>
                <td><?php echo $r[surname].' , '.$r[othernames];?></td>
                <td ><div align="center"><?php echo $r[form];?></div></td>
                <td bordercolor="#F7F0DB" ><?php echo $r[boarding];?></td>
                <td ><?php echo   number_format($r['boardOutstanding']+$r['ptaOutstanding']+$r['outstanding'], 2, '.', ',') ?>&nbsp;</td>
              </tr>
              <?php 
				  
								  } ?>
            </table> 
 
<?php }?>

    <?php if($_SESSION[caller]=='viewStudents.php'){?>
  </p>
<table width="97%" border="0" class="content" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="21">&nbsp;</td>
                <td width="71">Student ID</td>
                <td width="247"><strong>Name</strong></td>
                <td width="70"><strong>Class</strong></td>
                <td width="76"><strong>Picture</strong></td>
                <td width="62"><strong>Sex</strong></td>
                <td width="112"><strong>Day/Boarding</strong></td>
                <td width="144"><strong>House</strong></td>
                <td><strong>Place of residence</strong></td>
                <td width="161"><strong>Outstanding  Fees</strong></td>
              </tr>
              <?php 

//$query="SELECT*,SUM()FROM students where";
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td height="62"><?php echo $counter++ ?></td>
                <td><?php echo $r[id];?></td>
                <td><?php echo $r[surname].' , '.$r[othernames];?></td>
                <td ><?php echo $r[form];?></td>
                <td ><a href="addstudent.php?id=<?php echo $r[id]; ?>"><img  <?php picture("studentPics/$r[id].jpg",61)?>   src="studentPics/<?php echo $r[id]?>.jpg" alt="Insert Picture" /></a></td>
                <td bordercolor="#F7F0DB" ><?php echo $r[sex];?></td>
                <td ><?php echo $r[boarding];?></td>
                <td ><?php echo $r[house];?></td>
                <td width="183" ><?php echo $r[placeOfResidence];?></td>
                <td ><?php 				  $samount=$samount+($r[outstanding]);
 echo  number_format($r[outstanding], 2, '.', ',');?></td>
              </tr>
              <?php 
				  
								  } ?>
              <tr bordercolor="#ECE9D8" bgcolor="#FBFBFD" onmousemove="bgcolor="#Cfffff"">
                <td colspan="8"><div align="right" class="style7">
                    
                   <div align="right">TOTAL :                  </div>
                </div></td>
                <td><span class="style7">
                  
                </span></td>
                <td bgcolor="#FBFBFD"><span class="style9">
                  <?php  echo number_format($samount, 2, '.', ',');?></span></td>
              </tr>
            </table>
 
 
<?php }?>
    <?php if($_SESSION[caller]=='ViewGrades.php'){
		?>
  
  <table width="99%" class="content" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="25">&nbsp;</td>
                <td width="189"><div align="center"><strong>Student Name</strong></div></td>
                <td width="121"><div align="center"><strong>Subject</strong></div></td>
                <td width="97"><div align="center"><strong>Form</strong></div></td>
                <td width="86"><div align="center"><strong>Year</strong></div></td>
                <td width="62"><div align="center"><strong>Term</strong></div></td>
                <td width="70"><div align="center"><strong>Class Score</strong></div></td>
                <td width="87"><div align="center"><strong>Exam </strong>Score</div></td>
                <td width="42"><div align="center"><strong>Total</strong></div></td>
                <td width="42"><div align="center"><strong>Grade</strong></div></td>
                <td width="73"><div align="center"><strong>Position</strong></div></td>
              </tr>
              <?php 

$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td ><?php echo $thecounter=$counter++ ?></td>
                <td><?php echo $r[surname].", ".$r[othernames];?></td>
                <td><?php echo $r[subject] ?></td>
                <td><div align="center"><?php echo $r[form] ?></div></td>
                <td><div align="center"><?php echo $r[year] ?></div></td>
                <td><div align="center"><?php echo $r[term] ?></div></td>
                <td ><label><?php echo $r[quiz1] ?> </label></td>
                <td ><label><?php echo $r[exam] ?>                </label></td>
                <td ><div align="center"><strong><?php echo ($r[total]); ?></strong></div></td>
                <td ><div align="center">
                  <?php   echo $r['grade'];
				 
				  
				  ?>
                  &nbsp;</div></td>
                <td ><strong><?php echo $r[posInSubject]; ?></strong></td>
              </tr>
              <?php 
				  
								  } ?>
            </table>
 
 
<?php }?>


    <?php if($_SESSION[caller]=='addstudent.php'){?>

<div align="center">
  <p>
     
      <label></label>
    </p>
              <table width="98%" border="0">
                <tr>
                  <td><fieldset>
                    <div align="left">
                      <legend class="style12">Personal Info</legend>
                    </div>
                    <?php 
$sql=mysql_query($query) or die (mysql_error());
while($r=mysql_fetch_array($sql))

{
 
?>
                    <label>
                      <?php 
				
				if($_POST['getid']){
					
					
					echo $f=$_POST[textfield];
					 
					 $q=mysql_query("select id from students where id='$f'");
					echo mysql_num_rows($q); 
					 if(mysql_num_rows($q)==0){$y=$_POST['textfield'];}else{
					
					 echo "<script> alert('student with this  id does  exist alreader')</script>";
					
					 }  
  }
					?>
                      Student ID *
                      <input type="text" name="textfield"  style="color:#000000"  id="textfield" value=" <?php if($r['id']){ echo $studentid=$r['id']; }?>"  <?php if($dis==1){echo 'disabled="disabled"'; }?>/>
                      <input name="hiddenid" id="hiddenid" type="hidden" value="<?php if($r['id']){ echo $r['id']; $dis=1;} elseif($y) {echo $y; $dis=1;}?>"/>
                    </label>
                    <label></label>
                    <table width="104%" border="0" cellpadding="5">
                      <tr>
                        <th colspan="4" scope="row"><img <?php picture("studentPics/$studentid.jpg",191)?>  src="<?php echo file_exists("studentPics/$studentid.jpg")? "studentPics/$studentid.jpg":"images/Bdefault.png";?>" alt=" Picture of Student Here" /></th>
                      </tr>
                      <tr>
                        <th width="18%" bgcolor="#E7EDF5" scope="row"><div align="left">Surname *</div></th>
                        <td width="31%" bgcolor="#E7EDF5"><div align="left"><span id="sprytextfield4">
                          <input type="text" name="surname" id="surname"  value="<?php echo $r[surname]; ?>" />
                        </span></div></td>
                        <td width="18%" bgcolor="#E7EDF5"><div align="left">Other Names *</div></td>
                        <td width="33%" bgcolor="#E7EDF5"><label>
                          <div align="left"><span id="sprytextfield5">
                            <input type="text" name="othernames" id="othernames" value="<?php echo $r[othernames]; ?>" />
                            </span>
                            </label>
                          </div></td>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left">Gender*</div></th>
                        <td><div align="left">
                          <select name="sex" id="sex">
                                                       <option <?php if($r[sex]=='Female'){echo "selected='selected'";}  ?>>Female</option>

                            <option <?php if($r[sex]=='Male'){echo "selected='selected'";}  ?>>Male</option>
                          </select>
                        </div></td>
                        <td><div align="left">Current Form* </div></td>
                        <td><div align="left"><strong>
                          <select     name="form" id="form" >
                            <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($rs = mysql_fetch_array($sql))

{
?>
                            <option <?php if($r[form]==$rs[code]){echo 'selected="selected"'; }?> ><?php echo $rs[code];?></option>
                            <?php }?>
                          </select>
                        </strong></div></td>
                      </tr>
                      <tr>
                        <th bgcolor="#E7EDF5" scope="row"><div align="left">Form Admitted*</div></th>
                        <td bgcolor="#E7EDF5"><div align="left"><strong>
                          <select     name="classAdmited" id="classAdmited" >
                            <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($rs = mysql_fetch_array($sql))

{
?>
                            <option <?php if($r[classAdmited]==$rs[code]){echo 'selected="selected"'; }?> ><?php echo $rs[code];?></option>
                            <?php }?>
                          </select>
                        </strong></div></td>
                        <td bgcolor="#E7EDF5">Course Combination</td>
                        <td bgcolor="#E7EDF5"><select  name="Combination" id="Combination">
                          <option value="">SELECT COMBINATION</option>
                          <?php $sql=mysql_query("select name from combination ");
		  while($c=mysql_fetch_array($sql)){
		  ?>
                          <option <?php if($c['name']==$r['combination']){echo 'selected="selected"';} ?> ><?php echo $c['name']; ?></option>
                          <?php }?>
                        </select></td>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left">Day / Boarding*</div></th>
                        <td><div align="left">
                          <select name="boarding" id="boarding">
                            <option <?php if($r[boarding]=='Boarding'){echo "selected='selected'";}  ?>>Boarding</option>

                            <option <?php if($r[boarding]=='Day'){echo "selected='selected'";}  ?>>Day</option>
                          </select>
                        </div></td>
                        <td><div align="left">House</div></td>
                        <td><div align="left">
                          <select name="house" id="house">
                            <?php $sql=mysql_query("select house from house ");
		  while($c=mysql_fetch_array($sql)){
		  ?>
                            <option <?php if($c['house']==$r['house']){echo 'selected="selected"';} ?> ><?php echo $c['house']; ?></option>
                            <?php }?>
                          </select>
                        </div></td>
                      </tr>
                      <tr>
                        <td bgcolor="#E7EDF5"><div align="left">Date of Admisssion</div></td>
                        <td bgcolor="#E7EDF5"><div align="left">
                          <input type="text" name="dates" id="dates" onfocus="cal.showCal(this)"  value="<?php  echo @date('d/m/Y',$r[dates]); ?>" />
                        </div></td>
                        <td bgcolor="#E7EDF5"><div align="left">Date of Birth</div></td>
                        <td bgcolor="#E7EDF5"><div align="left">
                          <input type="text" name="dob" id="dob" onfocus="cal.showCal(this)" value="<?php echo $r[dob]; ?>" />
                        </div></td>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left">Nationality</div></th>
                        <td><label>
                          <div align="left">
                            <input type="text" name="nationality" id="nationality" value="<?php echo $r[nationality]; ?>"/>
                            </label>
                          </div></td>
                        <td><div align="left">Religion</div></td>
                        <td><div align="left">
                          <select name="religion" id="religion">
                            <option <?php if($r[religion]=='Christian'){echo "selected='selected'";}  ?>>Christian</option>
                            <option <?php if($r[religion]=='Muslim'){echo "selected='selected'";}  ?>>Muslim</option>
                            <option <?php if($r[religion]=='Others'){echo "selected='selected'";}  ?>>Others</option>
                          </select>
                        </div></td>
                      </tr>
                      <tr>
                        <th bgcolor="#E7EDF5" scope="row"><div align="left">Previous School</div></th>
                        <td bgcolor="#E7EDF5"><label>
                          <div align="left">
                            <input type="text" name="prevschool" id="prevschool" value="<?php echo $r[prevschool]; ?>"/>
                            </label>
                          </div></td>
                        <td bgcolor="#E7EDF5"><div align="left">Place of Residence</div></td>
                        <td bgcolor="#E7EDF5"><div align="left">
                          <input type="text" name="placeOfResidence" id="placeOfResidence" value="<?php echo $r[placeOfResidence]; ?>" />
                        </div></td>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left">Scholarship</div></th>
                        <td><div align="left">
                          <select name="Scholarship" id="Scholarship">
                            <option ></option>
                            <option <?php if($r[Scholarship]=='CMB'){echo "selected='selected'";}  ?>>CMB</option>
                            <option <?php if($r[Scholarship]=='Government'){echo "selected='selected'";}  ?>>Government</option>
                            <option <?php if($r[Scholarship]=='Hardship'){echo "selected='selected'";}  ?>>Hardship</option>
                            <option <?php if($r[Scholarship]=='Others'){echo "selected='selected'";}  ?>>Others</option>
                          </select>
                        </div></td>
                        <td><div align="left">Region</div></td>
                        <td><div align="left">
                          <select name="region" id="region">
                            <option>Select </option>
                            <option <?php if($r['region']=='Ashanti Region'){echo "selected='selected'";}  ?>>Ashanti Region</option>
                            <option <?php if($r['region']=='Brong-Ahafo Region'){echo "selected='selected'";}  ?>>Brong-Ahafo Region</option>
                            <option <?php if($r['region']=='Volta Region'){echo "selected='selected'";}  ?>>Volta Region</option>
                            <option <?php if($r['region']=='Greater Accra Region'){echo "selected='selected'";}  ?>>Greater Accra Region</option>
                            <option <?php if($r['region']=='Central Region'){echo "selected='selected'";}  ?>>Central Region</option>
                            <option <?php if($r['region']=='Wester Region'){echo "selected='selected'";}  ?>>Wester Region</option>
                            <option <?php if($r['region']=='Eastern Region'){echo "selected='selected'";}  ?>>Eastern Region</option>
                            <option <?php if($r['region']=='Upper East Region'){echo "selected='selected'";}  ?>>Upper East Region</option>
                            <option <?php if($r['region']=='Upper West Region'){echo "selected='selected'";}  ?>>Upper West Region</option>
                            <option <?php if($r['region']=='Northern Region'){echo "selected='selected'";}  ?>>Northern Region</option>
                          </select>
                        </div></td>
                      </tr>
                      <tr>
                        <th height="63" bgcolor="#E7EDF5" scope="row"><div align="left">Home Town</div></th>
                        <td bgcolor="#E7EDF5"><div align="left">
                          <input type="text" name="homeTown" id="homeTown" value="<?php echo $r[homeTown]; ?>"/>
                        </div></td>
                        <td bgcolor="#E7EDF5"><div align="left">Contact Address</div></td>
                        <td bgcolor="#E7EDF5"><div align="left">
                          <textarea name="contactAddress" id="contactAddress"><?php echo $r[contactAddress]; ?></textarea>
                        </div></td>
                      </tr>
                      <tr>
                        <th bgcolor="#E7EDF5" scope="row"><div align="left">Email Address</div></th>
                        <td bgcolor="#E7EDF5"><label>
                          <div align="left"><span id="sprytextfield2">
                            <input type="text" name="email" id="email" value="<?php echo $r[email]; ?>" />
                            <span class="textfieldInvalidFormatMsg">.</span></span>
                            </label>
                          </div></td>
                        <td bgcolor="#E7EDF5">&nbsp;</td>
                        <td bgcolor="#E7EDF5">&nbsp;</td>
                      </tr>
                    </table>
                  </fieldset></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" align="center">
                    <tr>
                      <td rowspan="2" valign="top"><fieldset >
                        <div align="left">
                          <legend class="style12">Particulars Of Parent / Guadian</legend>
                        </div>
                        <table width="101%" border="0">
                          <tr>
                            <th colspan="8" scope="row" align="left">Who To Contact
                              <select name="cont" id="cont">
                                <option value="f" <?php if($r[cont]=='f'){echo "selected='selected'";}  ?>>Father</option>
                                <option value="m" <?php if($r[cont]=='m'){echo "selected='selected'";}  ?>>Mother</option>
                                <option value="g" <?php if($r[cont]=='g'){echo "selected='selected'";}  ?>>Guardian</option>
                              </select></th>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row">&nbsp;</th>
                            <td>&nbsp;</td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row">&nbsp;</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th scope="row">&nbsp;</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row">&nbsp;</th>
                            <td>Father</td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row">&nbsp;</th>
                            <td>Mother</td>
                            <td>&nbsp;</td>
                            <th scope="row">&nbsp;</th>
                            <td>Guadian</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th width="10%" scope="row"><div align="right">Name</div></th>
                            <td width="14%"><div align="left">
                              <input type="text" name="fName" id="fName" value="<?php echo $r[fName]; ?>" />
                            </div></td>
                            <th width="5%" scope="row">&nbsp;</th>
                            <th width="14%" scope="row"><div align="right">Name</div></th>
                            <td width="20%"><div align="left">
                              <input type="text" name="mName" id="mName" value="<?php echo $r[mName]; ?>" />
                            </div></td>
                            <td width="5%">&nbsp;</td>
                            <th width="10%" scope="row"><div align="right">Name</div></th>
                            <td width="19%"><div align="left">
                              <input type="text" name="gName" id="gName" value="<?php echo $r[gName]; ?>" />
                            </div></td>
                            <td width="3%">&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row"><div align="right"> Postal Address</div></th>
                            <td><div align="left">
                              <input type="text" name="fAddress" id="fAddress" value="<?php echo $r[fAddress]; ?>" />
                            </div></td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row"><div align="right"> Postal Address</div></th>
                            <td><div align="left">
                              <input type="text" name="mAddress" id="mAddress" value="<?php echo $r[mAddress]; ?>" />
                            </div></td>
                            <td>&nbsp;</td>
                            <th scope="row"><div align="right"> Postal Address</div></th>
                            <td><div align="left">
                              <input type="text" name="gAddress" id="gAddress" value="<?php echo $r[gAddress]; ?>" />
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row"><div align="right">Occupation</div></th>
                            <td><div align="left">
                              <input type="text" name="fOccupation" id="fOccupation" value="<?php echo $r[fOccupation]; ?>" />
                            </div></td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row"><div align="right">Occupation</div></th>
                            <td><div align="left">
                              <input type="text" name="mOccupation" id="mOccupation" value="<?php echo $r[mOccupation]; ?>" />
                            </div></td>
                            <td>&nbsp;</td>
                            <th scope="row"><div align="right">Occupation</div></th>
                            <td><div align="left">
                              <input type="text" name="gOccupation" id="gOccupation" value="<?php echo $r[gOccupation]; ?>" />
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row"> <div align="right">Tel</div></th>
                            <td><div align="left"><span id="sprytextfield3">
                              <input name="fTel" type="text" id="fTel" value="<?php echo $r[fTel]; ?>" maxlength="10"/>
                            </span></div></td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row"> <div align="right">Tel</div></th>
                            <td><div align="left"><span id="sprytextfield">
                              <input name="mTel" type="text" id="mTel" value="<?php echo $r[mTel]; ?>" maxlength="12"/>
                            </span></div></td>
                            <td>&nbsp;</td>
                            <th scope="row"> <div align="right">Tel</div></th>
                            <td><div align="left"><span id="sprytextfield3"><span id="sprytextfield6">
                              <input name="gTel" type="text" id="gTel" value="<?php echo $r[gTel]; ?>" maxlength="12"/>
                            </span></span></div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th scope="row" align="right">Email</th>
                            <td><input name="femail" type="text" id="femail" value="<?php echo $r[femail]; ?>"/></td>
                            <th scope="row">&nbsp;</th>
                            <th scope="row" align="right">Email</th>
                            <td><input name="memail" type="text" id="memail" value="<?php echo $r[memail]; ?>"/></td>
                            <td>&nbsp;</td>
                            <th scope="row" align="right">Email</th>
                            <td><input name="gemail" type="text" id="gemail" value="<?php echo $r[gemail]; ?>"/></td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php                              if($studentid){}else{
?>
                          <?php }?>
                          <tr>
                            <th colspan="8" scope="row"><div align="left"></div>                              <div align="left"></div>                              <div align="left"></div>                              <div align="left"></div></th>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <input type="hidden" value="the value" name="since" id="since" />
                        <?php }?>
                      </fieldset></td>
</tr>
                    <tr> </tr>
                    <tr>
                      <td align="center"><?php  if($_SESSION['level']!="administrator" and  $_SESSION['level']!="Financial Administrator"and  $_SESSION['level']!="Registration Officer"){}else{?>
                        <label>
                          <script>
                           function checker(){
						   fna=document.getElementById("othernames").value;
						   lna=document.getElementById("surname").value;
						   hiddenid=document.getElementById("hiddenid").value;

						   
						   if(fna=='' || lna=='' || hiddenid==''){
						   alert("PLEASE FILL MANDATORY FIELDS");
						   return false;
						   }
						   }
						   
                           </script></label>
                        <?php }?>
                        <?php  if($_SESSION[level]!="Data Entry Clerk"){}else{?>
                        <label>
                          <script>
                           function checker(){
						   fna=document.getElementById("othernames").value;
						   lna=document.getElementById("surname").value;
						   hiddenid=document.getElementById("hiddenid").value;

						   
						   if(fna=='' || lna=='' || hiddenid==''){
						   alert("PLEASE FILL MANDATORY FIELDS");
						   return false;
						   }
						   }
						   
                           </script></label>
                        <label></label>
                        <?php }?></td>
                    </tr>
                    <tr>
                      <td rowspan="2" valign="top"><fieldset >
                        <table width="101%" border="0">
                          <tr> </tr>
                        </table>
                      </fieldset></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <p>&nbsp;</p>
  </div>



 
 
<?php }?>



    <?php if($_SESSION[caller]=='sumbill.php'){;?>
  </p><table width="90%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F9EBE6" class="deco">
                <td width="28">&nbsp;</td>
                <td width="184">Type</td>
                <td width="229"><strong>Description</strong></td>
                <td width="68"><div align="center"><strong>Program</strong></div></td>
                <td width="59"><strong>Form</strong></td>
                <td width="77"><strong>Sub Form</strong></td>
                <td width="102"><strong>Day/Boarding</strong></td>
                <td width="71"><strong>Amount</strong></td>
                <td width="71">No of Student</td>
                <td width="71">Total <strong>Amount</strong></td>
              </tr>
              <?php 
//include 'connect.php';
if($_GET['id'] and $_GET['id']!="ALL"){
$id=$_GET['id'];

$w=mysql_query("select * from classcode where code='$id'");
while($r=mysql_fetch_array($w)){
$program=$r['program'];
$form=$r['form'];
$subProg=$r['subProg'];

}
$inser=" (program='$program' or program='' ) and (form='' or form='$form') and (subProg='' or subProg='$subProg')";
}

if($_SESSION['t']){
$type=$_SESSION['t'];
$newinsert="( type='$type' or type='')";
}

if($_SESSION['t'] and $_GET['id']){
$type=$_SESSION['t'];
$newinsert="and (type='$type' or type='' )";
}


if($_SESSION['t'] or $_GET['id']){$inswhere='where';}
 $counter=1;
 $query="SELECT * FROM bill $inswhere $inser $newinsert order by type";		  
//include('pageno.php');
$sql = mysql_query($query) or die (mysql_error());
//echo mysql_num_rows($sql)." Records Returned";
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?todelete=<?php echo $r[id];?>"><img onclick="return confirm('DO YOU REALLY WANT TO DELETE THIS ITME?')" src="images/delete.png" alt="gfg" /></a><a href="<?php echo $_SERVER['PHP_SELF']; ?>?todelete=<?php echo $r[id];?>">
                  <?php 
				  
				   $thecounter=$counter++ ?>
                </a></td>
                <td><select     name="type<?php echo $thecounter ?>" id="type<?php echo $thecounter ?>" >
                  <option value="" >ALL</option>
                  <option <?php if($r['type']=='Academic'){echo 'selected="selected"';}?> >Academic</option>
                  <option <?php if($r['type']=='PTA'){echo 'selected="selected"';}?>> PTA</option>
                  <option <?php if($r['type']=='Boarding'){echo 'selected="selected"';}?>>Boarding</option>
                </select></td>
                <td>
                  <label>
                  <input name="descr<?php echo $thecounter ?>" type="text" id="descr<?php echo $thecounter ?>" value="<?php echo $r[descr];?>" />
                  <input type="hidden" name="class<?php echo $thecounter ?>" id="class<?php echo $thecounter ?>" value="<?php echo $r[id];?>" />
                  </label></td>
                <td >
                  <select name="program<?php echo $thecounter ?>" id="program<?php echo $thecounter ?>">
                    <option value="" >ALL </option>
                    <?php $sqli=mysql_query("select distinct program from classcode ");
		  while($c=mysql_fetch_array($sqli)){
		  ?>
                    <option <?php if($r['program']==$c['program']){echo 'selected="selected"';} ?>  ><?php echo $c['program']; ?></option>
                    <?php }?>
                  </select></td>
                <td ><label>
                  <select name="form<?php echo $thecounter ?>" id="form<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r['form']=="1"){echo 'selected="selected"';} ?>>1</option>
                    <option <?php if($r['form']=="2"){echo 'selected="selected"';} ?>>2</option>
                    <option <?php if($r['form']=="3"){echo 'selected="selected"';} ?>>3</option>
                    <option <?php if($r['form']=="4"){echo 'selected="selected"';} ?>>4</option>
                  </select>
                  </label></td>
                <td ><label>
                  <select name="subProg<?php echo $thecounter ?>" id="subProg<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r[subProg]=="1"){echo 'selected="selected"';} ?>>1</option>
                    <option <?php if($r[subProg]=="2"){echo 'selected="selected"';} ?>>2</option>
                  </select>
                  </label></td>
                <td ><label>
                  <select name="boarding<?php echo $thecounter ?>" id="boarding<?php echo $thecounter ?>">
                    <option value="">ALL</option>
                    <option <?php if($r[boarding]=="Day"){echo 'selected="selected"';} ?>>Day</option>
                    <option <?php if($r[boarding]=="Boarding"){echo 'selected="selected"';} ?>>Boarding</option>
                  </select>
                  </label>
                  <label></label></td>
                <td >
                  <label>
                  <input name="amount<?php echo $thecounter ?>" type="text" id="amount<?php echo $thecounter ?>" size="10" value="<?php echo $r[amount];?>" />
                 <?php $total+=$r[amount];?>
                  </label></td>
                <td ><?php
				$inse="";
				if($r[program]){$inse.=" and  classcode.program='$r[program]' ";}
				if($r[boarding]){$inse.=" and  boarding='$r[boarding]' ";}
				if($r[classes]){$inse.=" and  students.form='$r[classes]'";}
				if($r[subProg]){$inse.=" and classcode.subProg='$r[subProg]'";}
				if($r[form]){$inse.=" and classcode.form='$r[form]'";}
				if($_GET['id']){$inse.=" and students.form='$_GET[id]'";}
				 
				 $f="select * from students,classcode where classcode.code=students.form $inse";
				$g=mysql_query($f) or die(mysql_error());
				echo $classsize=mysql_num_rows($g);
				
				?>&nbsp;</td>
                <td ><?php echo $classsize*$r[amount];$truetotal+=($classsize*$r[amount]); ?>&nbsp;</td>
              </tr> <?php 
				  
								  } ?>
              <tr bordercolor="#AED7FF" >
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" ><div align="center" class="style9">Total</div></td>
                <td bgcolor="#CCCCCC" ><div align="center"><strong><?php echo number_format($total, 2, '.', ',') ?>&nbsp;</strong></div></td>
                <td bgcolor="#CCCCCC" >&nbsp;</td>
                <td bgcolor="#CCCCCC" ><strong><?php echo  number_format($truetotal, 2, '.', ',') ?>&nbsp;</strong></td>
              </tr>
            </table>
 
 
 
<?php }?>

 
   <?php if($_SESSION[caller]=='feePayRecords.php'){;?>

<table width="93%" border="0" cellpadding="1" cellspacing="1" >
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="130">Date</td>
                <td width="133"><strong>Name</strong></td>
                <td width="86"><strong>Class</strong></td>
                <td width="102"><strong>Payment Type</strong></td>
                <td width="102"><strong>Receipt No</strong></td>
                <td width="102"><strong>Cheque No</strong></td>
                <td>B/F <strong>(GH&cent;) </strong></td>
                <td><strong>Paid(GH&cent;) </strong></td>
                <td width="124"><strong> Balance(GH&cent;) </strong></td>
                <td width="124"><strong>Nullified</strong></td>
              </tr>
              <?php 
//include 'connect.php';

//$query="SELECT*,SUM()FROM students where";
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td height="23"><?php echo Ttodate($r[dates]) ?></td>
                <td><?php echo $r[surname].' , '.$r[othernames];?></td>
                <td ><?php echo $r[classes];?></td>
                <td ><?php echo $r[type];?></td>
                <td ><?php echo $r[receiptno];?></td>
                <td  ><?php echo $r[chequeno];?></td>
                <td width="91" ><?php echo $r[oldbalance];?></td>
                <td width="78" ><?php echo  number_format($r[paid]+$r[nullvalue], 2, '.', ',');?></td>
                <td ><?php echo  number_format($r[curbalace], 2, '.', ',');
				$spaid+=$r[paid]; 
				?></td>
                <td ><?php echo $r[nullified];?></td>
              </tr>
              <?php 
				  
								  } ?>
              <tr bordercolor="#ECE9D8" bgcolor="#FBFBFD" onmousemove="bgcolor="#Cfffff"">
                <td colspan="6"><div align="right" class="style7">
                    <div align="center">
                      TOTAL :                    </div>
                </div></td>
                <td><span class="style7">
                 
                </span></td>
                <td><span class="style9">
                  <?php echo  number_format($spaid, 2, '.', ',');?></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table> 
 
<?php }?>
 
   <?php if($_SESSION[caller]=='enterGrades.php'){;?>

<table width="99%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="29">&nbsp;</td>
                <td width="304"><div align="center"><strong>Student Name</strong></div></td>
                <td width="72"><div align="center">Class Score</div></td>
                <td width="66"><div align="center">Exam Score</div></td>
                <td width="41">Total</td>
                <td width="45">Grade</td>
                <td width="159" ><div align="center">Comments</div></td>
              </tr>
              <?php 
//include 'connect.php';

$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td ><?php echo $thecounter=$counter++ ?></td>
                <td><?php echo $r[surname].", ".$r[othernames];?>
                  <input type="hidden" name="stu<?php echo $thecounter ?>" id="stu<?php echo $thecounter ?>" value="<?php echo $r[stid];?>" />
                  <input type="hidden" name="idd<?php echo $thecounter ?>" id="idd<?php echo $thecounter ?>" value="<?php echo $r[id];?>" /><?php  ?></td>
                <td ><label><?php echo $r[quiz1] ?></label></td>
                <td ><label><?php echo $r[exam] ?></label></td>
                <td ><div align="center"><strong><?php echo ($r[total]); ?></strong></div></td>
                <td ><div align="center">
                  <?php $gra=mysql_query("select grade,comment from gradeDefinition where   lower <=$r[total]  and upper >= $r[total]   ")or die(mysql_error()) ;
                  while($rq= mysql_fetch_array($gra)){
				  echo $rq['grade'];
				   $comment=$rq['comment'];
				  }
				  
				  ?>
                  &nbsp;</div></td>
                <td ><label>
                <?php 				  echo $comment;
				  
				  
				  ?>
                  
                </label></td>
              </tr>
              <?php 
				  
								  } ?>
            </table> 
 
<?php }?>
 
 
 
      <?php if($_SESSION[caller]=='prepareReport.php'){;?>

<table width="99%" border="0" class="content" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="17">&nbsp;</td>
                <td width="207"><div align="center" class="style20">Student Name</div></td>
                <td width="82"><span class="style20">Total Score</span></td>
                <td width="46"><span class="style20">Position in Class</span></td>
                <td width="59"><div align="center" class="style20">Attendance</div></td>
                <td width="76"><div align="center" class="style20">Conduct</div></td>
                <td width="76"><div align="center" class="style20">Attitude</div></td>
                <td width="61"><div align="center"><span class="style20">Interest</span></div></td>
                <td width="91"><div align="center" class="style20">
                    <p>Form master Report</p>
                </div></td>
                <td width="80"><div align="center"><strong><span class="style37">Head master Report</span></strong></div></td>
                <td width="53" ><div align="center" class="style20">Promoted To</div></td>
              </tr>
              <?php 
//$_SESSION[currentterm]="";
//include 'connect.php';

$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td ><?php echo $thecounter=$counter++ ?></td>
                <td><?php echo $r[surname].", ".$r[othernames];?>
                    <input type="hidden" name="stu<?php echo $thecounter ?>" id="stu<?php echo $thecounter ?>" value="<?php echo $r[sid];?>" />
                    <input type="hidden" name="idd<?php echo $thecounter ?>" id="idd<?php echo $thecounter ?>" value="<?php echo $r[id];?>" /></td>
                <td><strong><?php echo ($r[total]); ?></strong></td>
                <td><div align="center"><strong><?php echo $r[position]; ?> </strong></div>
                    <strong>
                      <label></label>
                  </strong></td>
                <td ><label><strong><?php echo $r[attendance] ?> </strong></label></td>
                <td ><label><strong>
            <?php echo $r[conduct]; ?>
                </strong></label></td>
                <td ><label><strong><?php echo $r[attitude]; ?>
                </strong></label></td>
                <td ><div align="center">
                    <label><strong><?php echo $r[interest]; ?>
                    </strong></label>
                </div></td>
                <td ><label><strong>
               <?php echo $r[form_mast_report]; ?>
                </strong></label></td>
                <td ><div align="center"><strong>
                    <?php echo $r[head_mast_report]; ?>
                </strong></div></td>
                <td ><label><?php echo $r[cname]?>
                </label></td>
              </tr>
              <?php 
				  
								  } ?>
            </table> 
 <?php }?>

   <?php if($_SESSION[caller]=='viewcourses.php'){;?>
<table width="73%" border="0" class="content" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
              <tr bgcolor="#F7F0DB" class="deco">
                <td width="92"><strong>Class</strong></td>
                <td width="92"><strong>Subject</strong></td>
                <td width="219"><strong>Teacher</strong></td>
              </tr>
              <?php 
$sql = mysql_query($query) or die (mysql_error());
while($r = mysql_fetch_array($sql))

{

?>
              <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>" onmouseout="this.style.backgroundColor = ''" onmouseover="this.style.backgroundColor = '#AED7FF'" >
                <td ><?php echo $r[classId];?></td>
                <td ><?php echo $r[name]?></td>
                <td ><?php echo $r[surname].' , '.$r[fname];?>&nbsp;</td>
              </tr>
              <?php 
				  
								  } ?>
            </table> 
 
 <?php }?>
  
</div>
</body>

</html>


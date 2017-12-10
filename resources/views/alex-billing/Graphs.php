<?php 
$beef="AD@";

include 'check.php';

if($_GET[id]){
$_SESSION[classes]=$_GET[id];
}

if($_GET[course]){
$_SESSION[course]=$_GET[course];
}

if($_GET[year]){
$_SESSION[year]=$_GET[year];
}

if($_GET[ter]){
$_SESSION[ter]=$_GET[ter];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Students</title>
<style type="text/css">
<!--
-->
</style>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="calendar.js"></script>
</head>

<body> 
<?php include ('bar.php');?>
<table width="1020" height="528" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <td height="120" background="images/banner.png" style="background-repeat:no-repeat" scope="row">&nbsp; </td>
  </tr>
  <tr  background="images/body.png">
    <td height="268" valign="top" scope="row"><table  align="center"width="92%" height="183" border="0"  class="container" cellpadding="0" cellspacing="0">
      <tr>
      <script>
      function check(ids){
	  if(document.getElementById(ids).value >10 ){
	  
	  alert('Score can not be greater than 10');
	  document.getElementById(ids).value="";
	  				document.getElementById(ids).focus();
					//                document.getElementById(ids).select()

	  }
	  
	  }
      
      </script>
      
        <td width="549" valign="top"><form id="form2" name="form2" method="post" action="">
                  <table width="200" border="0" align="center">
                    <tr>
                      <td><div align="center">
                        <div align="left"><hr/>
                          <table width="749" height="72" border="0">
                            <tr style="background-color:#FFFFFF" >
                              <td width="341" >&nbsp;</td>
                              <td width="70"><strong>Class</strong></td>
                              <td width="91"><strong>Year</strong></td>
                              <td width="67"><strong>Term</strong></td>
                              <td width="74"><strong>Group By</strong></td>
                              <td width="80">&nbsp;</td>
                            </tr>
                            <tr style="background-color:#cccccc">
                              <td valign="top"><strong> Grades against No of Students</strong></td>
                              <td valign="top"><select     name="c" id="c" >
                                  <option>All</option>
                                  <?php 
//include 'connect.php';


$query="SELECT  code FROM classcode ORDER BY code";		  
$sql = mysql_query($query) or die (mysql_error());

while($rs = mysql_fetch_array($sql))

{
?>
                                  <option  ><?php echo $rs[code];?></option>
                                  <?php }?>
                                </select></td>
                              <td valign="top"><select name="year1" id="year1">
                                  <option>2009/2010</option>
                                  <option>2010/2011</option>
                                  <option>2011/2012</option>
                                  <option>2012/2013</option>
                                  <option>2013/2014</option>
                                  <option>2014/2015</option>
                                </select>
                              </td>
                              <td valign="top"><label>
                                <select name="term1" id="term1">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                </select>
                              </label></td>
                              <td valign="top"><label>
                                <select name="group1" id="group1">
                                  <option>Nothing</option>
                                  <option>Sex</option>
                                  <option>House</option>
                                  <option>Day/Boarding</option>
                                </select>
                                <script>

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
				function callgraph(idd)
{

 cla="classes"+idd;

//alert(cla);
   //invoiceno=document.getElementById("invoice").value;
 
// alert("hgg");  
  group =document.getElementById("group1").value;
   c=document.getElementById("c").value;
   year=document.getElementById("year1").value;
   term=document.getElementById("term1").value;
 
url="bargraph.php?group="+group+"&classes="+c+"&year="+year+"&term="+term;
MM_openBrWindow(url,'customer','menubar=yes,scrollbars=yes,resizable=yes,width=800,height=1000%');

}
            
			
			
			          </script>
                              </label></td>
                              <td valign="top"><img src="images/demo.png" id="1" alt="ghg" width="32" height="23"  onclick="callgraph(this.id)"/></td>
                            </tr>
                          </table><hr/>
                          <table width="675" height="72" border="0">
                            <tr style="background-color:#FFFFFF">
                              <td width="341" >&nbsp;</td>
                              <td width="91"><strong>Year</strong></td>
                              <td width="67"><strong>Term</strong></td>
                              <td width="74"><strong>Group By</strong></td>
                              <td width="80">&nbsp;</td>
                            </tr>
                            <tr style="background-color:#cccccc">
                              <td valign="top"><strong>Class Against Average Score</strong></td>
                              <td valign="top"><select name="year2" id="year2">
                                  <option>2009/2010</option>
                                  <option>2010/2011</option>
                                  <option>2011/2012</option>
                                  <option>2012/2013</option>
                                  <option>2013/2014</option>
                                  <option>2014/2015</option>
                                </select>
                              </td>
                              <td valign="top"><label>
                                <select name="term2" id="term2">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                </select>
                              </label></td>
                              <td valign="top"><label>
                                <select name="group2" id="group2">
                                  <option>Nothing</option>
                                  <option>Sex</option>
                                  <option>House</option>
                                  <option>Day/Boarding</option>
                                </select>
                                <script>

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function perforgraph(idd)
{
  group =document.getElementById("group2").value;
   year=document.getElementById("year2").value;
   term=document.getElementById("term2").value;
 
url="performancegraph.php?group="+group+"&year="+year+"&term="+term+"&who=perf";
MM_openBrWindow(url,'customer','menubar=yes,scrollbars=yes,resizable=yes,width=800,height=1000%');

}			
			
			          </script>
                              </label></td>
                              <td valign="top"><img src="images/demo.png" id="12" alt="ghg" width="32" height="23"  onclick="perforgraph(this.id)"/></td>
                            </tr>
                          </table><hr/>
                          <table width="661" height="72" border="0">
                            <tr style="background-color:#FFFFFF">
                              <td width="303" >&nbsp;</td>
                              <td width="99"><strong>Year</strong></td>
                              <td width="58"><strong>Term</strong></td>
                              <td width="116"><strong>Group By</strong></td>
                              <td width="63">&nbsp;</td>
                            </tr>
                            <tr style="background-color:#CCCCCC">
                              <td valign="top"><strong>Class Against Students Population</strong></td>
                              <td valign="top"><select name="year3" id="year3">
                                  <option>2009/2010</option>
                                  <option>2010/2011</option>
                                  <option>2011/2012</option>
                                  <option>2012/2013</option>
                                  <option>2013/2014</option>
                                  <option>2014/2015</option>
                                </select>
                              </td>
                              <td valign="top"><label>
                                <select name="term3" id="term3">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                </select>
                              </label></td>
                              <td valign="top"><label>
                                <select name="group3" id="group3">
                                  <option>Nothing</option>
                                  <option>Sex</option>
                                  <option>House</option>
                                  <option>Day/Boarding</option>
                                </select>
                                <script>

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function populationgraph(idd)
{
  group =document.getElementById("group3").value;
   year=document.getElementById("year3").value;
   term=document.getElementById("term3").value;
 
url="performancegraph.php?group="+group+"&year="+year+"&term="+term+"&who=pop";
MM_openBrWindow(url,'customer','menubar=yes,scrollbars=yes,resizable=yes,width=800,height=1000%');

}			
			
			          </script>
                              </label></td>
                              <td valign="top"><img src="images/demo.png" id="122" alt="ghg" width="32" height="23"  onclick="populationgraph(this.id)"/></td>
                            </tr>
                          </table>
                        </div>
                        <p>&nbsp;</p>
                      </div></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                  <p>
                    <label></label>
                  </p>
        </form>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <th background="images/footer.png"  style="background-repeat:no-repeat"scope="row"><p>&nbsp;</p>
    <p>&nbsp;</p></th>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>

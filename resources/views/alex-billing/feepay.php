<?php 
//ob_start();
//$beef="FI@AD";
include 'check.php';

if($_POST[fee]){
	$index=$_POST[fee];
	$s="select id from students where id='$index'";
if(mysql_num_rows(mysql_query($s))==1){
	header("location:newfeePayment.php?index=$index"); }else {echo "<script> alert('student with this  id does not exist')</script>";}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript" src="images/jquery_002.js"></script>
<script type="text/javascript" src="images/jquery.js"></script>
<script type="text/javascript" src="images/jquery_003.js"></script>
<link rel="stylesheet" type="text/css" 
href="images/jquery.css">
<script src="calendar.js"></script>
<script type="text/javascript">
$().ready(function() {

   $('#fee').autocomplete('AjaxstudentFee.php', {
width: 360,
height: 960,
       minChars:1,
       delay:400,
       cacheLength:100,
       matchContains:true,
       max:10,
       formatItem:function(item, index, total, query){
           return "<img height='50' width='50' src='" + item.pic + " '/> "+ item.name + '( ' + item.id+' )' + '( ' + item.outstand+' )'+ '( ' + item.form+' )';
       },
       formatMatch:function(item){
           return item.name+" "+item.id;
       },
       formatResult:function(item){
           return item.id;
       },
       dataType:'json',
       parse:function(data) {
                       return $.map(data, function(item) {
                               return {
                                       data: item,
                                       value: item.id,
                                       result: item.id
                               }
                       });
               }});

});
</script>

    <link rel="icon" href="images/print.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Management System ::Deposit </title>
<style type="text/css">
<!--
-->
</style>
<link href="images/cea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style7 {font-size: 12px; font-weight: bold; }
.style8 {color: #FF0000}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body onload="document.getElementById('fee').focus()" > 
<?php include ('bar.php');
?>
<table width="1020" height="548" align="center" cellspacing="0" bordercolor="#0000FF">
  <tr>
    <th height="125" background="images/banner.png" scope="row">&nbsp; </th>
  </tr>
  <tr  background="images/body.png"><?php 
  
  
  ?>
    <td height="268" align="center" valign="top" scope="row"><table width="80%" border="0" align="center" class="content">
      <tr>
        <th align="center" valign="top" scope="row"><form id="form1" method="post" action="">
            <div align="center">
              <table width="924" height="80%" border="0"  class="container" cellpadding="0" cellspacing="0">
                <tr >
                  <td width="549" height="53" align="center" valign="top"><div align="center"></div>
                      <label>
                      <br />
                      <br />
                      <br />
                      <br />
                      <br />
                      ENTER THE STUDENT INDEX NO TO PAY FEES<br />
                      <br />
                      <input name="fee" type="text" class="style5" id="fee" autocomplete="off" />
                      <br />
                      <br />
                      <input type="submit" name="print" id="print" value="Print" />
                      </label>
                    <div align="center"></div>                  </td>
                </tr>
                <tr>
                  <td valign="top"><p align="center">&nbsp;</p></td>
                </tr>
              </table>
            </div>
          </form>
          </th>
      </tr>
    </table>
    </td>
  </tr>
  <tr >
    <th background="images/footer.png" style="background-repeat:no-repeat" scope="row">&nbsp;</th>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>

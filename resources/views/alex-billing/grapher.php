<?php 
//content="text/plain; charset=utf-8"
//include('check.php');
session_start() ;
include ('connect.php');

require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

$college=$_GET['college'];
	if($_SESSION[form]){$inse=" and form='$_SESSION[form]' ";}
	
	
	//get all courses ie groups to plot graph for ie y
	
	
				$subs=array(); 
				 $hj="select shortcode,courses.id as cid from subjects,courses where  subjects.name=courses.name and classId='$_SESSION[classes]' ";
				$hh=mysql_query($hj)or die(mysql_error());
				while($s=mysql_fetch_array($hh)){
					// $s[id];
					 $subs["$s[cid]"]=$s['shortcode'];
					}
	
	 $sql="select shortcode,courses.id as cid from subjects,courses where  subjects.name=courses.name and classId='$_SESSION[classes]' ";
	$query=mysql_query($sql) or die(mysql_error());
	$core=array();  
	while($f=@mysql_fetch_array($query)){
 array_push($core,$f[shortcode]);
	}
	



$stud=array();	
//different items to show on graph 
$score=array('quiz1','quiz2','quiz3','exam'); 

$counter=1;
$newdata=array();
$i=1;
  foreach ($score as $v){
 $origV=$v;
$newdata="newdata$i";
$i++;
$$newdata=array();

 
 foreach($core as $thesubject){
	 
    $aa="select  id  from grades where  coursecode='$thesubject' and score='$v' and grades.year='$_SESSION[year]' and grades.term='$_SESSION[term]' and college='$college'";
$sub=mysql_query($aa)or die(mysql_error());
$mark=$stud["$thesubject"]["$origV"]=mysql_num_rows($sub);

 array_push($$newdata,$mark);

//echo $stud["$thesubject"]["$v"];
 }

  }
//print_r($newdata2);
$color=array('orange','blue','brown','green','lightblue','black','yellow','red','pink','white');
$label=array('A','B+','B','C+','C','D+','D','E','BLI','ABS');


$plot=array();
for($i=1;$i<=10;$i++){
 $bplot="bplot$i";

 $newi=$i-1;

$data="newdata$i";
//$$dat=$data['data'][$i];
$dat=$$datay;
$$bplot = new BarPlot($$data);
 array_push($plot,$$bplot);

$$bplot->SetFillColor($color[$i-1]);
$$bplot->SetLegend($label[$i-1]);
$$bplot->SetShadow('black@0.4');

}



// Create the basic graph
$graph = new Graph(1250,450,'auto');	
$graph->SetScale("textlin");
$graph->img->SetMargin(30,80,10,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Get localised version of the month names
$graph->xaxis->SetTickLabels($core);

// Set a nice summer (in Stockholm) image
//$graph->SetBackgroundImage('stship.jpg',BGIMG_COPY);

// Set axis titles and fonts
$graph->xaxis->title->Set('COURSES');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');

$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');

$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('black@0.5');

// Setup graph title
$graph->title->Set("Graph of Grades against Frequency Group by Courses");
// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);


$gbarplot = new GroupBarPlot($plot);
$gbarplot->SetWidth(0.8);
$graph->Add($gbarplot);

$graph->Stroke();
?>


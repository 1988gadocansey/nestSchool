<?php // content="text/plain; charset=utf-8"
session_start();
include("connect.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');



// Some data
//$datay1=array(140,110,50);
//$datay2=array(35,90,190);
//$datay3=array(20,60,70);

//get y datafor graph creation
  $aa="select courseId ,quiz1,quiz2,quiz3,exam,total from grades where grades.stuId='$_GET[id]' and grades.year='$_SESSION[year]' and grades.term='$_SESSION[ter]' order by courseId asc";

		  	$sub=mysql_query($aa);
$t=mysql_num_rows($sub);
$subject=array();
$quiz1=array();
$quiz2=array();
$quiz3=array();
$exam=array();
while($r = @mysql_fetch_array($sub))
{
 $subid=$r['courseId'];
 $subject[]=$r['courseId'];
$quiz1[]=$r['quiz1'];
$quiz2[]=$r['quiz2'];
$quiz3[]=$r['quiz3'];
$exam[]=$r['exam'];
 }
 
 $subs=array(); 
 foreach($subject as $s){
				 $hj="select shortcode from subjects,courses where  subjects.name=courses.name  and courses.id='$s' ";
				$hh=mysql_query($hj)or die(mysql_error());
				while($s=mysql_fetch_array($hh)){
					// $s[id];
					 $subs[]=$s['shortcode'];
					}
 }
$q1 = new BarPlot($quiz1);
$q2 = new BarPlot($quiz2);
$q3 = new BarPlot($quiz3);
$ex = new BarPlot($exam);

// Setup the colors with 40% transparency (alpha channel)
$q1->SetFillColor('yellow');
$q2->SetFillColor('red');
$q3->SetFillColor('darkgreen');
$ex->SetFillColor('blue');

// Setup legends
$q1->SetLegend('Quiz 1');
$q2->SetLegend('Quiz 2');
$q3->SetLegend('Quiz 3');
$ex->SetLegend('Exams');

// Setup each bar with a shadow of 50% transparency
$q1->SetShadow('black@0.4');
$q2->SetShadow('black@0.4');
$q3->SetShadow('black@0.4');
$ex->SetShadow('black@0.4');

// Create the basic graph

$graph = new Graph(905,450,'auto');	
$graph->SetScale("textlin");
$graph->img->SetMargin(30,80,10,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

$graph->SetMarginColor('white:0.9');
$graph->SetColor('white');
$graph->SetShadow();

// Adjust the position of the legend box
//$graph->legend->Pos(0.03,0.10);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.1');

// Get localised version of the month names
$graph->xaxis->SetTickLabels($subs);
//$graph->SetBackgroundCountryFlag('mais',BGIMG_COPY,50);

// Set axis titles and fonts
$graph->xaxis->title->Set('Subjects');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('white');

$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('navy');

$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('navy');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('white@0.5');

// Setup graph title
//$graph->title->Set('Using a country flag background');

// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Create the three var series we will combine

$gbarplot = new GroupBarPlot(array($q1,$q2,$q3,$ex));
$gbarplot->SetWidth(0.6);
$graph->Add($gbarplot);

$graph->Stroke();
?>


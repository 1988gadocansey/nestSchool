<?php
/**
 * Created by PhpStorm.
 * User: gadoo
 * Date: 07/12/2017
 * Time: 12:37 PM
 */

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'gadeksys_tnsc');
define('DB_PASSWORD', 'PRINT45dull');
define('DB_NAME', 'gadeksys_tnsc');
//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
    die("Connection failed: " . $mysqli->error);
}
//query to get data from the table
$query =  "SELECT total,comments FROM assesmentsheet WHERE class LIKE 'JHS%' AND total>0 ";
 
$result = $mysqli->query($query);
//loop through the returned data

foreach ($result as $row) {
     $total=$row["total"];
     
      $sql= "SELECT grade, value,lower,upper FROM gradingsystem WHERE type='JHS' and lower<='$total' and upper>='$total'  ";
 		 
 		$out = $mysqli->query($sql);
//loop through the returned data

		foreach ($out as $rows) {
			$grade=$rows["grade"];
			$value=$rows["value"];
			$upper=$rows["upper"];
			$lower=$rows["lower"];

			$s=  "UPDATE  assesmentsheet SET grade='$grade', comments='$grade',gpoint='$value' WHERE  total  between '$lower' and '$upper' ";
//execute query
			//print_r($s);
			 $mysqli->query($s);
		}
}
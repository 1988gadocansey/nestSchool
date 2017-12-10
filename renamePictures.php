<?php
/**
 * Created by PhpStorm.
 * User: gadoo
 * Date: 07/12/2017
 * Time: 12:37 PM
 */

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tnsc');
//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
    die("Connection failed: " . $mysqli->error);
}
//query to get data from the table
$query = sprintf("SELECT * FROM student WHERE currentClass='JHS3'");
//execute query
$result = $mysqli->query($query);
//loop through the returned data

foreach ($result as $row) {
     $name=$row["name"];
    $photo=preg_replace('/\s+/','',$name);
     rename($_SERVER["DOCUMENT_ROOT"]."/public/albums/students/".$name.".jpg",$_SERVER["DOCUMENT_ROOT"]."/public/albums/students/".$photo.".jpg");
}
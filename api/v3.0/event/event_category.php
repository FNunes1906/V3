<?php
ini_set('error_reporting',1);
ini_set('display_errors',1);
include("../connection.php");

// Display all published category from J_Events component
if(isset($_REQUEST['category_id'])){
	$catId = $_REQUEST['category_id'];
}else{
	$catId = 34;
}
$select_query = "SELECT  id,name FROM `jos_categories` WHERE (`parent_id` = ".$catId." OR `id` = ".$catId.") AND PUBLISHED = 1 ORDER BY id";
$catResult = mysql_query($select_query);
$i = 0;

while($row = mysql_fetch_array($catResult)){
	$data[$i]['id']    = $row['id'];
	$data[$i]['title'] = utf8_encode($row['name']);
	++$i;
} 

header('Content-type: application/json');
echo json_encode($data);
?>
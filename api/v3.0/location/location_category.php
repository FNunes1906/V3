<?php
/*PARAMETERS CAN BE USED LIKE
api/v2.1/location/location_category.php						=	list all categories
api/v2.1/location/location_category.php?category_id=152	=	list all sub categories including it self
*/

include("../connection.php");

// Display all published category from J_Events component
if(isset($_REQUEST['category_id'])){
	$catId			= $_REQUEST['category_id'];
	$select_query	= "select id,name from jos_categories where (`parent_id` =".$catId." OR `id` =".$catId.") AND section='com_jevlocations2' and published=1 order by `name`";
	
	$catResult = mysql_query($select_query);
	$i=0;

	while($row = mysql_fetch_array($catResult)){
		$data[$i]['id']    = $row['id'];
		$data[$i]['title'] = $row['name'];
		++$i;
	} 
}else{
	$select_query = "SELECT id,name FROM jos_categories WHERE section LIKE 'com_jevlocations2' AND PUBLISHED = 1 ORDER BY name";
	$catResult = mysql_query($select_query);
	$i=0;

	while($row = mysql_fetch_array($catResult)){
		$data[$i]['id']    = $row['id'];
		$data[$i]['title'] = $row['name'];
		++$i;
	} 
} 

header('Content-type: application/json');
echo json_encode($data);
?>
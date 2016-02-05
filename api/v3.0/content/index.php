<?php
/*PARAMETERS CAN BE USED LIKE
api/v2.1/location/								=	list all locations
api/v2.1/location/?id=534						=	list perticular location	
api/v2.1/location/?featured=1					=	list all featured locations
api/v2.1/location/?category_id=151				=	list all locations from specific category
api/v2.1/location/?category_id=151&featured=1	=	list all featured locations from specific category
*/

include("../connection.php");
include("../iadbanner.php");

/* All REQUEST paramter variable  */
$catId		= isset($_GET['category_id']) ? $_GET['category_id']:'';
$offset		= isset($_GET['offset']) ? $_GET['offset']:0;
$limit		= isset($_GET['limit']) ? $_GET['limit']:0;

/* Image URL Path variable setting : Yogi  */
$imagePath = "http://".$_SERVER['HTTP_HOST']."/partner/".strtolower(PARTNER_FOLDER_NAME)."/images/stories/";

/* 
Code Begin 
Result  : display banner for category
Request : Fetching Title from category id
Developer:Rinkal 
Last update Date:02-01-2013
*/

$cat_query = "select title from jos_categories where id=".$catId;
$res = mysql_query($cat_query);
while($bann_cat_name = mysql_fetch_array($res)){
	$banner_cat_name = $bann_cat_name['title'];
}

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == True) {
	$banner_code =  m_show_banner('android-'.$banner_cat_name.'-screen');
}else{
	$banner_code = m_show_banner('iphone-'.$banner_cat_name.'-screen');
}

/* 
CASE: 1
Result		: Listing of Articles from CATEGORY ID
Parameter	: category_id
API Request	: /content/?category_id=151
*/

if(isset($catId) && $catId != ''){
	
/*------------------------------------*/
/* 

CASE: 2
Result		: Listing of All Articles
Parameter	: N/A
API Request	: /content/
*/
}else{

	$select_query	= "SELECT * from jos_content where state = 1";
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);

	while($row = mysql_fetch_array($result)){
		$value['title']					= utf8_encode($row['title']);
		$value['description']			= $row['fulltext'];
		$value['short_description']		= $row['introtext'];
		$value['image_url']				= $row['introtext'];
		$value['category']				= $row['catid'];
		$value['is_featured_article']	= $row['introtext'];
		
			
	# Assigning Array values to $data array variable
		$data[] = $value;		
	}
	
	$response = array(
	'data' => $data,
	'ad' => $banner_code,
	'meta' => array(
		'total' => $num_records,
		'limit' => $limit != 0?(int)$limit:(int)$num_records,
		'offset' => $offset != 0?(int)$offset:(int)0
	)
	);
	header('Content-type: application/json');
	echo json_encode($response);
	
}

	/**
	* Fucntion to find Cateogory name from category ID
	* Developer: Yogi
	*/	
	function catNameFromID($caterogyIDs){
		
		$select_query	= "SELECT title from jos_categories WHERE id IN ($caterogyIDs) ";
		$result			= mysql_query($select_query);
		$num_records	= mysql_num_rows($result);
		while($catrow = mysql_fetch_array($result)){
			$categoryNameArray[] = $catrow['title'];
		}
		return $categoryNameArray;
	}
	
?>
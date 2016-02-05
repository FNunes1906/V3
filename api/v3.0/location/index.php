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
$locId		= isset($_GET['id']) ? $_GET['id']:'';
$glat		= isset($_GET['latitude']) ? $_GET['latitude']:'';
$glon		= isset($_GET['longitude']) ? $_GET['longitude']:'';
$offset		= isset($_GET['offset']) ? $_GET['offset']:0;
$limit		= isset($_GET['limit']) ? $_GET['limit']:0;
$featured	= isset($_GET['featured']) ? $_GET['featured']:0;

/* Image URL Path variable setting : Yogi  */
$imagePath = "http://".$_SERVER['HTTP_HOST']."/partner/".strtolower(PARTNER_FOLDER_NAME)."/images/stories/jevents/jevlocations/";

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

// Session varialbe set for Latitute to calculate distance
if (isset($_SESSION['lat_device1']) && $_REQUEST['lat']!="")
	$lat1 = $_SESSION['lat_device1'];
else
	$lat1 = 0;

if (isset($_SESSION['lon_device1']) && $_REQUEST['lon']!="")
	$lon1 = $_SESSION['lon_device1']; 
else
	$lon1=0;

function distance($lat1, $lon1, $lat2, $lon2, $unit){ 
	$theta	= $lon1 - $lon2; 
	$dist	= sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist	= acos($dist); 
	$dist	= rad2deg($dist); 
	$miles	= $dist * 60 * 1.1515;
	$unit	= strtoupper($unit);
	
	if($unit == "KM") {
		return round($miles * 1.609344); 
	}else if($unit == "Miles"){
		return round($miles * 0.8684);
	}else{
		return round($miles);
	}
}

/* 
CASE: 1
Result		: Listing of Locations from CATEGORY ID
Parameter	: category_id
API Request	: /location/?category_id=151
*/

if(isset($catId) && $catId != ''){
	
	//$select_query	= "SELECT loc.loc_id, loc.image, loc.postcode, loc.street, loc.phone, loc.url, loc.title, loc.alias, loc.description, loc.image, loc.geolat, loc.geolon, loc.catid_list, cate.title as category, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND loc.published = 1 ";
	//$select_query .= "AND cate.parent_id  = $catId ";
	
	//$select_query	= "SELECT loc.*, cat.id, cf.value FROM jos_jev_locations as loc, jos_categories as cat, jos_jev_customfields3 as cf WHERE FIND_IN_SET($catId,loc.catid_list) AND loc.published = 1 ";	
	//$select_query .= "AND cat.parent_id = $catId ";
	
	$select_query = "SELECT `jos_jev_locations`.*, `jos_jev_customfields3`.`value` FROM `jos_jev_locations`
				INNER JOIN `jos_categories`
					ON (`jos_jev_locations`.`catid_list` = `jos_categories`.`id`)
				INNER JOIN `jos_jev_customfields3`
					ON (`jos_jev_customfields3`.`target_id` = `jos_jev_locations`.`loc_id`)
				WHERE (`jos_categories`.`id` = $catId)
					OR (`jos_categories`.`parent_id` = $catId)";
	
	/* Query for Featured parameter if featured = 1 in URL */
	if(isset($featured) && $featured == 1){
		//$select_query .= "AND loc.loc_id = cf.target_id AND cf.value = 1 ";
		$select_query .= "AND `jos_jev_customfields3`.`value` = 1 ";
	}
	
	$select_query .= "GROUP BY `jos_jev_locations`.`loc_id` ORDER BY `jos_jev_locations`.`title` ASC";
	
	// Creaeating data set variable from Mysql query	
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
		$lat2								= $row['geolat'];
		$lon2								= $row['geolon'];
		$value['id'] 						= (int)$row['loc_id'];
		$value['title'] 				 	= utf8_encode($row['title']);
		//$value['category_id']				= (int)$row['loccat'];
		//$value['category_id']				= $row['catid_list'];
		$value['categories']				= catNameFromID($row['catid_list']);
		//$value['category'] 				= utf8_encode($row['category']);
		$value['location']['latitude']		= (float)$lat2;
		$value['location']['longitude']		= (float)$lon2;
		$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
		$value['location']['zip']			= $row['postcode'];
		$value['location']['address']		= $row['street'];
		$value['location']['name']			= $row['title'];
		$value['location']['phone']			= $row['phone'];
		$value['location']['website']		= $row['url'];
		$value['location']['description']	= $row['description'];

		$value['image_url'] = ($row['image'] != '')?$imagePath.$row['image']:NULL;
		$value['is_featured_location'] = $row['value'];

		/* Assigning Array values to $data array variable */
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

/*------------------------------------*/
/* 
CASE: 2
Result		: Listing of Events from EVENT ID (This will be REPETATION ID))
Parameter	: id
API Request	: /event/?id=1
*/
}elseif(isset($locId) && $locId != 0){

	$select_query = "select * from jos_jev_locations where loc_id=".$locId." ";

	// Creaeating data set variable from Mysql query	
	$result			= mysql_query($select_query);
//	echo $num_records	= mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
			$lat2								= $row['geolat'];
			$lon2								= $row['geolon'];
			$value['id'] 						= (int)$row['loc_id'];
			$value['title'] 				 	= utf8_encode($row['title']);
			//$value['category_id']				= (int)$row['loccat'];
			//$value['category_id']				= $row['catid_list'];
			$value['categories']				= catNameFromID($row['catid_list']);			
			$value['location']['latitude']		= (float)$lat2;
			$value['location']['longitude']		= (float)$lon2;
			$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
			$value['location']['zip']			= $row['postcode'];
			$value['location']['address']		= $row['street'];
			$value['location']['name']			= $row['title'];
			$value['location']['phone']			= $row['phone'];
			$value['location']['website']		= $row['url'];
			$value['location']['description']	= $row['description'];
			
			$value['image_url'] = ($row['image'] != '')?$imagePath.$row['image']:NULL;
			$value['is_featured_location'] = $row['value'];
			
			/* Assigning Array values to $data array variable */
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
/*------------------------------------*/
/* 
CASE: 0
Result		: Listing of All Location
Parameter	: N/A
API Request	: /event/
*/
}else{

	//$select_query	= "SELECT loc.loc_id, loc.title, loc.alias, loc.description, loc.image, loc.geolat, loc.geolon, loc.catid_list, cate.title as category, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND loc.published = 1 ";
	$select_query	= "SELECT `jos_jev_locations`.*, `jos_jev_customfields3`.`value` FROM `jos_jev_locations`
						INNER JOIN `jos_jev_customfields3`
							ON (`jos_jev_locations`.`loc_id` = `jos_jev_customfields3`.`target_id`)
						WHERE (`jos_jev_locations`.`published` = 1)";
	
	/* Query for Featured parameter if featured = 1 in URL */
	if(isset($featured) && $featured == 1){
		$select_query .= "AND `jos_jev_customfields3`.`value` = 1 ";
	}
	$select_query .= "GROUP BY `jos_jev_locations`.`loc_id` ORDER BY `jos_jev_locations`.`title` ASC";

	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);

	while($row = mysql_fetch_array($result)){
		
			$lat2								= $row['geolat'];
			$lon2								= $row['geolon'];
			$value['id'] 						= (int)$row['loc_id'];
			$value['title'] 				 	= utf8_encode($row['title']);
			//$value['category_id']				= $row['catid_list'];
			$value['categories']				= catNameFromID($row['catid_list']);
			$value['location']['latitude']		= (float)$lat2;
			$value['location']['longitude']		= (float)$lon2;			
			$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
			$value['location']['zip']			= $row['postcode'];
			$value['location']['address']		= $row['street'];
			$value['location']['name']			= $row['title'];
			$value['location']['phone']			= $row['phone'];
			$value['location']['website']		= $row['url'];
			$value['location']['description']	= $row['description'];
			
			$value['image_url'] = ($row['image'] != '')?$imagePath.$row['image']:NULL;
			$value['is_featured_location'] = $row['value'];
			
			/* Assigning Array values to $data array variable */
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
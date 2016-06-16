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
include("../common_function.php");


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
	
	# QUERY START
	/*$select_query = "SELECT `jos_jev_locations`.*, `jos_jev_customfields3`.`value` FROM `jos_jev_locations`
				INNER JOIN `jos_categories`
					ON (`jos_jev_locations`.`catid_list` = `jos_categories`.`id`)
				INNER JOIN `jos_jev_customfields3`
					ON (`jos_jev_customfields3`.`target_id` = `jos_jev_locations`.`loc_id`)
				WHERE (`jos_categories`.`id` = $catId)
					OR (`jos_categories`.`parent_id` = $catId)";
	# Query for Featured parameter if featured = 1 in URL
	if(isset($featured) && $featured == 1){
		//$select_query .= "AND loc.loc_id = cf.target_id AND cf.value = 1 ";
		$select_query .= "AND `jos_jev_customfields3`.`value` = 1 ";
	}
	$select_query .= "GROUP BY `jos_jev_locations`.`loc_id` ORDER BY `jos_jev_locations`.`title` ASC";*/
	# QUERY END
	
	# NEW QUERY START
	$fetch_cat_id_query = " SELECT c.id FROM jos_categories AS c
							LEFT JOIN jos_categories AS pc
								ON c.parent_id = pc.id
							LEFT JOIN jos_categories AS mc
								ON pc.parent_id = mc.id
							LEFT JOIN jos_categories AS gpc
								ON mc.parent_id = gpc.id
							WHERE c.section = 'com_jevlocations2'
								AND (c.id = $catId OR pc.id = $catId OR mc.id = $catId OR gpc.id = $catId)
								AND c.published = 1";
	$fetch_cat_id_result		= mysql_query($fetch_cat_id_query);
	$fetch_cat_id_num_records	= mysql_num_rows($fetch_cat_id_result);
	
	# Create category ID array
	if($fetch_cat_id_num_records > 0){
		while($catData = mysql_fetch_assoc($fetch_cat_id_result)){ 
			$catIdArray[] = $catData['id'];
		}
	}
	
	# Fetch all location data for category array
	$select_query = "	SELECT `jos_jev_locations`.*, `jos_jev_customfields3`.`value` FROM `jos_jev_locations`
						INNER JOIN `jos_jev_customfields3` ON (`jos_jev_customfields3`.`target_id` = `jos_jev_locations`.`loc_id`) AND ";
						
	# Concate Category ID query to fetch location for category
	for($k = 0; $k < count($catIdArray) ; $k++){	
		$select_query .= " FIND_IN_SET(".$catIdArray[$k].",`jos_jev_locations`.`catid_list` )";
		if($k < count($catIdArray)-1 ){
			$select_query .=" or";
		}
	}
	
	# Concate query for Features location parameter
	if(isset($featured) && $featured == 1){
		$select_query .= "AND `jos_jev_customfields3`.`value` = 1 ";
	}
	
	$select_query .= " WHERE (`jos_jev_locations`.`published` = 1) GROUP BY `jos_jev_locations`.`loc_id` ORDER BY `jos_jev_locations`.`title` ASC";
	
	# To check if Limit is given then apply in query
	if(isset($limit) && $limit != 0){
		if(isset($offset) && $offset != 0)
			$select_query .= " limit $offset,$limit";
		else	
			$select_query .= " limit $limit";
	}
	# NEW QUERY END
/*	exit($select_query);*/
	# Creating data set variable from Mysql query	
	$result			= mysql_query($select_query);
	//$num_records	= mysql_num_rows($result);
	$num_records = 0;

	$data = array();
	# Code for banner Start
	if($banner_code['url'] != '')
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	# Code for banner End
	
	while($row = mysql_fetch_array($result)){
		if($row['published'] != 0){ // If location is published then only add to json array
			$lat2								= $row['geolat'];
			$lon2								= $row['geolon'];
			$value['id'] 						= (int)$row['loc_id'];
			
			# Process Start for title : Yogi
			/*$enc = utf8_decode($row['title']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$value['title'] = $new_title;*/
			# Process End for title : Yogi
			
			$value['title'] 					= handleSpecialChar($row['title']);
			$value['categories']				= catNameFromID($row['catid_list']);
			$value['location']['latitude']		= (float)$lat2;
			$value['location']['longitude']		= (float)$lon2;
			$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
			$value['location']['zip']			= $row['postcode'];
			$value['location']['city']			= handleSpecialChar($row['city']);
			$value['location']['address']		= handleSpecialChar($row['street']);
			$value['location']['phone']			= $row['phone'];
			$value['location']['website']		= $row['url'];
			$value['location']['description']	= html_entity_decode(htmlentities($row['description'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
			$value['image_url'] 				= ($row['image'] != '')?$imagePath.$row['image']:NULL;
			$value['is_featured_location'] 		= $row['value'];
			$num_records++;
		}
			if(isset($value) && count($value) > 0 ){
				$data[] = $value;
			}
	}

	# Assigning Array values to $data array variable
	$response = array(
	'data' => count($data) > 1?$data:'',
	//'ad' => $banner_code,
	'meta' => array(
		'total' => $num_records,
		'offset' => $offset != 0?(int)$offset:(int)0,
		'limit' => $limit != 0?(int)$limit:(int)$num_records
	)
	);
	header('Content-type: application/json');
	$jsonData = json_encode($response);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;

/*------------------------------------*/
/* 
CASE: 2
Result		: Listing of Events from EVENT ID (This will be REPETATION ID))
Parameter	: id
API Request	: /event/?id=1
*/
}elseif(isset($locId) && $locId != 0){

	$select_query = "select * from jos_jev_locations where loc_id=".$locId." ";

	# To check if Limit is given then apply in query
	if(isset($limit) && $limit != 0){
		if(isset($offset) && $offset != 0)
			$select_query .= " limit $offset,$limit";
		else	
			$select_query .= " limit $limit";
	}
	
	// Creaeating data set variable from Mysql querys
	$result			= mysql_query($select_query);
//	echo $num_records	= mysql_num_rows($result);
	
	$data = array();
	# Code for banner Start
	if($banner_code['url'] != '')
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	# Code for banner End
		
	while($row = mysql_fetch_array($result)){
			$lat2								= $row['geolat'];
			$lon2								= $row['geolon'];
			$value['id'] 						= (int)$row['loc_id'];
			
			# Process Start for title : Yogi
			/*$enc = utf8_decode($row['title']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$value['title'] = $new_title;*/
			# Process End for title : Yogi
			
			$value['title'] 					= handleSpecialChar($row['title']);
			$value['categories']				= catNameFromID($row['catid_list']);			
			$value['location']['latitude']		= (float)$lat2;
			$value['location']['longitude']		= (float)$lon2;
			$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
			$value['location']['zip']			= $row['postcode'];
			$value['location']['city']			= handleSpecialChar($row['city']);
			$value['location']['address']		= handleSpecialChar($row['street']);
			$value['location']['phone']			= $row['phone'];
			$value['location']['website']		= $row['url'];
			$value['location']['description']	= html_entity_decode(htmlentities($row['description'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
			
			$value['image_url'] = ($row['image'] != '')?$imagePath.$row['image']:NULL;
			$value['is_featured_location'] = $row['value'];
			
			/* Assigning Array values to $data array variable */
			if(isset($value) && count($value) > 0 ){
				$data[] = $value;
			}
	}
	
	$response = array(
	'data' => count($data) > 1?$data:'',
	//'ad' => $banner_code,
	'meta' => array(
		'total' => $num_records,
		'offset' => $offset != 0?(int)$offset:(int)0,
		'limit' => $limit != 0?(int)$limit:(int)$num_records
	)
	);
	header('Content-type: application/json');
	$jsonData = json_encode($response);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;
/*------------------------------------*/
/* 
CASE: 0
Result		: Listing of All Location
Parameter	: N/A
API Request	: /location/
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
	$select_query .= " GROUP BY `jos_jev_locations`.`loc_id` ORDER BY `jos_jev_locations`.`title` ASC";

	# To check if Limit is given then apply in query
	if(isset($limit) && $limit != 0){
		if(isset($offset) && $offset != 0)
			$select_query .= " limit $offset,$limit";
		else	
			$select_query .= " limit $limit";
	}

	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);
	$data = array();
	# Code for banner Start
	if($banner_code['url'] != '')
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	# Code for banner End
	
	while($row = mysql_fetch_array($result)){
		
			$lat2								= $row['geolat'];
			$lon2								= $row['geolon'];
			$value['id'] 						= (int)$row['loc_id'];
			
			# Process Start for title : Yogi
/*			$enc = utf8_decode($row['title']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$value['title'] = $new_title;
*/			# Process End for title : Yogi

			$value['title'] 					= handleSpecialChar($row['title']);
			$value['categories']				= catNameFromID($row['catid_list']);
			$value['location']['latitude']		= (float)$lat2;
			$value['location']['longitude']		= (float)$lon2;			
			$value['location']['distance']		= distance($lat1, $lon1, $lat2, $lon2, $dunit);
			$value['location']['zip']			= $row['postcode'];
			$value['location']['city']			= handleSpecialChar($row['city']);
			$value['location']['address']		= handleSpecialChar($row['street']);
			$value['location']['phone']			= $row['phone'];
			$value['location']['website']		= $row['url'];
			$value['location']['description']	= html_entity_decode(htmlentities($row['description'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1"));
			
			$value['image_url'] = ($row['image'] != '')?$imagePath.$row['image']:NULL;
			$value['is_featured_location'] = $row['value'];
			
			/* Assigning Array values to $data array variable */
			if(isset($value) && count($value) > 0 ){
				$data[] = $value;
			}
	}
	
	$response = array(
	'data' => count($data) > 1?$data:'',
	'ad' => $banner_code,
	'meta' => array(
		'total' => $num_records,
		'offset' => $offset != 0?(int)$offset:(int)0,
		'limit' => $limit != 0?(int)$limit:(int)$num_records
	)
	);
	
	header('Content-type: application/json');
	$jsonData = json_encode($response);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;

}
	
?>
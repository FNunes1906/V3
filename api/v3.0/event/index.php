<?php
//ini_set('display_errors',1);
include("../connection.php");
include("../iadbanner.php");
include("../common_function.php");

/* Assigning Timezone Session varialble to $timezoneValue vriable */
$timezoneValue 	= $_SESSION['tw_timezone'];

//Setting up Timezone time (hour, minut and second) varible
$timeZoneArray 	= explode(':',$timezoneValue);
$totalHours		= date("H") + $timeZoneArray[0];
$totalMinutes	= date("i") + $timeZoneArray[1];
$totalSeconds	= date("s") + $timeZoneArray[2];

//Using mktime function setting up final date in timestamp based on timezone specified in $totalHours & $totalMinutes
$today		= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
$tomonth	= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
$toyear		= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
/* Timezone Block End August 2013 */


/* Code for iPhone Banner Begin */
$banner_code =  m_show_banner('iphone-events-screen');
/* Code for iPhone Banner End */


/* All REQUEST paramter variable  */
$catId		= isset($_REQUEST['category_id'])?$_REQUEST['category_id']:'34';
$eventId	= isset($_REQUEST['id']) ? $_REQUEST['id']:'';
$glat		= isset($_REQUEST['latitude']) ? $_REQUEST['latitude']:'';
$glon		= isset($_REQUEST['longitude']) ? $_REQUEST['longitude']:'';
$dfrom		= isset($_REQUEST['from']) ? $_REQUEST['from']:0;
$dto		= isset($_REQUEST['to']) ? $_REQUEST['to']:0;
$offset		= isset($_REQUEST['offset']) ? $_REQUEST['offset']:0;
$limit		= isset($_REQUEST['limit']) ? $_REQUEST['limit']:50;
$featured	= isset($_REQUEST['featured']) ? $_REQUEST['featured']:0;
$startDate	= explode('-',$dfrom);
$endDate	= explode('-',$dto);
$menu		= isset($_GET['menu']) ? $_GET['menu']:'';
/*$today_date = date('Y-m-d');
$td_array 	= explode('-',$today_date);*/

// Session varialbe set for Latitute to calculate distance
$_SESSION['lat_device1'] = '';
if(isset($glat) && $glat != '' ){
	$_SESSION['lat_device1']	= $glat;
}

/* Session varialbe set for Lontitutde to calculate distance */
$_SESSION['lon_device1'] = '';
if (isset($glon) && $glon != 0){
	$_SESSION['lon_device1']	= $glon;
}

/* 
CASE: 1
Result		: Listing of Events from CATEGORY ID
Parameter	: category_id
API Request	: /event/?category_id=1
*/

if(isset($catId) && $catId != ''){
	
	//$today = date('d'); $tomonth = date('m'); $toyear = date('Y');
	$select_query	= "SELECT ev.rawdata,ev.ev_id,rpt.rp_id,rpt.startrepeat,rpt.endrepeat,ev.catid,cat.title,evd.description,evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND rpt.eventdetail_id = evd.evdet_id AND rpt.eventdetail_id = cf.evdet_id";
	
	/* When Start Date & End Date provided */
	if((isset($dfrom) && $dfrom != 0) && (isset($dto) && $dto != 0)){
		$select_query .= " AND rpt.endrepeat >= '".$startDate[0]."-".$startDate[1]."-".$startDate[2]." 00:00:00' AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59'";
	/* When Start Date provided */
	}elseif((isset($dfrom) && $dfrom != 0)){
		$select_query .= " AND rpt.endrepeat >= '".$startDate[0]."-".$startDate[1]."-".$startDate[2]." 00:00:00'";
	/* When End Date provided */
	}elseif((isset($dto) && $dto != 0)){
		//$select_query .= " AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59' AND rpt.endrepeat >= '".$td_array[0]."-".$td_array[1]."-".$td_array[2]." 00:00:00'";
		$select_query .= " AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59' AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00'";
	}else{
	/* No date is provided */
		$select_query .= " AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00'";
	}	
	
//	$select_query .= "AND ev.catid = cat.id AND ev.catid = $catId AND ev.state = 1";
	$select_query .= "AND ev.catid = cat.id AND (cat.id=$catId OR cat.parent_id=$catId) AND ev.state = 1";
	

	/* Query for Featured parameter if featured = 1 in URL */
	if(isset($featured) && $featured == 1){
		$select_query .= " AND cf.value = 1 GROUP BY ev.ev_id,rpt.startrepeat ORDER BY rpt.startrepeat";
	}else{
		$select_query .= " GROUP BY ev.ev_id,rpt.startrepeat ORDER BY rpt.startrepeat";
	}	
	/* To check if Limit is given then apply in query */
	if(isset($limit) && $limit != 0){
		/* If featured event and limit is provided then unset limit */ 
		if(isset($featured) && $featured == 1)
			$select_query .= "";
		elseif(isset($offset) && $offset != 0)
			$select_query .= " limit $offset,$limit";
		else	
			$select_query .= " limit $limit";
	}
	// Creaeating data set variable from Mysql query	
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);

	/* Logic for Featured event */	
	// if we need to remove duplicate events for featured event
	$dup_eid_logic = 0;
	
	//Assigning dup_eid_logic varialble = 1 if featured & limit will be provided in URL 
	if(isset($featured) && $featured == 1 && $limit != 0)
	{
		$dup_eid_logic = 1;
		$f_event_array = array();
	}
		
	if($num_records > 0){
	
	$data = array();
	# Code for banner Start
	if($banner_code['url'] != ''){
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	}
	$data[0]['clickurl'] = "<a href='" . $banner_code['clickurl'] . "'> ".$banner_code['clickurl']." </a>";
	# Code for banner End
	
		/* Looping for Event Data */
		while($rs_ev_tbl = mysql_fetch_array($result)){
			
			/* Checking condition for duplicate featured event id */
			if($dup_eid_logic == 1){
				if(in_array($rs_ev_tbl['ev_id'],$f_event_array))
				{
					continue;
				}else{
					$f_event_array[] = $rs_ev_tbl['ev_id'];
				}	
			}
		
			//Creating Image array from Event description
			$imgArray = explode('src="',$rs_ev_tbl['description']);
			$evImageArray = array();
			$singleImage = '';
			
			for($i=0;$i<count($imgArray);$i++){
				if(strstr($imgArray[$i],'" />',true) != ''){
					if($singleImage == '')
						$singleImage 	= strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0
					else
						$evImageArray[] = strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0	
					
					# Remove all other parameters from image tag and keep only image URL : Yogi - 6 may 2016
					if(strpos($singleImage, '"') !== false ){
						$singleImage = strstr($singleImage,'"',true);
						if(strpos($singleImage, '?') !== false ){
							$singleImage = strstr($singleImage,'?',true);
						}
					}
				}	
			}
			
			/* Location table */
			if ((int) ($rs_ev_tbl['location'])) {
				$loc_qry = "select * from jos_jev_locations where loc_id=".$rs_ev_tbl['location'];		
				$location_query		= mysql_query($loc_qry);
				$rs_loc_tbl			= mysql_fetch_array($location_query);
				$lat2				= $rs_loc_tbl['geolat'];
				$lon2				= $rs_loc_tbl['geolon'];
			}
			/* Creating Jason Array variable $data */
			$value['id'] 					= (int)$rs_ev_tbl['rp_id'];
			//$value['title'] 				= utf8_encode($rs_ev_tbl['summary']);
			# Process Start for title : Yogi
/*			$enc = utf8_decode($rs_ev_tbl['summary']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$value['title'] = $new_title;
*/			# Process End for title : Yogi
			
			$value['title']					= handleSpecialChar($rs_ev_tbl['summary']);
			$value['category'] 				= handleSpecialChar($rs_ev_tbl['title']);
			$value['category_id']			= (int)$rs_ev_tbl['catid'];
			$value['location']['latitude']	= (float)$lat2;
			$value['location']['longitude']	= (float)$lon2;
			$value['location']['zip']		= $rs_loc_tbl['postcode'];
			$value['location']['address']	= handleSpecialChar($rs_loc_tbl['street']);
			$value['location']['name']		= handleSpecialChar($rs_loc_tbl['title']);
			$value['location']['phone']		= $rs_loc_tbl['phone'];
			$value['location']['website']	= $rs_loc_tbl['url'];
			if($_SESSION['lat_device1'] != '' && $_SESSION['lon_device1']){
				$value['location']['distance']	= round(distance($_SESSION['lat_device1'], $_SESSION['lon_device1'], $lat2, $lon2,$dunit),'1');
			}else{
				$value['location']['distance'] = '';
			}
			
			if(in_array($rs_ev_tbl['ev_id'],$ev_id_array)){
				$value['is_featured_event']	= 0;
			}else{
				$value['is_featured_event']	= (int)$rs_ev_tbl['value'];
			}
			$ev_id_array[] = $rs_ev_tbl['ev_id'];
			
			//$value['description']			= utf8_encode($rs_ev_tbl['description']);
			$value['description']			= html_entity_decode(htmlentities($rs_ev_tbl['description'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
			$value['image_url']				= $singleImage;
			$value['start_time']			= $rs_ev_tbl['startrepeat'];
			$value['end_time']				= $rs_ev_tbl['endrepeat'];
			
			# Code to check all day event or not
			if(strpos($rs_ev_tbl['rawdata'], ':"on"') !== false) { 
    			$value['duration'] = 'All Day Event';
			}else{
    			unset($value['duration']);
			}
			
			# Generate share Url
			$value['shareurl']				= shareURL($menu,$value['title'],$value['id'],'events',null,$value['category_id'],$value['start_time']);

			/* Assigning Array values to $data array variable */
			$data[] = $value;
			
			/* Checking condition for duplicate featured event id */
			if($dup_eid_logic == 1){
				if(isset($f_event_array) && (count($f_event_array) == $limit))
					break;
			}
		}	
		
		# Coding for Next URL
	    $nextUrlOffset = $offset + $limit + 1;
		$nextPageURL = nextPageURL($limit,$num_records,$nextUrlOffset);
		
		$response = array(
	    	'data'		=> $data,
			//'ad' 		=> $banner_code,
	    	'meta'		=> array(
	        'total'		=> $num_records,
	        'offset' 	=> $offset != 0?(int)$offset:(int)0,
	        'limit' 	=> $limit != 0?(int)$limit:(int)$num_records,
	        //'shareurl' => ($menu != '')?"http://".$_SERVER['HTTP_HOST']."/".$menu:'',
	        # Added below for Next page url
	        //'nexturl'	=> "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?offset=$nextUrlOffset&limit=$limit"
	        'nexturl'	=> $nextPageURL
	    	)
		);
		
		header('Content-type: application/json');
		$jsonData = json_encode($response);
		$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
		$jsonData = (str_replace("\u0092","\u0027",$jsonData));
		echo $jsonData;
	}else{
		$data["error"] = "Not Found";
		header('Content-type: application/json');
		echo json_encode($data);
	}
/*------------------------------------*/
/* 
CASE: 2
Result		: Listing of Events from EVENT ID (This will be REPETATION ID))
Parameter	: id
API Request	: /event/?id=1
*/
}elseif(isset($eventId) && $eventId != 0){

	$select_query	= "SELECT rpt.rp_id,ev.catid,cat.title,rpt.startrepeat,rpt.endrepeat,evd.description,evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_repetition AS rpt,jos_categories AS cat,jos_jevents_vevdetail
 AS evd, jos_jev_customfields AS cf	WHERE ev.ev_id= rpt.eventid AND ev.catid=cat.id AND rpt.eventdetail_id = evd.evdet_id AND rpt.eventdetail_id = cf.evdet_id AND rpt.rp_id = $eventId AND ev.state=1";
	
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);

	if($num_records > 0){

	$data = array();
	# Code for banner Start
	if($banner_code['url'] != ''){
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	}
	$data[0]['clickurl'] = "<a href='" . $banner_code['clickurl'] . "'> ".$banner_code['clickurl']." </a>";
	# Code for banner End

		//Looping Repetation table data
		while($rs_ev_tbl = mysql_fetch_array($result)){

			//Creating Image array from Event description
			$imgArray = explode('src="',$rs_ev_tbl['description']);
			$evImageArray = array();
			$singleImage = '';
			
			for($i=0;$i<count($imgArray);$i++){
				if(strstr($imgArray[$i],'" />',true) != ''){
					if($singleImage == '')
						$singleImage 	= strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0
					else
						$evImageArray[] = strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0	
					
					# Remove all other parameters from image tag and keep only image URL : Yogi - 6 may 2016
					//$singleImage = strstr($singleImage,'"',true);		
				}	
			}	
				
			// Location table
			if ((int) ($rs_ev_tbl['location'])) {
				$loc_qry		= "select *  from jos_jev_locations where loc_id=".$rs_ev_tbl['location'];
				$location_query	= mysql_query($loc_qry);
				$rs_loc_tbl		= mysql_fetch_array($location_query);
				$lat2			= $rs_loc_tbl['geolat'];
				$lon2			= $rs_loc_tbl['geolon'];
			}

			// Creating Jason Array variable $data	
			$data['id'] 					= (int)$rs_ev_tbl['rp_id'];
			//$data['title'] 				= utf8_encode($rs_ev_tbl['summary']);
			# Process Start for title : Yogi
/*			$enc = utf8_decode($rs_ev_tbl['summary']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$data['title'] = $new_title;
*/			# Process End for title : Yogi
			
			$data['title']					= handleSpecialChar($rs_ev_tbl['summary']);
			$data['category'] 				= handleSpecialChar($rs_ev_tbl['title']);
			$data['category_id']			= (int)$rs_ev_tbl['catid'];
			$data['location']['latitude']	= (float)$lat2;
			$data['location']['longitude']	= (float)$lon2;
			$data['location']['zip']		= $rs_loc_tbl['postcode'];
			$data['location']['address']	= handleSpecialChar($rs_loc_tbl['street']);
			$data['location']['name']		= handleSpecialChar($rs_loc_tbl['title']);
			$data['location']['phone']		= $rs_loc_tbl['phone'];
			$data['location']['website']	= $rs_loc_tbl['url'];
			
			if($_SESSION['lat_device1'] != '' && $_SESSION['lon_device1']){
				$data['location']['distance']	= round(distance($_SESSION['lat_device1'], $_SESSION['lon_device1'], $lat2, $lon2,$dunit),'1');
			}else{
				$data['location']['distance'] = '';
			}
			
			$data['is_featured_event']		= (int)$rs_ev_tbl['value'];
			$data['description']			= html_entity_decode(htmlentities($rs_ev_tbl['description'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
			$data['image_url']				= $singleImage;
			$data['start_time']				= $rs_ev_tbl['startrepeat'];
			$data['end_time']				= $rs_ev_tbl['endrepeat'];
			$data['images']					= $evImageArray;
		}
	}else{
		$data["error"] = "Not Found";
	}	
	header('Content-type: application/json');
	$jsonData = json_encode($data);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;
/*------------------------------------*/
/* 
CASE: 0
Result		: Listing of All Events
Parameter	: N/A
API Request	: /event/
*/
}else{

//featured = 1	
	//$today = date('d'); $tomonth = date('m'); $toyear = date('Y');
	$select_query	= "SELECT rpt.rp_id,rpt.startrepeat,rpt.endrepeat,ev.ev_id,ev.catid,cat.title,evd.description,evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND rpt.eventdetail_id = evd.evdet_id AND rpt.eventdetail_id = cf.evdet_id";

	/* When Start Date & End Date provided */
	if((isset($dfrom) && $dfrom != 0) && (isset($dto) && $dto != 0)){
		$select_query .= " AND rpt.endrepeat >= '".$startDate[0]."-".$startDate[1]."-".$startDate[2]." 00:00:00' AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59'";
	/* When Start Date provided */
	}elseif((isset($dfrom) && $dfrom != 0)){
		$select_query .= " AND rpt.endrepeat >= '".$startDate[0]."-".$startDate[1]."-".$startDate[2]." 00:00:00'";
	/* When End Date provided */
	}elseif((isset($dto) && $dto != 0)){
		//$select_query .= " AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59' AND rpt.endrepeat >= '".$td_array[0]."-".$td_array[1]."-".$td_array[2]." 00:00:00'";
		$select_query .= " AND rpt.startrepeat <='".$endDate[0]."-".$endDate[1]."-".$endDate[2]." 23:59:59' AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00'";
	}else{
	/* No date is provided */
		$select_query .= " AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00'";
	}	

	$select_query .= " AND ev.catid = cat.id AND ev.state = 1";

	/* Query for Featured parameter if featured = 1 in URL */
	if(isset($featured) && $featured == 1){
		$select_query .= " AND cf.value = 1 GROUP BY ev.ev_id,rpt.startrepeat ORDER BY rpt.startrepeat";
	}

	/* To check if Limit is given then apply in query */
	if(isset($limit) && $limit != 0){
		/* If featured event and limit is provided then unset limit */ 
		if(isset($featured) && $featured != 0)
			$select_query .= "";
		elseif(isset($offset) && $offset != 0)
			$select_query .= " limit $offset,$limit";
		else	
			$select_query .= " limit $limit";
	}
	
	// Creaeating data set variable from Mysql query
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);

	/* Logic for Featured event */	
	// To remove duplicate events for featured event
	$dup_eid_logic = 0;
	
	//Assigning dup_eid_logic varialble = 1 if featured & limit will be provided in URL 
	if(isset($featured) && $featured == 1 && $limit != 0)
	{
		$dup_eid_logic = 1;
		$f_event_array = array();
	}	
	// Creating aray varialble to check unique ID for featured event	
	
	
	if($num_records > 0){
	
	$data = array();
	# Code for banner Start
	if($banner_code['url'] != '')
		$data[]['banner_add'] = "<a href='$banner_code[url]'><img src='$banner_code[banner]'></a>";
	# Code for banner End

		/* Looping for Event Data */
		while($rs_ev_tbl = mysql_fetch_array($result)){
			
			if($dup_eid_logic == 1){
				if(in_array($rs_ev_tbl['ev_id'],$f_event_array))
				{
					continue;
				}else{
					$f_event_array[] = $rs_ev_tbl['ev_id'];
				}
				
			}
			
			
			//Creating Image array from Event description
			$imgArray = explode('src="',$rs_ev_tbl['description']);
			$evImageArray = array();
			$singleImage = '';
			
			for($i=0;$i<count($imgArray);$i++){
				if(strstr($imgArray[$i],'" />',true) != ''){
					if($singleImage == '')
						$singleImage 	= strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0
					else
						$evImageArray[] = strstr($imgArray[$i],'" />',true); // As of PHP 5.3.0	
					
					# Remove all other parameters from image tag and keep only image URL : Yogi - 6 may 2016
					//$singleImage = strstr($singleImage,'"',true);		
				}	
			}
			
			/* Location table */
			if ((int) ($rs_ev_tbl['location'])) {
				$loc_qry = "select * from jos_jev_locations where loc_id=".$rs_ev_tbl['location'];		
				$location_query		= mysql_query($loc_qry);
				$rs_loc_tbl			= mysql_fetch_array($location_query);
				$lat2				= $rs_loc_tbl['geolat'];
				$lon2				= $rs_loc_tbl['geolon'];
			}
			/* Creating Jason Array variable $data */
			$value['id'] 					= (int)$rs_ev_tbl['rp_id'];
			//$value['title'] 				= utf8_encode($rs_ev_tbl['summary']);
			# Process Start for title : Yogi
			/*$enc = utf8_decode($rs_ev_tbl['summary']);
			$new_title = utf8_encode($enc);
			$new_title = (str_replace("?","'",$new_title));
			$value['title'] = $new_title;*/
			# Process End for title : Yogi
			
			$value['title']					= handleSpecialChar($rs_ev_tbl['summary']);
			$value['category'] 				= handleSpecialChar($rs_ev_tbl['title']);
			$value['category_id']			= (int)$rs_ev_tbl['catid'];
			$value['location']['latitude']	= (float)$lat2;
			$value['location']['longitude']	= (float)$lon2;
			$value['location']['zip']		= $rs_loc_tbl['postcode'];
			$value['location']['address']	= handleSpecialChar($rs_loc_tbl['street']);
			$value['location']['name']		= handleSpecialChar($rs_loc_tbl['title']);
			$value['location']['phone']		= $rs_loc_tbl['phone'];
			$value['location']['website']	= $rs_loc_tbl['url'];
			
			if($_SESSION['lat_device1'] != '' && $_SESSION['lon_device1']){
				$value['location']['distance']	= round(distance($_SESSION['lat_device1'], $_SESSION['lon_device1'], $lat2, $lon2,$dunit),'1');
			}else{
				$value['location']['distance'] = '';
				/* For Bhavan to set distanc as N/A */
				// $value['location']['distance'] = "N/A";
			}
			
			$value['is_featured_event']		= (int)$rs_ev_tbl['value'];
			//$value['description']			= utf8_encode($rs_ev_tbl['description']);
			$value['description']			= html_entity_decode(htmlentities($rs_ev_tbl['description'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
			$value['image_url']				= $singleImage;
			$value['start_time']			= $rs_ev_tbl['startrepeat'];
			$value['end_time']				= $rs_ev_tbl['endrepeat'];
			
			/* Assigning Array values to $data array variable */
			$data[] = $value;
			
			/* Checking condition for duplicate featured event id */
			if($dup_eid_logic == 1){
				if(isset($f_event_array) && (count($f_event_array) == $limit))
					break;
			}
		}	
		$response = array(
	    	'data' => $data,
	    	//'ad' => $banner_code,
			//'shareurl' => ($menu != '')?"http://".$_SERVER['HTTP_HOST']."/".$menu:'',
			'meta' => array(
	        'total' => $num_records,
	        'limit' => $limit != 0?(int)$limit:(int)$num_records,
			'offset' => $offset != 0?(int)$offset:(int)0
	    	)
		);
		header('Content-type: application/json');
		$jsonData = json_encode($response);
		//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
		echo $jsonData;
	}else{
		if($dto < $dfrom){
			$data["error"] = "Bad Request";
		}else{
			$data["error"] = "Not Found";	
		}	
		header('Content-type: application/json');
		echo json_encode($data);
	}
}	

?>
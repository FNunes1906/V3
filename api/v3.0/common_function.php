<?php
/**
* @Developer : Yogi
* @Parameter : Sting Variable
* @return : String with Special character
*/
function handleSpecialChar($string){

	# Process START
	//$enc		= utf8_decode($string);
	//$new_title	= utf8_encode($enc);
	$new_title	= utf8_encode($string);
	
	//var_dump($new_title); exit;
	//$new_title	= (str_replace("?","'",$new_title));
	return $new_title;
	# Process END

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
		$categoryNameArray[] = handleSpecialChar($catrow['title']);
	}
	return $categoryNameArray;
}

/**
* Fucntion to find Cateogory name from category ID
* Developer: Yogi
*/	
function singleCatNameFromID($caterogyIDs){
	
	$select_query	= "SELECT title from jos_categories WHERE id IN ($caterogyIDs) ";
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);
	
	while($catrow = mysql_fetch_array($result)){
		$categoryName = handleSpecialChar($catrow['title']);
	}
	
	if(isset($categoryName)){ return $categoryName; }
}


/**
* Fucntion to find Cateogory ID from category NAME
* Developer: Yogi
*/	
function fetchCatIdFromName($cat_name){
	
	$select_query	= "SELECT id from jos_categories WHERE title = '$cat_name' ";
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);
	
	while($catrow = mysql_fetch_array($result)){
		$categoryID = handleSpecialChar($catrow['id']);
	}
	
	if(isset($categoryID)){ return $categoryID; }
}

/**
* Fucntion to get Menu name from Category ID for Article / Blog
* Developer: Yogi
*/	
function fetchMenuNameFromCatID($categoty_id){
	$select_query	= "SELECT name from jos_menu WHERE link LIKE '%index.php?option=com_content&view=category&layout=blog&id=$categoty_id%' AND menutype LIKE 'leftmenu' ";
	$result			= mysql_query($select_query);
	$num_records	= mysql_num_rows($result);
	
	while($menurow = mysql_fetch_array($result)){
		$menu_name = handleSpecialChar($menurow['name']);
	}
	
	if(isset($menu_name)){ 
		return strtolower($menu_name);
	}else{
		return 'home';
	}
}


/* Function to calculate Location Distance */
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



/**
* Fucntion to find NEXT PAGE URL form Limit & number of records
* Developer: Yogi
*/	
function nextPageURL($limit,$num_records,$nextUrlOffset){
	if($num_records >= $limit){
		return $nextpageURL = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?offset=$nextUrlOffset&limit=$limit";
	}else{
		return $nextpageURL = '';
	}
}	

/**
* Fucntion to create shareURL 
* Developer: Yogi
* @$menu:Menu Name, @$title:Title, @$id:id, @$type:Componenet type (Event, Locaiton, content etc) 
*/	
function shareURL($menu,$title,$id,$type,$cname = NULL,$cid = NULL,$start_date = NULL){
	if(isset($menu) && $menu != ''){
		# If menu is there in URL
		if($type == 'location'){
			# Type : Location
			//$title = str_replace(' ', '-', strtolower($title)); // Convert spaces to dash and lowercase
			$title = seoUrl($title); // Convert spaces to dash and lowercase
			
			$shareURL = "http://".$_SERVER['HTTP_HOST']."/".$menu."/detail/".$id."/1/".$title;
			return $shareURL;
		
		}elseif($type == 'events'){
			# Type : Event
			// Event code
			$title = seoUrl($title); // Convert spaces to dash and lowercase
			$date=seoDate($start_date);
			$shareURL = "http://".$_SERVER['HTTP_HOST']."/".$menu."/icalrepeat.detail/".$date."/".$id."/".$cid."/".$title;
			$shareURL = strtolower($shareURL);
			return $shareURL;
		}elseif($type == 'content'){
			# Type : Content
			//$title = str_replace(' ', '-', strtolower($title)); // Convert spaces to dash and lowercase
			$title = seoUrl($title); // Convert spaces to dash and lowercase
			if(isset($cid) && $cid != ''){
				$shareURL = "http://".$_SERVER['HTTP_HOST']."/".$menu."/".$cid."-".strtolower($cname)."/".$id."-".$title;
			}else{
				$shareURL = "http://".$_SERVER['HTTP_HOST']."/".fetchMenuNameFromCatID(fetchCatIdFromName($cname))."/".fetchCatIdFromName($cname)."-".strtolower($cname)."/".$id."-".$title;
			}
			return $shareURL;
		}
	}else{ //If menu is not in URL
		return '';
	}	
} // Function end tag


function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
function seoDate($date){
	return date('Y/m/d',strtotime($date));
}

?>
<?php
/**
* @Developer : Yogi
* @Parameter : Sting Variable
* @return : String with Special character
*/
function handleSpecialChar($string){

	# Process START
	$enc		= utf8_decode($string);
	$new_title	= utf8_encode($enc);
	$new_title	= (str_replace("?","'",$new_title));
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


?>
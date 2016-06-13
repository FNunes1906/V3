<?php
include("../connection.php");
include("../iadbanner.php");
include("../common_function.php");

# include simple_html_dom to extract image tag from description
include("../simple_html_dom.php");

/* All REQUEST paramter variable  */
$catId		= isset($_GET['category_id']) ? $_GET['category_id']:'';
$offset		= isset($_GET['offset']) ? $_GET['offset']:0;
$limit		= isset($_GET['limit']) ? $_GET['limit']:50;
$order		= isset($_GET['order']) ? $_GET['order']:0;

/* Date Settings: Yogi  */
$todaydate	= date("Y-m-j",strtotime("+1 day"));
$today 		= date("Y-m-d G:i:s");

/* 
Code Begin 
Result  : display banner for category
Request : Fetching Title from category id
Developer:Rinkal 
Last update Date:02-01-2013
*/

if($catId != ''){
	$cat_query = "select title from jos_categories where id=".$catId;
	$res = mysql_query($cat_query);
	if(mysql_num_rows($res) > 0){
		while($bann_cat_name = mysql_fetch_array($res)){
			$banner_cat_name = $bann_cat_name['title'];
		}
	}
}


$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

if(isset($banner_cat_name) && $banner_cat_name != ''){
	if(stripos($ua,'android') == True) {
		$banner_code =  m_show_banner('android-'.$banner_cat_name.'-screen');
	}else{
		$banner_code = m_show_banner('iphone-'.$banner_cat_name.'-screen');
	}
}else{
	if(stripos($ua,'android') == True) {
		$banner_code =  m_show_banner('android-news-screen');
	}else{
		$banner_code = m_show_banner('iphone-news-screen');
	}
}
/* 
CASE: 1
Result		: Listing of Articles from CATEGORY ID
Parameter	: category_id
API Request	: /content/?category_id=151
*/

if(isset($catId) && $catId != ''){
	
	$select_query = "SELECT jc.*, jcf.ordering, jcf.content_id
						FROM jos_content AS jc
						LEFT JOIN jos_content_frontpage AS jcf
							ON jc.id = jcf.content_id
						LEFT JOIN jos_categories AS jcs
							ON jcs.id = jc.catid
						WHERE jc.catid = $catId
							AND jc.state = 1
							AND (jc.publish_down > '$today'
								OR jc.publish_down = '0000-00-00 00:00:00')
							AND (jc.publish_up <= '$todaydate'
								OR jc.publish_up = '0000-00-00 00:00:00')
						GROUP BY jc.id ";
						
						if(isset($order) && $order == 1)
							$select_query.= "ORDER BY jc.ordering";
						else
							$select_query.= "ORDER BY jc.id DESC";
						
											
	
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
		# Process Start for title : Yogi
/*		$enc = utf8_decode($row['title']);
		$new_title = utf8_encode($enc);
		$new_title = (str_replace("?","'",$new_title));
		$value['title'] = $new_title;
*/		# Process End for title : Yogi
		
		$value['title']					= handleSpecialChar($row['title']);
		$value['short_description']		= html_entity_decode(htmlentities($row['introtext'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
		$value['description']			= html_entity_decode(htmlentities($row['fulltext'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
		
		$value['category']				= singleCatNameFromID($row['catid']);
		$value['is_featured_article']	= ($row['content_id'] != '')?1:0;
	
		# Image operation START **************************
		# Extract Image URL from introtext
		if($row['introtext'] != ''){
			$html = str_get_html($row['introtext']);
			$images = $html->find("img");
		}
		
		# Extract Image URL from fulltext
		if(count($images) == 0){ // No Image found in introtext then search in fulltext
			if($row['fulltext'] != ''){
				$html = str_get_html($row['fulltext']);
				$images = $html->find("img");
			}
		}
		
		$links = array();
		if(count($images) > 0){
			foreach($images as $image){
				$links[] = $image->src;
			}
		}
		
		$value['image_url'] = (count($links) > 0)?$links[0]:'';
		# Image operations END	************************
		
		
	# Assigning Array values to $data array variable
		$data[] = $value;		
	}
	
	# Coding for Next URL
	$nextUrlOffset = $offset + $limit + 1;
	$nextPageURL = nextPageURL($limit,$num_records,$nextUrlOffset);
	    
	$response = array(
	'data' => isset($data)?$data:null,
	//'ad' => isset($banner_code)?$banner_code:null,
	'meta' => array(
		'total' => $num_records,
		'limit' => $limit != 0?(int)$limit:(int)$num_records,
		'offset' => $offset != 0?(int)$offset:(int)0,
		# Added below for Next page url
	    //'nexturl'	=> "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?offset=$nextUrlOffset&limit=$limit"
	    'nexturl'	=> $nextPageURL
	)
	);
	header('Content-type: application/json');
	$jsonData = json_encode($response);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;

}else{
	/*------------------------------------*/
	/* 

	CASE: 2
	Result		: Listing of All Articles
	Parameter	: N/A
	API Request	: /content/
	*/
	$select_query	= " SELECT jc.*, jcf.ordering
						FROM `jos_content` jc,
							`jos_categories` jcs,
							`jos_content_frontpage` jcf
						WHERE jc.id = jcf.content_id
							AND (jcs.id = jc.catid || jc.catid = 0)
							AND jc.state = 1
							AND (jc.publish_down > '$today'
								OR jc.publish_down = '0000-00-00 00:00:00')
							AND (jc.publish_up <= '$todaydate'
								OR jc.publish_up = '0000-00-00 00:00:00')
						GROUP BY jc.id ";
						
						if(isset($order) && $order == 1)
							$select_query.= "ORDER BY jcf.ordering";
						else
							$select_query.= "ORDER BY jc.id DESC";
	
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
		
		# Process Start for title : Yogi
/*		$enc = utf8_decode($row['title']);
		$new_title = utf8_encode($enc);
		$new_title = (str_replace("?","'",$new_title));
		$value['title'] = $new_title;
*/		# Process End for title : Yogi
		
		$value['title']					= handleSpecialChar($row['title']);
		$value['short_description']		= html_entity_decode(htmlentities($row['introtext'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
		$value['description']			= html_entity_decode(htmlentities($row['fulltext'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
		
		$value['category']				= singleCatNameFromID($row['catid']);
		$value['is_featured_article']	= 1;
	
		# Image operation START **************************
		# Extract Image URL from introtext
		if($row['introtext'] != ''){
			$html = str_get_html($row['introtext']);
			$images = $html->find("img");
		}
		
		# Extract Image URL from fulltext
		if(count($images) == 0){ // No Image found in introtext then search in fulltext
			if($row['fulltext'] != ''){
				$html = str_get_html($row['fulltext']);
				$images = $html->find("img");
			}
		}
		
		$links = array();
		if(count($images) > 0){
			foreach($images as $image){
				$links[] = $image->src;
			}
		}
		
		$value['image_url'] = (count($links) > 0)?$links[0]:'';
		# Image operations END	************************
		
	# Assigning Array values to $data array variable
		$data[] = $value;		
	}
	# Coding for Next URL
	$nextUrlOffset = $offset + $limit + 1;
	$nextPageURL = nextPageURL($limit,$num_records,$nextUrlOffset);
	
	$response = array(
	'data' => isset($data)?$data:null,
	//'ad' => isset($banner_code)?$banner_code:null,
	'meta' => array(
		'total' => $num_records,
		'limit' => $limit != 0?(int)$limit:(int)$num_records,
		'offset' => $offset != 0?(int)$offset:(int)0,
	    'nexturl'	=> $nextPageURL		
	)
	);
	header('Content-type: application/json');
	$jsonData = json_encode($response);
	//$jsonData = (str_replace("\u0080","\u20AC",$jsonData));
	echo $jsonData;
	
}

?>
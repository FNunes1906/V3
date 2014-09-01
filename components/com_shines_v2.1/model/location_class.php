<?php

# Class for all location related queries and operation
class location {
	
	var $ajax_ser_query;
	var $ajax_query1;
	var $ajax_query2;
	var $cat_title;
	// Fetch location detail data
	function fetch_detail_data($did) {
		$query = "select * from jos_jev_locations where loc_id=".$did;
		mysql_set_charset("UTF8");
		$rec = mysql_query($query) or die(mysql_error());
		return $rec;
	}
	
	function fetch_location_categories($cat_id){
		$res = mysql_query("SELECT c . * , pc.title AS parenttitle FROM jos_categories AS c LEFT JOIN jos_categories AS pc ON c.parent_id = pc.id LEFT JOIN jos_categories AS mc ON pc.parent_id = mc.id LEFT JOIN jos_categories AS gpc ON mc.parent_id = gpc.id WHERE c.section = 'com_jevlocations2' AND (c.id =".$cat_id." OR pc.id =".$cat_id." OR mc.id =".$cat_id." OR gpc.id =".$cat_id.") AND c.published=1 ORDER BY c.title ASC") or die(mysql_error());
		return $res;
	}
	
	function fetch_feature_location($categories){
		//$query_location = "SELECT loc.loc_id, loc.title, loc.alias, loc.image, loc.description, loc.created, cate.title as category, cate.id as cateid, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND loc.published = 1 AND loc.loc_id = cf.target_id AND cf.value = 1 AND loc.loccat IN (".$modifycat.") ORDER BY cateid ASC";
		
		$query_location = 'SELECT loc.loc_id, loc.title, loc.alias, loc.image, loc.description,loc.catid_list,loc.created, cf.value FROM  jos_jev_locations as loc, jos_jev_customfields3 as cf WHERE (';
		if (is_array($categories))
		{
			for($p = 0; $p < count($categories) ; $p++)
			{	
				$query_location .= '  FIND_IN_SET('.$categories[$p].',loc.catid_list )';
				if($p < count($categories)-1 ){
					$query_location .=' or';
				}else{
					$query_location .=' )';
				}
			}
		}else{
			$query_location .= '  FIND_IN_SET('.$categories.',loc.catid_list ))';
		}
		$query_location .= ' AND loc.loc_id = cf.target_id AND cf.value = 1 AND loc.published = 1 ORDER BY loc.created DESC';

		$featured_loc=mysql_query($query_location) or die(mysql_error());;
		mysql_set_charset("UTF8");
		return $featured_loc;
	}
	
	function fetch_banner_category($category_id){
		$loc_cat = mysql_query("select title from jos_categories where id=".$category_id);
		return $loc_cat;
	}
	
	function fetch_page_title($category_id){
		$cat_query=mysql_query("select title from jos_categories where id=".$category_id." AND section='com_jevlocations2' and published=1 order by `ordering`");
		$cat_title = mysql_fetch_array($cat_query);

		$pagemeta_res = mysql_query("select title from `jos_pagemeta`where uri='/$cat_title[title]'");
		$pagemeta =mysql_fetch_array($pagemeta_res);
		$this->cat_title = $cat_title;
		return $pagemeta;
	}
	
	function fetch_for_pagination($default_values){
		$lat1 		 		 = $default_values['lat1'];
		$lon1				 = $default_values['lon1'];
		$allCatIds 			 = $default_values['allCatIds'];
		$filter_loccat 		 = $default_values['filter_loccat'];
		
		$query1 = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ";

		if(($filter_order != "") || (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat']=='alp'))
			$query1 .= " ORDER BY title ASC ";
		else
			$query1 .= " ORDER BY dist ASC";
			
		$rec1 = mysql_query($query1) or die(mysql_error());
		return $rec1;
	}
	
	function fetchlocationRecord($default_values) {
		
		$lat1 		 		 = $default_values['lat1'];
		$lon1				 = $default_values['lon1'];
		if($default_values['filter_loccat'] != 0 && $_REQUEST['filter_loccat'] != 'alp'){
			$allCatIds 		 = $default_values['filter_loccat'];
		}else { 
			$allCatIds 		= $default_values['allCatIds'];
		}
		$subquery 			 = $default_values['subquery'];
		$start_at 			 = $default_values['start_at'];
		$entries_per_page 	 = $default_values['entries_per_page'];
		
		//$query  = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".$subquery;
		
		$query  = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations WHERE (";
		if (is_array($allCatIds))
		{
			for($p = 0; $p < count($allCatIds) ; $p++)
			{	
				$query .= "  FIND_IN_SET(".$allCatIds[$p].",catid_list )";
				if($p < count($allCatIds)-1 ){
					$query .=" or";
				}else{
					$query .=" )";
				}
			}
		}else{
			$query .= "  FIND_IN_SET(".$allCatIds.",catid_list ))";
		}
		$query .= " AND published=1 ";
		
		$query1 = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180))";
		$query2 = "cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations WHERE (";
		if (is_array($allCatIds))
		{
			for($q = 0; $q < count($allCatIds) ; $q++)
			{	
				$query2 .= "  FIND_IN_SET(".$allCatIds[$q].",catid_list )";
				if($q < count($allCatIds)-1 ){
					$query2 .=" or";
				}else{
					$query2 .=" )";
				}
			}
		}else{
			$query2 .= "  FIND_IN_SET(".$allCatIds.",catid_list ))";
		}
		$query2 .= " AND published=1 ";
		
		if(($filter_order != "") || ($_REQUEST['filter_loccat'] == 'alp')){
			$query  .= " ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
			$query2 .= " ORDER BY title ASC LIMIT ";
		}else{
			$query  .= " ORDER BY dist ASC LIMIT " .$start_at.','.$entries_per_page;
			$query2 .= " ORDER BY dist ASC LIMIT ";
		}
		//echo $query;
		$res = mysql_query($query) or die(mysql_error());
		$this->ajax_query1 = $query1;
		$this->ajax_query2 = $query2;
		return $res;
	}
	
	function fetchSearchRecord($search_array){
		//$filter_loccat 		 = $search_array['filter_loccat'];
		$_POST['search_rcd'] = $search_array['search_rcd'];
		if($search_array['filter_loccat'] != 0 && $search_array['filter_loccat'] != 'alp'){
			$allCatIds 		 = $search_array['filter_loccat'];
		}else { 
			$allCatIds 		= $search_array['allCatIds'];
		}
		//$allCatIds 			 = $search_array['allCatIds'];
		$searchdata 		 = $search_array['searchdata'];
		$start_at 			 = $search_array['start_at'];
		$entries_per_page 	 = $search_array['entries_per_page'];
		
		$search_query1 = "select * from `jos_jev_locations` where ("; 
		if (is_array($allCatIds))
		{
			for($r = 0; $r < count($allCatIds) ; $r++)
			{	
				$search_query1 .= "  FIND_IN_SET(".$allCatIds[$r].",catid_list )";
				if($r < count($allCatIds)-1 ){
					$search_query1 .=" or";
				}else{
					$search_query1 .=" )";
				}
			}
		}else{
			$search_query1 .= "  FIND_IN_SET(".$allCatIds.",catid_list ))";
		}
		$search_query1 .= " AND (title like '%".$searchdata."%') AND published=1  ORDER BY title ASC LIMIT ".$start_at.','.$entries_per_page;

		$ajaxquery1 = "select * from `jos_jev_locations` where (";
		if (is_array($allCatIds))
		{
			for($s = 0; $s < count($allCatIds) ; $s++)
			{	
				$ajaxquery1 .= "  FIND_IN_SET(".$allCatIds[$s].",catid_list )";
				if($s < count($allCatIds)-1 ){
					$ajaxquery1 .=" or";
				}else{
					$ajaxquery1 .=" )";
				}
			}
		}else{
			$ajaxquery1 .= "  FIND_IN_SET(".$allCatIds.",catid_list ))";
		}
		$ajaxquery1 .= " AND (title like '%25".$searchdata."%25') AND published=1  ORDER BY title ASC LIMIT ";
		//echo $search_query1;
		$searchResult = mysql_query($search_query1) or die(mysql_error());
		$this->ajax_ser_query = $ajaxquery1;
		return $searchResult;
	}
	
	
}	
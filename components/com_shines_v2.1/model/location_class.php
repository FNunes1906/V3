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
	
	function fetch_feature_location($modifycat){
		$query_location = "SELECT loc.loc_id, loc.title, loc.alias, loc.image, loc.description, loc.created, cate.title as category, cate.id as cateid, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND loc.published = 1 AND loc.loc_id = cf.target_id AND cf.value = 1 AND loc.loccat IN (".$modifycat.") ORDER BY cateid ASC";

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
		$allCatIds 			 = $default_values['allCatIds'];
		$subquery 			 = $default_values['subquery'];
		$filter_loccat 		 = $default_values['filter_loccat'];
		$start_at 			 = $default_values['start_at'];
		$entries_per_page 	 = $default_values['entries_per_page'];
		
		$query  = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".$subquery;
		$query1 = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180))";
		$query2 = "cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".$subquery;
		
		if($filter_loccat == 'Featured'){
			$query  .= " AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ";
			$query2 .= " AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ";
		}elseif($filter_loccat != 0 && $_REQUEST['filter_loccat'] != 'alp'){
			$query  .= " AND loccat = $filter_loccat ";
			$query2 .= " AND loccat = $filter_loccat ";
		}
		if(($filter_order != "") || ($_REQUEST['filter_loccat'] == 'alp')){
			$query  .= " ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
			$query2 .= " ORDER BY title ASC LIMIT ";
		}else{
			$query  .= " ORDER BY dist ASC LIMIT " .$start_at.','.$entries_per_page;
			$query2 .= " ORDER BY dist ASC LIMIT ";
		}
			
		$res = mysql_query($query) or die(mysql_error());
		$this->ajax_query1 = $query1;
		$this->ajax_query2 = $query2;
		return $res;
	}
	
	function fetchSearchRecord($search_array){
		$filter_loccat 		 = $search_array['filter_loccat'];
		$_POST['search_rcd'] = $search_array['search_rcd'];
		$allCatIds 			 = $search_array['allCatIds'];
		$searchdata 		 = $search_array['searchdata'];
		$start_at 			 = $search_array['start_at'];
		$entries_per_page 	 = $search_array['entries_per_page'];
		
		if((isset($filter_loccat)==0) || ($_REQUEST['filter_loccat']=='alp') && ($_POST['search_rcd']==JText::_('SEARCH'))){
				$search_query1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT ".$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT ";
			}elseif($filter_loccat == 'Featured' && $_POST['search_rcd'] == JText::_('SEARCH') ){
				$search_query1 = "select * from `jos_jev_locations` $customfields3_table where loccat IN (".implode(',',$allCatIds).") AND published=1 and (title like '%$searchdata%'  or description like '%$searchdata%')  AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` $customfields3_table where loccat IN (".implode(',',$allCatIds).") AND published=1 and (title like '%$searchdata%'  or description like '%$searchdata%')  AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ORDER BY title ASC LIMIT ";
			}else if($_POST['search_rcd'] == JText::_('SEARCH') && $filter_loccat!=0){
				$search_query1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND loccat=$filter_loccat and published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND loccat=$filter_loccat and published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT ";
			}elseif($_POST['search_rcd'] == JText::_('SEARCH')){
				$search_query1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") and published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") and published=1 and (title like '%$searchdata%'  or description like '%$searchdata%') ORDER BY title ASC LIMIT ";
			}
			$searchResult = mysql_query($search_query1) or die(mysql_error());
			$this->ajax_ser_query = $ajaxquery1;
			return $searchResult;
	}
	
	
}	
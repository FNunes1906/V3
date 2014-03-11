<?php

# Class for all blog relatedt queries and operation
class blog {

	// Fetch blog data from the content table
	function fetch_blog_data($todaydate, $today,$start_at,$end_at,$cat_id) {
		$sql = "select jc.* from `jos_content` jc, `jos_categories` jcs where jcs.id = jc.catid and jc.state=1 and (jc.publish_down>'".$today."' or jc.publish_down='0000-00-00 00:00:00') and (jc.publish_up <= '".$todaydate."' or jc.publish_up='0000-00-00 00:00:00') ";
		if($cat_id==''){
			$sql.="and jcs.title='blog'";
		}else{
			$sql.="and jcs.id=".$cat_id;
		}
		$sql.=" order by jc.ordering LIMIT " .$start_at.",".$end_at;
		$param = mysql_query($sql);
		return $param;
	}

	// Fetch blog data from the content table
	function fetch_pagemeta_title() {
		$pagemeta_res	= mysql_query("select title from `jos_pagemeta`where uri='/blog'");
		$pagemeta		= mysql_fetch_array($pagemeta_res);
		return $pagemeta;
	}
	
	// Fetch blog data from the content table
	function fetch_blog_detail_data($id) {
		$sql = mysql_query("select jc.* from `jos_content` jc where id=".$id." and jc.state=1");
		$article_res = mysql_fetch_array($sql);
		return $article_res;
	}
	
	function fetch_banner_category($cat_id){
		$loc_cat = mysql_query("select title from jos_categories where id=".$cat_id);
		return $loc_cat;
	}
	
}	
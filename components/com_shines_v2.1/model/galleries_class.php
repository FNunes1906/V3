<?php
class  photosdata{
	
	function fetchCatData(){
	 	$query = "select * from jos_phocagallery_categories where id<>2 and published=1 and approved=1 order by ordering";
		mysql_set_charset("UTF8");
		$rec=mysql_query($query) or die(mysql_error());
		
		$param = array();
		while($r=mysql_fetch_assoc($rec)) {
			$param[] = $r;
		}
			
		 foreach($param as $k => $v) {
			$query1 = "select id, filename from `jos_phocagallery` where `published` = 1 and `approved` = 1 and `catid` = ".$v['id'] ." ORDER BY ordering"; 
			$rec1=mysql_query($query1) or die(mysql_error());

			$v['photos'] = array();
			while($r1=mysql_fetch_assoc($rec1)) {
				$v['photos'][] = $r1;
			}
			
			$id = rand(0, (count($v['photos']) - 1));
			if(isset($v['photos'][$id]['filename'])){
				
				$tmp_arr = explode('/', $v['photos'][$id]['filename']);
				$userfolder = '';
				$filename = $v['photos'][$id]['filename'];
				if(count($tmp_arr) > 1) {
					$userfolder = $tmp_arr[0].'/';
					$filename = $tmp_arr[1];
				}
				unset($tmp_arr);
				if(trim($userfolder) == '' && trim($filename) == '')
					$param[$k]['avatar'] = '';
				else
					$param[$k]['avatar'] = '/partner/'.$_SESSION['partner_folder_name'].'/images/phocagallery/'.$userfolder.'thumbs/phoca_thumb_s_'.$filename;
			}
		}
	return $param;
	}

	function title($urlpara){
		$query			= "select title from `jos_pagemeta`where uri='".addslashes($urlpara)."'";
		$pagemeta_res	= mysql_query($query) or die(mysql_error());
		$pagemeta		= mysql_fetch_array($pagemeta_res);
		return $pagemeta;
	}
	
	function photos($CatId,$start){
		if($CatId>0){
			$select_query = "select jpc.title as cattitle,jp.* from jos_phocagallery as jp,jos_phocagallery_categories as jpc where jp.catid={$CatId} and jpc.id={$CatId} and jp.published=1 and jp.approved=1 order by jp.id desc";
		}else{
			$select_query = "select * from jos_phocagallery where catid<>2 and published=1 and approved=1 order by id desc";
		}
		return $select_query;
	}
	
	function photos_view($CatId){
		if($CatId>0){
			$select_query = "select * from jos_phocagallery where  catid={$CatId} and published=1 and approved=1 order by id desc";
		}else{
			$select_query = "select * from jos_phocagallery where catid<>2 and published=1 and approved=1 order by id desc";
		}
		return $select_query;
	}
	
	function fetchVideo(){
		
		$select_query = "select * from jos_phocagallery where catid=2 AND published = 1 order by id desc";
		$rec=mysql_query($select_query) or die(mysql_error());
		return $rec;
	}
	
}
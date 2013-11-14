<?php

//ini_set('error_reporting',1);
//ini_set('display_errors',1);
include("iadbanner.php");
include("connection.php");


$query = "select * from jos_phocagallery_categories where id<>2 and published=1 and approved=1 order by id desc";

$rec=mysql_query($query) or die(mysql_error());

//*********************************************


  //$param = db_fetch("select * from `jos_phocagallery_categories` where id != 2 and `published` = 1 and `approved` = 1 order by ordering asc", true, true);
  
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
	

/* code start by rinkal for page title */
$pagemeta_res = mysql_query("select title from `jos_pagemeta`where uri='/photos'");
$pagemeta =mysql_fetch_array($pagemeta_res);
/* code end by rinkal for page title */


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="index,follow" name="robots" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="pics/homescreen.gif" rel="apple-touch-icon" />
<!--<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />-->
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
<script src="javascript/functions.js" type="text/javascript"></script>

<title>
<?php
	/* code start by rinkal for page title */
	if ($_SESSION['tpl_folder_name'] == 'defaultspanish' || $_SESSION['tpl_folder_name'] == 'defaultportuguese'){
		$t = 'Fotos';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
		$t = "Foto's";
	}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
		$t = 'Fotografije';
	}elseif($_SESSION['tpl_folder_name'] == 'default'){
		$t = 'Photos';
	}
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { 
		$title = $site_name.' ~ '.$t;
		if($pagemeta['title']!='')
		{
			$title.= ' ~ '.$pagemeta['title'];
		}
		echo $title;
	}
	else{
		$title = $site_name.' : '.$t;
		if($pagemeta['title']!='')
		{
			$title .= ' : '.$pagemeta['title'];
		}
		echo $title;
	}
	/* code end by rinkal for page title */
?>
</title>

<!--<link href="pics/startup.png" rel="apple-touch-startup-image" /> -->
<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>


<!-- New styles add by Doug Schaffer to be moved to CSS file -->

<style type="text/css">
  #placesList img { width:100px;height:83px; }
</style>

</head>

<body>
<?php

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == true) { ?>
	<div class="iphoneads" style="vertical-align:bottom;">
	<?php m_show_banner('android-photos-screen'); ?>
  </div>
  <?php } 
  else {
  ?>
  <div class="iphoneads" style=" vertical-align:top">
    <?php m_show_banner('iphone-photos-screen'); ?>
  </div>
  <?php } ?>
  


<?php
	/* Code added for iphone_galleries.tpl */
	require($_SERVER['DOCUMENT_ROOT']."/partner/".$_SESSION['tpl_folder_name']."/tpl_v2.1/iphone_galleries.tpl");
	?>
</body>

</html>

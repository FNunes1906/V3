<?php

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

include("connection.php");
include("iadbanner.php");

# Include location class file
include("model/location_class.php");
$objloclist = new location();

function showBrief($str, $length) {
	$str = strip_tags($str);
	$str = explode(" ", $str);
	return implode(" " , array_slice($str, 0, $length));
}

function stripJunk($string) { 
	$cleanedString = preg_replace("/[^A-Za-z0-9\s\.\-\/+\!;\n\t\r\(\)\'\"._\?>,~\*<}{\[\]\=\&\@\#\$\%\^` ]:/","", $string); 
	$cleanedString = preg_replace("/\s+/"," ",$cleanedString); 
	return $cleanedString; 
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if($unit == "KM") {
		return ($miles * 1.609344); 
		}else if($unit == "N"){
		return ($miles * 0.8684);
		}else{
		return $miles;
	}
}

if (isset($_REQUEST['lat']) && $_REQUEST['lat']!="")
	$lat1=$_REQUEST['lat'];
else
	$lat1='0';

if (isset($_REQUEST['lon']) && $_REQUEST['lon']!="")
	$lon1=$_REQUEST['lon'];
else
	$lon1='0';

if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat'] != '0')
	 $filter_loccat=$_REQUEST['filter_loccat'];

if(isset($filter_loccat) && $filter_loccat == 'Featured')
	$customfields3_table = ", `jos_jev_customfields3` ";
else
	$customfields3_table = "";

if (isset($_REQUEST['start']))
	$ii=$_REQUEST['start'];
else
	$ii=0;
	
if(isset($_REQUEST['filter_order']) && $_REQUEST['filter_order']!="")
	$filter_order = $_REQUEST['filter_order'];
else	
	$filter_order = "";
	
if(isset($_REQUEST['filter_order_Dir']) && $_REQUEST['filter_order_Dir']!="")
	$filter_order_Dir = $_REQUEST['filter_order_Dir'];
else	
	$filter_order_Dir = "ASC";

//fetching category id and calling class file

if(isset($_REQUEST['category_id']))
{
	$category_id = $_REQUEST['category_id'];
}
/* fetching all subcategory and creating associate array */
global $cat_assoc,$allCatIds;
$res = $objloclist->fetch_location_categories($category_id);
while($idsrow=mysql_fetch_assoc($res)){
		$cat_assoc[$idsrow['id']] = $idsrow['title'];
}
// create key for category
$allCatIds = array_keys($cat_assoc);
/* echo "<pre>";
print_r($cat_assoc);
echo "</pre>"; */
$path= $_SERVER['PHP_SELF'] . "?category_id=".$category_id."&option=com_jevlocations&task=locations.listlocations&tmpl=component&needdistance=1&sortdistance=1&lat=".$lat1."&lon=".$lon1."&bIPhone=". $_REQUEST['bIPhone']."&iphoneapp=1&search=". $_REQUEST['search']."&limit=0&jlpriority_fv=0&filter_loccat=".$filter_loccat."&filter_order=".$filter_order."&filter_order_Dir=".$filter_order_Dir;

		$default_values = array(
			"lat1" => $lat1,
			"lon1" => $lon1,
			"allCatIds" => $allCatIds,
			"subquery" => $subquery,
			"filter_loccat" =>$filter_loccat
			);
		// count number of data for pagination
		$rec1 = $objloclist->fetch_for_pagination($default_values);
		mysql_set_charset("UTF8");
		$total_data			= mysql_num_rows($rec1);
		$total_rows			= $total_data;
		$page_limit			= 20;
		$entries_per_page	= $page_limit;
		$current_page		= (empty($_REQUEST['page']))? 1:$_REQUEST['page'];
		$start_at			= ($current_page * $entries_per_page)-$entries_per_page;
		$link_to			= $path;

/* CODE ADDED BY AKASH FOR SLIDER */

	//If retrived data is array then
	/* if(count($allCatIds) > 1){
		$modifycat =	implode(',',$allCatIds);
	}else{
		$modifycat = $allCatIds[0];
	} */
	$featured_loc = $objloclist->fetch_feature_location($allCatIds);

/*CODE END AKASH FOR SLIDER*/

/* code start by rinkal for page title */
$pagemeta = $objloclist->fetch_page_title($category_id);
$cat_title = $objloclist->cat_title;
/* code end by rinkal for page title */

header( 'Content-Type:text/html;charset=utf-8');

//bhavan: need to tell ios8.3 not to cache the page
//header('Expires: Thu, 19 Nov 1981 08:52:00 GMT', true);
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//header ('Pragma: no-cache');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Conditional comment for mobile ie7 blogs.msdn.com/b/iemobile/ -->
<!--[if IEMobile 7 ]>    <html class="no-js iem7" lang="en"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--Meta Tag-->
	<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="index,follow" name="robots" />
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<title>
	<?php
		/* code start by rinkal for page title */
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == True) { 
			$title = $site_name.' ~ '.$cat_title['title'];
			if($pagemeta['title']!='')
			{
				$title.= ' ~ '.$pagemeta['title'];
			}
			echo $title;
		}
		else{
			$title = $site_name.' : '.$cat_title['title'];
			if($pagemeta['title']!='')
			{
				$title.= ' : '.$pagemeta['title'];
			}
			echo $title;
		}
		/* code end by rinkal for page title */
	?>
	</title>

	<!--Css and image file-->
	<link href="pics/homescreen.gif" rel="apple-touch-icon" />
	<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
	<link rel="shortcut icon" href="images/l/apple-touch-icon.png">
	<link href="pics/startup.png" rel="apple-touch-startup-image" />

	<!--Javascript and jqery code-->
	<script type="text/javascript">
		var iWebkit;if(!iWebkit){iWebkit=window.onload=function(){function fullscreen(){var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++){if(a[i].className.match("noeffect")){}else{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}}}function hideURLbar(){window.scrollTo(0,0.9)}iWebkit.init=function(){fullscreen();hideURLbar()};iWebkit.init()}}
	</script>

	<script type="text/javascript">
		function linkClicked(link) { document.location = link; }
		ddsmoothmenu.init({
			mainmenuid: "smoothmenu1", //menu DIV id
			orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu', //class added to menu's outer DIV
			//customtheme: ["#1c5a80", "#18374a"],
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
			})
		ddsmoothmenu.init({
			mainmenuid: "smoothmenu2", //Menu DIV id
			orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
			//customtheme: ["#804000", "#482400"],
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
			})
			function redirecturl(val)
		{
			
			url="<?php echo $_SERVER['PHP_SELF']; ?>?category_id=<?php echo $category_id?>&option=com_jevlocations&task=locations.listlocations&tmpl=component&needdistance=1&sortdistance=1&lat=<?php echo $_REQUEST['lat']?>&lon=<?php echo $_REQUEST['lon']?>&bIPhone=<?php echo isset($_REQUEST['bIPhone'])?>&iphoneapp=1&search=<?php echo $_REQUEST['search']?>&limit=0&jlpriority_fv=0&filter_loccat="+val + "&filter_order=<?php echo $filter_order?>&filter_order_Dir=<?php echo $filter_order_Dir?>";
	window.location=url;
		}

		function divopen(str) {
			if(document.getElementById(str).style.display=="none") {
				document.getElementById(str).style.display="block";
				} else {
				document.getElementById(str).style.display="none";
			}
		}
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="javascript/libs/jquery-1.7.1.min.js"><\/script>')</script>

	<!-- scripts for sliders -->
	<script type="text/javascript" src="javascript/sliders.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider({
			  animation: "slide",
			  directionNav: false,
			  controlsContainer: ".flexslider-container"
		  });
		});
	</script>
	<script>
		$(document).ready( function() {
			$("#searchIcon").click(function () {
				$("#searchForm").slideToggle("slow");
			});
		});
	</script>
	<script src="javascript/helper.js"></script>
		
	<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
</head>

	<body>
		<?php
		
		# Code added for iphone_generic_locations_loder.tpls
		require($_SERVER['DOCUMENT_ROOT']."/partner/".$_SESSION['tpl_folder_name']."/tpl_v2.1/iphone_generic_locations_loder.tpl");
		?>
	</body>
</html>
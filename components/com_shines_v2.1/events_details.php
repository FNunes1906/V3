<?php
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler");
else ob_start();
session_start();

include("connection.php");
header( 'Content-Type:text/html;charset=utf-8');
include("iadbanner.php");

# Include event detail class file
include("model/events_class.php");
$objevdetail = new event();

/* code added by rinkal for date format in all language */
$lang =& JFactory::getLanguage();
$lan = $lang->getName();

function distance($lat1, $lon1, $lat2, $lon2, $unit){
	$theta = $lon1 - $lon2;
	$dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist  = acos($dist);
	$dist  = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit  = strtoupper($unit);

	if($unit == "KM"){
		return ($miles * 1.609344);
	}elseif($unit == "N"){
		return ($miles * 0.8684);
	}else{
		return $miles;
	}
}

$eid = $_REQUEST['eid'];

if(isset($_REQUEST['lat']) && $_REQUEST['lat'] != "" ){
	$_SESSION['lat_device1'] = $_REQUEST['lat'];
	$lat1 = $_SESSION['lat_device1'];
}

if(isset($_REQUEST['lon']) && $_REQUEST['lon'] != "" ){
	$_SESSION['lon_device1'] = $_REQUEST['lon'];
	$lon1 = $_SESSION['lon_device1'];
}

if($_REQUEST['d'] == "")	$today = date('d');
else	$today = $_REQUEST['d'];

if($_REQUEST['m'] == "")	$tomonth = date('m');
else	$tomonth = $_REQUEST['m'];

if($_REQUEST['Y'] == "")	$toyear = date('Y');
else	$toyear      = $_REQUEST['Y'];

$todaestring = date('D, M j', mktime(0, 0, 0, $tomonth, $today, $toyear));
$rec         = $objevdetail->fetch_eventdetail_time($eid);

/* code start by rinkal for page title */
$title = $objevdetail->fetch_eventdetail_time($eid);
/* code end by rinkal for page title */

$catId = $_REQUEST['catId'];

$param_res = "SELECT `parent`,`id`,`params`,`alias` FROM `jos_menu` WHERE `link`='index.php?option=com_jevents&view=week&task=week.listevents' and parent='0' AND published = '1'";
	$menu_param=mysql_query($param_res);
	
	while($menu_ids = mysql_fetch_array($menu_param)){
		$iParams = new JParameter($menu_ids[2]);
		$categories = $iParams->get('catid0');
		$sub_res = "SELECT `id` FROM `jos_categories` WHERE (parent_id='".$categories."' or id='".$categories."') AND published = '1'";
		$sub_menu_id = mysql_query($sub_res);
		while($sub_cat_ids = mysql_fetch_array($sub_menu_id)){ 
			//echo "<pre>";
			//print_r($sub_cat_ids);
			if($sub_cat_ids[0] == $catId){
				$cat_name = $menu_ids[3];
			}
		}
		
	}
header('Content-Type:text/html;charset=utf-8');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="image_src" href="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png" />
		<meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png"/>
		<meta property="og:title" content="<?php echo $site_name.' | Event';?>"/>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="index,follow" name="robots" />
		<link href="pics/homescreen.gif" rel="apple-touch-icon" />
		<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
		
<script type="text/javascript" src="javascript/jquery-1.10.2.min.js"></script>

<script type="text/javascript">
$(document).ready(

	function() {
		
		var pageTitle = document.title;
		var pageUrl = location.href; 
		
		$("#myshare").click(function() {
		  $("ul.share-inner-wrp").fadeToggle();
		 $("ul.share-inner-wrp").delay(3500).fadeOut("slow");
		});
		
    });
</script>
		
		<script language="javascript">
			function linkClicked(link){
				document.location = link;
			}
		</script>
		<!-- AddThisEvent Settings -->
		<script src="javascript/libs/ical.js"></script>

		<?php
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == True){
			?>
			<script type="text/javascript">
				addthisevent.settings({
						mouse	: false,
						css		: false,
						outlook:{show:false, text:"Outlook"},
						google	:{show:true,  text:"Add to cal"},
						yahoo:{show:false, text:"Yahoo"},
						ical	:{show:false, text:"Add to cal"},
						hotmail:{show:false, text:"Hotmail"}
					});
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				addthisevent.settings({
						mouse	: false,
						css	: false,
						outlook:{show:false, text:"Outlook"},
						google	:{show:false, text:"Add to Gcal"},
						yahoo:{show:false, text:"Yahoo"},
						ical	:{show:true,  text:"Add to cal"},
						hotmail:{show:false, text:"Hotmail"}
					});
			</script>
			<?php
		} ?>
		
		<title>
			<?php
			/* code start by rinkal for page title */
			$page_title = JText::_('EVENT_DETAIL');

			while($row = mysql_fetch_array($title)){
				$ev_title = $objevdetail->fetch_event_title($row['eventdetail_id']);
				$ua       = strtolower($_SERVER['HTTP_USER_AGENT']);
				if(stripos($ua,'android') == True){
					echo $site_name.' ~ '.$page_title.' ~ '.$ev_title['summary'];
				}else{
					echo $site_name.' : '.$page_title.' : '.$ev_title['summary'];
				}
			}
			?>
		</title>
		
		
		<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
		<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
		<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
	</head>

	<body>
		<?php
			if($lan == "Español"){
				setlocale(LC_TIME,"spanish");
				$todaestring = iconv('ISO-8859-2','UTF-8',ucwords(strftime('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));
			}else if($lan == "Croatian(HR)"){
				setlocale(LC_TIME,"croatian");
				$todaestring = $today.'/'.$tomonth;
			}else if($lan == "Nederlands - nl-NL"){
				setlocale(LC_TIME,"dutch");
				$todaestring=ucwords(strftime('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear)));
			}else if($lan == "Português (Brasil)"){
				setlocale(LC_TIME,"portuguese");
				$todaestring = iconv('ISO-8859-2','UTF-8',ucwords(strftime('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));
			}else if($lan == "French (Fr)"){
				 setlocale(LC_TIME,"french");
				 $todaestring = iconv('ISO-8859-2','UTF-8',ucwords(strftime('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));
			}
		
		/* Code added for iphone_places.tpl */
		require($_SERVER['DOCUMENT_ROOT']."/partner/".$_SESSION['tpl_folder_name']."/tpl_v2.1/iphone_events_details.tpl");
		?>
	</body>
</html>
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
		
		$('.button-wrap').click(function(event) {
			var shareName = $(this).attr('class').split(' ')[0]; //get the first class name of clicked element
			
			switch (shareName) //switch to different links based on different social name
			{
				case 'facebook':
					var openLink = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
					break;
				case 'twitter':
					var openLink = 'http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl);
					break;
				case 'digg':
					var openLink = 'http://www.digg.com/submit?phase=2&amp;url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
					break;
				case 'stumbleupon':
					var openLink = 'http://www.stumbleupon.com/submit?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
					break;
				case 'delicious':
					var openLink = 'http://del.icio.us/post?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
					break;
				case 'google':
					var openLink = 'https://plus.google.com/share?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
					break;
				case 'email':
					var openLink = 'mailto:?subject=' + pageTitle + '&body=Found this useful link for you : ' + pageUrl;
					break;
			}

			//Parameters for the Popup window
			winWidth 	= 650;	
			winHeight	= 450;
			winLeft   	= ($(window).width()  - winWidth)  / 2,
			winTop    	= ($(window).height() - winHeight) / 2,	
			winOptions   = 'width='  + winWidth  + ',height=' + winHeight + ',top='    + winTop    + ',left='   + winLeft;

			//open Popup window and redirect user to share website.
			window.open(openLink,'Share This Link',winOptions);
			return false;
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
				addthisevent.settings(
					{
						mouse	: false,
						css		: false,
						outlook	:
						{
							show:false, text:"Outlook"
						},
						google	:
						{
							show:true,  text:"<?php echo JText::_('TW_ADDTO'); ?>"
						},
						yahoo	:
						{
							show:false, text:"Yahoo"
						},
						ical	:
						{
							show:false, text:"<?php echo JText::_('TW_ADDTO'); ?>"
							
						},
						hotmail	:
						{
							show:false, text:"Hotmail"
						}
					});
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				addthisevent.settings(
					{
						mouse	: false,
						css		: false,
						outlook	:
						{
							show:false, text:"Outlook"
						},
						google	:
						{
							show:false, text:"Add to Gcal"
						},
						yahoo	:
						{
							show:false, text:"Yahoo"
						},
						ical	:
						{
							show:true,  text:"<?php echo JText::_('TW_ADDTO'); ?>"
						},
						hotmail	:
						{
							show:false, text:"Hotmail"
						}
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
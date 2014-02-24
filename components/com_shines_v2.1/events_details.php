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
		<script type="text/javascript">
			// TOUCH-EVENTS SINGLE-FINGER SWIPE-SENSING JAVASCRIPT
			// this script can be used with one or more page elements to perform actions based on them being swiped with a single finger
			var triggerElementID = null; // this variable is used to identity the triggering element
			var fingerCount = 0;
			var startX = 0;
			var startY = 0;
			var curX = 0;
			var curY = 0;
			var deltaX = 0;
			var deltaY = 0;
			var horzDiff = 0;
			var vertDiff = 0;
			var minLength = 72; // the shortest distance the user may swipe
			var swipeLength = 0;
			var swipeAngle = null;
			var swipeDirection = null;
			// The 4 Touch Event Handlers
			// NOTE: the touchStart handler should also receive the ID of the triggering element
			// make sure its ID is passed in the event call placed in the element declaration, like:
			// <div id="picture-frame" ontouchstart="touchStart(event,'picture-frame');"  ontouchend="touchEnd(event);" ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
			function touchStart(event,passedName){
				// disable the standard ability to select the touched object
				// event.preventDefault();
				// get the total number of fingers touching the screen
				fingerCount = event.touches.length;
				// since we're looking for a swipe (single finger) and not a gesture (multiple fingers),
				// check that only one finger was used
				if ( fingerCount == 1 ){
					// get the coordinates of the touch
					startX = event.touches[0].pageX;
					startY = event.touches[0].pageY;
					// store the triggering element ID
					triggerElementID = passedName;
				}else{
					// more than one finger touched so cancel
					touchCancel(event);
				}
			}

			function touchMove(event){
				//event.preventDefault();
				if ( event.touches.length == 1 ){
					curX = event.touches[0].pageX;
					curY = event.touches[0].pageY;
				}else{
					touchCancel(event);
				}
			}

			function touchEnd(event){
				event.preventDefault();
				// check to see if more than one finger was used and that there is an ending coordinate
				if ( fingerCount == 1 && curX != 0 ){
					// use the Distance Formula to determine the length of the swipe
					swipeLength = Math.round(Math.sqrt(Math.pow(curX - startX,2) + Math.pow(curY - startY,2)));
					// if the user swiped more than the minimum length, perform the appropriate action
					if ( swipeLength >= minLength ){
						caluculateAngle();
						determineSwipeDirection();
						processingRoutine();
						touchCancel(event); // reset the variables
					}else{
						touchCancel(event);
					}
				}else{
					touchCancel(event);
				}
			}

			function touchCancel(event){
				// reset the variables back to default values
				fingerCount = 0;
				startX = 0;
				startY = 0;
				curX = 0;
				curY = 0;
				deltaX = 0;
				deltaY = 0;
				horzDiff = 0;
				vertDiff = 0;
				swipeLength = 0;
				swipeAngle = null;
				swipeDirection = null;
				triggerElementID = null;
			}

			function caluculateAngle(){
				var X = startX-curX;
				var Y = curY-startY
				var Z = Math.round(Math.sqrt(Math.pow(X,2)+Math.pow(Y,2))); //the distance - rounded - in pixels
				var r = Math.atan2(Y,X); //angle in radians (Cartesian system)
				swipeAngle = Math.round(r*180/Math.PI); //angle in degrees
				if ( swipeAngle < 0 ){
					swipeAngle =  360 - Math.abs(swipeAngle);
				}
			}

			function determineSwipeDirection(){
				if( (swipeAngle <= 45) && (swipeAngle >= 0) ){
					swipeDirection = 'left';
				}else if ( (swipeAngle <= 360) && (swipeAngle >= 315) ){
					swipeDirection = 'left';
				}else if ( (swipeAngle >= 135) && (swipeAngle <= 225) ){
					swipeDirection = 'right';
				}else if ( (swipeAngle > 45) && (swipeAngle < 135) ){
					swipeDirection = 'down';
				}else{
					swipeDirection = 'up';
				}
			}

			function processingRoutine(){
				var swipedElement = document.getElementById(triggerElementID);
				if ( swipeDirection == 'right' ){
					// REPLACE WITH YOUR ROUTINES
					window.history.back()
				}
			}
		</script>
		
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
<?php
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){	ob_start("ob_gzhandler");
}else{ ob_start(); }

session_start();
include("connection.php");
include("iadbanner.php");

# Include event class file
include("model/events_class.php");
$objEvent = new event();

# Code to fetch Joomla Language Variable
$lang =& JFactory::getLanguage();
$lan = $lang->getName();

if($lan == "Español")					{$final_lang = "es"; 	$page_title = 'Eventos';     setlocale(LC_TIME,"spanish");}
elseif($lan == "Croatian(HR)")			{$final_lang = "cr";	$page_title = 'Događanja';   setlocale(LC_TIME,"croatian");}
elseif($lan == "Nederlands - nl-NL")	{$final_lang = "de";	$page_title = 'Evenementen'; setlocale(LC_TIME,"dutch");}
elseif($lan == "Português (Brasil)")	{$final_lang = "pt-PT";	$page_title = 'Eventos';     setlocale(LC_TIME,"portuguese");}
elseif($lan == "French (Fr)")			{$final_lang = "fr";	$page_title = 'évènements';  setlocale(LC_TIME,"French");}
else									{$final_lang = "";		$page_title = 'Events';}

// Function for distance calculation
function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	$dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if($unit == "KM")		{return ($miles * 1.609344);}
	elseif($unit == "N")	{return ($miles * 0.8684);}
	else					{return  $miles;}
}

// Display all published category from JEvents component
if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != 0){
	$catId = $_REQUEST['category_id'];
	$result_event_cat = $objEvent->select_event_categories_from_id($catId);
}else{
	$result_event_cat = $objEvent->select_event_categories();
} 

// Assigning latitude value
if(isset($_REQUEST['lat']) && $_REQUEST['lat'] != "" ){
	$_SESSION['lat_device1'] = $_REQUEST['lat'];
	$lat1					 = $_SESSION['lat_device1'];
}
// Assigning longitude value
if(isset($_REQUEST['lon']) && $_REQUEST['lon'] != "" ){
	$_SESSION['lon_device1'] = $_REQUEST['lon'];
	$lon1					 = $_SESSION['lon_device1'];
}

// timezone value assigning to current Servertime Setting up Timezone time hour, minut and second varible
$timeZoneArray	= explode(':',$timezone);
$totalHours		= date("H") + $timeZoneArray[0];
$totalMinutes	= date("i") + $timeZoneArray[1];
$totalSeconds	= date("s") + $timeZoneArray[2];

$featureday 	= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
$today 			= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
$fromDay 		= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));

$featuremonth	= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
$tomonth 		= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
$fromMonth		= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));

$featureyear	= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
$toyear 		= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
$fromYear 		= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));

if(isset($_REQUEST['eventdate'])){
	$_REQUEST['eventdate'] = trim($_REQUEST['eventdate']);	
}

// If date is select from datepicker then assign below date variable
$todaestring = '';

if(!empty($_REQUEST['eventdate'])){
	#Creating Array for Start and end date
	$startDate = explode('-',$_REQUEST['eventdate']);

	# Creating Daterange variable
	$fromDay	= date('d',strtotime($startDate[0]));
	$fromMonth	= date('m',strtotime($startDate[0]));
	$fromYear	= date('Y',strtotime($startDate[0]));
	
	$today		= date('d',strtotime($startDate[1]));
	$tomonth	= date('m',strtotime($startDate[1]));
	$toyear		= date('Y',strtotime($startDate[1]));
	
	$seachStartFullDate	=	$fromYear.'-'.$fromMonth.'-'.$fromDay;
	$searchEndFullDate	=	$toyear.'-'.$tomonth.'-'.$today ;
	$seachStartDate		=	date('l, j M', mktime(0, 0, 0, $fromMonth, $fromDay, $fromYear));
	$searchEndDate		=	date('l, j M', mktime(0, 0, 0, $tomonth, $today, $toyear));
	$single_day_date	= 	($fromYear.'-'.$fromMonth.'-'.$fromDay);
}else{
	$todaestring		=	date('l, j M', mktime(0, 0, 0, $tomonth, $today, $toyear));
	$single_day_date	= 	($toyear.'-'.$tomonth.'-'.$today);
}

# Display all published category from JEvents component
if(isset($catId) && $catId != ''){
	$rec_cat = $objEvent->select_cat_id($catId);
}else{
	$rec_cat = $objEvent->select_cat();
} 
mysql_set_charset("UTF8");

while($row_cat = mysql_fetch_array($rec_cat)){
	$array_cat[] = $row_cat['id'];
}

$byday = strtoupper(substr(date('D',mktime(0, 0, 0, $tomonth, $today, $toyear)),0,2));
$arrstrcat = implode(',',array_merge(array(-1), $array_cat));

if(isset($startDate)){
	$ser_start_date = date("Y-m-d",strtotime($startDate[0]));
	$ser_end_date   = date("Y-m-d",strtotime($startDate[1]));
}

if(!isset($_REQUEST['eventdate']) || $_REQUEST['eventdate'] == '' || $seachStartDate == $searchEndDate ){
	$rec_filter = $objEvent->select_events($toyear,$tomonth,$today,$totalHours,$totalMinutes,$totalSeconds,$arrstrcat);
	mysql_set_charset("UTF8");
	$arr_rr_id = $objEvent->select_rowfilter_rpid($rec_filter);

	if(isset($arr_rr_id) && count($arr_rr_id)){
		$strchk = implode(',',$arr_rr_id);
		$rec = $objEvent->select_events_from_rpid($strchk);
		mysql_set_charset("UTF8");
	}	
}

# Feature Event Query By Akash

# Last Day of the Month
$LD = Date('d', strtotime("+30 days"));
$LM = Date('m', strtotime("+30 days"));
$LY = Date('y', strtotime("+30 days"));

$featured_filter = $objEvent->select_featured_event($featureyear,$featuremonth,$featureday,$LY,$LM,$LD);

# code for page title
$pagemeta = $objEvent->select_pagemeta_title();

header('Content-Type:text/html;charset=utf-8');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
		<?php
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if(stripos($ua,'android') == True){ 
				$title = $site_name.' ~ '.$page_title;
				if($pagemeta['title']!=''){ $title.= ' ~ '.$pagemeta['title']; }
			}else{
				$title = $site_name.' : '.$page_title;
				if($pagemeta['title']!=''){ $title.= ' : '.$pagemeta['title']; }
			}
			echo $title;?>
		</title>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="index,follow" name="robots" />
		<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
		<link rel="shortcut icon" href="images/l/apple-touch-icon.png">
		<link href="pics/startup.png" rel="apple-touch-startup-image" />
		<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
		<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
		<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
		<script type="text/javascript" src="/components/com_shines_v2.1/javascript/mobileswipe.js"></script>
		<script type="text/javascript">
		var iWebkit;if(!iWebkit){iWebkit=window.onload=function(){function fullscreen(){var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++){if(a[i].className.match("noeffect")){}else{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}}}function hideURLbar(){window.scrollTo(0,0.9)}iWebkit.init=function(){fullscreen();hideURLbar()};iWebkit.init()}}
		</script>
		<script type="text/javascript">
			function linkClicked(link) { document.location = link; }
		</script>
		<script type="text/javascript">
			function submitForm() {
				document.events.submit();
			}
			$(document).ready(function () {
				// Date with external button
				$('#date1').scroller({ showOnFocus: false });
				$('#show').click(function() { $('#date1').scroller('show'); return false; });
				// Time
				$('#date2').scroller({ preset: 'time' });
				// Datetime
				 $('#date3').scroller({ preset: 'date' });
				$('#custom').scroller({ showOnFocus: false });
				$('#custom').click(function() { $(this).scroller('show'); });
				$('#disable').click(function() {
					$('#date1').scroller('disable');
					return false;
				});
				$('#enable').click(function() {
					$('#date1').scroller('enable');
					return false;
				});
				$('#get').click(function() {
					alert($('#date1').scroller('getDate'));
					return false;
				});
				$('#set').click(function() {
					$('#date1').scroller('setDate', new Date(), true);
					return false;
				});
				$('#theme, #mode').change(function() {
					var t = $('#theme').val();
					var m = $('#mode').val();
					$('#date1').scroller('destroy').scroller({ showOnFocus: false, theme: t, mode: m });
					$('#date2').scroller('destroy').scroller({ preset: 'time', theme: t, mode: m });
					$('#date3').scroller('destroy').scroller({ preset: 'date', theme: t, mode: m });
					$('#custom').scroller('destroy').scroller({ showOnFocus: false, theme: t, mode: m });
				});
			});
		</script>

		<!--Code for Mobiscroll NEW date picker - Yogi START -->
		<script src="/templates/townwizard/js/jquery-1.9.0.min.js" type="text/javascript"></script>
		<link href="/templates/townwizard/css/mobiscroll.custom-2.7.2.min.css" rel="stylesheet" type="text/css" />
		<script src="/templates/townwizard/js/mobiscroll.custom-2.7.2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(function (){
				var now = new Date();
				var curr = new Date(now.getFullYear(), now.getMonth(), now.getDate())
				var opt = {}
				opt.rangepicker = {preset : 'rangepicker'};
				jQuery('select.changes').bind('change', function(){
					var demo = "rangepicker";
					jQuery(".demos").hide();
					if (!($("#demo_"+demo).length))
					demo = 'default';
					jQuery("#demo_" + demo).show();
					jQuery('#test_'+demo).val('').scroller('destroy').scroller($.extend(opt["rangepicker"], { theme: "ios7", mode: "mixed", display: "modal", lang: "<?php echo $final_lang;?>", minDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()) }));
				});
				jQuery('#demo').trigger('change');
			});
		</script>
		<script type="text/javascript">
			function redirecturl(val){
				url="/components/com_shines_v2.1/events.php?eventdate="+val; 
				window.location = url;
			}
		</script>
		<!--Code for Mobiscroll NEW date picker - Yogi END -->
		
		<!--Code for event Category drop down - Yogi START -->
		<script type="text/javascript">
		function redirecturlcat(val){
			if(val == 'all')
				url = "<?php echo $_SERVER['PHP_SELF'];?>";
			else
				url = "<?php echo $_SERVER['PHP_SELF']; ?>?category_id="+val;
			window.location = url;
		}
		</script>
		<!--Code for event Category drop down - Yogi END -->
		
		<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
	</head>
	<body>
		<div style="display: none">
			<label for="demo">Demo</label>
			<select name="demo" id="demo" class="changes">
				<option value="date" selected>Date</option>
				<option value="datetime" >Datetime</option>
				<option value="time" >Time</option>
				<option value="rangepicker" selected="selected" >Range Picker</option>
			</select>
		</div>
		<?php require($_SERVER['DOCUMENT_ROOT']."/partner/".$_SESSION['tpl_folder_name']."/tpl_v2.1/iphone_events.tpl"); ?>
	</body>
</html>
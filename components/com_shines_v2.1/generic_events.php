<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
	ob_start("ob_gzhandler");
}else{
	ob_start();
}

session_start();
include("connection.php");
include("iadbanner.php");

if($_SESSION['tpl_folder_name'] == "defaultspanish"){
	$final_lang = "es";
}elseif($_SESSION['tpl_folder_name'] == "defaultcroatian"){
	$final_lang = "cr";
}elseif($_SESSION['tpl_folder_name'] == "defaultdutch"){
		$final_lang = "de";
}elseif($_SESSION['tpl_folder_name'] == "defaultportuguese"){
	$final_lang = "pt-PT";
}elseif($_SESSION['tpl_folder_name'] == "defaultfrench"){
	$final_lang = "fr";
}else{
	$final_lang = "";
}

// Function for distance calculation
function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

	if ($unit == "KM") {
		return ($miles * 1.609344); 
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
}

// Assigning latitude value
if (isset($_REQUEST['lat']) && $_REQUEST['lat'] != "" ){
	$_SESSION['lat_device1'] = $_REQUEST['lat'];
	$lat1 = $_SESSION['lat_device1'];
}

// Assigning longitude value
if (isset($_REQUEST['lon']) && $_REQUEST['lon'] != "" ){
	$_SESSION['lon_device1']=$_REQUEST['lon'];
	$lon1=$_SESSION['lon_device1'];
}

// timezone value assigning to current Servertime Setting up Timezone time hour, minut and second varible
$timeZoneArray	= explode(':',$timezone);
$totalHours		= date("H") + $timeZoneArray[0];
$totalMinutes	= date("i") + $timeZoneArray[1];
$totalSeconds	= date("s") + $timeZoneArray[2];

if ($_REQUEST['d'] == ""){
	$featureday = date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
	$today 		= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
	$fromDay 	= date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
}

if ($_REQUEST['m'] == ""){
	$featuremonth	= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
	$tomonth 		= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
	$fromMonth		= date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
}

if ($_REQUEST['Y'] == ""){
	$featureyear	= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
	$toyear 		= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
	$fromYear 		= date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
}

//#DD#
$_REQUEST['eventdate'] = trim($_REQUEST['eventdate']);
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
//#DD#


/*//Query to fetch ID of all categories created in Jevents from category table
$query_cat = "SELECT c.id FROM jos_categories AS c LEFT JOIN jos_categories AS p ON p.id=c.parent_id LEFT JOIN jos_categories AS gp ON gp.id=p.parent_id LEFT JOIN jos_categories AS ggp ON ggp.id=gp.parent_id WHERE c.access <= 2 AND c.published = 1 AND c.section = 'com_jevents'";
*/
// checking cat id is set or not 
if(isset($_REQUEST['category_id'])){
	$cat_id 	= $_REQUEST['category_id'];
	$query_cat	= "SELECT c.id,c.name FROM jos_categories AS c WHERE (c.id=".$cat_id." OR parent_id=".$cat_id.") and c.access <= 2 AND c.published = 1 AND c.section = 'com_jevents' ORDER BY c.name";
}

$rec_cat 		= mysql_query($query_cat);
$result_event_cat = mysql_query($query_cat);
mysql_set_charset("UTF8");

while($row_cat = mysql_fetch_array($rec_cat)){
	# Creating Category array
	$array_cat[] = $row_cat['id'];
}


$byday = strtoupper(substr(date('D',mktime(0, 0, 0, $tomonth, $today, $toyear)),0,2));
$arrstrcat = implode(',',array_merge(array(-1), $array_cat));

$ser_start_date = date("Y-m-d",strtotime($startDate[0]));
$ser_end_date   = date("Y-m-d",strtotime($startDate[1]));

if(!isset($_REQUEST['eventdate']) || $_REQUEST['eventdate'] == '' || $seachStartDate == $searchEndDate ){
	$query_filter = "SELECT rpt.*, ev.*, rr.*, det.*, ev.state as published , loc.loc_id,loc.title as loc_title, loc.title as location, loc.street as loc_street, loc.description as loc_desc, loc.postcode as loc_postcode, loc.city as loc_city, loc.country as loc_country, loc.state as loc_state, loc.phone as loc_phone , loc.url as loc_url    , loc.geolon as loc_lon , loc.geolat as loc_lat , loc.geozoom as loc_zoom    , YEAR(rpt.startrepeat) as yup, MONTH(rpt.startrepeat ) as mup, DAYOFMONTH(rpt.startrepeat ) as dup , YEAR(rpt.endrepeat ) as ydn, MONTH(rpt.endrepeat ) as mdn, DAYOFMONTH(rpt.endrepeat ) as ddn , HOUR(rpt.startrepeat) as hup, MINUTE(rpt.startrepeat ) as minup, SECOND(rpt.startrepeat ) as sup , HOUR(rpt.endrepeat ) as hdn, MINUTE(rpt.endrepeat ) as mindn, SECOND(rpt.endrepeat ) as sdn FROM jos_jevents_repetition as rpt LEFT JOIN jos_jevents_vevent as ev ON rpt.eventid = ev.ev_id LEFT JOIN jos_jevents_icsfile as icsf ON icsf.ics_id=ev.icsid LEFT JOIN jos_jevents_vevdetail as det ON det.evdet_id = rpt.eventdetail_id LEFT JOIN jos_jevents_rrule as rr ON rr.eventid = rpt.eventid LEFT JOIN jos_jev_locations as loc ON loc.loc_id=det.location LEFT JOIN jos_jev_peopleeventsmap as persmap ON det.evdet_id=persmap.evdet_id LEFT JOIN jos_jev_people as pers ON pers.pers_id=persmap.pers_id WHERE ev.catid IN(".$arrstrcat.") AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00' AND rpt.startrepeat <= '".$toyear."-".$tomonth."-".$today." 23:59:59' AND ev.state=1 AND rpt.endrepeat>='".date('Y',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('m',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('d', mktime($totalHours, $totalMinutes, $totalSeconds))." 00:00:00' AND ev.access <= 0 AND icsf.state=1 AND icsf.access <= 0 and ((YEAR(rpt.startrepeat)=".$toyear." and MONTH(rpt.startrepeat )=".$tomonth." and DAYOFMONTH(rpt.startrepeat )=".$today.") or freq<>'WEEKLY')GROUP BY rpt.rp_id";
}

$rec_filter = mysql_query($query_filter);
mysql_set_charset("UTF8");

while($row_filter = mysql_fetch_array($rec_filter)){
	$arr_rr_id[] = $row_filter['rp_id'];
}

if (count($arr_rr_id)){
	$strchk = implode(',',$arr_rr_id);
}else{
	$strchk = 0;
}	
	$query = "select *,DATE_FORMAT(`startrepeat`,'%h:%i %p') as timestart, DATE_FORMAT(`endrepeat`,'%h:%i %p') as timeend from jos_jevents_repetition where rp_id in ($strchk) ORDER BY `startrepeat` ASC ";
	$rec   = mysql_query($query) or die(mysql_error());
	mysql_set_charset("UTF8");
	
/*Feature Event Query By Akash*/
/*Last Day of the Month*/
$LD = Date('d', strtotime("+30 days"));
$LM = Date('m', strtotime("+30 days"));
$LY = Date('y', strtotime("+30 days"));
	
$query_featuredeve	= "SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%Y') as Eyear,DATE_FORMAT(rpt.startrepeat,'%m') as Emonth,DATE_FORMAT(rpt.startrepeat,'%d') as EDate,DATE_FORMAT(rpt.startrepeat,'%m/%d') as Date,DATE_FORMAT(rpt.startrepeat,'%h:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%h:%i %p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE (cat.id=".$cat_id." OR cat.parent_id=".$cat_id.") and cat.access <= 2 AND cat.published = 1 AND cat.section = 'com_jevents' AND rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid = cat.id AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND cf.value = 1 AND rpt.endrepeat >= '".$featureyear."-".$featuremonth."-".$featureday." 00:00:00' AND rpt.startrepeat <= '".$LY."-".$LM."-".$LD." 23:59:59' GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";	
$featured_filter	= mysql_query($query_featuredeve);

/* code start by rinkal for page title */
$pagemeta_res	= mysql_query("select title from `jos_pagemeta`where uri='/events'");
$pagemeta		= mysql_fetch_array($pagemeta_res);
/* code end by rinkal for page title */

header('Content-Type:text/html;charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>

		<?php
			/* code start by rinkal for page title */
			if ($_SESSION['tpl_folder_name'] == 'defaultspanish' || $_SESSION['tpl_folder_name'] == 'defaultportuguese'){
				$t = 'Eventos';
			}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
				$t = 'Evenementen';
			}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
				$t = 'Događanja';
			}elseif($_SESSION['tpl_folder_name'] == 'default'){
				$t = 'Events';
			}
			
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if(stripos($ua,'android') == True){ 
				$title = $site_name.' ~ '.$t;
				if($pagemeta['title']!=''){
					$title.= ' ~ '.$pagemeta['title'];
				}
				echo $title;
			}else{
				$title = $site_name.' : '.$t;
				if($pagemeta['title']!=''){
					$title.= ' : '.$pagemeta['title'];
				}
				echo $title;
			}
			/* code end by rinkal for page title */
		?>
		</title>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="index,follow" name="robots" />
		<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
		<link rel="shortcut icon" href="images/l/apple-touch-icon.png">
		<link href="pics/startup.png" rel="apple-touch-startup-image" />
		<!--<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />-->
		<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
		<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
		<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
		<!--<link href="../../mobiscroll/css/mobiscroll-1.5.1.css" rel="stylesheet" type="text/css" />-->

		<script type="text/javascript" src="/components/com_shines_v2.1/javascript/mobileswipe.js"></script>
		<script type="text/javascript">
		var iWebkit;if(!iWebkit){iWebkit=window.onload=function(){function fullscreen(){var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++){if(a[i].className.match("noeffect")){}else{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}}}function hideURLbar(){window.scrollTo(0,0.9)}iWebkit.init=function(){fullscreen();hideURLbar()};iWebkit.init()}}
		</script>
		<script type="text/javascript">
		    function linkClicked(link) { document.location = link; }
		</script>
		<!--<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>-->
		<!--<script src="../../mobiscroll/js/mobiscroll-1.5.1.js" type="text/javascript"></script>-->
		<script type="text/javascript">
		            function submitForm() {
		                    document.events.submit(); //#DD#
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
		 jQuery(function () {
		 var now = new Date();
		 var curr = new Date(now.getFullYear(), now.getMonth(), now.getDate())
		 var opt = {}
		 opt.rangepicker = {preset : 'rangepicker'};
		 jQuery('select.changes').bind('change', function() {
		  var demo = "rangepicker";
		  jQuery(".demos").hide();
		  if (!($("#demo_"+demo).length))
		  demo = 'default';
		  jQuery("#demo_" + demo).show();
		  jQuery('#test_'+demo).val('').scroller('destroy').scroller($.extend(opt["rangepicker"], { theme: "ios7", mode: "mixed", display: "bottom", lang: "<?php echo $final_lang;?>", minDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()) }));
		 });
		 jQuery('#demo').trigger('change');
		 });
		</script>

		<script type="text/javascript">
			function redirecturl(val){
				url="/components/com_shines_v2.1/generic_events.php?category_id="+<?php echo $cat_id?>+"&eventdate="+val; 
				window.location = url;
			}
		</script>
		<!--Code for Mobiscroll NEW date picker - Yogi END -->
		
		<!--Code for event Category drop down - Yogi START -->
		<script type="text/javascript">
		function redirecturlcat(val){
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
		<?php
	    /* Code added for iphone_places.tpl */
		require($_SERVER['DOCUMENT_ROOT']."/partner/".$_SESSION['tpl_folder_name']."/tpl_v2.1/iphone_generic_events.tpl");
		?>
	</body>
</html>
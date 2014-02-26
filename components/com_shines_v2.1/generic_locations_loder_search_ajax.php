<?php 
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$x = realpath(dirname(__FILE__)."/../../") ;
// SVN version
if (!file_exists($x.DS.'includes'.DS.'defines.php')){
	$x = realpath(dirname(__FILE__)."/../../../") ;
}
define( 'JPATH_BASE', $x );
require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
$away		= JText::_('AWAY');
$call 		= JText::_('CALL');
$checkin 	= JText::_('CHECK_IN');
$moreinfo 	= JText::_('MORE_INFO');

global $loder_entry_page;

require_once($_SERVER['DOCUMENT_ROOT']."/configuration.php");

$jconfig = new JConfig();
$link = @mysql_pconnect($jconfig->host,  $jconfig->user, $jconfig->password);
mysql_select_db($jconfig->db);

$query				= $_GET['ajaxquery1'];
$lat1				= $_GET['lat1'];
$lon1				= $_GET['lon1'];
$dunit				= $_GET['dunit'];
$entries_per_page	= $_GET['entries_per_page'];
$lpage				= $_GET['lpage'];

$start_at = ($lpage * $entries_per_page);
$query  .= $start_at.','.$entries_per_page;

$rec = mysql_query($query) or die(mysql_error());
$n   = 0;

if(mysql_num_rows($rec) > 0){
	while($row = mysql_fetch_assoc($rec)){

		$title 			= utf8_encode($row['title']);
		$phone			= str_replace(array(' ','(',')','-','.'), '', $row[phone]);
		$geolat			= $row['geolat'];
		$geolon			= $row['geolon'];
		$loc_id			= $row['loc_id'];
					
		$distance = distance($lat1, $lon1, $geolat,  $geolon, $dunit);
		$distance		= round($distance,1);
		$description 	= showBrief(strip_tags(utf8_encode($row['description'])),30);

		$code = "<li>
				<h1>$title</h1>
				<p>$description</p>
				<p class='distance'>$distance&nbsp;$dunit&nbsp;$away</p>
				<ul class='btnList'>";
					if($phone!=''){
						$code.="<li><a class='button small' href='tel:$phone'>$call</a></li>";
					}
					$code.="<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>$checkin</a></li>
					<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>$moreinfo</a></li>
					<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
				</ul>
			</li>";	
		echo $code;
		
	}
}else{
	return FALSE;
}	 ?>

<?php
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

function showBrief($str, $length) {
	$str = strip_tags($str);
	$str = explode(" ", $str);
	return implode(" " , array_slice($str, 0, $length));
}

?>
<?php 
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

while($row = mysql_fetch_assoc($rec)){

	$title 			= utf8_encode($row['title']);
	$phone			= str_replace(array(' ','(',')','-','.'), '', $row[phone]);
	$geolat			= $row['geolat'];
	$geolon			= $row['geolon'];
	$loc_id			= $row['loc_id'];
				
	$distance = distance($lat1, $lon1, $geolat,  $geolon, $dunit);
	$distance		= round($distance,1);
	$description 	= showBrief(strip_tags(utf8_encode($row['description'])),30);
	//print("swaminarayan");

	if ($_SESSION['tpl_folder_name'] == 'defaultspanish'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>$distance&nbsp;$dunit Lejos</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>llamar</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>Registrar visita</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>m&#225;s info</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}elseif( $_SESSION['tpl_folder_name'] == 'defaultportuguese'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>$distance&nbsp;$dunit longe</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>Ligue</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>check in</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>Mais Informa&#231;&#245;es</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>$distance&nbsp;$dunit weg</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>Bel</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>Inchecken</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>Meer informatie</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>Udaljenost :$distance&nbsp;$dunit</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>Nazovi</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>Prijavi se</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>Više</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}elseif($_SESSION['tpl_folder_name'] == 'defaultfrench'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>$distance&nbsp;$dunit Loin</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>Appeller</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>Ajouter un lieu</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>Plus d’informations</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}elseif($_SESSION['tpl_folder_name'] == 'default'){
		echo "
		<li>
			<h1>$title</h1>
			<p>$description</p>
			<p class='distance'>$distance&nbsp;$dunit Away</p>
			<ul class='btnList'>
				<li><a class='button small' href='tel:$phone'>call</a></li>
				<li><a class='button small' href='javascript:linkClicked('APP30A:FBCHECKIN:$geolat:$geolon')'>check in</a></li>
				<li><a class='button small' href='diningdetails.php?did=$loc_id&lat=$lat1&lon=$lon1'>more info</a></li>
				<li><a href='javascript:linkClicked('APP30A:SHOWMAP:$geolon:$geolat')'></a></li>
			</ul>
		</li>";	
	}
	
} ?>

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
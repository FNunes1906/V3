<?php 
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
?>

<link rel="stylesheet" type="text/css" href="<?php echo $templateDir?>/css/pirobox/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $templateDir ?>/css/jquery-ui.css" media="screen" />
<script type="text/javascript" src="<?php echo $templateDir ?>/js/popup/pirobox.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
    my_speed: 400, //animation speed
    bg_alpha: 0.8, //background opacity
    slideShow : true, // true == slideshow on, false == slideshow off
    slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
    close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox
	});
});
</script>

<?php
defined('_JEXEC') or die('Restricted access');
define("TOWNWIZARD_LOCATION_IMAGE_PATH", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/thumbnails/thumb_");
define("TOWNWIZARD_LOCATION_IMAGE_PATH_FULL", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/");

global $var;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');

_init();

$this->loadTemplate("body");
$data = $this->data['row'];
$ev_start_date = ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date)));

//Created date to manage repeat date - Yogi
$date=date_create($_GET['day'].'-'.$_GET['month'].'-'.$_GET['year']);
$data->start_date = date_format($date,"l, F d, Y");

# Event detail variables
$ev_title	= $data->_title;

/* code added by rinkal for date format in all language */

$lang =& JFactory::getLanguage();
$lan = $lang->getName();

if($lan=="Español"){
	setlocale(LC_TIME,"spanish");
	$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$map_lang="es";
}
else if($lan=="Croatian(HR)"){
	setlocale(LC_TIME,"croatian");
	/*$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));*/
	$ev_start_date= iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$map_lang="hr";
}
else if($lan=="Nederlands - nl-NL"){
	setlocale(LC_TIME,"dutch");
	$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$map_lang="nl";
}
else if($lan=="Português (Brasil)"){
	setlocale(LC_TIME,"portuguese");
	$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$map_lang="pt";
}
else if($lan=="French (Fr)"){
	 setlocale(LC_TIME,"french");
	 $ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	 $map_lang="fr";
}else{
	$ev_start_date	= $data->start_date;
	$map_lang="en";
}

if($data->_alldayevent == 1){
	$ev_time =JText::_('ALL_DAY');
}else{
	if($data->_noendtime == '0')
		$ev_time = $data->start_time.' - '.$data->stop_time;
	else
		$ev_time = $data->start_time;
}

/* code ended by rinkal for date format in all language */
$ev_desc = $data->_description;

# Assign Current date to variable
$currentDate =  date("l, F d, Y");
//print_r($data->_jevlocation);
# Location detail variables
$lc_title 		= $data->_jevlocation->title;
$lc_street 		= $data->_jevlocation->street;
$lc_postcode 	= $data->_jevlocation->postcode;
$lc_city 		= $data->_jevlocation->city;
$lc_country 	= $data->_jevlocation->country;
$lc_state 		= $data->_jevlocation->state;
$lc_phone 		= $data->_jevlocation->phone;
$lc_url    		= $data->_jevlocation->url;
$lc_geolon 		= $data->_jevlocation->geolon;
$lc_geolat 		= $data->_jevlocation->geolat;
$lc_geozoom 	= $data->_jevlocation->geozoom;
$lc_image 		= TOWNWIZARD_LOCATION_IMAGE_PATH.$data->_jevlocation->image;
?>

<!--MAP CODE START-->

<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&callback=initialize&language=<?php echo $map_lang;?>"></script>
<script>
    function initialize() {
      var myLatlng = new google.maps.LatLng(<?php echo $lc_geolat;?>,<?php echo $lc_geolon;?>);
      var myOptions = {zoom:<?php echo $lc_geozoom;?>,center: myLatlng, mapTypeId: google.maps.MapTypeId.ROADMAP}
      var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	  marker = new google.maps.Marker({draggable: true, position: myLatlng,  map: map, title: "Your location" });
    }
</script>-->

<!--MAP CODE END-->

<!-- NEW MAP CODE END-->
<script src="http://maps.googleapis.com/maps/api/js?language=en"></script>
<script>
	var myCenter=new google.maps.LatLng(<?php echo $lc_geolat;?>,<?php echo $lc_geolon;?>);

	function initialize(){
		var mapProp = {
			center:myCenter,
			zoom:14,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};
		var map=new google.maps.Map(document.getElementById("map_canvas"),mapProp);
		var marker=new google.maps.Marker({
		position:myCenter,
		});

		marker.setMap(map);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- NEW MAP CODE END-->

<div id="eventContainer" itemtype="http://schema.org/Event" itemscope="">
	<h2 itemprop="name"><?php echo $ev_title; ?></h2>
	<p>
		<?php 
		if($currentDate == $ev_start_date){
			echo 'Today'.'<br/>'.$ev_time;
		}?>
	</p>
	<p></p>
	<strong itemtype="http://schema.org/Place" itemscope="" itemprop="location"><?php echo $lc_title; ?></strong>
	<p>
		<?php 
		if($currentDate != $ev_start_date){
			echo $ev_start_date.$ev_time;
		}?>
	</p>
	<p itemprop="description"><?php echo $ev_desc; ?></p>
	<div>
		<?php $replace = array("#","&");
		$new_lc_street = str_replace($replace, "", $lc_street);?>
		<a class="maptag" href="https://maps.google.com/maps?q=<?php echo $new_lc_street ?>+<?php echo $lc_city ?>+<?php echo $lc_state ?>+<?php echo $lc_country ?>+<?php echo $lc_postcode ?>&hl=<?php echo $map_lang;?>&z=<?php echo $lc_geozoom;?>" target="_blank">
			<div id="map_canvas" style="width:100%; height:150px;margin:6px 0px;"></div>
		</a>
	</div>
	<ul itemtype="http://schema.org/Place" itemscope="" itemprop="location">
	 	<li><?php echo $lc_title;?></li>

	    <span itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
	       	<li><span itemprop="streetAddress"><?php echo $lc_street;?></span>,</li>
	       	<li><span itemprop="addressLocality"><?php echo $lc_city;?></span>,</li>
	       	<li><span itemprop="addressRegion"><?php echo $lc_state;?></span><span>,</span> <span itemprop="postalCode"><?php echo $lc_postcode;?></span></li>
	    </span>

		<?php 
			$remove = array("(","-",")"," ");
			$new_phone = str_replace($remove, "", $lc_phone);?>
	    <li><a href="tel:<?php echo $new_phone?>" itemprop="telephone"><?php echo $lc_phone;?></a></li>
		<?php 
			$link = strip_tags($lc_url);
			$new_url = str_replace("http://", "",$link);?>
	    <li><a href="<?php echo $link?>" target="_blank"><?php echo $new_url ;?></a></li>
	</ul>
	<?php include_once($_SERVER['DOCUMENT_ROOT'].'/rsvp_data.php'); ?>
	<!-- RSVP Images code Begin -->
			<div class="checkins fl">
				<?php if(isset($userCount) > 0): ?>
					<span><?php echo $userCount.' '.JText::_("TW_ATTENDING") ?>:</span>
					<?php
					$i = 0;
					$imgCnt = 0;
					# Looping RSVP data object to get RSVP User image
					foreach($arr_rsvpuser as $value){

						if($arr_rsvpuser[$i]->value == 'Y'){
							# Printg user profile Image from social site
							echo "<img class='fl' src=".tw_get_user_image_url($arr_rsvpuser[$i]->user)." />";	
							$imgCnt += 1;
						}	
							# Increment varialbe and total image count to break loop
							$i++; if($imgCnt >= 5) break;
					}?>
					<a class="seeAll fl" data-ref-panel="AttendancePanel" href="#"><?php echo JText::_("TW_SEEALL") ?> &raquo;</a>
				<?php endif; ?>	
			</div>
			<!-- RSVP Images code End -->
	
	<span style="margin-bottom: 10px;clear: both;">
		<p><?php echo JText::_("TW_LIKEDBY") ?>:</p>
			<span class="fb-like" data-send="false" data-layout="standard" data-width="245" data-show-faces="true"></span>
	</span>
		
		<div class="cb"></div>	
	</div>

	<?php if(isset($data->_jevlocation->image) && !empty($data->_jevlocation->image)): ?>
	
		<!-- IMAGE CODE Begin -->
		<div class="photoGallerySect sect" id="VenuePhotoGallery">
			<h3 class="fl">
				<a href="/index.php?option=com_phocagallery&amp;view=categories&amp;Itemid=102" class="heading display"><?php echo JText::_("TW_PHOTO_GALLERY") ?></a>
			</h3>
			<div class="bc fr">
				<a href="/index.php?option=com_phocagallery&amp;view=categories&amp;Itemid=102"><?php echo JText::_("LOC_SEND_PHOTO") ?></a>
			</div>
			<ul>
				<li>
					<a title="Open image in new window" href="<?php echo TOWNWIZARD_LOCATION_IMAGE_PATH_FULL.$data->_jevlocation->image; ?>" class='pirobox_gall' id="notitle" ><img style="max-height: 100% !important; max-width: 100% !important;" src="<?php echo $lc_image;?>"></a>
				</li>
			</ul>
		</div>
		<!-- IMAGE CODE End -->
	
	<?php endif; ?>
	
</div>	


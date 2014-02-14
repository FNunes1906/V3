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
	$lang="es";
}
else if($lan=="Croatian(HR)"){
	setlocale(LC_TIME,"Croatian");
	/*$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));*/
	$ev_start_date= iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$lang="hr";
}
else if($lan=="Nederlands - nl-NL"){
	setlocale(LC_TIME,"Dutch");
	$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$lan1="nl";
}
else if($lan=="Português (Brasil)"){
	setlocale(LC_TIME,"Portuguese");
	$ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	$lang="pt";
}
else if($lan=="French (Fr)"){
	 setlocale(LC_TIME,"French");
	 $ev_start_date=UTF8_encode(ucwords(strftime ('%A, %b %d,%Y',strtotime($data->start_date))));
	 $lang="fr";
}else{
	$ev_start_date	= $data->start_date;
	$lang="en";
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
$lc_geolon 		= $data->_jevlocation->geolon;
$lc_geolat 		= $data->_jevlocation->geolat;
$lc_geozoom 	= $data->_jevlocation->geozoom;
$lc_image 		= TOWNWIZARD_LOCATION_IMAGE_PATH.$data->_jevlocation->image;
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&callback=initialize&language=<?php echo $lang;?>"></script>
<script>
    function initialize() {
      var myLatlng = new google.maps.LatLng(<?php echo $lc_geolat;?>,<?php echo $lc_geolon;?>);
      var myOptions = {zoom:<?php echo $lc_geozoom;?>,center: myLatlng, mapTypeId: google.maps.MapTypeId.ROADMAP}
      var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	  marker = new google.maps.Marker({draggable: true, position: myLatlng,  map: map, title: "Your location" });
    }
</script>

<div id="Feat">
    <div class="detailFeature sect" id="EventDetail">
        <div class="bc bold fr" style="text-align: right;">
			<?php 
			if($currentDate == $ev_start_date){
				echo 'Today'.'<br/>'.$ev_time;
			}else{
				echo $ev_start_date.'<br/>'.$ev_time;
			}?>
		</div>
        <h2 class="display"><?php echo $ev_title; ?></h2>
        <div class="rating"></div>
        <div class="evtTmb fr"></div>
        <div style="text-transform: capitalize;" class="bold"><?php echo $lc_title; ?></div>
       	<div class="map fr">
			<div id="map_canvas" style="width:200px; height:156px;margin:5px 0px 5px 5px;"></div>
		</div>
	    <p class="desc"><?php echo $ev_desc; ?></p>
        <a href="https://maps.google.com/maps?q=<?php echo $lc_street ?>+<?php echo $lc_city ?>+<?php echo $lc_state ?>+<?php echo $lc_country ?>+<?php echo $lc_postcode ?>&hl=<?php echo $lan1;?>&z=<?php echo $lc_geozoom;?>" target="_blank">
			<div class="address">
				<?php include_once($_SERVER['DOCUMENT_ROOT'].'/rsvp_data.php'); ?>
				<div><?php echo $lc_title;?></div>
				<div><?php echo $lc_street;?></div>
				<div><?php echo $lc_city.' '.$lc_state.', '.$lc_postcode;?></div>
			</div>
		</a>
		<div style="margin-bottom: 10px;">
			<?php 
				$remove = array("(","-",")"," ");
				$new_phone = str_replace($remove, "", $lc_phone);?>
			<a href=tel:<?php echo $new_phone?>><?php echo $lc_phone;?></a>
		</div>
		<div class="people cb">

			<div class="likes fl"><span><?php echo JText::_("TW_LIKEDBY") ?>:</span>
	            <div class="fb-like" data-send="false" data-layout="standard" data-width="45%" data-show-faces="true"></div>
			</div>
			<!-- RSVP Images code Begin -->
				<div class="checkins fl">
					<div class="pad">
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
				</div>
				<!-- RSVP Images code End -->
			<div class="cb"></div>	
		</div>

		<?php if(isset($data->_jevlocation->image) && !empty($data->_jevlocation->image)): ?>
		
			<!-- IMAGE CODE Begin -->
			<div style="width: 420px; overflow: hidden;" class="photoGallerySect sect" id="VenuePhotoGallery">
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
</div>

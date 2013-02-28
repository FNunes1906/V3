<?php 
defined('_JEXEC') or die('Restricted access');
define("TOWNWIZARD_LOCATION_IMAGE_PATH", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/thumbnails/thumb_");
define("TOWNWIZARD_LOCATION_IMAGE_PATH_FULL", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/");

global $var;

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');

_init();
//$this->_header();
//  don't show navbar stuff for events detail popup
/*
if( !$this->pop ){
	$this->_showNavTableBar();
}
*/
$this->loadTemplate("body");
/*
if( !$this->pop ){
	$this->_viewNavAdminPanel();
}
$this->_footer();
*/
?>
<?php 
$data = $this->data[row];

# Event detail variables
$ev_title		= $data->_title;
$ev_start_date	= $data->start_date;
$ev_time		= $data->start_time.' - '.$data->stop_time;
$ev_desc		= $data->_description;

# Location detail variables
$lc_title 		= $data->_jevlocation->title;
$lc_street 		= $data->_jevlocation->street;
$lc_postcode 	= $data->_jevlocation->postcode;
$lc_city 		= $data->_jevlocation->city;
$lc_country 	= $data->_jevlocation->country;
$lc_state 		= $data->_jevlocation->state;
$lc_phone 		= $data->_jevlocation->phone;
$lc_image 		= TOWNWIZARD_LOCATION_IMAGE_PATH.$data->_jevlocation->image;
?>


<div id="Feat">
    <div class="detailFeature sect" id="EventDetail">
        <div class="bc bold fr"><?php echo $ev_start_date.' '.$ev_time; ?></div>
        <h1 class="display"><?php echo $ev_title; ?></h1>
        <div class="rating"></div>
        <div class="evtTmb fr"></div>
        <div style="text-transform: capitalize;" class="bold"><?php echo $lc_title; ?></div>
        <p class="desc"><?php echo $ev_desc; ?></p>
        <div class="address">
			<?php include_once($_SERVER['DOCUMENT_ROOT'].'/rsvp_data.php'); ?>
			<div><?php echo $lc_title;?></div>
			<div><?php echo $lc_street;?></div>
			<div><?php echo $lc_city.', '.$lc_state.', '.$lc_postcode;?></div>
			<div>&nbsp;</div>
			<div><?php echo $lc_phone;?></div>
		</div>
		<div class="people cb">

			<div class="likes fl"><span><?php echo JText::_("TW_LIKEDBY") ?>:</span>
	            <div class="fb-like" data-send="false" data-layout="standard" data-width="45%" data-show-faces="true"></div>
			</div>
			<!-- RSVP Images code Begin -->
				<div class="checkins fl">
					<div class="pad">
					<?php if($userCount > 0): ?>
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
		
		<!-- IMAGE CODE Begin -->
		<div style="width: 420px; overflow: hidden;" class="photoGallerySect sect" id="VenuePhotoGallery">
 			<h3 class="fl">
 				<a href="/index.php?option=com_phocagallery&amp;view=categories&amp;Itemid=102" class="heading display"> Photo Gallery</a>
			</h3>
			<div class="bc fr">
 				<a href="/index.php?option=com_phocagallery&amp;view=categories&amp;Itemid=102">Send us your photos</a>
			</div>
 			<ul>
				<li>
					<a href="#" id="pop"><img style="max-height: 100% !important; max-width: 100% !important;" src="<?php echo $lc_image;?>"></a>
					<div style="left: 524.5px; top: 174.833px; position: absolute; display: none;" id="overlay_form">
						<a href="#" id="close">Close</a>
						<img style="max-height: 100% !important; max-width: 100% !important;" src="<?php echo TOWNWIZARD_LOCATION_IMAGE_PATH_FULL.$data->_jevlocation->image; ?>">
					</div>
				</li>
			</ul>
		</div>
		<!-- IMAGE CODE End -->
		
        <!--<div> <?php if(isset($lc_image) && !empty($lc_image)):
					echo "<img src=$lc_image />";
			 endif; ?>
		</div>-->
	</div>	
</div>

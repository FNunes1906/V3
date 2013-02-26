<?php 
defined('_JEXEC') or die('Restricted access');
define("TOWNWIZARD_LOCATION_IMAGE_PATH", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/thumbnails/thumb_");
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
			<div><?php echo $lc_phone;?></div>
		</div>
		<div class="likes fl"><span>Liked by:</span>
            <div class="fb-like" data-send="false" data-layout="standard" data-width="45%" data-show-faces="true"></div>
        	<div> <?php if(isset($lc_image) && !empty($lc_image)): echo "<img src=$lc_image />"; endif; ?></div>
		</div>	
	</div>
</div>​


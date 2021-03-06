<?php 
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
# Code to prevent Mootols script in Joomla website - to resolve conflict with event datepicker
if( JRequest::getVar( 'option' ) == 'com_jevents' ){
	$setHeader = $this->getHeadData();
	$setHeader['scripts'] = array(' '=>' ');
	$this->setHeadData($setHeader);
}

global $var;

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');

_init();
define("TOWNWIZARD_TMPL_PATH", "http://".$_SERVER['HTTP_HOST']."/templates/townwizard");
define("TOWNWIZARD_PARTNER_PATH", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']);

include_once($_SERVER['DOCUMENT_ROOT'].'/townwizard-db-api/user-api.php');
//echo $var->keywords;
?>

<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $var->characterset; ?>" />
<meta name="keywords" content="<?php echo $var->keywords; ?>" />
<meta name="description" content="<?php echo $var->metadesc; ?>" />
<meta name="description" content="<?php echo $var->extra_meta; ?>" />
<!--<meta property="og:image" content="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png"/>-->

<?php
// CODE FOR EVENT DETAIL DESCRIPTION TO SHARING DETAIL
if(JRequest::getVar('task') == 'icalrepeat.detail'){
        if($_REQUEST['evid'] != ""){
                $query = mysql_query("SELECT `description` FROM `jos_jevents_vevdetail` where evdet_id = (SELECT `eventdetail_id` FROM `jos_jevents_repetition` WHERE `rp_id` = ".$_REQUEST['evid'].")");
                $data = mysql_fetch_assoc($query);
                        $fetchimage = explode('<img src="',$data['description']);
                        $finalimage = explode('" />',$fetchimage[1]);
                        if($data['description'] !=""){?>
                                <meta property="og:description" content="<?php echo strip_tags($data['description']); ?>"/>
                                <meta id="ogimage" property="og:image" content="<?php echo $finalimage[0]; ?>"/>
                        <?php }
        }

// LOCATION SHARING
}else if(JRequest::getVar('task') == 'locations.detail'){
        if($_REQUEST['loc_id'] != ""){
                $query = mysql_query("SELECT `description` FROM `jos_jev_locations` WHERE `loc_id` = ".$_REQUEST['loc_id']);
                $data = mysql_fetch_assoc($query);
                        $fetchimage = explode('<img src="',$data['description']);
                        $finalimage = explode('" />',$fetchimage[1]);
                        if($data['description'] !=""){?>
                                <meta property="og:description" content="<?php echo strip_tags($data['description']); ?>"/>
                                <meta id="ogimage" property="og:image" content="<?php echo $finalimage[0]; ?>"/>
                        <?php }
        }
// ARTICLE AND BLOG SHARING
}else if(JRequest::getVar('option') == 'com_content' && JRequest::getVar('view') == 'article'){
        $cleanid = explode(":",$_REQUEST['id']);
        if($_REQUEST['id'] != ""){
                $query = mysql_query("SELECT `introtext`,`fulltext` FROM `jos_content` where `id` = ".$cleanid[0]);
                $data = mysql_fetch_assoc($query);
                $fetchimage = explode('<img src="',$data['introtext'].$data['fulltext']);
                $finalimage = explode('" />',$fetchimage[1]);
                if(isset($data) && $data !=""){ ?>
                        <meta property="og:description" content="<?php echo strip_tags($data['introtext'].$data['fulltext']); ?>"/>
                        <meta id="ogimage" property="og:image" content="<?php echo $finalimage[0]; ?>"/>
                <?php }
        }
}else { ?>
        <meta property="og:description" content="&nbsp;"/>
         <meta property="og:image" content="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png"/>
<?php } ?>

<!-- set css and js path for new design v3 -->
<meta name="viewport" content="width=device-width;initial-scale = 1.0,maximum-scale = 1.0" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/core.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/tablet.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/events.css" />

<!-- Add css for location image pop up -->
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/jquery.fancybox.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/yetii-min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/tw.js"></script>

<!-- Add jQuery library for location and Event detail image pop up -->

<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/css/pirobox/style.css" media="screen" />
<!--<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/css/jquery-ui.css" media="screen" />-->
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/js/pirobox.min.js"></script>
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
<!-- Add jQuery library for location and Event detail  image pop up END-->

<!-- Share This -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
	stLight.options({
		publisher:'fe72f22e-436e-4b4e-9486-bbcb87276adc',
	});
</script>
<!-- Share This End-->

<!-- Code for Print Icon begin -->
<script type="text/javascript">     
        function PrintDiv() {    
           var divToPrint = document.getElementById('Feat');
           var popupWin = window.open('', 'My Event', 'width=550,height=450');
           popupWin.document.open();
           popupWin.document.write('<html><head><title>My Event</title><link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/print.css" /></head><body>' + '<input class="printBtn" type="button" value="" onclick="window.print();" />' + divToPrint.innerHTML +  '</html>');
            popupWin.document.close();
                }
</script>
<!-- Code for Print Icon end -->


<!-- End css and js path for new design v3 -->

<!-- use favicon icon for v2 -->
<link rel="shortcut icon" href="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/favicon.ico" />

<!--  CODE for SAFARI BROWSER DETECTION BEGIN -->
<?php if( JRequest::getVar( 'view' ) == 'frontpage' ) { ?>
<script type="text/javascript">
 // First Time Visit Processing
 // copyright 10th January 2006, Stephen Chapman
 // permission to use this Javascript on your web page is granted
 // provided that all of the below code in this script (including this
 // comment) is used without any alteration
 function rC(nam) {var tC = document.cookie.split('; '); for (var i = tC.length - 1; i >= 0; i--) {var x = tC[i].split('='); if (nam == x[0]) return unescape(x[1]);} return '~';} function wC(nam,val) {document.cookie = nam + '=' + escape(val);} function lC(nam,pg) {var val = rC(nam); if (val.indexOf('~'+pg+'~') != -1) return false; val += pg + '~'; wC(nam,val); return true;} function firstTime(cN) {return lC('pWrD4jBo',cN);} function thisPage() {var page = location.href.substring(location.href.lastIndexOf('\/')+1); pos = page.indexOf('.');if (pos > -1) {page = page.substr(0,pos);} return page;}

 // example code to call it - you may modify this as required
 function start() {
    if (firstTime(thisPage())) {
       // this code only runs for first visit
      if((navigator.userAgent.match(/iphone/i)) || (navigator.userAgent.match(/ipad/i)) || (navigator.userAgent.match(/ipod/i))) {
     var r=confirm("We have an iPhone app too! Click OK to install the app.");
      if (r==true){window.location = "<?php echo $var->iphone?>";}
      }else if (navigator.userAgent.match(/android/i)) {
      var r=confirm("We have an Android app too! Click OK to install the app.");
      if (r==true){location.href="<?php echo $var->android?>";}
   }else {}
    }
    // other code to run every time once page is loaded goes here
 }
 onload = start;

 </script>
<?php } ?>
<!--  CODE for SAFARI BROWSER DETECTION END -->


<script type="text/javascript">
	/* Facebook login function */
	function fb_login() {
		window.open("/townwizard-db-api/fb-login.php", "_blank", "height=400,width=600,status=no,toolbar=no,menubar=no");
	}

	/* Twitter login function */
	function twitter_login() {
		window.open("/townwizard-db-api/twitter-login.php", "_blank", "height=400,width=600,status=no,toolbar=no,menubar=no");
	}
  	
	function tw_logout() {
		jQuery.ajax({
			url: "townwizard-db-api/logout.php",
			type: "get",
			complete: function() {
			window.location.reload();
			}
		});
	}

</script>

<script type="text/javascript"> 
jQuery(document).ready(function(){
  jQuery("#flip").click(function(){
    jQuery("#panel").slideToggle("slow");
  });
});
</script>

<!-- Townwizard Ad banner for free product start -->
<?php if($_SESSION['partner_type']=="free") { ?>
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/44090425/TownWizard-Left-180', [180, 150], 'div-gpt-ad-1403199524717-0').addService(googletag.pubads());
googletag.defineSlot('/44090425/TownWizard-Right-300', [300, 250], 'div-gpt-ad-1403199524717-1').addService(googletag.pubads());
googletag.defineSlot('/44090425/TownWizard-Top-468', [468, 60], 'div-gpt-ad-1403199524717-2').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
<?php } ?>
<!-- Townwizard Ad banner for free product end -->

<?php
$app = JFactory::getApplication();
if(JRequest::getVar('task') == 'icalrepeat.detail'){
 $this->setTitle( $this->getTitle() . ' | '. JText::_("TW_EVENT_DETAIL") .' | '. $var->site_name);
}elseif(JRequest::getVar('task') == 'locations.detail'){
 $this->setTitle( $this->getTitle(). ' | ' . JText::_('TW_LOCATION_DETAIL'). ' | ' .$var->site_name ); 
}else{
 $this->setTitle( $this->getTitle() . ' | ' . $var->site_name . ' | ' .  $var->page_title ); 
}?>

<!--  Town wizard Google Analytic code -->
<?php include("ga.php"); ?>

</head>

<body>
 <div id="fb-root"></div>
<script type="text/javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);	
}(document, 'script', 'facebook-jssdk'));</script>
  
 			  
<!-- Top Bar Start -->
<div id="TopBar" style="background:url('<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/whitezig_zag.png') repeat-x scroll left 30px <?php echo $var->Header_color; ?>;height: 36px;">
	<?php if($_SESSION['partner_type']=="free" AND JRequest::getVar('view') != 'reset') {?>
		<div class="sWidth">
			<div class="fr powered"><a href="http://www.townwizard.com/free" target="_blank"><span style="float: left; font-size: 12px; text-align: center; font-weight: bold; text-transform: capitalize; font-family: arial; padding-top: 8px;color: #fff"><?php echo JText::_("TW_FREE_GUIDE")." | ".JText::_("POWERED BY") ?></span><img style="padding: 5px;" alt="townwizard" src="templates/townwizard/images/header/twBanner.png"></a></div>
		</div>
	<?php } ?>
</div>

<!-- Top Bar End -->

  <!-- Content Start -->

  <div id="Content" class="sWidth">
  	
  	<!-- Header Start -->
	<?php if(JRequest::getVar('view') != 'reset'): ?>
	  	<div id="Header">
	  	  <div id="Logo" class="fl">
	  	  	<a href="<?php echo $this->baseurl ?>" title="HOME"> <img alt="logo" src="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png" height="120" width="190" /> </a>
	  	  </div>
	  	     <div class="headerAdFlex fl">
	  	  	  <div id="Social" class="fr">
	            <div>
					<!-- SOCIAL LOGIN START -->
					<?php if(isset($_SESSION['tw_user_name'])) { ?>
						<div id="LoggedIn" class="fl" style="font-size:11.5px; width:270px; text-align: right;">
							<img style="float:right;padding:0px;" src="<?php echo $_SESSION['tw_user_image_url']; ?>">
                			<span style="padding-right:60px; display: block;"><?php echo JText::_("TW_WELCOME").' '.$var->site_name.' '.$_SESSION['tw_user_name']; ?>!</span>
							<span><a style="padding-right:60px;"   class="logOut" href="javascript:void(0)" onclick="tw_logout();"><?php echo JText::_("TW_CLICKHERE_SIGHOUT") ?></a></span>
							<?php $user = $_SESSION['tw_user']; ?>                      				
						</div>	
					<?php }  else { ?>
						<div>
							<a class="fbLogin fl" href="javascript:void(0)" onclick="fb_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
              				<a class="twtLogin fl" href="javascript:void(0)" onclick="twitter_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
              				<!-- <a class="helpBtn" data-ref-panel="HelpTT" href="#"><img alt="Help" src="images/header/helpBtn.png" /></a> -->
							<a class="helpBtn" data-ref-panel="HelpTT" style="cursor:pointer"><img alt="Help" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/helpBtn.png" /></a>
						</div>	
					<?php } ?>
						
				  <!-- SOCIAL LOGIN END -->
	              <!-- <a href="#"><img alt="Help" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/header/helpBtn.png" /></a> -->
	            </div>
	          </div>
              <div id="UpperBannerAd" class="bannerAd">
			  <!-- TW Banner Ad start -->
			<?php if($_SESSION['partner_type']=="free") {?>
					<div id='div-gpt-ad-1403199524717-2' style='width:468px; height:60px;'>
						<script type='text/javascript'>
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-1403199524717-2'); });
						</script> 
					</div>
			<!-- TW Banner Ad End -->
			<?php }else { ?>
	  	  	  	<?php if($this->countModules('banner1')) : ?>
				<div class="bannerCont">
	  	  	      <!-- TOP BANNER AD -->
	  	  	    	 <jdoc:include type="modules" name="banner1" style="rounded" />
         		 </div>
				 <?php else: ?>
					 <img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/default_banner.png" />
				  <?php endif; ?>
				<?php } ?>
	  	  	  </div>
	  	    </div>
	  	    
			<?php require ("./inc/config.php"); 
				$handle = fopen($query, "r");
				$xml = '';
				// Applying condition for $handle variable to check weather it is null or not
				if($handle != null || !empty($handle)){
					while (!feof($handle)) {
				  		$xml.= fread($handle, 8192);
					}
				}
				fclose($handle);
				$data = XML_unserialize($xml);
			?>
	  	    <div id="GuideInfo" class="cr">
	  	      <div class="localCont">
	            <div id="Local" class="fl">
					<div id="Weather" class="fr">
	  				<?php
					if(isset($data['weather']['cc']['tmp'])){
						echo str_replace('N/A','--',$data['weather']['cc']['tmp']) . "&#176; ";
						echo " <a href='http://www.weather.com/weather/today/$var->location_code' target='_blank'><img alt='weather'  src='/common/images/weather/" . $data['weather']['cc']['icon'] . ".png' /></a>";
					}
					?>
					</div> 
	  	      	    <?php echo '<h1>'.$var->beach.'</h1>'; ?> 
	            </div>
	          </div>
              
			  <?php if($this->countModules('search')) : ?>
			          <div class="search fr">
			  	  	    <jdoc:include type="modules" name="search" style="rounded" />
		         	 </div>
         	 <?php endif; ?>
             
	  	    </div>
	  	</div>
	<?php endif; ?>
  		<!-- Header End -->

  	<div id="MainContent">
  	  
  	 <!-- Left Column Start -->
	<?php if(JRequest::getVar('view') != 'reset'): ?>
        <div id="LeftCol" class="fl">
		        <?php if($this->countModules('menu')) : ?>
                <div id="MainNav" class="display">
                  	<jdoc:include type="modules" name="menu" style="rounded" />
				</div>
				<?php endif; ?>
               
			   <?php if($_SESSION['partner_type']!="free") {?>
			   
                <?php if($var->android != "" || $var->iphone != ""):?>
                <div id="SideMobile" class="sect">
                  <strong><?php echo JText::_("TW_MOBILE") ?>!</strong>
                  <?php if($var->iphone != ""):?>
                    <a class="iphone_img" href="<?php echo $var->iphone?>" target="_blank">
							<span style="font-size: 11px;"><?php echo JText::_("DOWNLOAD") ?></span>
							<b style="font-size: 17px;">Iphone/Ipad</b>
						</a>
                  <?php endif;?>
                  
                  <?php if($var->android != ""):?>
                   <a class="android_img" href="<?php echo $var->android?>" target="_blank">
					  		<span style="font-size: 11px;"><?php echo JText::_("DOWNLOAD") ?></span>
							<b style="font-size: 17px;">Android</b>
					  </a>
                  <?php endif;?>
                </div>
                  <?php endif;?>
                
                <?php if($var->youtube != "" || $var->twitter != ""):?>
                  <div id="SideSocial" class="sect">
                  <h3 class="display"><?php echo JText::_("TW_FOLLOWUS") ?></h3>
                   <?php if($var->twitter != ""):?>
                  <a class="twitter" href="<?php echo $var->twitter ?>" target="_blank"><img alt="Follow us on Twitter" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/twtFollowBtn.png" /></a>
                  <?php endif;?>
                  <?php if($var->youtube != ""):?>
                  <a class="youtube" href="<?php echo $var->youtube ?>" target="_blank"><img alt="Follow us on YouTube" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/ytFollowBtn.png" /></a>
                  <?php endif;?>
                </div>
                  <?php endif;?>
                
                <?php if($this->countModules('banner2')) : ?>
                <div id="SideAds" class="sect">
                            <div class="ad space">
                                <jdoc:include type="modules" name="banner2" style="rounded" />
                            </div>
                </div>
               <?php else: ?>
     				<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Left_banner.png" />
               <?php endif; ?>
			   
			   <!-- TW Banner Ad start -->
			<?php } else { ?>
				<div class="sect">
					<div id='div-gpt-ad-1403199524717-0' style='width:180px; height:150px;'>
						<script type='text/javascript'>
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-1403199524717-0'); });
						</script>
					</div>
				</div>
			<?php } ?>
			<!-- TW Banner Ad End -->
			   
        </div>
	<?php endif; ?>
  	  <!-- Left Column End -->

  	  <div id="WidgetArea">
		 <!-- Placeholder for Header Banner Ad in Vertical Layout Start -->

     	<div id="LowerBannerAd" class="bannerAd"></div>
		<?php if($this->countModules('FrontSlider') && (JRequest::getVar( 'view' )!='article')) : ?>
            <div id="EvtRot" class="rotator carousel fl">
                  <jdoc:include type="modules" name="FrontSlider" style="xhtml" />
                   <div class="cb"></div>
             </div>
		<?php endif; ?>
      <!-- Placeholder for Header Banner Ad in Vertical Layout End -->
	  
   
	    	  
      <!-- Main body start -->
       <div class="centerCol fl">
					<!-- Event Rotator Start -->
				 	<?php //if(JRequest::getVar('task') == 'week.listevents'):?>
					
					<?php if(JRequest::getVar('task') != 'icalrepeat.detail'):?>
				  
				 	<div class="fl">
						<?php if($this->countModules('slider')) : ?>
				            <div>
				                <jdoc:include type="modules" name="slider" style="rounded" />
				                <div class="cb"></div>
				             </div>
			          	<?php endif; ?>					
						<?php if($this->countModules('searchevent')) : ?>
				            <div id="Feat">
								<div id="Find" class="sect">
				                	<jdoc:include type="modules" name="searchevent" style="rounded" />
				                	<div class="cb"></div>
				             	</div>
							</div>
			          	<?php endif; ?>
				    </div>
				       	<?php endif; ?>     
				     <!-- Event Rotator End -->
					
					<?php
					 if(JRequest::getVar('task') != 'locations.detail') : ?>
						
						<?php if($this->countModules('loc_slider')) : ?>
								<div>
									<jdoc:include type="modules" name="loc_slider" style="rounded" />
									<div class="cb"></div>
								</div>
						<?php endif; ?>
						<?php if($this->countModules('searchres')) : ?>
								<div id="Feat">
									<div id="Find" class="sect">
										<jdoc:include type="modules" name="searchres" style="rounded" />
										<div class="cb"></div>
									</div>
								</div>
						<?php endif; ?>
				    <?php endif; ?>
					
            		<div id="Try3" class="sect">
                    	<?php if( JRequest::getVar( 'view' ) == 'frontpage' ) { ?>
						 <div class="description">
						<?php } else { ?>
						<div class="cont">	
						<?php } ?>
	                             <?php if ($this->getBuffer('message')) : ?> 
							
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
								
							<script type="text/javascript">
	
	jQuery(document).ready( function() {
			
		jQuery('#popupBoxClose').click( function() {		
			jQuery('.black').css('display','none');
			jQuery('#systmsg').css('display','none');
		});
		});
</script>
							<div id="systmsg" >
  		<a id="popupBoxClose" class="close">x</a>
  <jdoc:include type="message" />
 	
</div>  
	<div class="black" ></div>
<?php endif; ?> 
	                            
								 <jdoc:include type="component" />
								 
								<!-- RSVP CODE BEGIN -->
								
								
                         </div>
						 
              	   </div>
				   <!-- Code for Location category count module begin -->
				   <?php if($this->countModules('user1')) : ?>
                		<jdoc:include type="modules" name="user1" style="xhtml" />
        			<?php endif; ?>
				 	<!-- Code for Location category count module end -->	
             </div>
  	  <!-- Main body end -->	
	  
	 <!--Used for Sharethis module begin -->
	  <?php if(JRequest::getVar('evid') != '' || JRequest::getVar('loc_id') != '' || JRequest::getVar( 'view' )=='article') :?>
			 <?php if($this->countModules('ev_right')) : ?>
		            <div class="rightCol fr">
		             	<jdoc:include type="modules" name="ev_right" style="rounded" />
		            </div>
		      <?php endif; ?>
			 
	 <?php endif; ?>		
	 <!--Used for Sharethis module end --> 
	 
 	<?php if(JRequest::getVar('Itemid') == 97 && JRequest::getVar('task') == 'week.listevents'):?>
				<?php if($this->countModules('slider')) : ?>
					<div id="neg" class="adSect rightCol fr">
				<?php else: ?>
					<div class="adSect rightCol fr">	
				<?php endif; ?>
	<?php elseif(JRequest::getVar('view') == 'wrapper'): ?>
				<div class="adSect rightCol fr wrapper">
	<?php else: ?>
					<div class="adSect rightCol fr">	
	<?php endif; ?>	
				
				<!-- event_submit and photo upload start-->
				  <?php if(JRequest::getVar('task') == 'week.listevents') : ?>
				   <?php if($this->countModules('right')) : ?>
				             <div class="rightCol">
				               <jdoc:include type="modules" name="right" style="rounded" />
				             </div>
				       <?php endif; ?>
				   <?php else: ?>
				   <?php if($this->countModules('right')) : ?>
				             <div class="rightCol">
				               <jdoc:include type="modules" name="right" style="rounded" />
				             </div>
				       <?php endif; ?>
				   <?php endif; ?>
			   <!-- event_submit and photo upload End-->
				<?php if(JRequest::getVar('view') != 'reset'): ?>
					<?php if($_SESSION['partner_type']!="free") {?>
					  <!-- 300 x 100 Banner Ad Start -->
					<?php if($this->countModules('banner3')) : ?>
					  <div class="ad space">
					    <jdoc:include type="modules" name="banner3" style="rounded" />
					    </div>
					   <?php else: ?>
					   <img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Right_banner.png" />
					     <?php endif; ?>
					  <!-- 300 x 100 Banner Ad End -->
					<!-- TW Banner Ad start -->
					<?php }else { ?> 
					<div class="ad space">
					<div id='div-gpt-ad-1403199524717-1' style='width:300px; height:250px;'>
					<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1403199524717-1'); });
					</script>
					</div>
					</div>
					<?php } ?>
					<!-- TW Banner Ad End -->
					<?php endif; ?>

  	  </div>
		</div>
  	  <div class="cb"></div>
  	</div>
  </div>

  <!-- Content End -->

  <!-- Footer Start -->
<?php if(JRequest::getVar('view') != 'reset'): ?>
  <div id="Footer">
  	<div class="sWidth">
  	  <ul>
    	<?php if($this->countModules('footer1')) : ?>
        <li class="about">
          <div class="pad">
          	<h3 class="display"><?php echo JText::_("TW_ABOUT").' '.$var->site_name; ?></h3>
           	<jdoc:include type="modules" name="footer1" style="rounded" />
           </div>
         </li>
         <?php endif; ?>
         
         <?php if($this->countModules('footer3')) : ?>
			<li class="site" style="width: 26%;">
				<div class="pad">
					<h3 class="display"> <?php echo JText::_("TW_CONNECT_WITH").' '.$var->site_name ?></h3>
					<jdoc:include type="modules" name="footer3" style="rounded" />
				</div>
			</li>
         <?php endif; ?>
		 
		<?php if($this->countModules('footer2')) : ?>
			<li class="community">
				<div class="pad">
					<h3 class="display" style="float: left;margin-right:4px"><?php echo $var->site_name; ?>  -<span style="font-size: 10px;padding-left: 2px; display: inline;"><?php echo JText::_("TW_POWERED_BY") ?></span></h3>
					<a class="footer_tw" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><img alt="townwizard" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/twBanner.png" /></a>
					<!-- <jdoc:include type="modules" name="footer2" style="rounded" />-->
					<a style="margin-top: 24px; clear: both;" class="all" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><?php echo JText::_("TW_COMMUNITY") ?></a>
					<a class="all" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><?php echo JText::_("TW_WANT") ?></a>
				</div>
			</li>
		<?php endif; ?>
      </ul>
      <div class="footer_tag">
     		 <?php if($this->countModules('footer')) : ?>
            <div class="legal bold">
                   <jdoc:include type="modules" name="footer" style="rounded" />
            </div>
            <?php endif; ?>
        	<div class="twlogo bold">| &copy;&nbsp;<?PHP $time = time () ; $year= date("Y",$time); echo $year . "&nbsp;" . $var->site_name; ?></div>
        </div>
  	</div>
  </div>
<?php endif; ?>
  <!-- Footer End -->

<!-- Tooltip Overlay Start -->
	<div id="Darkness"></div>

	<div id="HelpTT" class="takeOverlay">
		<a class="close">x</a>
		<span>
	  		<?php echo JText::_("TW_TOOLTIP") ?><br /><br /><?php echo JText::_("TW_RSVP") ?>
	  		<div class="socialLinks cb">
	   			<a class="fbLogin fl" href="javascript:void(0)" onclick="fb_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
	   			<a class="twtLogin fl" href="javascript:void(0)" onclick="twitter_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
	  		</div>
		</span>
	</div>
<!-- Tooltip Overlay End -->

</body>
</html>
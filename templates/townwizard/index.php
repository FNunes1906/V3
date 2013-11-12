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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo $var->keywords; ?>" />
<meta name="description" content="<?php echo $var->metadesc; ?>" />
<meta name="description" content="<?php echo $var->extra_meta; ?>" />
<meta property="og:image" content="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png"/>

<!-- set css and js path for new design v3 -->

<meta name="viewport" content="width=device-width;initial-scale = 1.0,maximum-scale = 1.0" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/core.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/tablet.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/events.css" />

<!-- Add css for location image pop up -->
<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/jquery.fancybox.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/yetii-min.js"></script>
<script type="text/javascript" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/tw.js"></script>

<!-- Add jQuery library for location and Event detail image pop up -->

<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/css/pirobox/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']?>/templates/townwizard/css/jquery-ui.css" media="screen" />
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
 <script>
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


<script>
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

<script> 
jQuery(document).ready(function(){
  jQuery("#flip").click(function(){
    jQuery("#panel").slideToggle("slow");
  });
});
</script>

<!--  Town wizard Google Analytic code -->

<?php
$app = JFactory::getApplication();
if(JRequest::getVar('task') == 'icalrepeat.detail'){
	$this->setTitle( $var->site_name . ' | '. JText::_("TW_EVENT_DETAIL").' | '. $this->getTitle() . ' | ' . $var->page_title );
}else{
	$this->setTitle( $var->site_name . ' | ' . $this->getTitle() . ' | ' . $var->page_title );	
}
?>
<?php include("ga.php"); ?>

</head>

<body>
 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);	
}(document, 'script', 'facebook-jssdk'));</script>
  
 			  
 <!-- Top Bar Start -->
  <!--<div id="TopBar" style="background:url('<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/whitezig_zag.png') repeat-x scroll left bottom <?php echo $var->Header_color; ?>;height: 36px;">-->
  <div id="TopBar" style="background:url('<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/whitezig_zag.png') repeat-x scroll left 30px <?php echo $var->Header_color; ?>;height: 36px;">
  	<!--<div class="sWidth">
  	  <div class="fl powered"><?php echo JText::_("TW_POWERED_BY") ?><a href="http://www.townwizard.com/" target="_blank"><img alt="townwizard" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/twBanner.png" /></a></div>
		  <?php if($this->countModules('top')): ?>
          <div class="fr links">
            <jdoc:include type="modules" name="top" style="rounded" />
          </div>
          <?php endif; ?>
  	</div>-->
  </div>

  <!-- Top Bar End -->

  <!-- Content Start -->

  <div id="Content" class="sWidth">
  	
  	<!-- Header Start -->

	  	<div id="Header">
	  	  <div id="Logo" class="fl">
	  	  	<a href="<?php echo $this->baseurl ?>" title="HOME"> <img src="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png" height="118" width="192" /> </a>
	  	  </div>
	  	     <div class="headerAdFlex fl">
	  	  	  <div id="Social" class="fr">
	            <div>
					<!-- SOCIAL LOGIN START -->
					<?php if($_SESSION['tw_user_name']) { ?>
						<div id="LoggedIn" class="fl" style="font-size:11.5px; width:270px; text-align: right;">
							<img style="float:right;padding:0px;" src="<?php echo $_SESSION['tw_user_image_url']; ?>">
                			<span style="padding-right:60px; display: block;">Welcome to <?php echo $var->site_name.' '.$_SESSION['tw_user_name']; ?>!</span>
							<span><a style="padding-right:60px;"   class="logOut" href="javascript:void(0)" onclick="tw_logout();">Click here to sign out</a></span>
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
	  	  	  	<?php if($this->countModules('banner1')) : ?>
				<div class="bannerCont">
	  	  	      <!-- TOP BANNER AD -->
	  	  	    	 <jdoc:include type="modules" name="banner1" style="rounded" />
         		 </div>
				 <?php else: ?>
					 <img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/default_banner.png" />
				  <?php endif; ?>
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
						echo str_replace('N/A','--',$data[weather][cc][tmp]) . "&#176; ";
						echo " <a href='http://www.weather.com/weather/today/$var->location_code' target='_blank'><img  SRC='/common/images/weather/" . $data[weather][cc][icon] . ".png' height='25' border='0' style='vertical-align: middle;'></a>";
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

  		<!-- Header End -->

  	<div id="MainContent">
  	  
  	 <!-- Left Column Start -->

        <div id="LeftCol" class="fl">
		        <?php if($this->countModules('menu')) : ?>
                <div id="MainNav" class="display">
                  	<jdoc:include type="modules" name="menu" style="rounded" />
				</div>
				<?php endif; ?>
               
                <?php if($var->android != "" || $var->iphone != ""):?>
                <div id="SideMobile" class="sect">
                  <strong><?php echo JText::_("TW_MOBILE") ?>!</strong>
                  <?php if($var->iphone != ""):?>
                    <a href="<?php echo $var->iphone?>" target="_blank"><img alt="Download for the iPhone/iPad" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/iphoneAppBtn.png" /></a>
                  <?php endif;?>
                  
                  <?php if($var->android != ""):?>
                  <a href="<?php echo $var->android?>" target="_blank"><img alt="Download for Android" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/androidAppBtn.png" /></a>
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
                <?php endif; ?>
        </div>

  	  <!-- Left Column End -->

  	  <div id="WidgetArea">
		 <!-- Placeholder for Header Banner Ad in Vertical Layout Start -->

     	<div id="LowerBannerAd" class="bannerAd"></div>
		<?php if($this->countModules('FrontSlider')) : ?>
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
							
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
								
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
	  <?php if(JRequest::getVar('evid') != '' || JRequest::getVar('loc_id') != '') :?>
	  
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
				
		  	  	<!-- 300 x 100 Banner Ad Start -->
				<?php if($this->countModules('banner3')) : ?>
		  	  	<div class="ad space">
		  	  		 <jdoc:include type="modules" name="banner3" style="rounded" />
		        </div>
		       <?php endif; ?>

		  	  	<!-- 300 x 100 Banner Ad End -->

  	  </div>

		  	   <div class="adSect tall rightCol fr cr">

		            <!-- 300 x 600 Banner Ad Start -->
		    		<?php if($this->countModules('banner4')) : ?>
		            <div class="ad">
		              <jdoc:include type="modules" name="banner4" style="rounded" />
		            </div>
		           <?php endif; ?>
		    
		            <!-- 300 x 600 Banner Ad End -->

		  	  </div>
  	  
		</div>
  	  <div class="cb"></div>
  	</div>
  </div>

  <!-- Content End -->

  <!-- Footer Start -->

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
					<h3 class="display"> Connect with <?php echo $var->site_name ?></h3>
					<jdoc:include type="modules" name="footer3" style="rounded" />
				</div>
			</li>
         <?php endif; ?>
		 
		<?php if($this->countModules('footer2')) : ?>
			<li class="community">
				<div class="pad">
					<h3 class="display" style="float: left;margin-right:4px"><?php echo $var->site_name; ?>  -<span style="font-size: 10px;padding-left: 2px; display: inline;"><?php echo JText::_("TW_POWERED_BY") ?></span></h3>
					<a class="footer_tw" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><img alt="townwizard" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/twBanner.png" /></a></h3>
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
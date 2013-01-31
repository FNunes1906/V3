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

global $var;
//echo "<pre>";
//print_r($_SERVER);
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');

_init();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<title><?php echo $var->site_name.' | '.$var->page_title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo $var->keywords; ?>" />
<meta name="description" content="<?php echo $var->metadesc; ?>" />
<meta name="description" content="<?php echo $var->extra_meta; ?>" />

<!-- set css and js path for new design v3 -->

<meta name="viewport" content="width=device-width;initial-scale = 1.0,maximum-scale = 1.0" />
<link rel="stylesheet" type="text/css" href="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/css/core.css" />
<link rel="stylesheet" type="text/css" href="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/css/tablet.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/js/yetii-min.js"></script>
<script type="text/javascript" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/js/tw.js"></script>

<!-- End css and js path for new design v3 -->

<!-- use favicon icon for v2 -->
<link rel="shortcut icon" href="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/partner/<?php echo $_SESSION['partner_folder_name'];?>/images/favicon.ico" />

<!--  CODE for SAFARI BROWSER DETECTION BEGIN -->
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
	     } 
	     else if (navigator.userAgent.match(/android/i)) {
	     var r=confirm("We have an Android app too! Click OK to install the app.");
	     if (r==true){location.href="<?php echo $var->android?>";}
	 }else {}
	   }
	   // other code to run every time once page is loaded goes here
	}
	onload = start;

	</script>
<!--  CODE for SAFARI BROWSER DETECTION END -->

<!--  Town wizard Google Analytic code -->

</head>

<body>

 <!-- Top Bar Start -->
  <div id="TopBar" style="background:url('<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/images/header/whitezig_zag.png') repeat-x scroll left bottom <?php echo $var->Header_color; ?>;height: 50px;">
  	<div class="sWidth">
  	  <div class="fl powered">Powered by<img alt="townwizard" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name'];?>/images/header/twBanner.png" /></div>
		  <?php if($this->countModules('top')) : ?>
          <div class="fr links">
            <jdoc:include type="modules" name="top" style="rounded" />
          </div>
          <?php endif; ?>
  	</div>
  </div>

  <!-- Top Bar End -->

  <!-- Content Start -->

  <div id="Content" class="sWidth">
  	
  	<!-- Header Start -->

	  	<div id="Header">
	  	  <div id="Logo" class="fl">
	  	  	<a href="index.php" title="HOME"> <img src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png" height="118" width="192" /> </a>
	  	  </div>
	  	     <div class="headerAdFlex fl">
	  	  	  <div id="Social" class="fr">
	            <div>
	              <a href="#" onClick="fb_login(); return false;"><img alt="Login with Facebook" src="common/<?php echo $_SESSION['style_folder_name']?>/images/header/fbLoginBtn.png" /></a>
	              <a href="#"><img alt="Login with Twitter" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name']?>/images/header/twtLoginBtn.png" /></a>
	              <a href="#"><img alt="Help" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/common/<?php echo $_SESSION['style_folder_name']?>/images/header/helpBtn.png" /></a>
	            </div>
	          </div>
              <?php if($this->countModules('banner1')) : ?>
	          <div id="UpperBannerAd" class="bannerAd">
	  	  	  	<div class="bannerCont">
	  	  	      <!-- TOP BANNER AD -->
	  	  	    	 <jdoc:include type="modules" name="banner1" style="rounded" />
         		 </div>
	  	  	  </div>
              <?php endif; ?>
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
						echo " <a href='http://www.weather.com/weather/today/$var->location_code' target='_blank'><img  SRC='common/images/weather/" . $data[weather][cc][icon] . ".png' height='25' border='0' style='vertical-align: middle;'></a>";
					?>
					</div> 
	  	      	    <?php echo $var->beach; ?> 
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
               
                <div id="SideMobile" class="sect">
                  <h2>TownWizard Mobile!</h2>
                  <p>Click here to download Apps.</p>
                  <?php if($var->iphone && $var->iphone != ""):?>
                    <a href="<?php echo $var->iphone?>" target="_blank"><img alt="Download for the iPhone/iPad" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/sidebar/iphoneAppBtn.png" /></a>
                  <?php endif;?>
                  
                  <?php if($var->android && $var->android != ""):?>
                  <a href="<?php echo $var->android?>" target="_blank"><img alt="Download for Android" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/sidebar/androidAppBtn.png" /></a>
                  <?php endif;?>
                  
                </div>
                
                <div id="SideSocial" class="sect">
                  <h3 class="display">Follow Us</h3>
                  <a class="twitter" href="#" target="_blank"><img alt="Follow us on Twitter" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/sidebar/twtFollowBtn.png" /></a>
                  <a class="youtube" href="#" target="_blank"><img alt="Follow us on YouTube" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/sidebar/ytFollowBtn.png" /></a>
                </div>
                
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

      <!-- Event Rotator Start -->
		
	 <?php if($this->countModules('right')): ?>	
  	  <div id="Events" class="carousel fr">
	  <?php else: ?>
		<div id="Events" class="carousel fl">
		 <?php endif; ?>
  	  	 <?php
		  if ( JRequest::getVar('view') === 'range' AND JRequest::getVar('Itemid') === '97' ) {
		 	 if($this->countModules('slider')) : ?>
		          <div class="gallery centerCol fl">
		          	     <jdoc:include type="modules" name="slider" style="rounded" />
		                 <div class="cb"></div>
		           </div>
          <?php endif;} ?>
          <?php if($this->countModules('right')) : ?>
            <div class="galleryNav rightCol fr">
             	<jdoc:include type="modules" name="right" style="rounded" />
            </div>
            <?php endif; ?>
      </div>
     

  	  <!-- Event Rotator End -->
      
      <!-- Main body start -->
            <div class="centerCol fl">
            		<div id="Try3" class="sect">
                    	<div class="cont">
                             <jdoc:include type="message" />
                            
							 <jdoc:include type="component" />
							
                             <div class="cb"></div>
                         </div>
              	   </div>
             </div>
  	  <!-- Main body end -->	

  	 
  	  <div class="adSect rightCol fr">

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
          	<h3 class="display"><?php echo "About ".$var->site_name; ?></h3>
           	<jdoc:include type="modules" name="footer1" style="rounded" />
           </div>
         </li>
         <?php endif; ?>
         
         <?php if($this->countModules('footer2')) : ?>
        <li class="site">
          <div class="pad">
         		<h3 class="display"><?php echo $var->site_name." is a TownWizard Site" ?></h3>
                <span>Other TownWizard sites near this area include:</span>
           		<jdoc:include type="modules" name="footer2" style="rounded" />
                <a class="all" href="http://www.townwizard.com/locations/" target="_blank">See All Partner Sites &gt;</a>
           </div>
         </li>
         <?php endif; ?>
          <?php if($this->countModules('footer3')) : ?>
            <li class="community">
              <div class="pad">
                    <h3 class="display">TownWizard Brings Communities Alive</h3>
                    <jdoc:include type="modules" name="footer3" style="rounded" />
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
        	<div class="twlogo bold">| &copy;&nbsp;<?PHP $time = time () ; $year= date("Y",$time); echo $year . "&nbsp;" . $var->site_name; ?> TownWizard</div>
        </div>
  	</div>
  </div>

  <!-- Footer End -->

</body>
</html>
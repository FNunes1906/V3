<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// Remove auto generated mootool from header
$headerstuff = $this->getHeadData();
foreach( $headerstuff['scripts'] as $key => $value ) {
	if ($key =='/media/system/js/mootools.js') {
    	//echo $key;
		unset($headerstuff['scripts'][$key]);
	}
}
$this->setHeadData($headerstuff);

global $var;

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');

_init();
define("TOWNWIZARD_TMPL_PATH", "http://".$_SERVER['HTTP_HOST']."/templates/townwizard_responsive");
define("TOWNWIZARD_PARTNER_PATH", "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']);

include_once($_SERVER['DOCUMENT_ROOT'].'/townwizard-db-api/user-api.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<jdoc:include type="head" />
		<meta http-equiv="content-type" content="text/html; charset=<?php echo $var->characterset; ?>" />
		<meta name="keywords" content="<?php echo $var->keywords; ?>" />
		<meta name="description" content="<?php echo $var->metadesc; ?>" />
		<meta name="description" content="<?php echo $var->extra_meta; ?>" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
	
	
		<meta charset="utf-8">
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
		<link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/style.css" media="screen, projection">
		
<!-- Townwizard Ad banner for free product start -->
<?php if($_SESSION['partner_type']=="free") { ?>
<!--<script type='text/javascript'>
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
</script>-->

<!--<script type='text/javascript'>
	googletag.cmd.push(function() {
		googletag.defineSlot('/44090425/TownWizard-Left-180', [180, 150], 'div-gpt-ad-1403199524717-0').addService(googletag.pubads());
		googletag.defineSlot('/44090425/TownWizard-Right-300', [300, 250], 'div-gpt-ad-1403199524717-1').addService(googletag.pubads());
		googletag.defineSlot('/44090425/TownWizard-Top-468', [468, 60], 'div-gpt-ad-1403199524717-2').addService(googletag.pubads());
		googletag.pubads().enableSingleRequest();
		googletag.enableServices();
	});
</script>-->
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
<style>
	.right-side-testing-ad{width: 300px; height: 250px;}
	@media(max-width: 500px){.right-side-testing-ad{width: 180px; height: 150px;}}
	@media(max-width: 636px){.right-side-testing-ad{width: 200px; height: 200px;}}
	@media(max-width: 1023px){.right-side-testing-ad{width: 200px; height: 200px;}}
	.left-side-testing-ad {width: 180px; height: 150px;}
	@media(max-width: 600px){.left-side-testing-ad {width: 180px; height: 150px;}}
	@media(max-width: 800px){.left-side-testing-ad {width: 125px; height: 125px;}}
	.top-testing-ad {width:  468px; height: 60px;}
	@media(max-width: 600px){.top-testing-ad {width: 320px; height: 50px;}}
</style>
</head>

<body>
	<div id="fb-root"></div>
	<script type="text/javascript">(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);	
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div id="TopBar" style="background-color:<?php echo $var->Header_color; ?>;"></div>
		
	<div id="pageContent">
		<?php if(JRequest::getVar('view') != 'reset') {?>		
		<header id="mainHeader">
				<div id="mobNav">
				
		    <div id="mobileMenuBttn">
		<p>Menu <span class="indicator">+</span></p>
		    </div>
			<!-- SOCIAL LOGIN START -->
			<?php if(isset($_SESSION['tw_user_name'])) { ?>
			<ul id="loginBttns">
				<div id="LoggedIn" class="fl" style="font-size:11.5px; width:270px; text-align: right;">
				<img style="float:right;padding:0px;width:38px;" src="<?php echo $_SESSION['tw_user_image_url']; ?>">
				<span style="padding-right:60px; display: block;"><?php echo JText::_("TW_WELCOME").' '.$var->site_name.' '.$_SESSION['tw_user_name']; ?>!</span>
				<a style="padding-right:60px;"   class="logOut" href="javascript:void(0)" onclick="tw_logout();"><?php echo JText::_("TW_CLICKHERE_SIGHOUT") ?></a>
				<?php $user = $_SESSION['tw_user']; ?>                      				
				</div>	
			</ul>
			<?php }  else { ?>
		    <ul id="loginBttns">
				<li id="fbLogin"><a href="javascript:void(0)" onclick="fb_login();"><?php echo JText::_("TW_LOGIN_WITH") ?></a></li>
				<li id="twtLogin"><a href="javascript:void(0)" onclick="twitter_login();"><?php echo JText::_("TW_LOGIN_WITH") ?></a></li>
				<li id="helpBtn"><a class="helpBtn" style="cursor:pointer"><img src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/helpBtn.png" alt="Help"></a></li>
			</ul>
			<?php } ?>
			<?php if($this->countModules('search')) : ?>
			    <div class="searchbar">
			  	<jdoc:include type="modules" name="search" />
		        </div>
         	<?php endif; ?>	
			</div>
			
			
			<div id="siteLogo">
				<a href="<?php echo $this->baseurl ?>" title="HOME"> <img alt="Site logo" src="<?php echo TOWNWIZARD_PARTNER_PATH ?>/images/logo/logo.png"/> </a>
			</div>
			
			<?php echo '<h1 id="siteName" class="sitestitle"><a href="index.php">'.$var->site_name.'</a></h1>'; ?>
			<?php echo '<h1 id="siteName" class="siteslogan">'.$var->beach.'</h1>'; ?>
			<div id="weather">  				
				<?php
					if(isset($data['weather']['cc']['tmp'])){
						echo str_replace('N/A','--',$data['weather']['cc']['tmp']) . "&#176; ";
						echo " <a href='http://www.weather.com/weather/today/$var->location_code' target='_blank'><img alt='weather'  src='/common/images/weather/" . $data['weather']['cc']['icon'] . ".png' /></a>";
					}
				?>
			</div>
			<strong></strong>
		</header>				
				
				
			<div id="leftColumn">
			<nav id="mainNav">	
			<h2>Site Main Navigation</h2>
				<?php if($this->countModules('menu')) : ?>
				<jdoc:include type="modules" name="menu" />
				<?php endif; ?>
			</nav>
				
				<?php if($_SESSION['partner_type']!="free") {?>
                <?php if($var->android != "" || $var->iphone != ""):?>				
				<aside id="downloadApps">
					<h2><?php echo JText::_("TW_MOBILE") ?>!</h2>
					<ul>
						<?php if($var->iphone != ""):?>
						<li><a class="iphone_img" href="<?php echo $var->iphone?>" target="_blank">
							<span><?php echo JText::_("DOWNLOAD") ?></span>
							<b>Iphone/Ipad</b></a>
						</li>
						<?php endif;?>
					  <?php if($var->android != ""):?>
						<li><a class="android_img" href="<?php echo $var->android?>" target="_blank">
							<span><?php echo JText::_("DOWNLOAD") ?></span>
							<b>Android</b></a>
						  </li>
					  <?php endif;?>
					  </ul>
				</aside>
				<?php endif;?>
				<?php if($var->youtube != "" || $var->twitter != ""):?>				
				<aside id="downloadApps">
					<h2><?php echo JText::_("TW_FOLLOWUS") ?></h2>
					<ul>
						<?php if($var->twitter != ""):?>
						<li><a class="twitter" href="<?php echo $var->twitter ?>" target="_blank"><img alt="Follow us on Twitter" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/twtFollowBtn.png" /></a>
						</li>
                  <?php endif;?>
                  <?php if($var->youtube != ""):?>
						<li><a class="youtube" href="<?php echo $var->youtube ?>" target="_blank"><img alt="Follow us on YouTube" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/sidebar/ytFollowBtn.png" /></a>
						</li>
                  <?php endif;?>
						
					</ul>
				</aside>
				<?php endif;?>

				
				
				<?php if($this->countModules('banner2')) : ?>
				<aside id="leftBanners">
					 <jdoc:include type="modules" name="banner2" />
				</aside>
				<?php else: ?>
     				<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Left_banner.png" />
               <?php endif; ?>
			   <!-- TW Banner Ad start -->
			<?php } else { ?>
				<aside id="leftBanners">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Left Side Testing Ad -->
<ins class="adsbygoogle left-side-testing-ad"
     style="display:inline-block"
     data-ad-client="ca-pub-7206979589656043"
     data-ad-slot="3428266646"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
<?php if($this->countModules('banner2')) : ?>
	<jdoc:include type="modules" name="banner2" />
<?php else: ?>
	<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Left_banner.png" />
<?php endif; ?>
				</aside>
			<?php } ?>
			<!-- TW Banner Ad End -->
			</div>
			

			
		<?php if($this->countModules('FrontSlider') && (JRequest::getVar( 'view' )!='article')) : ?>
			<section id="topSlider" class="frontPage">
				<jdoc:include type="modules" name="FrontSlider" />
			</section><!--top Events Slider closing tag-->
		<?php endif; ?>
		
		<?php if(JRequest::getVar('task') != 'icalrepeat.detail'):?>
			<?php if($this->countModules('slider')) : ?>
				<section id="topSlider" class="otherPages">
					<jdoc:include type="modules" name="slider"/>
				</section><!--top Events Slider closing tag-->
			<?php endif; ?>		
		<?php endif; ?>	
		
		<?php if(JRequest::getVar('task') != 'locations.detail') : ?>
			<?php if($this->countModules('loc_slider')) : ?>
				<section id="topSlider" class="otherPages">
					<jdoc:include type="modules" name="loc_slider"/>
				</section><!--top Events Slider closing tag-->
			<?php endif; ?>		
		<?php endif; ?>	
		
	
		<div id="rightColumn">
			<!--Used for Sharethis module begin -->
			<?php if(JRequest::getVar('evid') != '' || JRequest::getVar('loc_id') != '' || JRequest::getVar( 'view' )=='article') :?>
				<?php if($this->countModules('ev_right')) : ?>
		            <aside id="topRightAside">
		             	<jdoc:include type="modules" name="ev_right" style="rounded" />
		            </aside>  
				<?php endif; ?>
			<?php endif; ?>		
			<!--Used for Sharethis module end --> 		
			<!-- event_submit and photo upload start-->
			
				<?php if($this->countModules('right')) : ?>
				<aside id="topRightAside">
					<jdoc:include type="modules" name="right" style="rounded" />
				</aside>   
				<?php endif; ?>
			

			<aside id="rightBanners">
			<?php if($_SESSION['partner_type']!="free") {?>
				<?php if($this->countModules('banner3')) : ?>
					<jdoc:include type="modules" name="banner3" />
				<?php else: ?>
					<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Right_banner.png" />
				<?php endif; ?>
			<!-- TW Banner Ad start -->
			<?php }else { ?> 
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Right Side Testing Ad -->
<ins class="adsbygoogle right-side-testing-ad"
     style="display:inline-block"
     data-ad-client="ca-pub-7206979589656043"
     data-ad-slot="9474800247"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
<?php if($this->countModules('banner3')) : ?>
	<jdoc:include type="modules" name="banner3" />
<?php else: ?>
	<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/Right_banner.png" />
<?php endif; ?>
			<?php } ?>
			<!-- TW Banner Ad End -->
			</aside>
		</div>
	
	
	<?php if(JRequest::getVar('task') != 'icalrepeat.detail'):?>
		<?php if($this->countModules('searchevent')) : ?>
			<nav id="eventsCategoriesSearch">
				<jdoc:include type="modules" name="searchevent" style="rounded" />
			</nav>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if(JRequest::getVar('task') != 'locations.detail') : ?>
		<?php if($this->countModules('searchres')) : ?>
			<nav id="eventsCategoriesSearch">
				<jdoc:include type="modules" name="searchres" />
			</nav>
		<?php endif; ?>
	<?php endif; ?>
	<?php } ?>
	<div id="middleColumn">
		<?php if(JRequest::getVar('view') != 'reset') {?>
		<div id="topBanner">
		<!-- TW Banner Ad start -->
	  	<?php if($_SESSION['partner_type']=="free") {?>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Top Testing Ad -->
				<ins class="adsbygoogle top-testing-ad"
				     style="display:inline-block"
				     data-ad-client="ca-pub-7206979589656043"
				     data-ad-slot="4904999847"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
		<!-- TW Banner Ad End -->
		<?php }else { ?>
			<?php if($this->countModules('banner1')) : ?>
				<jdoc:include type="modules" name="banner1" />
			<?php else: ?>
				<img alt="Default Banner" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/default_banner.png" />
			<?php endif; ?>
		<?php } ?>
		</div>
		<?php } ?>
		<?php if($this->countModules('FrontSlider') && (JRequest::getVar( 'view' )!='article')) : ?>
		<section id="mainContent">
		<?php else: ?>
		<section id="mainContentwhite">
		<?php endif; ?>
		
		<?php if ($this->getBuffer('message')) : ?> 
			<div id="Darkness" style="display: block"></div>
			<div id="systemmsg" class="takeOverlay">
				<a class="close">x</a>
				<span>
					<jdoc:include type="message" />
				</span>
			</div>
		<?php endif; ?>

			<jdoc:include type="component" />
		</section>
		
		<!-- Code for Location category count module begin -->
		<?php if($this->countModules('user1')) : ?>
		<aside id="cuisinePlacesType">
			<jdoc:include type="modules" name="user1" style="xhtml" />
		</aside>
		<?php endif; ?>
		<!-- Code for Location category count module end -->	
					
	</div><!--middle Column Closing Tag-->
    
		
	</div><!--page content cloasing tag-->
	<?php if(JRequest::getVar('view') != 'reset') {?>	
		<div id="pageFooterContainer">
		<footer id="pageFooter">
			<?php if($this->countModules('footer1')) : ?>
			<div id="about">
			<h2><?php echo JText::_("TW_ABOUT").' '.$var->site_name; ?></h2>
			<jdoc:include type="modules" name="footer1" />
           </div>
			<?php endif; ?>
			
			<?php if($this->countModules('footer3')) : ?>
			<div id="connect">
				<h3 class="display"> <?php echo JText::_("TW_CONNECT_WITH").' '.$var->site_name ?></h3>
				<jdoc:include type="modules" name="footer3" />
			</div>
			<?php endif; ?>
			
			<?php if($this->countModules('footer2')) : ?>
			<div id="poweredBy">
			<h3><?php echo $var->site_name; ?> - <span><?php echo JText::_("TW_POWERED_BY") ?></span>
				<a class="footer_tw" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><img alt="townwizard" src="<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/twBanner.png" /></a>
			</h3>
			<a style="margin-top: 24px; clear: both;" class="all" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><?php echo JText::_("TW_COMMUNITY") ?></a>
			<!-- <jdoc:include type="modules" name="footer2" />-->
			<a class="all" href="<?php echo $var->Footer_Menu_Link;?>" target="_blank"><?php echo JText::_("TW_WANT") ?></a>
			</div>
			<?php endif; ?>
			
			<?php if($this->countModules('footer')) : ?>
			<div id="termsOfUse">
			<h3><jdoc:include type="modules" name="footer"/></h3>
			<?php endif; ?> 
			
			</div>
			<span id="copyRight">&copy; <?PHP $time = time () ; $year= date("Y",$time); echo $year . "&nbsp;" . $var->site_name; ?> </span>
			</footer>	
		</div>
		<?php } ?>
<!-- Tooltip Overlay Start -->
	<div id="Darkness"></div>

	<div id="HelpTT" class="takeOverlay">
		<a class="close">x</a>
		<span>
	  		<?php echo JText::_("TW_TOOLTIP") ?><br /><br /><?php echo JText::_("TW_RSVP") ?>
	  		<div class="socialLinks cb">
	   			<a class="fbLogin" href="javascript:void(0)" onclick="fb_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
	   			<a class="twtLogin" href="javascript:void(0)" onclick="twitter_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
	  		</div>
		</span>
	</div>
<!-- Tooltip Overlay End -->

<!-- Share This -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
	stLight.options({
		publisher:'fe72f22e-436e-4b4e-9486-bbcb87276adc',
	});
</script>

<!-- Code for Print Icon begin -->
<script type="text/javascript">     
        function PrintDiv() {    
           var divToPrint = document.getElementById('placeContainer');
     if (divToPrint == null){ divToPrint = document.getElementById('eventContainer');}
           var popupWin = window.open('', 'My Event', 'width=550,height=450');
           popupWin.document.open();
           popupWin.document.write('<html><head><title>My Event</title><link rel="stylesheet" type="text/css" href="<?php echo TOWNWIZARD_TMPL_PATH ?>/css/print.css" /></head><body>' + '<input class="printBtn" type="button" value="" onclick="window.print();" /><div id="placeContainer">' + divToPrint.innerHTML +  '</div></html>');
            popupWin.document.close();
                }
</script>
<!-- Code for Print Icon end -->

<!-- Share This End-->
	<?php if(JRequest::getVar('view') != 'categories' AND JRequest::getVar('view') != 'category' AND JRequest::getVar( 'option' ) != 'com_jevents' AND JRequest::getVar('task') !='locations.detail' AND JRequest::getVar('Itemid') != 105) { ?>
  		<script src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/jQuery.js"></script>
 	<?php } ?>
	 <?php if(JRequest::getVar('Itemid') != 105){ ?>
	  <script src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/script.js"></script>
	 <?php }else{ ?>
	  <script src="<?php echo TOWNWIZARD_TMPL_PATH ?>/js/script2.js"></script>
	 <?php } ?>
 
	 
 
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
		
	</body>
</html>

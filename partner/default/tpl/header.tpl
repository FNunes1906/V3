<!-- Top Bar Start -->
  <div id="TopBar" style="background:url('common/<?php echo $_SESSION['style_folder_name'];?>/images/header/whitezig_zag.png') repeat-x scroll left bottom <?php echo $var->Header_color; ?>;height: 50px;">
  	<div class="sWidth">
  	  <div class="fl powered">Powered by<img alt="townwizard" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/header/twBanner.png" /></div>
  	  <div class="fr links">
  	  	
		<?php
			/**
			Purpose: Joomla menu code for header
			last Updated Date : 27-12-2012
			Global Variable: $_SESSION['topmenu'] (Joomla menu code)
			**/
			
			global $topmenu;
			echo $topmenu;
			
			?>
  	  </div>
  	</div>
  </div>

  <!-- Top Bar End -->
  
  <div id="Content" class="sWidth">
	<!-- Header Start -->

	  	<div id="Header">
	  	  <div id="Logo" class="fl">
	  	  	<a href="index.php" title="HOME"> <img src="./partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png" height="118" width="192" /> </a>
	  	  </div>
	  	     <div class="headerAdFlex fl">
	  	  	  <div id="Social" class="fr">
	            <div>
	              <a href="#" onclick="fb_login(); return false;"><img alt="Login with Facebook" src="common/<?php echo $_SESSION['style_folder_name']?>/images/header/fbLoginBtn.png" /></a>
	              <a href="#"><img alt="Login with Twitter" src="common/<?php echo $_SESSION['style_folder_name']?>/images/header/twtLoginBtn.png" /></a>
	              <a href="#"><img alt="Help" src="common/<?php echo $_SESSION['style_folder_name']?>/images/header/helpBtn.png" /></a>
	            </div>
	          </div>
	          <div id="UpperBannerAd" class="bannerAd">
	  	  	  	<div class="bannerCont">
	  	  	      <!-- TOP BANNER AD -->
	  	  	      <?php m_show_banner('Website Top 468x60'); ?>
	  	  	  	</div>
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
						echo " <a href='http://www.weather.com/weather/today/$var->location_code' target='_blank'><img  SRC='common/images/weather/" . $data[weather][cc][icon] . ".png' height='25' border='0' style='vertical-align: middle;'></a>";
					?>
					</div> 
	  	      	    <?php echo $var->beach; ?> 
	            </div>
	          </div>
	          <div class="search fr">
	  	  	    <form>
	  	  	  	  <input type="text" placeholder="Search..." />
	  	  	  	  <input type="submit" value="" class="searchBtn" />
	  	  	    </form>
	  	  	  </div>
	  	    </div>
	  	</div>

  		<!-- Header End -->
	</div>
	



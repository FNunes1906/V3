<!-- Left Column Start -->

<div id="LeftCol" class="fl">
  	  	<nav id="MainNav" class="display">
  	  	 	<?php
			/**
			Purpose: Joomla menu code for header
			last Updated Date : 27-12-2012
			Global Variable: $_SESSION['leftmenu'] (Joomla menu code)
			**/
			
			global $leftmenu;
			echo $leftmenu;
			
			?>
  	    </nav>
  	   
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
		
  	    <div id="SideAds" class="sect">
		
			<?php for($i=1;$i<=5;++$i):?>
					<div class="ad space">
		  	      		<?php m_show_banner("Website left $i"); ?>
					</div>
			<?php endfor; ?>
  	    </div>
</div>

  	  <!-- Left Column End -->

<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

	<h2><?php echo JText::_("TW_SHARETHIS") ?></h2>
	<ul class="shareThis">
		<li class='st_facebook_large' displayText='Facebook'><span class="share_font"><?php echo JText::_("TW_SHAREFB") ?></span></li>  
		<li class='st_googleplus_large' displayText='Google Plus'><span  class="share_font"><?php echo JText::_("TW_SHAREGOO") ?></span></li>			
		<li class='st_twitter_large' displayText='Tweet This'><span class="share_font"><?php echo JText::_("TW_SHARETW") ?></span></li>
		<li class='st_email_large' displayText='Email'><span class="share_font"><?php echo JText::_("TW_SHAREEMAIL") ?></span></li>
		<li class='st_tumblr_large' displayText='Tumblr'><span class="share_font"><?php echo JText::_("TW_SHARETUM") ?></span></li>	
	</ul>	
			<?php if(JRequest::getVar('evid') != '' || JRequest::getVar('loc_id') != '') : ?>
			
	<ul class="bottomShareThis">


			<?php if(JRequest::getVar('task') != 'locations.detail'):?>
				<li><a href="index.php?option=com_rsform&view=rsform&Itemid=117" class='wrongInfo'>
					
					<strong><?php echo JText::_("TW_EV_ERROR") ?></strong> 
					<?php echo JText::_("TW_EV_CON") ?>
				</a></li>
			<?php endif; ?>
				<li>
				<a href="#" onclick="PrintDiv();" class="print">
					<span>
						<?php echo JText::_("TW_PRINT") ?>
					</span>
				</a>   
</li> 				
			</ul>
			<?php endif; ?>
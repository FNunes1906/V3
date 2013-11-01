<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div id="ShareThis" class="neg sect">
	<div class="cont">
		<strong class="heading display fl"><?php echo JText::_("TW_SHARETHIS") ?></strong>
		<div id="ShareTool" class="cl">
			<div class="side fl">
				<div class='st_facebook_large' displayText='Facebook'><span class="share_font"><?php echo JText::_("TW_SHAREFB") ?></span></div>                
				<div class='st_twitter_large' displayText='Tweet This'><span class="share_font"><?php echo JText::_("TW_SHARETW") ?></span></div>
				<div class='st_tumblr_large' displayText='Tumblr'><span class="share_font"><?php echo JText::_("TW_SHARETUM") ?></span></div>
			</div>
			<div class="side fl">
				<div class='st_googleplus_large' displayText='Google Plus'><span  class="share_font"><?php echo JText::_("TW_SHAREGOO") ?></span></div>
				<div class='st_email_large' displayText='Email'><span class="share_font"><?php echo JText::_("TW_SHAREEMAIL") ?></span></div>
			</div>
			<div class="lower cl">
				<a href="index.php?option=com_rsform&view=rsform&Itemid=117" class='error_large'>
					<span class="errorBtn btn fl"></span>
					<span class="bold error"><?php echo JText::_("TW_EV_ERROR") ?></span> 
					<span class="hideSm error"><?php echo JText::_("TW_EV_CON") ?></span>
				</a>
				<div class="cl"></div>  
				<a href="#" onclick="PrintDiv();">
					<span class='print_large'>
						<span class="printBtn btn fl"></span>
						<?php echo JText::_("TW_PRINT") ?>
					</span>
				</a>    
			</div>
		</div>
	</div>
</div>
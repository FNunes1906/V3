<?php
/**
* @version		$Id: mod_quickicon.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
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

if (!defined( '_JOS_QUICKICON_MODULE' )){
	/** ensure that functions are declared only once */
	define( '_JOS_QUICKICON_MODULE', 1 );

	function quickiconButton( $link, $image, $text ){
		global $mainframe;
		$lang		=& JFactory::getLanguage();
		$template	= $mainframe->getTemplate();
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $link; ?>">
					<?php echo JHTML::_('image.site',  $image, '/templates/'. $template .'/images/header/', NULL, NULL, $text ); ?>
					<span><?php echo $text; ?></span></a>
			</div>
		</div>
		<?php } 
		function quickiconButtonhreftarget( $link, $image, $text ){
			global $mainframe;
			$lang  =& JFactory::getLanguage();
			$template = $mainframe->getTemplate();
			?>
			<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
			<a href="<?php echo $link; ?>" target="_blank">
			 <?php echo JHTML::_('image.site',  $image, '/templates/'. $template .'/images/header/', NULL, NULL, $text ); ?>
			 <span><?php echo $text; ?></span></a>
			</div>
			</div>
		<?php } ?>
		
	<div id="cpanel">
		<?php
		// Get the current JUser object
		$user = &JFactory::getUser();
		
		$link = 'index.php?option=com_frontpage';
		quickiconButton( $link, 'twIcon_home.png', JText::_( 'MANAGE HOME PAGE FEATURES' ) );
		
		$link = 'index.php?option=com_content&amp;task=add';
		quickiconButton( $link, 'twIcon_feature.png', JText::_( 'ADD NEW FEATURE' ) );

		if ( $user->get('gid') > 23 ) {
			
			$link = 'index.php?option=com_jevents&task=icalevent.list';
			quickiconButton( $link, 'twIcon_date.png', JText::_( 'MANAGE EVENTS' ) );
		
			$link = 'index.php?option=com_jevlocations&task=locations.overview';
			quickiconButton( $link, 'twIcon_location.png', JText::_( 'MANAGE LOCATIONS' ) );
		
			$link = 'index.php?option=com_phocagallery&view=phocagallerys';
			quickiconButton( $link, 'twIcon_photos.png', JText::_( 'MANAGE<br>IMAGES & VIDEOS' ) );
		
			$link = 'index.php?option=com_media&folder=banners';
			quickiconButton( $link, 'twIcon_bannerUpload.png', JText::_( 'UPLOAD AD BANNER' ) );

			$link = 'index.php?option=com_banners';
			quickiconButton( $link, 'twIcon_bannerAdd.png', JText::_( 'MANAGE  BANNERS' ) );
		
			$link = 'index.php?option=com_media';
			quickiconButton( $link, 'twIcon_media.png', JText::_( 'MEDIA MANAGER ' ) );
		
			$link = 'index.php?option=com_pagemeta';
			quickiconButton( $link, 'twIcon_meta.png', JText::_( 'SETTINGS ' ) );
			
			//if($_SESSION['partner_type']=="free") {
				$link = '/upgrade/upgrade_packages.php';
				quickiconButtonhreftarget( $link, 'twIcon_upgrade.png', JText::_( 'UPGRADE ' ) );
			//}
		}?>
	</div>
<?php }
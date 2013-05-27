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


if (!isset($this->error)) {
	$this->error = JError::raiseWarning( 403, JText::_('ALERTNOTAUTH') );
	$this->debug = false; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->code ?> - Requsted page not found</title>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error.css" type="text/css" />
	<?php if($this->direction == 'rtl') : ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/error_rtl.css" type="text/css" />
	<?php endif; ?>
</head>
<body>
	<div align="center">
	
		<div id="outline">
		<div id="errorboxoutline">
			<div id="errorboxheader">SORRY, THE PAGE YOU REQUESTED WAS NOT FOUND</div>
			<div id="errorboxbody">
			<p><strong><?php echo JText::_('Please try one of the following Steps:'); ?></strong></p>
			
			<p>
				<ul>
					<li><strong>Please check the URL for proper spelling.</strong></li>
					<p></p>
					<li><strong>If you're having trouble locating a destination on the site, try visiting the <a style="color:#9d0000"  href="<?php echo $this->baseurl; ?>/index.php">Home Page</a></strong></li>
				</ul>
			</p>
			
			</div>
			</div>
		</div>
		</div>
	</div>
</body>
</html>

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link href="templates/<?php echo $this->template ?>/css/login.css" rel="stylesheet" type="text/css" />

<?php  if($this->direction == 'rtl') : ?>
	<link href="templates/<?php echo $this->template ?>/css/login_rtl.css" rel="stylesheet" type="text/css" />
<?php  endif; ?>

<!--[if IE 7]>
<link href="templates/<?php echo  $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="templates/<?php echo  $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php  if($this->params->get('useRoundedCorners')) : ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->template ?>/css/rounded.css" />
<?php  else : ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->template ?>/css/norounded.css" />
<?php  endif; ?>

<script language="javascript" type="text/javascript">
	function setFocus() {
		document.login.username.select();
		document.login.username.focus();
	}
</script>
</head>
<body onload="javascript:setFocus()" class="vt_login_bg">
	<a href="http://www.townwizard.com" target="_blank"><img style="margin: 10px auto auto; display: block;" src="templates/vtemadmin/images/logo_red.png"></a>
	<div class="login">
				
				<h1><?php echo JText::_('Administration Login') ?></h1>
					<jdoc:include type="message" />
					<jdoc:include type="component" />
			<div class="clr"></div>
           <p>
						<a href="<?php echo JURI::root(); ?>"><?php echo JText::_('Return to site Home Page') ?></a>
			</p>		
	</div>
			<noscript>
				<?php echo JText::_('WARNJAVASCRIPT') ?>
			</noscript>
</body>
</html>

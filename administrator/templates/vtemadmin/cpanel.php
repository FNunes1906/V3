<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo  $this->language; ?>" lang="<?php echo  $this->language; ?>" dir="<?php echo  $this->direction; ?>" id="minwidth" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link href="templates/<?php echo  $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />
<?php if($this->direction == 'rtl') : ?>
	<link href="templates/<?php echo  $this->template ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<!--[if IE 7]>
<link href="templates/<?php echo  $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="templates/<?php echo  $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php if(JModuleHelper::isEnabled('menu')) : ?>
	<script type="text/javascript" src="templates/<?php echo  $this->template ?>/js/menu.js"></script>
	<script type="text/javascript" src="templates/<?php echo  $this->template ?>/js/index.js"></script>
<?php endif; ?>

</head>
<body id="minwidth-body" class="<?php echo $this->params->get('headerColor','green');?>">
	<div id="header-box">
	 <div id="vt_logo"><a href="index.php"><img src="templates/<?php echo  $this->template ?>/images/logo_<?php echo $this->params->get('headerColor','green');?>.png" /></a></div>
	 <div id="vt_main_header">
	   <div id="vt_main_sitename_status">
	    <div id="vt_sitename"><span class="title" style="color:#fff;"><?php echo $this->params->get('showSiteName') ? $mainframe->getCfg( 'sitename' ) : JText::_('Administration'); ?></span></div>
		<div id="module-status">
			<jdoc:include type="modules" name="status"  />
		</div>
		<div class="clr"></div>
		</div>
		<div id="module-menu">
			<jdoc:include type="modules" name="menu" />
			<!--<span class="version"><?php echo  JText::_('Version') ?> <?php echo  JVERSION; ?></span>-->
		</div>
		<div class="clr"></div>
	  </div>
	  <div class="clr"></div>
	</div>
	<jdoc:include type="message" />
	<table class="vt_cpanel" cellspacing="10">
		<tr>
			<td width="55%" valign="top" align="right">
			  <div id="vt_icon">
				<jdoc:include type="modules" name="icon" />
				<div style="clear:both"></div>
			  </div>
			</td>
			<td width="45%" valign="top" align="left">
			  <div id="vt_main">
				<jdoc:include type="component" />
			  </div>
			</td>
		</tr>
	</table>

	<noscript>
	<?php //echo  JText::_('WARNJAVASCRIPT') ?>
	</noscript>
	<div class="vt_space"></div>
	<!--<div id="footer">
		<p class="copyright">
			<a href="http://www.joomla.org" target="_blank">Joomla!</a>
			<?php //echo  JText::_('ISFREESOFTWARE') ?>
		</p>
	</div>-->
</body>
</html>

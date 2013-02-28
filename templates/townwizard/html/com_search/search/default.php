<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php if ( $this->params->get( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo JText::_("TW_RES");?>
</div>
<div class="your"><?php echo "<br/>".JText::_("TW_YOUR");?></div>
<?php endif; ?>

<?php echo $this->loadTemplate('form'); ?>

<?php if(!$this->error && count($this->results) > 0) :
	echo $this->loadTemplate('results');
else : ?>
	<h3 style="clear: both;padding-top: 20px;"><?php echo JText::_("LOC_RES");?></h3>
<?php endif; ?>

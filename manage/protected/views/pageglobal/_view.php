<?php
/* @var $this PageglobalController */
/* @var $data Pageglobal */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_name')); ?>:</b>
	<?php echo CHtml::encode($data->site_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('googgle_map_api_keys')); ?>:</b>
	<?php echo CHtml::encode($data->googgle_map_api_keys); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_code')); ?>:</b>
	<?php echo CHtml::encode($data->location_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('beach')); ?>:</b>
	<?php echo CHtml::encode($data->beach); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo_mini_slider_cat')); ?>:</b>
	<?php echo CHtml::encode($data->photo_mini_slider_cat); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('photo_upload_cat')); ?>:</b>
	<?php echo CHtml::encode($data->photo_upload_cat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($data->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iphone')); ?>:</b>
	<?php echo CHtml::encode($data->iphone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('android')); ?>:</b>
	<?php echo CHtml::encode($data->android); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Header_color')); ?>:</b>
	<?php echo CHtml::encode($data->Header_color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Footer_Menu_Link')); ?>:</b>
	<?php echo CHtml::encode($data->Footer_Menu_Link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('distance_unit')); ?>:</b>
	<?php echo CHtml::encode($data->distance_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weather_unit')); ?>:</b>
	<?php echo CHtml::encode($data->weather_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($data->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('youtube')); ?>:</b>
	<?php echo CHtml::encode($data->youtube); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_zone')); ?>:</b>
	<?php echo CHtml::encode($data->time_zone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_format')); ?>:</b>
	<?php echo CHtml::encode($data->date_format); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_format')); ?>:</b>
	<?php echo CHtml::encode($data->time_format); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('homeslidercat')); ?>:</b>
	<?php echo CHtml::encode($data->homeslidercat); ?>
	<br />

	*/ ?>

</div>
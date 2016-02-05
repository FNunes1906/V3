<?php
/* @var $this BannersController */
/* @var $data Banners */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bid), array('view', 'id'=>$data->bid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cid')); ?>:</b>
	<?php echo CHtml::encode($data->cid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imptotal')); ?>:</b>
	<?php echo CHtml::encode($data->imptotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('impmade')); ?>:</b>
	<?php echo CHtml::encode($data->impmade); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('clicks')); ?>:</b>
	<?php echo CHtml::encode($data->clicks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageurl')); ?>:</b>
	<?php echo CHtml::encode($data->imageurl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clickurl')); ?>:</b>
	<?php echo CHtml::encode($data->clickurl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('showBanner')); ?>:</b>
	<?php echo CHtml::encode($data->showBanner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out_time')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editor')); ?>:</b>
	<?php echo CHtml::encode($data->editor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custombannercode')); ?>:</b>
	<?php echo CHtml::encode($data->custombannercode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid')); ?>:</b>
	<?php echo CHtml::encode($data->catid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sticky')); ?>:</b>
	<?php echo CHtml::encode($data->sticky); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish_up')); ?>:</b>
	<?php echo CHtml::encode($data->publish_up); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish_down')); ?>:</b>
	<?php echo CHtml::encode($data->publish_down); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php echo CHtml::encode($data->tags); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	*/ ?>

</div>
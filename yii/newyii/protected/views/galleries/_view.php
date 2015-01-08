<?php
/* @var $this GalleriesController */
/* @var $data Galleries */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid')); ?>:</b>
	<?php echo CHtml::encode($data->catid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sid')); ?>:</b>
	<?php echo CHtml::encode($data->sid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hits')); ?>:</b>
	<?php echo CHtml::encode($data->hits); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitude')); ?>:</b>
	<?php echo CHtml::encode($data->latitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitude')); ?>:</b>
	<?php echo CHtml::encode($data->longitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zoom')); ?>:</b>
	<?php echo CHtml::encode($data->zoom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('geotitle')); ?>:</b>
	<?php echo CHtml::encode($data->geotitle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('videocode')); ?>:</b>
	<?php echo CHtml::encode($data->videocode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vmproductid')); ?>:</b>
	<?php echo CHtml::encode($data->vmproductid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imgorigsize')); ?>:</b>
	<?php echo CHtml::encode($data->imgorigsize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved')); ?>:</b>
	<?php echo CHtml::encode($data->approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out_time')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metakey')); ?>:</b>
	<?php echo CHtml::encode($data->metakey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadesc')); ?>:</b>
	<?php echo CHtml::encode($data->metadesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extlink1')); ?>:</b>
	<?php echo CHtml::encode($data->extlink1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extlink2')); ?>:</b>
	<?php echo CHtml::encode($data->extlink2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extid')); ?>:</b>
	<?php echo CHtml::encode($data->extid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extl')); ?>:</b>
	<?php echo CHtml::encode($data->extl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extm')); ?>:</b>
	<?php echo CHtml::encode($data->extm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exts')); ?>:</b>
	<?php echo CHtml::encode($data->exts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exto')); ?>:</b>
	<?php echo CHtml::encode($data->exto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extw')); ?>:</b>
	<?php echo CHtml::encode($data->extw); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exth')); ?>:</b>
	<?php echo CHtml::encode($data->exth); ?>
	<br />

	*/ ?>

</div>
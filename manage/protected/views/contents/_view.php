<?php
/* @var $this ContentsController */
/* @var $data Contents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_alias')); ?>:</b>
	<?php echo CHtml::encode($data->title_alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('introtext')); ?>:</b>
	<?php echo CHtml::encode($data->introtext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fulltext')); ?>:</b>
	<?php echo CHtml::encode($data->fulltext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sectionid')); ?>:</b>
	<?php echo CHtml::encode($data->sectionid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mask')); ?>:</b>
	<?php echo CHtml::encode($data->mask); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid')); ?>:</b>
	<?php echo CHtml::encode($data->catid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by_alias')); ?>:</b>
	<?php echo CHtml::encode($data->created_by_alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out_time')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish_up')); ?>:</b>
	<?php echo CHtml::encode($data->publish_up); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish_down')); ?>:</b>
	<?php echo CHtml::encode($data->publish_down); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('images')); ?>:</b>
	<?php echo CHtml::encode($data->images); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('urls')); ?>:</b>
	<?php echo CHtml::encode($data->urls); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribs')); ?>:</b>
	<?php echo CHtml::encode($data->attribs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('version')); ?>:</b>
	<?php echo CHtml::encode($data->version); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentid')); ?>:</b>
	<?php echo CHtml::encode($data->parentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metakey')); ?>:</b>
	<?php echo CHtml::encode($data->metakey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadesc')); ?>:</b>
	<?php echo CHtml::encode($data->metadesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access')); ?>:</b>
	<?php echo CHtml::encode($data->access); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hits')); ?>:</b>
	<?php echo CHtml::encode($data->hits); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadata')); ?>:</b>
	<?php echo CHtml::encode($data->metadata); ?>
	<br />

	*/ ?>

</div>
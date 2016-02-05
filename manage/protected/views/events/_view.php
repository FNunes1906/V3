<?php
/* @var $this EventsController */
/* @var $data Events */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ev_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ev_id), array('view', 'id'=>$data->ev_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('icsid')); ?>:</b>
	<?php echo CHtml::encode($data->icsid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid')); ?>:</b>
	<?php echo CHtml::encode($data->catid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refreshed')); ?>:</b>
	<?php echo CHtml::encode($data->refreshed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by_alias')); ?>:</b>
	<?php echo CHtml::encode($data->created_by_alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rawdata')); ?>:</b>
	<?php echo CHtml::encode($data->rawdata); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recurrence_id')); ?>:</b>
	<?php echo CHtml::encode($data->recurrence_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access')); ?>:</b>
	<?php echo CHtml::encode($data->access); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockevent')); ?>:</b>
	<?php echo CHtml::encode($data->lockevent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_notified')); ?>:</b>
	<?php echo CHtml::encode($data->author_notified); ?>
	<br />

	*/ ?>

</div>
<?php
/* @var $this EventsDetailController */
/* @var $data EventsDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('evdet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->evdet_id), array('view', 'id'=>$data->evdet_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rawdata')); ?>:</b>
	<?php echo CHtml::encode($data->rawdata); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtstart')); ?>:</b>
	<?php echo CHtml::encode($data->dtstart); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtstartraw')); ?>:</b>
	<?php echo CHtml::encode($data->dtstartraw); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('durationraw')); ?>:</b>
	<?php echo CHtml::encode($data->durationraw); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtend')); ?>:</b>
	<?php echo CHtml::encode($data->dtend); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('dtendraw')); ?>:</b>
	<?php echo CHtml::encode($data->dtendraw); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtstamp')); ?>:</b>
	<?php echo CHtml::encode($data->dtstamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class')); ?>:</b>
	<?php echo CHtml::encode($data->class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categories')); ?>:</b>
	<?php echo CHtml::encode($data->categories); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('geolon')); ?>:</b>
	<?php echo CHtml::encode($data->geolon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('geolat')); ?>:</b>
	<?php echo CHtml::encode($data->geolat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priority')); ?>:</b>
	<?php echo CHtml::encode($data->priority); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('summary')); ?>:</b>
	<?php echo CHtml::encode($data->summary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact')); ?>:</b>
	<?php echo CHtml::encode($data->contact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organizer')); ?>:</b>
	<?php echo CHtml::encode($data->organizer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extra_info')); ?>:</b>
	<?php echo CHtml::encode($data->extra_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sequence')); ?>:</b>
	<?php echo CHtml::encode($data->sequence); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multiday')); ?>:</b>
	<?php echo CHtml::encode($data->multiday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hits')); ?>:</b>
	<?php echo CHtml::encode($data->hits); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('noendtime')); ?>:</b>
	<?php echo CHtml::encode($data->noendtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	*/ ?>

</div>
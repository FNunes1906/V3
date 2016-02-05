<?php
/* @var $this LocationsController */
/* @var $data Locations */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loc_id), array('view', 'id'=>$data->loc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('postcode')); ?>:</b>
	<?php echo CHtml::encode($data->postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('geozoom')); ?>:</b>
	<?php echo CHtml::encode($data->geozoom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcode_id')); ?>:</b>
	<?php echo CHtml::encode($data->pcode_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loccat')); ?>:</b>
	<?php echo CHtml::encode($data->loccat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid_list')); ?>:</b>
	<?php echo CHtml::encode($data->catid_list); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catid')); ?>:</b>
	<?php echo CHtml::encode($data->catid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('global')); ?>:</b>
	<?php echo CHtml::encode($data->global); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priority')); ?>:</b>
	<?php echo CHtml::encode($data->priority); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access')); ?>:</b>
	<?php echo CHtml::encode($data->access); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out_time')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anonname')); ?>:</b>
	<?php echo CHtml::encode($data->anonname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anonemail')); ?>:</b>
	<?php echo CHtml::encode($data->anonemail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imagetitle')); ?>:</b>
	<?php echo CHtml::encode($data->imagetitle); ?>
	<br />

	*/ ?>

</div>
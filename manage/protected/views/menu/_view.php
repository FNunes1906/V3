<?php
/* @var $this MenuController */
/* @var $data Menu */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menutype')); ?>:</b>
	<?php echo CHtml::encode($data->menutype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
	<?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('componentid')); ?>:</b>
	<?php echo CHtml::encode($data->componentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sublevel')); ?>:</b>
	<?php echo CHtml::encode($data->sublevel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_out_time')); ?>:</b>
	<?php echo CHtml::encode($data->checked_out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pollid')); ?>:</b>
	<?php echo CHtml::encode($data->pollid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('browserNav')); ?>:</b>
	<?php echo CHtml::encode($data->browserNav); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access')); ?>:</b>
	<?php echo CHtml::encode($data->access); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utaccess')); ?>:</b>
	<?php echo CHtml::encode($data->utaccess); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lft')); ?>:</b>
	<?php echo CHtml::encode($data->lft); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rgt')); ?>:</b>
	<?php echo CHtml::encode($data->rgt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('home')); ?>:</b>
	<?php echo CHtml::encode($data->home); ?>
	<br />

	*/ ?>

</div>
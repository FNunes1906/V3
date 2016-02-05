<?php
/* @var $this ComponentsController */
/* @var $data Components */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menuid')); ?>:</b>
	<?php echo CHtml::encode($data->menuid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
	<?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_menu_link')); ?>:</b>
	<?php echo CHtml::encode($data->admin_menu_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_menu_alt')); ?>:</b>
	<?php echo CHtml::encode($data->admin_menu_alt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('option')); ?>:</b>
	<?php echo CHtml::encode($data->option); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_menu_img')); ?>:</b>
	<?php echo CHtml::encode($data->admin_menu_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iscore')); ?>:</b>
	<?php echo CHtml::encode($data->iscore); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enabled')); ?>:</b>
	<?php echo CHtml::encode($data->enabled); ?>
	<br />

	*/ ?>

</div>
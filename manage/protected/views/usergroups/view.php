<?php
/* @var $this UsergroupsController */
/* @var $model Usergroups */

$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Usergroups', 'url'=>array('index')),
	array('label'=>'Create Usergroups', 'url'=>array('create')),
	array('label'=>'Update Usergroups', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Usergroups', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Usergroups', 'url'=>array('admin')),
);
?>

<h1>View Usergroups #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'name',
		'lft',
		'rgt',
		'value',
	),
)); ?>

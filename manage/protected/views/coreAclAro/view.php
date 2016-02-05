<?php
/* @var $this CoreAclAroController */
/* @var $model CoreAclAro */

$this->breadcrumbs=array(
	'Core Acl Aros'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CoreAclAro', 'url'=>array('index')),
	array('label'=>'Create CoreAclAro', 'url'=>array('create')),
	array('label'=>'Update CoreAclAro', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoreAclAro', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoreAclAro', 'url'=>array('admin')),
);
?>

<h1>View CoreAclAro #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'section_value',
		'value',
		'order_value',
		'name',
		'hidden',
	),
)); ?>

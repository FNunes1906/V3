<?php
/* @var $this BannerclientController */
/* @var $model Bannerclient */

$this->breadcrumbs=array(
	'Bannerclients'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Bannerclient', 'url'=>array('index')),
	array('label'=>'Create Bannerclient', 'url'=>array('create')),
	array('label'=>'Update Bannerclient', 'url'=>array('update', 'id'=>$model->cid)),
	array('label'=>'Delete Bannerclient', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bannerclient', 'url'=>array('admin')),
);
?>

<h1>View Bannerclient #<?php echo $model->cid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cid',
		'name',
		'contact',
		'email',
		'extrainfo',
		'checked_out',
		'checked_out_time',
		'editor',
	),
)); ?>

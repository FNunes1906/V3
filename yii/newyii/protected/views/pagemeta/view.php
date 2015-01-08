<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Pagemetas'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Pagemeta', 'url'=>array('index')),
	array('label'=>'Create Pagemeta', 'url'=>array('create')),
	array('label'=>'Update Pagemeta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pagemeta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pagemeta', 'url'=>array('admin')),
);
?>

<h1>View Pagemeta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'uri',
		'title',
		'metadesc',
		'keywords',
		'extra_meta',
	),
)); ?>

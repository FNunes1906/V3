<?php
/* @var $this FrontpageController */
/* @var $model Frontpage */

$this->breadcrumbs=array(
	'Frontpages'=>array('index'),
	$model->content_id,
);

$this->menu=array(
	array('label'=>'List Frontpage', 'url'=>array('index')),
	array('label'=>'Create Frontpage', 'url'=>array('create')),
	array('label'=>'Update Frontpage', 'url'=>array('update', 'id'=>$model->content_id)),
	array('label'=>'Delete Frontpage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->content_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Frontpage', 'url'=>array('admin')),
);
?>

<h1>View Frontpage #<?php echo $model->content_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content_id',
		'ordering',
	),
)); ?>

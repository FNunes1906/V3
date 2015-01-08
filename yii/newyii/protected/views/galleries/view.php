<?php
/* @var $this GalleriesController */
/* @var $model Galleries */

$this->breadcrumbs=array(
	'Galleries'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Galleries', 'url'=>array('index')),
	array('label'=>'Create Galleries', 'url'=>array('create')),
	array('label'=>'Update Galleries', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Galleries', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Galleries', 'url'=>array('admin')),
);
?>

<h1>View Galleries #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'catid',
		'sid',
		'title',
		'alias',
		'filename',
		'description',
		'date',
		'hits',
		'latitude',
		'longitude',
		'zoom',
		'geotitle',
		'videocode',
		'vmproductid',
		'imgorigsize',
		'published',
		'approved',
		'checked_out',
		'checked_out_time',
		'ordering',
		'params',
		'metakey',
		'metadesc',
		'extlink1',
		'extlink2',
		'extid',
		'extl',
		'extm',
		'exts',
		'exto',
		'extw',
		'exth',
	),
)); ?>

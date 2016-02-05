<?php
/* @var $this BannersController */
/* @var $model Banners */

$this->breadcrumbs=array(
	'Banners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Banners', 'url'=>array('index')),
	array('label'=>'Create Banners', 'url'=>array('create')),
	array('label'=>'Update Banners', 'url'=>array('update', 'id'=>$model->bid)),
	array('label'=>'Delete Banners', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->bid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Banners', 'url'=>array('admin')),
);
?>

<h1>View Banners #<?php echo $model->bid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bid',
		'cid',
		'type',
		'name',
		'alias',
		'imptotal',
		'impmade',
		'clicks',
		'imageurl',
		'clickurl',
		'date',
		'showBanner',
		'checked_out',
		'checked_out_time',
		'editor',
		'custombannercode',
		'catid',
		'description',
		'sticky',
		'ordering',
		'publish_up',
		'publish_down',
		'tags',
		'params',
	),
)); ?>

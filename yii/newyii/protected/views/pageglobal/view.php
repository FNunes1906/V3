<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */

$this->breadcrumbs=array(
	'Pageglobals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pageglobal', 'url'=>array('index')),
	array('label'=>'Create Pageglobal', 'url'=>array('create')),
	array('label'=>'Update Pageglobal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pageglobal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pageglobal', 'url'=>array('admin')),
);
?>

<h1>View Pageglobal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'site_name',
		'email',
		'googgle_map_api_keys',
		'location_code',
		'beach',
		'photo_mini_slider_cat',
		'photo_upload_cat',
		'facebook',
		'iphone',
		'android',
		'Header_color',
		'Footer_Menu_Link',
		'distance_unit',
		'weather_unit',
		'twitter',
		'youtube',
		'time_zone',
		'date_format',
		'time_format',
		'homeslidercat',
	),
)); ?>

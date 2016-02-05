<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Locations', 'url'=>array('index')),
	array('label'=>'Create Locations', 'url'=>array('create')),
	array('label'=>'Update Locations', 'url'=>array('update', 'id'=>$model->loc_id)),
	array('label'=>'Delete Locations', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->loc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Locations', 'url'=>array('admin')),
);
?>

<h1>View Locations #<?php echo $model->loc_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'loc_id',
		'title',
		'alias',
		'street',
		'postcode',
		'city',
		'state',
		'country',
		'description',
		'geolon',
		'geolat',
		'geozoom',
		'pcode_id',
		'image',
		'phone',
		'url',
		'loccat',
		'catid_list',
		'catid',
		'global',
		'priority',
		'ordering',
		'access',
		'published',
		'created',
		'created_by',
		'created_by_alias',
		'modified_by',
		'checked_out',
		'checked_out_time',
		'params',
		'anonname',
		'anonemail',
		'imagetitle',
	),
)); ?>

<?php
/* @var $this PhocaCategoriesController */
/* @var $model PhocaCategories */

$this->breadcrumbs=array(
	'Phoca Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PhocaCategories', 'url'=>array('index')),
	array('label'=>'Create PhocaCategories', 'url'=>array('create')),
	array('label'=>'Update PhocaCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PhocaCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PhocaCategories', 'url'=>array('admin')),
);
?>

<h1>View PhocaCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'owner_id',
		'title',
		'name',
		'alias',
		'image',
		'section',
		'image_position',
		'description',
		'date',
		'published',
		'approved',
		'checked_out',
		'checked_out_time',
		'editor',
		'ordering',
		'access',
		'count',
		'hits',
		'accessuserid',
		'uploaduserid',
		'deleteuserid',
		'userfolder',
		'latitude',
		'longitude',
		'zoom',
		'geotitle',
		'extid',
		'exta',
		'extu',
		'params',
		'metakey',
		'metadesc',
	),
)); ?>

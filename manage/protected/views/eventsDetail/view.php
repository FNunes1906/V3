<?php
/* @var $this EventsDetailController */
/* @var $model EventsDetail */

$this->breadcrumbs=array(
	'Events Details'=>array('index'),
	$model->evdet_id,
);

$this->menu=array(
	array('label'=>'List EventsDetail', 'url'=>array('index')),
	array('label'=>'Create EventsDetail', 'url'=>array('create')),
	array('label'=>'Update EventsDetail', 'url'=>array('update', 'id'=>$model->evdet_id)),
	array('label'=>'Delete EventsDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->evdet_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventsDetail', 'url'=>array('admin')),
);
?>

<h1>View EventsDetail #<?php echo $model->evdet_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'evdet_id',
		'rawdata',
		'dtstart',
		'dtstartraw',
		'duration',
		'durationraw',
		'dtend',
		'dtendraw',
		'dtstamp',
		'class',
		'categories',
		'color',
		'description',
		'geolon',
		'geolat',
		'location',
		'priority',
		'status',
		'summary',
		'contact',
		'organizer',
		'url',
		'extra_info',
		'created',
		'sequence',
		'state',
		'multiday',
		'hits',
		'noendtime',
		'modified',
	),
)); ?>

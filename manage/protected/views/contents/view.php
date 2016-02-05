<?php
/* @var $this ContentsController */
/* @var $model Contents */

$this->breadcrumbs=array(
	'Contents'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Contents', 'url'=>array('index')),
	array('label'=>'Create Contents', 'url'=>array('create')),
	array('label'=>'Update Contents', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Contents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contents', 'url'=>array('admin')),
);
?>

<h1>View Contents #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'alias',
		'title_alias',
		'introtext',
		'fulltext',
		'state',
		'sectionid',
		'mask',
		'catid',
		'created',
		'created_by',
		'created_by_alias',
		'modified',
		'modified_by',
		'checked_out',
		'checked_out_time',
		'publish_up',
		'publish_down',
		'images',
		'urls',
		'attribs',
		'version',
		'parentid',
		'ordering',
		'metakey',
		'metadesc',
		'access',
		'hits',
		'metadata',
	),
)); ?>

<?php
/* @var $this PhocaCategoriesController */
/* @var $model PhocaCategories */

$this->breadcrumbs=array(
	'Phoca Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PhocaCategories', 'url'=>array('index')),
	array('label'=>'Create PhocaCategories', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#phoca-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Phoca Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'phoca-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'parent_id',
		'owner_id',
		'title',
		'name',
		'alias',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

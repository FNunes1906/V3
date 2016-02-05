<?php
/* @var $this SectionsController */
/* @var $model Sections */

$this->breadcrumbs=array(
	'Sections'=>array('index'),
	'Manage',
);

?>

<h1>Manage Sections</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sections-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'name',
		'alias',
		'image',
		'scope',
		/*
		'image_position',
		'description',
		'published',
		'checked_out',
		'checked_out_time',
		'ordering',
		'access',
		'count',
		'params',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this GalleriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Galleries',
);

$this->menu=array(
	array('label'=>'Create Galleries', 'url'=>array('create')),
	array('label'=>'Manage Galleries', 'url'=>array('admin')),
);
?>

<h1>Galleries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

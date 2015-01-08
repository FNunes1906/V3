<?php
/* @var $this PageglobalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pageglobals',
);

$this->menu=array(
	array('label'=>'Create Pageglobal', 'url'=>array('create')),
	array('label'=>'Manage Pageglobal', 'url'=>array('admin')),
);
?>

<h1>Pageglobals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

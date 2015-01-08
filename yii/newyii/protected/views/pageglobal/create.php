<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */

$this->breadcrumbs=array(
	'Pageglobals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pageglobal', 'url'=>array('index')),
	array('label'=>'Manage Pageglobal', 'url'=>array('admin')),
);
?>

<h1>Create Pageglobal</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
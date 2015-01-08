<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Pagemetas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pagemeta', 'url'=>array('index')),
	array('label'=>'Manage Pagemeta', 'url'=>array('admin')),
);
?>

<h1>Create Pagemeta</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
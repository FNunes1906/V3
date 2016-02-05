<?php
/* @var $this ComponentsController */
/* @var $model Components */

$this->breadcrumbs=array(
	'Components'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Components', 'url'=>array('index')),
	array('label'=>'Manage Components', 'url'=>array('admin')),
);
?>

<h1>Create Components</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
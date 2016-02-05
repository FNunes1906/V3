<?php
/* @var $this BannerclientController */
/* @var $model Bannerclient */

$this->breadcrumbs=array(
	'Bannerclients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bannerclient', 'url'=>array('index')),
	array('label'=>'Manage Bannerclient', 'url'=>array('admin')),
);
?>

<h1>Create Bannerclient</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
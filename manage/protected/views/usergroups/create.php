<?php
/* @var $this UsergroupsController */
/* @var $model Usergroups */

$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Usergroups', 'url'=>array('index')),
	array('label'=>'Manage Usergroups', 'url'=>array('admin')),
);
?>

<h1>Create Usergroups</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
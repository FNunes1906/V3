<?php
/* @var $this UsergroupsController */
/* @var $model Usergroups */

$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Usergroups', 'url'=>array('index')),
	array('label'=>'Create Usergroups', 'url'=>array('create')),
	array('label'=>'View Usergroups', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Usergroups', 'url'=>array('admin')),
);
?>

<h1>Update Usergroups <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
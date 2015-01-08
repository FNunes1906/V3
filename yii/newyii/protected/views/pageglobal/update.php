<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */

$this->breadcrumbs=array(
	'Pageglobals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pageglobal', 'url'=>array('index')),
	array('label'=>'Create Pageglobal', 'url'=>array('create')),
	array('label'=>'View Pageglobal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pageglobal', 'url'=>array('admin')),
);
?>

<h1>Update Pageglobal <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
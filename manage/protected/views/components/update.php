<?php
/* @var $this ComponentsController */
/* @var $model Components */

$this->breadcrumbs=array(
	'Components'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Components', 'url'=>array('index')),
	array('label'=>'Create Components', 'url'=>array('create')),
	array('label'=>'View Components', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Components', 'url'=>array('admin')),
);
?>

<h1>Update Components <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
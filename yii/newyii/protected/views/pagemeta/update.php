<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Pagemetas'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pagemeta', 'url'=>array('index')),
	array('label'=>'Create Pagemeta', 'url'=>array('create')),
	array('label'=>'View Pagemeta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pagemeta', 'url'=>array('admin')),
);
?>

<h1>Update Pagemeta <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
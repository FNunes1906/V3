<?php
/* @var $this BannerclientController */
/* @var $model Bannerclient */

$this->breadcrumbs=array(
	'Bannerclients'=>array('index'),
	$model->name=>array('view','id'=>$model->cid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bannerclient', 'url'=>array('index')),
	array('label'=>'Create Bannerclient', 'url'=>array('create')),
	array('label'=>'View Bannerclient', 'url'=>array('view', 'id'=>$model->cid)),
	array('label'=>'Manage Bannerclient', 'url'=>array('admin')),
);
?>

<h1>Update Bannerclient <?php echo $model->cid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this GalleriesController */
/* @var $model Galleries */

$this->breadcrumbs=array(
	'Galleries'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
/*	array('label'=>'List Galleries', 'url'=>array('index')),
	array('label'=>'Create Galleries', 'url'=>array('create')),
	array('label'=>'View Galleries', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Galleries', 'url'=>array('admin')),*/
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
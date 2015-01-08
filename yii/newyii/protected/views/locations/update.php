<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	$model->title=>array('view','id'=>$model->loc_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Locations', 'url'=>array('index')),
//	array('label'=>'Create Locations', 'url'=>array('create')),
//	array('label'=>'View Locations', 'url'=>array('view', 'id'=>$model->loc_id)),
//	array('label'=>'Manage Locations', 'url'=>array('admin')),
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Locations', 'url'=>array('index')),
//	array('label'=>'Manage Locations', 'url'=>array('admin')),
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
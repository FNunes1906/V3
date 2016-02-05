<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Events'=>array('admin'),
	'Create',
);

$this->menu=array(
/*	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Manage Events', 'url'=>array('admin')),*/
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
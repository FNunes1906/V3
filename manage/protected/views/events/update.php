<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Manage Events'=>array('index'),
	'Edit '.$model->ev_id,
);

$this->menu=array(
/*	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Create Events', 'url'=>array('create')),
	array('label'=>'View Events', 'url'=>array('view', 'id'=>$model->ev_id)),
	array('label'=>'Manage Events', 'url'=>array('admin')),*/
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
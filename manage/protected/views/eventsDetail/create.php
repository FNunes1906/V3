<?php
/* @var $this EventsDetailController */
/* @var $model EventsDetail */

$this->breadcrumbs=array(
	'Manage Events'=>array('/events'),
	'Create Event',
);

?>
<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
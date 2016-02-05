<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Manage Locations'=>array('admin'),
	'Create location',
);

?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
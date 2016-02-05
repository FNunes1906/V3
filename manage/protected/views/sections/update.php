<?php
/* @var $this SectionsController */
/* @var $model Sections */

$this->breadcrumbs=array(
	'Manage Categories'=>array('index'),
	'Edit '.$model->title,
);

?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
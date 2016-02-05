<?php
/* @var $this PhocaCategoriesController */
/* @var $model PhocaCategories */

$this->breadcrumbs=array(
	'Manage Gallery Categories'=>array('index'),
	'Create Category',
);

?>
<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
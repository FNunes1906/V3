<?php
/* @var $this GalleriesController */
/* @var $model Galleries */

$this->breadcrumbs=array(
	'Manage Galleries'=>array('index'),
	'Insert New Image',
);

?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
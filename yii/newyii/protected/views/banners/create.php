<?php
/* @var $this BannersController */
/* @var $model Banners */

$this->breadcrumbs=array(
	'Banners'=>array('admin'),
	'Create',
);

$this->menu=array(
/*	array('label'=>'List Banners', 'url'=>array('index')),
	array('label'=>'Manage Banners', 'url'=>array('admin')),*/
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
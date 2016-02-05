<?php
/* @var $this CategoriesController */
/* @var $model Categories */
if($_GET['type']=='com_content'){
	$type = 'index?type=com_content';
}else if($_GET['type']=='com_banner'){
	$type = 'banner_cat?type=com_banner';
}else if($_GET['type']=='com_jevlocations2'){
	$type = 'locations_cat?type=com_jevlocations2';
}else if($_GET['type']=='com_jevents'){
	$type = 'events_cat?type=com_jevents';
}
$this->breadcrumbs=array(
	'Manage Categories'=>array($type),
	'Create Category',
);

$this->menu=array(
/*	array('label'=>'List Categories', 'url'=>array('index')),
	array('label'=>'Manage Categories', 'url'=>array('admin')),*/
);
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
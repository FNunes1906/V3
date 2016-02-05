<?php
/* @var $this FrontpageController */
/* @var $model Frontpage */

$this->breadcrumbs=array(
	'Frontpages'=>array('index'),
	$model->content_id=>array('view','id'=>$model->content_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Frontpage', 'url'=>array('index')),
	array('label'=>'Create Frontpage', 'url'=>array('create')),
	array('label'=>'View Frontpage', 'url'=>array('view', 'id'=>$model->content_id)),
	array('label'=>'Manage Frontpage', 'url'=>array('admin')),
);
?>

<h1>Update Frontpage <?php echo $model->content_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this CoreAclAroController */
/* @var $model CoreAclAro */

$this->breadcrumbs=array(
	'Core Acl Aros'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CoreAclAro', 'url'=>array('index')),
	array('label'=>'Create CoreAclAro', 'url'=>array('create')),
	array('label'=>'View CoreAclAro', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CoreAclAro', 'url'=>array('admin')),
);
?>

<h1>Update CoreAclAro <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
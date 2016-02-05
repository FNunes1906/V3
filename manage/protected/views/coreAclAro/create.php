<?php
/* @var $this CoreAclAroController */
/* @var $model CoreAclAro */

$this->breadcrumbs=array(
	'Core Acl Aros'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CoreAclAro', 'url'=>array('index')),
	array('label'=>'Manage CoreAclAro', 'url'=>array('admin')),
);
?>

<h1>Create CoreAclAro</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
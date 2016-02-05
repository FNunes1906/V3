<?php
/* @var $this CoreAclAroController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Core Acl Aros',
);

$this->menu=array(
	array('label'=>'Create CoreAclAro', 'url'=>array('create')),
	array('label'=>'Manage CoreAclAro', 'url'=>array('admin')),
);
?>

<h1>Core Acl Aros</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

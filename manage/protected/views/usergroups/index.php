<?php
/* @var $this UsergroupsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usergroups',
);

$this->menu=array(
	array('label'=>'Create Usergroups', 'url'=>array('create')),
	array('label'=>'Manage Usergroups', 'url'=>array('admin')),
);
?>

<h1>Usergroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

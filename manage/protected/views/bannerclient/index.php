<?php
/* @var $this BannerclientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bannerclients',
);

$this->menu=array(
	array('label'=>'Create Bannerclient', 'url'=>array('create')),
	array('label'=>'Manage Bannerclient', 'url'=>array('admin')),
);
?>

<h1>Bannerclients</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

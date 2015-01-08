<?php
/* @var $this PagemetaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pagemetas',
);

$this->menu=array(
	array('label'=>'Create Pagemeta', 'url'=>array('create')),
	array('label'=>'Manage Pagemeta', 'url'=>array('admin')),
);
?>

<h1>Pagemetas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

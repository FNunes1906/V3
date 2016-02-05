<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Manage Pagemetas'=>array('index'),
	'Edit '.$model->title,
);

?>
<div>
	<ul class="breadcrumb">
	<?php
	if(isset($this->breadcrumbs)):
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	));/*breadcrumbs*/
	endif;?>
	</ul>
</div>
<!--<h1>Update Pagemeta <?php echo $model->id; ?></h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
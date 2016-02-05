<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Manage Menus'=>array('index'),
	'Edit '.$model->name,
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

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
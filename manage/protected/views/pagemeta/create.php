<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Manage Pagemetas'=>array('index'),
	'New Page Title',
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
<!--<h1>Create Pagemeta</h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
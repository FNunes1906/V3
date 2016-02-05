<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Manage Users'=>array('index'),
	'Create User',
);

?>

<div>
	<ul class="breadcrumb">
	<?php
	if(isset($this->breadcrumbs)):
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Home', array('/site/index')),
		'links'=>$this->breadcrumbs,
	));/*breadcrumbs*/
	endif;?>
	</ul>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
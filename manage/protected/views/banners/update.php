<?php
/* @var $this BannersController */
/* @var $model Banners */

$this->breadcrumbs=array(
	'Manage Banners'=>array('index'),
	'Edit '.$model->name,
);

?>
<!--Breadcrumnb Start-->
<div>
	<ul class="breadcrumb">
	<?php if(isset($this->breadcrumbs)): 
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'homeLink'=>CHtml::link('Home', array('/site/index')),
				'links'=>$this->breadcrumbs,
			));
		endif;?>
	</ul>
</div>
<!--Breadcrumnb End-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
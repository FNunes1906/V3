<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus'=>array('index'),
	'Manage',
);

?>
<!--BREADCRUMB START-->
	<div><ul class="breadcrumb">
		<?php
		if(isset($this->breadcrumbs)):
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));/*breadcrumbs*/
		endif;?>
		</ul>
	</div>
	<!--BREADCRUMB END-->
	
	<div class="row">
			<ul class="nav navbar-nav nav-pills global_menu main-menu">
				<li title="Page Meta" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta'); ?>"><i class="glyphicon glyphicon-cogwheel"></i></a></li>
				<li title="Page Global" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pageglobal'); ?>"><i class="glyphicon glyphicon-wrench"></i></a></li>
			</ul>
	</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'menu-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'menutype',
		'name',
		'alias',
		'link',
		'type',
		/*
		'published',
		'parent',
		'componentid',
		'sublevel',
		'ordering',
		'checked_out',
		'checked_out_time',
		'pollid',
		'browserNav',
		'access',
		'utaccess',
		'params',
		'lft',
		'rgt',
		'home',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

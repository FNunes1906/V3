<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Categories'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Categories', 'url'=>array('index')),
//	array('label'=>'Create Categories', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Locations" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('locations/admin'); ?>"><i class="glyphicon glyphicon-map-marker"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/admin'); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<!--<li title="Settings" data-placement="bottom" data-toggle="tooltip"><a href="Settings.html"><i class="glyphicon glyphicon-cog"></i></a></li>-->
	</ul>
</div>
		
<div class="row">
	<div class="box col-md-12">
		<div class="box-inner">		
			<div class="box-header well" data-original-title="">
			    <h2><i class="glyphicon glyphicon-list"></i> Category</h2>

			    <div class="navbar-right event-btn">
					<!--<a href="#mapmodals" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>-->
					<a href="#mapmodals" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
					<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> DELETE</a>
			    </div>
			</div>

<div class="box-content ">
<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(

'template'=>'{items}{summary}{pager}',
	'pagerCssClass' => 'dataTables_paginate paging_bootstrap center-block',
	'pager' => array(
		'class' => 'CLinkPager',
		'cssFile'=>false,
		'header' => '',
	  	'hiddenPageCssClass' => 'disabled',
	    'firstPageLabel'=>'<< First',
	    'prevPageLabel'=>'< Previous',
	    'nextPageLabel'=>'Next >',
	    'lastPageLabel'=>'Last >>',
		'selectedPageCssClass'=>'active',
		'htmlOptions'=>array(
	            'class'=>'pagination',
	            //'style'=>'text-align:center !important;',
	        ),
	),
	'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable responsive',
//	'filterPosition'=>false,
//	'enableSorting' => false,	
//	'summaryText' => false,

	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'parent_id',
		'published',
		/*
		'section',
		'name',
		'image_position',
		'alias',
		'image',
		'description',
		'checked_out',
		'checked_out_time',
		'editor',
		'ordering',
		'access',
		'count',
		'params',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 10px"></i>',
					'imageUrl' => false,
					
				),
				'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					'csrf'=>true,
				),
			)	
		),
		
	),

)); ?>
</div>
</div>
</div>
</div>
</div>
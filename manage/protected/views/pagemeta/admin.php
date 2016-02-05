<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */

$this->breadcrumbs=array(
	'Pagemetas'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Pagemeta', 'url'=>array('index')),
//	array('label'=>'Create Pagemeta', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pagemeta-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
            <!-- content starts -->
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
	<div class="row">
			<ul class="nav navbar-nav nav-pills global_menu main-menu">
				<li title="Page Meta" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta/admin'); ?>"><i class="glyphicon glyphicon-cog"></i></a></li>
				<li title="Page Global" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pageglobal/update/1'); ?>"><i class="glyphicon glyphicon-wrench"></i></a></li>
			</ul>
	</div>
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
	    <div class="box-header well" data-original-title="">
	        <h2><i class="glyphicon glyphicon-cog"></i> Page Meta</h2>

	        <div class="navbar-right event-btn">
			<!--<a href="#" class="btn-setting"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>-->
			<a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
			<!--<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> DELETE</a>-->
	       
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

	'id'=>'pagemeta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array( 
			'name'=>'id',
			'filter'=>false,
		),
		array( 
			'name'=>'uri',
			'type'=>'raw',
	        'value'=>'CHtml::link($data->uri, array("/pagemeta/update", "id"=>$data->id));',
			'filter'=>CHtml::textField('Pagemeta[uri]',(isset($_REQUEST['Pagemeta']['uri'])) ? $_REQUEST['Pagemeta']['uri'] : "",array('class' => 'form-control')
			),
		),
		array( 
			'name'=>'title',
			'filter'=>CHtml::textField('Pagemeta[title]',(isset($_REQUEST['Pagemeta']['title'])) ? $_REQUEST['Pagemeta']['title'] : "",array('class' => 'form-control')
			),
		),
		array( 
			'name'=>'metadesc',
			'filter'=>false,
			'sortable' => false,
		),
		array( 
			'name'=>'keywords',
			'filter'=>false,
			'sortable' => false,
		),
		array( 
			'name'=>'extra_meta',
			'filter'=>false,
			'sortable' => false,
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'header'=>'Action',
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

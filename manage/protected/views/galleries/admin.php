<?php
/* @var $this GalleriesController */
/* @var $model Galleries */

$this->breadcrumbs=array(
	'Galleries'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Galleries', 'url'=>array('index')),
//	array('label'=>'Create Galleries', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#galleries-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<!--BOX ICON START-->
<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Banners" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/admin'); ?>"><i class="glyphicon glyphicon-picture"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/admin'); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
	</ul>
</div>
<!--BOX ICON END-->

<!-- TABLE HEADING START -->
<div class="row">
<div class="box col-md-12">
<div class="box-inner">
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<div class="box-header well" data-original-title="">
    <h2><i class="glyphicon glyphicon-picture"></i> Gallery</h2>

	<div class="navbar-right event-btn">
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('galleries/ajaxupdate','act'=>'doActive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('galleries/ajaxupdate','act'=>'doInactive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('galleries/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
	<a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('galleries/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

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

	'id'=>'galleries-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50', 
			'htmlOptions' => array('style' => 'vertical-align: middle;text-align: center;'),
        ),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align: center;'),
		),
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link(CHtml::image(Yii::app()->request->hostInfo."/partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_".$data->filename,"$data->filename",array("height"=>"50px")),array("/galleries/update", "id"=>$data->id));',
	        'name'=>'filename',
	        'header'=>'Images',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),	
		
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/galleries/update", "id"=>$data->id));',
	        'name'=>'title',
			'filter'=>CHtml::textField('Galleries[title]',(isset($_REQUEST['Galleries']['title'])) ? $_REQUEST['Galleries']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
		),
		array(
            'name'  => 'phocaCat.title',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::activedropDownList($model, 'catid',  
               CHtml::listData(PhocaCategories::model()->findAll(), 'id', 'title'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
        ),
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/galleries/updatestatus", "id"=>$data->id,"published"=>$data->published),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'approved',
			'type' => 'html',
			'header'=>'Authorized',
			'value'=>'CHtml::link("", array("/galleries/approvedstatus", "id"=>$data->id,"approved"=>$data->approved),array("class" => $data->approved ? "pub" : "unpub"));',
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
		),
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center; display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;width: 7%;'),
			'filter'=>false,
        ),
		/*
		'description',
		'date',
		'alias',
		'sid',
		'hits',
		'latitude',
		'longitude',
		'zoom',
		'geotitle',
		'videocode',
		'vmproductid',
		'imgorigsize',
		'approved',
		'checked_out',
		'checked_out_time',
		'ordering',
		'params',
		'metakey',
		'metadesc',
		'extlink1',
		'extlink2',
		'extid',
		'extl',
		'extm',
		'exts',
		'exto',
		'extw',
		'exth',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'header'=>'Action',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 10px"></i>',
					'imageUrl' => false,
				),
				'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					'csrf'=>true,
				),
			),	
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
		),
		
	),

)); ?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('galleries-grid');
}
</script>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
<?php
/* @var $this ContentsController */
/* @var $model Contents */

$this->breadcrumbs=array(
	'Contents'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Contents', 'url'=>array('index')),
//	array('label'=>'Create Contents', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contents-grid').yiiGridView('update', {
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
		<li title="Articles" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents/admin'); ?>"><i class="glyphicon glyphicon-book"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-book"></i> Articles</h2>

    <div class="navbar-right event-btn">
       <a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('contents/ajaxupdate','act'=>'doActive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('contents/ajaxupdate','act'=>'doInactive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('contents/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
	<a href="<?php echo Yii::app()->createAbsoluteUrl('contents/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('contents/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
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

	'id'=>'contents-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50', 
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
        ),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/contents/update", "id"=>$data->id))',
	        'name'=>'title',
	        'header'=>'Name',
			'filter'=>CHtml::textField('Contents[title]',(isset($_REQUEST['Contents']['title'])) ? $_REQUEST['Contents']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'state',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/contents/updatestatus", "id"=>$data->id,"status"=>$data->state),array("class" => $data->state ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'state',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		/*array( 
			'name'=>'mask',
			'type' => 'html',
			 'header'=>'Front Page',
			'value'=>'CHtml::link("", array("/contents/frontstatus", "id"=>$data->id,"status"=>$data->mask),array("class" => $data->mask ? "pub" : "unpub"));',
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
		),*/
		array( 
			'name'=>'frontpage.content_id',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/contents/frontstatus", "id"=>$data->id,"status"=>isset($data->frontpage->content_id)?1:0),array("class" => isset($data->frontpage->content_id) ? "pub" : "unpub"));',
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
		),
		array(
            'name'  => 'sectiontitle.title',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::dropDownList('Contents[sectionid]',
					(isset($_REQUEST['Contents']['sectionid'])) ? $_REQUEST['Contents']['sectionid'] : "",
					CHtml::listData(Sections::model()->findAll('scope="content"'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),
			
        ),
		array(
            'name'  => 'articleCat.title',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::dropDownList('Contents[catid]',
					(isset($_REQUEST['Contents']['catid'])) ? $_REQUEST['Contents']['catid'] : "",
					CHtml::listData(Categories::model()->findAll('section=8'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),
        ),
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),
		array( 
			'name'=>'created',
			'filter'=>false,
		),
		
		
		/*
		'mask',
		'title_alias',
		'fulltext',
		'introtext',
		'alias',
		'created_by',
		'created_by_alias',
		'modified',
		'modified_by',
		'checked_out',
		'checked_out_time',
		'publish_up',
		'publish_down',
		'images',
		'urls',
		'attribs',
		'version',
		'parentid',
		'ordering',
		'metakey',
		'metadesc',
		'access',
		'hits',
		'metadata',
		*/
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
			),
			'htmlOptions' => array('style' => 'vertical-align: middle;'),	
		),
		
	),

)); ?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('contents-grid');
}
</script>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
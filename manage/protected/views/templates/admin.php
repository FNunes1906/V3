<?php
/* @var $this BannersController */
/* @var $model Banners */

$this->breadcrumbs=array(
	'Banners'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Banners', 'url'=>array('index')),
//	array('label'=>'Create Banners', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#banners-grid').yiiGridView('update', {
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
		<li title="Banners" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('banners/admin'); ?>"><i class="glyphicon glyphicon-folder-open"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Banners</h2>

   <div class="navbar-right event-btn">
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('banners/ajaxupdate','act'=>'doActive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('banners/ajaxupdate','act'=>'doInactive'), array('success'=>'reloadGrid')); ?></a>
	<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('banners/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
	<a href="<?php echo Yii::app()->createAbsoluteUrl('banners/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('banners/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
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

	'id'=>'banners-grid',
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
			'name'=>'bid',
			'filter'=>false,
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
		),
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->name, array("/banners/update", "id"=>$data->bid));',
	        'name'=>'name',
			'filter'=>CHtml::textField('Banners[name]',(isset($_REQUEST['Banners']['name'])) ? $_REQUEST['Banners']['name'] : "",array('class' => 'form-control')
			),
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
		),
		array(
            'name'  => 'catid',
            'type'  => 'raw',
			'value' => '(isset($data->catid) ? $data->bannersCat->title : "")',
            'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
			/*'filter'=>CHtml::dropDownList('Banners[catid]',
					(isset($_REQUEST['Banners']['catid'])) ? $_REQUEST['Banners']['catid'] : "",
					CHtml::listData(Categories::model()->findAll('section="com_banner"'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),*/
			'filter'=>CHtml::activedropDownList($model, 'catid',  
               CHtml::listData(Categories::model()->findAll('section="com_banner"'), 'id', 'title'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
        ),
		array( 
			'name'=>'impmade',
			'type' => 'html',
			'filter'=>false,
			'value'=>'CHtml::tag("span",array("class" => "graydigit"),$data->impmade);',
		 	'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'clicks',
			'type' => 'html',
			'filter'=>false,
			'value'=>'CHtml::tag("span",array("class" => "graydigit"),$data->clicks);',
		 	'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'showBanner',
			'type' => 'raw',
		 	'value'=>'CHtml::link("", array("/banners/updatestatus", "id"=>$data->bid,"status"=>$data->showBanner),array("class" => $data->showBanner ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'showBanner',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->bid]",$data->ordering,array("style"=>"width:60px;text-align: center; display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),
		/*
		'type',
		'alias',
		'imptotal',
		'imageurl',
		'clickurl',
		'cid',
		'date',
		'checked_out',
		'checked_out_time',
		'editor',
		'custombannercode',
		'description',
		'sticky',
		'ordering',
		'publish_up',
		'publish_down',
		'tags',
		'params',
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
			'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
		),
		
	),

)); ?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('banners-grid');
}
</script>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
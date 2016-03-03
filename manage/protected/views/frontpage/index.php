<?php
/* @var $this FrontpageController */
/* @var $model Frontpage */

$this->breadcrumbs=array(
	'Frontpages'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List Frontpage', 'url'=>array('index')),
	array('label'=>'Create Frontpage', 'url'=>array('create')),
);*/


?>
<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<!-- MESSAGE ALERT BOX START -->
 <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="tw_success">
		 <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button>
        <?php echo Yii::app()->user->getFlash('success'); ?>
		<?php Yii::app()->clientScript->registerScript(
			   'myHideEffect',
			   '$(".tw_success").animate({opacity: 1.0}, 5000).fadeOut("slow");',
			   CClientScript::POS_READY
			);?>
    </div>
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->

<!--BOX ICON START-->
<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Articles" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents'); ?>"><i class="glyphicon glyphicon-book"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories'); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<li title="Frontpage" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('frontpage'); ?>"><i class="glyphicon glyphicon-log-book"></i></a></li>
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
	<!--<a href="<?php echo Yii::app()->createAbsoluteUrl('contents/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>-->
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('contents/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">
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

	'id'=>'frontpage-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'content_id',
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->article_data->title, array("/contents/update", "id"=>$data->article_data->id))',
	        'name'=>'article_data.title',
			//'filter'=>CHtml::textField('$data->article_data->title',(isset($_REQUEST['Contents']['title'])) ? $_REQUEST['Contents']['title'] : "",array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		'ordering',
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
    $.fn.yiiGridView.update('contents-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

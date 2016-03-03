<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	'Manage',
);

# COMMENT THIS TO HIDE CREATE LOCATION AND LIST LOCATION LINK DEFAULT BY Yii
$this->menu=array(
//	array('label'=>'List Locations', 'url'=>array('admin')),
//	array('label'=>'Create Locations', 'url'=>array('create')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#locations-grid').yiiGridView('update', {
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
	</ul>
</div>
		
<div class="row">
	<div class="box col-md-12">
		<div class="box-inner">	
		<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
	
			<div class="box-header well" data-original-title="">
			    <h2><i class="glyphicon glyphicon-map-marker"></i> Locations</h2>

				<div class="navbar-right event-btn">
					<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('locations/ajaxupdate','act'=>'doActive'), array('success'=>'reloadGrid')); ?></a>
					<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('locations/ajaxupdate','act'=>'doInactive'), array('success'=>'reloadGrid')); ?></a>
					<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('locations/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('locations/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
					<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('locations/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
				</div>
			</div>
			

<div class="box-content ">
	<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
	<div class="search-form" style="display:none">
		<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
	</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(

	'template'=>'{items}{summary}{pager}',
	'pagerCssClass' => 'dataTables_paginate paging_bootstrap center-block',
	'pager' => array(
		'class' => 'CLinkPager',
		'cssFile'=>false,
		'header' => '',
	  	'hiddenPageCssClass' => 'disabled',
	    'firstPageLabel'=>'← First',
	    'prevPageLabel'=>'< Previous',
	    'nextPageLabel'=>'Next >',
	    'lastPageLabel'=>'Last →',
		'selectedPageCssClass'=>'active',
		'htmlOptions'=>array(
	            'class'=>'pagination',
		),
	),
	'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable responsive',
//	'filterPosition'=>false,
//	'enableSorting' => false,	
//	'summaryText' => false,

	'id'=>'locations-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',   
        ),
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/locations/update", "id"=>$data->loc_id));',
	        'name'=>'title',
	        'header'=>'Title',
			'filter'=>CHtml::activeTextField($model,'title',array('class' => 'form-control'))
		),
		array(
            'name'  => 'catid_list',
            'type'  => 'raw',
            'header'=> 'Location Category',
            'value' => '(isset($data->catid_list) ? $data->CatName($data->catid_list) : "")',
            'htmlOptions' => array('style' => 'text-align:center;'),
			/*'filter'=>CHtml::dropDownList('Locations[catid_list]',
					(isset($_REQUEST['Locations']['catid_list'])) ? $_REQUEST['Locations']['catid_list'] : "",
					CHtml::listData(Categories::model()->findAll('section="com_jevlocations2"'), 'id', 'title'),
					array('empty' => "Please Select",'class'=>'form-control','data-rel'=>'chosen')
			),*/
			'filter'=>CHtml::activedropDownList($model, 'catid_list',  
					  CHtml::listData(Categories::model()->findAll('section="com_jevlocations2"'), 'id', 'title'),
					  array('empty' => "Please Select",'class'=>'form-control')
			),
			
        ),
		array( 
			'type'=>'raw',
	        //'value'=>'CHtml::link($data->title, array("/locations/update", "id"=>$data->loc_id));',
	        'name'=>'city',
	        'header'=>'City',
			'filter'=>CHtml::activeTextField($model,'city',array('class' => 'form-control'))
		),
		/*array(
			'header'=>'Status',
			'name'  => 'published',
			'type'  => 'raw',
			'value'=> 'CHtml::ajaxSubmitButton("$data->published",array("locations/changestatus","status"=>$data->published,"id"=>$data->loc_id), array("success"=>"reloadGrid"),array("class" => $data->published ? "glyphicon glyphicon-ok-sign" : "glyphicon glyphicon-remove-sign"));',
			'htmlOptions' => array('style' => 'text-align:center;'),
			'filter'=>CHtml::activedropDownList($model, 'published',  
					  array(''=>'All','1'=>'Published','0'=>'Unpublished',),
					  array('class' => 'form-control')
			),
		),*/
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/locations/updatestatus", "id"=>$data->loc_id,"status"=>$data->published),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		
		
		array( 
			'name'=>'loc_id',
			'filter'=>false,
		),
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
			)	
		),
		
	),

)); ?>

<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('locations-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
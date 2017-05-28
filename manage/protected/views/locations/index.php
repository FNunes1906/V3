<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Manage Locations',
);

if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$lc_cat = explode('|',$_REQUEST['cat_id']);
	$cat_condition = '';
	foreach($lc_cat as $key=>$value){
		$cat_condition .= ' (id ='.$value.' OR parent_id ='.$value.') ';
		if($key < count($lc_cat)-1 ){
			$cat_condition .=' OR';
		}
	}
	$c_id = $_REQUEST['cat_id'];
}else{
	$cat_condition = '';
	$c_id = '';
}
if(isset($_REQUEST["menu_id"])){
	$m_id = $_REQUEST["menu_id"];
}else{
	$m_id = '';
}
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<!-- MESSAGE ALERT BOX START -->
<div id="status_msg" style="display: none"></div>
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
		<li data-toggle="tooltip" data-placement="bottom" title="" class="active" data-original-title="Locations"><a href="<?php echo Yii::app()->createAbsoluteUrl('locations')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-map-marker"></i></a></li>
		<li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Categories"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/locations_cat',array('type'=>'com_jevlocations2','cat_id'=>isset($_REQUEST["cat_id"])?$_REQUEST["cat_id"]:'','menu_id'=>isset($_REQUEST["menu_id"])?$_REQUEST["menu_id"]:'')); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
	</ul>
</div>
<!--BOX ICON END-->
		
<div class="row">
	<div class="box col-md-12">
		<div class="box-inner">	
		<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
	
			<div class="box-header well" data-original-title="">
			    <h2><i class="glyphicon glyphicon-map-marker"></i> Locations</h2>

				<div class="navbar-right event-btn">
					
					<a href="<?php echo Yii::app()->createAbsoluteUrl('locations/create')."?menu_id=".$m_id."&cat_id=".$c_id; ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
					<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('locations/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() {if($("#locations-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
					<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('locations/ajaxupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#locations-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
					<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('locations/ajaxupdate','act'=>'doInactive'), array('beforeSend'=>'function() {if($("#locations-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
					<!--<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('locations/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>-->
				</div>
			</div>
			

<div class="box-content ">
<?php 
	# CODE FOR SET PAGE SIZE START
	$pageSize = Yii::app()->user->getState( 'pageSizeLocations', Yii::app()->params[ 'defaultPageSize' ] );
	$pageSizeDropDown = CHtml::dropDownList(
		'pageSize',
		$pageSize,
		array( 10 => 10, 25 => 25, 50 => 50, 100 => 100 ),
		array(
			'class'    => 'change-pagesize', 
			'onchange' => "$.fn.yiiGridView.update('locations-grid',{data:{pageSize:$(this).val()}});",
		)
	);

?>
<div class="page-size-wrap">
	<span>Display </span><?php echo  $pageSizeDropDown; ?> Records
</div>
<?php Yii::app()->clientScript->registerCss( 'initPageSizeCSS', '.page-size-wrap{text-align: right;}' ); 
	# CODE FOR SET PAGE SIZE END ?>


	<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
	<div class="search-form" style="display:none">
		<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
	</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

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
            'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
			/*'filter'=>CHtml::dropDownList('Locations[catid_list]',
					(isset($_REQUEST['Locations']['catid_list'])) ? $_REQUEST['Locations']['catid_list'] : "",
					CHtml::listData(Categories::model()->findAll('section="com_jevlocations2"'), 'id', 'title'),
					array('empty' => "Please Select",'class'=>'form-control','data-rel'=>'chosen')
			),*/
			'filter'=>CHtml::activedropDownList($model, 'catid_list',  
					  CHtml::listData(Categories::model()->findAll('section="com_jevlocations2" and published=1 and '.$cat_condition.' ORDER BY title ASC'), 'id', 'title'),
					  array('empty' => "Please Select",'class'=>'form-control')
			),
			
        ),
		array( 
			'type'=>'raw',
	        //'value'=>'CHtml::link($data->title, array("/locations/update", "id"=>$data->loc_id));',
	        'name'=>'city',
	        'header'=>'City',
			'filter'=>CHtml::activeTextField($model,'city',array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align:center;'),
		),
		array( 
			'name'=>'location_feature',
			'header'=>'Featured',
			'type' => 'raw',
			'value'=>'CHtml::link("", array("/locations/featuredstatus", "id"=>$data->loc_id,"status"=>$data->locationfeatured==""?"0":$data->locationfeatured->value,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->locationfeatured==""?"unpub":($data->locationfeatured->value ? "pub" : "unpub") 
			));',
			'filter'=>CHtml::activedropDownList($model, 'location_feature',  
                array(''=>'All','1'=>'Featured','0'=>'Unfeatured'),
				array('class' => 'form-control')
            ),
			'htmlOptions'=>array('style' => 'width:12.4%;vertical-align: middle;text-align:center;'),
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
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/locations/updatestatus", "id"=>$data->loc_id,"status"=>$data->published,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'loc_id',
			'filter'=>false,
			'htmlOptions' => array('style' => 'width:5%;text-align:center;vertical-align: middle;'),
		),
		array(
			'class'=>'TWButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) $("#status_msg").html(data);$("#status_msg").show();$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");}',
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

))); ?>

<script>
function reloadGrid(data) {
	$("#status_msg").html(data);
	$("#status_msg").show();
	$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $.fn.yiiGridView.update('locations-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

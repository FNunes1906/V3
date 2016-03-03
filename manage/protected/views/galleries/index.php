<?php
/* @var $this GalleriesController */
/* @var $model Galleries */

$this->breadcrumbs=array(
	'Manage Galleries',
);

if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name'])){
	$c_id = $_REQUEST['cat_id'];
	$cat_condition = 'AND (id = '.$_REQUEST['cat_id'].' OR parent_id = '.$_REQUEST['cat_id'].') ';
}else if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$gallery_cat = explode(';',$_REQUEST['cat_id']);
	$cat_condition = 'AND ';
	foreach($gallery_cat as $key=>$value){
		$cat_condition .= ' (id <>'.$value.' AND parent_id <>'.$value.') ';
		if($key < count($gallery_cat)-1 ){
			$cat_condition .=' AND';
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
	<?php if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name'])){ ?>
			<li title="Images" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries')."?menu_id=".$m_id."&cat_id=".$c_id."&cat_name=".$_REQUEST['cat_name']?>"><i class="glyphicon glyphicon-picture"></i></a></li>
			<!--<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=".$c_id."&cat_name=videos"?>"><i class="glyphicon glyphicon-list"></i></a></li>-->
			<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=0" ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<?php } else { ?>
			<li title="Images" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-picture"></i></a></li>
			<!--<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-list"></i></a></li>-->
			<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=0" ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<?php } ?>
		
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
	<a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/create')."?menu_id=".$m_id."&cat_id=".$c_id; ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('galleries/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() {if($("#galleries-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('galleries/ajaxupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#galleries-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('galleries/ajaxupdate','act'=>'doInactive'), array('beforeSend'=>'function() {if($("#galleries-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Authorize',array('galleries/ajaxupdate','act'=>'doAuthorize'), array('beforeSend'=>'function() {if($("#galleries-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to Authorize");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unauthorize',array('galleries/ajaxupdate','act'=>'doUnauthorize'), array('beforeSend'=>'function() {if($("#galleries-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to Unauthorize");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<!--<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('galleries/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>-->
	
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">


<?php $this->widget('zii.widgets.grid.CGridView', array_merge(CommonController::CGridViewCommonSettings(),array(

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
			'type'=>'raw',
	        //'value'=>'CHtml::link(CHtml::image(Yii::app()->request->hostInfo."/partner/partnerfoldername/images/phocagallery/thumbs/phoca_thumb_s_".$data->filename,"$data->filename",array("height"=>"50px")),array("/galleries/update", "id"=>$data->id));',
	        'value'=>'($data->filename !=="")?CHtml::link(CHtml::image(Yii::app()->request->hostInfo."/partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_".$data->filename,"$data->filename",array("height"=>"50px","style"=>"border: 2px solid #fff; box-shadow: 0px 1px 7px 0px;")),array("/galleries/update", "id"=>$data->id)):CHtml::link(CHtml::image(Yii::app()->request->hostInfo."/manage/images/camera.jpg".$data->filename,"$data->filename",array("height"=>"50px")),array("/galleries/update", "id"=>$data->id));',
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
               CHtml::listData(PhocaCategories::model()->findAll('published=1 '.$cat_condition.' ORDER BY title ASC'), 'id', 'title'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
        ),
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/galleries/updatestatus", "id"=>$data->id,"published"=>$data->published,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->published ? "pub" : "unpub"));',
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
			'value'=>'CHtml::link("", array("/galleries/approvedstatus", "id"=>$data->id,"approved"=>$data->approved,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->approved ? "pub" : "unpub"));',
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
		),
		/*array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center; display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;width: 7%;'),
			'filter'=>false,
        ),*/
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align: center;'),
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
    $.fn.yiiGridView.update('galleries-grid');
}
</script>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
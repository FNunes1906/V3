<?php
/* @var $this PhocaCategoriesController */
/* @var $model PhocaCategories */
$this->setPageTitle(Yii::app()->name.' - Gallery Categories');
$this->breadcrumbs=array(
	'Manage Gallery Categories',
);
if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name']) && $_REQUEST['cat_name'] == 'videos'){
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
	<?php if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name']) && $_REQUEST['cat_name'] == 'videos'){ ?>
			<li title="Images" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries')."?menu_id=".$m_id."&cat_id=".$c_id."&cat_name=videos"?>"><i class="glyphicon glyphicon-picture"></i></a></li>
			<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=".$c_id."&cat_name=videos"?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<?php } else { ?>
			<li title="Images" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-picture"></i></a></li>
			<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-list"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-list"></i> Gallery Categories</h2>
	<div class="navbar-right event-btn">
	<a href="<?php echo Yii::app()->createAbsoluteUrl('phocaCategories/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	
	<!--# Comment bellow line to hide global delete button-->
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('phocaCategories/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() {if($("#phoca-Categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('phocaCategories/ajaxupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#phoca-Categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('phocaCategories/ajaxupdate','act'=>'doInactive'), array('beforeSend'=>'function() {if($("#phoca-Categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<div class="box-content ">
<?php $this->widget('zii.widgets.grid.CGridView', array_merge(CommonController::CGridViewCommonSettings(),array(
	'id'=>'phoca-Categories-grid',
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
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("phocaCategories/update", "id"=>$data->id))',
	        'name'=>'title',
			'filter'=>CHtml::textField('PhocaCategories[title]',(isset($_REQUEST['PhocaCategories']['title'])) ? $_REQUEST['PhocaCategories']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		
		array( 
			'type'=>'raw',
	        'name'=>'Parenttitle.title',
			'filter'=>CHtml::activedropDownList($model, 'parent_id',  
					  /*CHtml::listData(PhocaCategories::model()->findAll('published=1 '.$cat_condition .'ORDER BY title ASC'), 'id', 'title'),*/
					  CHtml::listData(PhocaCategories::model()->findAll('published=1 ORDER BY title ASC'), 'id', 'title'),
					  array('empty' => "Please Select",'class'=>'form-control')
			),
			'header'=>'Parent Category',
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("phocaCategories/updatestatus", "id"=>$data->id,"status"=>$data->published),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'Published','0'=>'Unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'hits',
			'type' => 'html',
			'filter'=>false,
			'value'=>'CHtml::tag("span",array("class" => "graydigit"),$data->hits);',
		 	'htmlOptions' => array('style' => 'text-align:center;vertical-align: middle;'),
		),
		
		/*
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center; display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),		
		array( 
			'name'=>'approved',
			'type' => 'html',
			'value'=>'CHtml::link("", array("phocacategories/approvedstatus", "id"=>$data->id,"approved"=>$data->approved),array("class" => $data->approved ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'approved',  
                array(''=>'All','1'=>'Approved','0'=>'Unapproved'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align:center;width: 4%;'),
		),
		
		'owner_id',
		'name',
		'alias',
		'image',
		'section',
		'image_position',
		'description',
		'date',
		'checked_out',
		'checked_out_time',
		'editor',
		'ordering',
		'access',
		'count',
		'accessuserid',
		'uploaduserid',
		'deleteuserid',
		'userfolder',
		'latitude',
		'longitude',
		'zoom',
		'geotitle',
		'extid',
		'exta',
		'extu',
		'params',
		'metakey',
		'metadesc',
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
					# To HIDE delete button keep visible = false 
					'visible'=>'false',
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
    $.fn.yiiGridView.update('phoca-Categories-grid');
}
</script>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

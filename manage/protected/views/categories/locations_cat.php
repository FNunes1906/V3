<?php
/* @var $this CategoriesController */
/* @var $model Categories */
$this->setPageTitle(Yii::app()->name.' - Locations Categories ');
$this->breadcrumbs=array(
	'Manage Categories',
);
if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$lc_cat = explode('|',$_REQUEST['cat_id']);
	$cat_condition = '';
	//$cat_condition = ' AND ';
	/*foreach($lc_cat as $key=>$value){
		$cat_condition .= ' (id ='.$value.' OR parent_id ='.$value.') ';
		if($key < count($lc_cat)-1 ){
			$cat_condition .=' OR';
		}
	}*/
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
		<li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Locations"><a href="<?php echo Yii::app()->createAbsoluteUrl('locations')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-map-marker"></i></a></li>
		<li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Categories"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/locations_cat',array('type'=>'com_jevlocations2','cat_id'=>isset($_REQUEST["cat_id"])?$_REQUEST["cat_id"]:'','menu_id'=>isset($_REQUEST["menu_id"])?$_REQUEST["menu_id"]:'')); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-list"></i> Locations Categories</h2>

    <div class="navbar-right event-btn">
       
	<!--<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('categories/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>-->
	<a href="<?php echo Yii::app()->createAbsoluteUrl('categories/create',array('type'=>'com_jevlocations2')); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<!--# Comment bellow line to hide global delete button-->
	<!--<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('categories/ajaxupdate','act'=>'doDelete'),array('beforeSend'=>'function() {if($("#categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>-->
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('categories/ajaxupdate','act'=>'doActive'),array('beforeSend'=>'function() {if($("#categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
		<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('categories/ajaxupdate','act'=>'doInactive'),array('beforeSend'=>'function() {if($("#categories-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">

<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

	'id'=>'categories-grid',
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
	        'value'=>'CHtml::link($data->title, array("/Categories/update", "id"=>$data->id,"type"=>"com_jevlocations2"))',
	        'name'=>'title',
			'filter'=>CHtml::textField('Categories[title]',(isset($_REQUEST['Categories']['title'])) ? $_REQUEST['Categories']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'type'=>'raw',
	        'name'=>'Parenttitle.title',
			'header'=>'Parent Category',
			'filter'=>CHtml::activedropDownList($model, 'parent_id',  
					  CHtml::listData(Categories::model()->findAll('section="com_jevlocations2" AND published=1 '.$cat_condition.' ORDER BY title ASC'), 'id', 'title'),
					  array('empty' => "Please Select",'class'=>'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'published',
			'type' => 'html',
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/categories/updatestatus", "id"=>$data->id,"status"=>$data->published),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align:center;width: 4%;'),
		),
		/*
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center;display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),
		
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
			'class'=>'TWButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) $("#status_msg").html(data);$("#status_msg").show();$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");}',
			'template'=>'{update}{delete}',
			'header'=>'Action',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 10px"></i>',
					'imageUrl' => false,
					'url'=>'CController::createUrl("/Categories/update",array("id"=>$data->id,"type"=>"com_jevlocations2"))',
					
				),
				'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					'csrf'=>true,
					# To HIDE delete button keep visible = false 
					'visible'=>'false',
				),
			)	
		),
		
	),

))); ?>

<script>
function reloadGrid(data) {
	$("#status_msg").html(data);
	$("#status_msg").show();
	$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $.fn.yiiGridView.update('categories-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
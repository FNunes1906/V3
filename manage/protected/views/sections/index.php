<?php
/* @var $this SectionsController */
/* @var $model Sections */

$this->breadcrumbs=array(
	'Manage Categories',
);
if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$section_id = Categories::model()->findAll("id=".$_REQUEST['cat_id']." and published=1","section");
	$cat_condition = 'and (id ='.$section_id[0]->section.')';
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
<?php elseif(Yii::app()->user->hasFlash('fail')):?>
	<div class="tw_fail">
		<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button>
		<?php echo Yii::app()->user->getFlash('success'); ?>
		<?php Yii::app()->clientScript->registerScript(
		   'myHideEffect',
		   '$(".tw_fail").animate({opacity: 1.0}, 5000).fadeOut("slow");',
		   CClientScript::POS_READY
		);?>
	</div>
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->

<!--BOX ICON START-->
<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Articles" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-book"></i></a></li>
		<li title="Manage Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('sections')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-server"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-server"></i> Categories</h2>

    <div class="navbar-right event-btn">
       
	<a href="<?php echo Yii::app()->createAbsoluteUrl('sections/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	
	<!--# Comment bellow line to hide global delete button-->
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('sections/ajaxupdate','act'=>'doDelete'),array('beforeSend'=>'function() {if($("#sections-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('sections/ajaxupdate','act'=>'doActive'),array('beforeSend'=>'function() {if($("#sections-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('sections/ajaxupdate','act'=>'doInactive'),array('beforeSend'=>'function() {if($("#sections-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<!--<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('sections/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>-->
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">

<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

	'id'=>'sections-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50', 
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
        ),
		/*array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;width: 10%;'),
		),*/
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/sections/update", "id"=>$data->id))',
	        'name'=>'title',
	        'header'=>'Name',
			'filter'=>CHtml::textField('Sections[title]',(isset($_REQUEST['Sections']['title'])) ? $_REQUEST['Sections']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/sections/updatestatus", "id"=>$data->id,"status"=>$data->published,"menu_id"=>$_REQUEST["menu_id"],"cat_id"=>$_REQUEST["cat_id"]),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 16%;text-align:center;vertical-align: middle;'),
		),
		/*array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center;display:inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),*/
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
					'url'=>'CController::createUrl("/sections/delete",array("id"=>$data->id,"cat_id"=>$_REQUEST["cat_id"]))',
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
    $.fn.yiiGridView.update('sections-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
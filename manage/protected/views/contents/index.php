<?php
/* @var $this ContentsController */
/* @var $model Contents */
$this->setPageTitle(Yii::app()->name.' - Articles');
$this->breadcrumbs=array(
	'Manage Articles',
);
if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$section_id = Categories::model()->findAll("id=".$_REQUEST['cat_id']." and published=1");
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
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->
<?php 
$criteria1 = new CDbCriteria;
$criteria1->addSearchCondition('scope','content', true);
$criteria1->addSearchCondition('published','1', true);
$secData = Sections::model()->findAll($criteria1);
$criteria2 = new CDbCriteria;
if(count($secData)>0)
{	
	foreach($secData as $id=>$value){
		$criteria2->condition .= 'section='.$value['id'];
		if(count($secData)-1!=$id)
		{
			$criteria2->condition .= ' || ';
		}
	}
	$criteria2->condition .= ' and published=1 ORDER BY title ASC';
}
?>
<!--BOX ICON START-->
<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Articles" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-book"></i></a></li>
		<li title="Manage Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('sections')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-server"></i></a></li>
		<!--<li title="Home Articles" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents/front'); ?>"><i class="glyphicon glyphicon-home"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/index',array('type'=>'com_content')); ?>"><i class="glyphicon glyphicon-list"></i></a></li>-->
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
      
	<a href="<?php echo Yii::app()->createAbsoluteUrl('contents/create')."?menu_id=".$m_id."&cat_id=".$section_id[0]->section; ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('contents/ajaxupdate','act'=>'doDelete'),array('beforeSend'=>'function() {if($("#contents-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	 <a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('contents/ajaxupdate','act'=>'doActive'),array('beforeSend'=>'function() {if($("#contents-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('contents/ajaxupdate','act'=>'doInactive'),array('beforeSend'=>'function() {if($("#contents-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('contents/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">

<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

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
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/contents/update", "id"=>$data->id))',
	        'name'=>'title',
	        'header'=>'Name',
			'filter'=>CHtml::textField('Contents[title]',(isset($_REQUEST['Contents']['title'])) ? $_REQUEST['Contents']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array(
            'name'  => 'sectiontitle.title',
            'type'  => 'raw',
			'header'=>'Category',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::dropDownList('Contents[sectionid]',
					(isset($_REQUEST['Contents']['sectionid'])) ? $_REQUEST['Contents']['sectionid'] : "",
					CHtml::listData(Sections::model()->findAll('scope="content" and published=1 '.$cat_condition.' ORDER BY title ASC'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),
			
        ),
		/*array(
            'name'  => 'articleCat.title',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::dropDownList('Contents[catid]',
					(isset($_REQUEST['Contents']['catid'])) ? $_REQUEST['Contents']['catid'] : "",
					CHtml::listData(Categories::model()->findAll($criteria2), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),
        ),*/
		array( 
			'name'=>'state',
			'type' => 'html',
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/contents/updatestatus", "id"=>$data->id,"status"=>$data->state,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->state ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'state',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'frontpage.content_id',
			'header'=>'Home',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/contents/frontstatus", "id"=>$data->id,"status"=>isset($data->frontpage->content_id)?1:0,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => isset($data->frontpage->content_id) ? "pub" : "unpub"));',
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
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
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'hits',
			'type' => 'html',
			'filter'=>false,
			'value'=>'CHtml::tag("span",array("class" => "graydigit"),$data->hits);',
			'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
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
		
		'metadata',
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
    $.fn.yiiGridView.update('contents-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

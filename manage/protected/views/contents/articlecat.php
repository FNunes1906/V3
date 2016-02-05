<?php
/* @var $this ContentsController */
/* @var $model Contents */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
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
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents/articlecat'); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<li title="Frontpage" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('contents/front'); ?>"><i class="glyphicon glyphicon-log-book"></i></a></li>
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
	<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('contents/ajaxupdate','act'=>'doSortOrderfront'), array('success'=>'reloadGrid')); ?></a>
	<a href="<?php echo Yii::app()->createAbsoluteUrl('contents/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('contents/ajaxupdate','act'=>'doDeletefront'), array('beforeSend'=>'function() { if(confirm("Are You Sure you want to delete?")) return true; return false; }','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">
<?php 
$criteria1 = new CDbCriteria;
$criteria1->addSearchCondition('scope','content', true);
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
}
?>
<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

	'id'=>'contents-grid',
	'dataProvider'=>$model->searcharticlecat(),
	'filter'=>Categories::model(),
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
		/*array( 
			'type'=>'raw',
	        'value'=>'CHtml::link($data->title, array("/contents/update", "id"=>$data->id))',
	        'name'=>'title',
	        'header'=>'Name',
			'filter'=>CHtml::textField('Contents[title]',(isset($_REQUEST['Contents']['title'])) ? $_REQUEST['Contents']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),*/
		array(
            'name'  => 'title',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			/*'filter'=>CHtml::textField('Categories[title]',(isset($_REQUEST['Categories']['title'])) ? $_REQUEST['Categories']['title'] : "",array('class' => 'form-control')
			),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),*/
		),
		array(
            'name'  => 'section',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			/*'filter'=>CHtml::dropDownList('Contents[sectionid]',
					(isset($_REQUEST['Contents']['sectionid'])) ? $_REQUEST['Contents']['sectionid'] : "",
					CHtml::listData(Sections::model()->findAll('scope="content"'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),*/
			
        ),
		
		array( 
			'name'=>'published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/contents/frontupdatestatus", "id"=>$data->id,"status"=>$data->published),array("class" => $data->published ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList(Categories::model(), 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center;display:inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
			'header'=>'Action',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 0px"></i>',
					'imageUrl' => false,
					
				),
				/*'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					'csrf'=>true,
				),*/
			),
			'htmlOptions' => array('style' => 'vertical-align: middle;text-align: center;'),	
		),
		
	),

))); ?>

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

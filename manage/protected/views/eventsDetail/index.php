<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Manage',
);

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
		<li title="Events" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('events'); ?>"><i class="glyphicon glyphicon-calendar"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/events_cat',array('type'=>'com_jevents')); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<!--<li title="Settings" data-placement="bottom" data-toggle="tooltip"><a href="Settings.html"><i class="glyphicon glyphicon-cog"></i></a></li>-->
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
    <h2><i class="glyphicon glyphicon-calendar"></i> Events</h2>

    <div class="navbar-right event-btn">
	<a href="<?php echo Yii::app()->createAbsoluteUrl('eventsDetail/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('events/ajaxupdate','act'=>'doDelete'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('events/ajaxupdate','act'=>'doActive'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('events/ajaxupdate','act'=>'doInactive'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">
<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(
	'id'=>'events-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50', 
			'htmlOptions' => array('style' => 'vertical-align: middle;text-align:center;'),
        ),
		//'evdet_id',
		array( 
	        'name'=>'summary',
			'type'=>'raw',
	        'value'=>'CHtml::link($data->summary, array("/eventsdetail/update", "id"=>$data->evdet_id))',
	        'header'=>'Name',
			'filter'=>CHtml::activeTextField($model,'summary',array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array(
            'name'  => 'categoriesCat.title',
			'header'=>'Events Category',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::dropDownList('Events[catid]',
					(isset($_REQUEST['Events']['catid'])) ? $_REQUEST['Events']['catid'] : "",
					CHtml::listData(Categories::model()->findAll('section="com_jevents" and published=1 ORDER BY title ASC'), 'id', 'title'),
					array('empty' => "Please Select", 'class' => 'form-control')
			),
        ),
		array( 
			'name'=>'state',
			'type' => 'html',
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/events/updatestatus", "id"=>$data->evdet_id,"status"=>$data->state),array("class" => $data->state ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'state',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		'dtstart',
		'dtend',
		/*
		'dtend',
		'dtendraw',
		'dtstamp',
		'class',
		'categories',
		'color',
		'description',
		'geolon',
		'geolat',
		'location',
		'priority',
		'status',
		'summary',
		'contact',
		'organizer',
		'url',
		'extra_info',
		'created',
		'sequence',
		'state',
		'multiday',
		'hits',
		'noendtime',
		'modified',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'header'=>'Actions',
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
			)	
		),
	),
))); ?>

<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('events-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

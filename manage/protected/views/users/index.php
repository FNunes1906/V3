<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Manage Users',
);
?>
<!--BREADCRUMB START-->
<div>
<ul class="breadcrumb">
	<?php
	if(isset($this->breadcrumbs)):
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Home', array('/site/index')),
			'links'=>$this->breadcrumbs,
		));/*breadcrumbs*/
	endif;?>
</ul>
</div>
<!--BREADCRUMB END-->
<div class="row">
			<ul class="nav navbar-nav nav-pills loc_menu main-menu site_settings">
				<li title="Website settings" data-placement="bottom" data-toggle="tooltip">
					<a href="<?php echo Yii::app()->createAbsoluteUrl('pageglobal/update/1'); ?>"><i class="glyphicon glyphicon-cogwheel"></i><span> Website settings</span></a>
				</li>
				<li title="User settings" data-placement="bottom" data-toggle="tooltip">
					<a href="<?php echo Yii::app()->createAbsoluteUrl('users'); ?>">
					<i class="glyphicon glyphicon-user"></i><span> User settings</span>
					</a>
				</li>
			</ul>
</div>
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
<?php if(Yii::app()->user->hasFlash('fail')):?>
    <div class="tw_fail">
		 <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button>
        <?php echo Yii::app()->user->getFlash('fail'); ?>
		<?php Yii::app()->clientScript->registerScript(
			   'myHideEffect',
			   '$(".tw_fail").animate({opacity: 1.0}, 5000).fadeOut("slow");',
			   CClientScript::POS_READY
			);?>
    </div>
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->

<!-- TABLE HEADING START -->
<div class="row">
<div class="box col-md-12">
<div class="box-inner">
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<div class="box-header well" data-original-title="">
    <h2><i class="glyphicon glyphicon-user"></i> Users</h2>

    <div class="navbar-right event-btn">
		<a href="<?php echo Yii::app()->createAbsoluteUrl('users/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
		<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('users/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() {if($("#users-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
       <a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('users/ajaxupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#users-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('users/ajaxupdate','act'=>'doInactive'), array('beforeSend'=>'function() {if($("#users-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">
<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(
	'id'=>'users-grid',
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
	        'value'=>'CHtml::link($data->name, array("/users/update", "id"=>$data->id))',
	        'name'=>'name',
			'filter'=>CHtml::textField('Users[name]',(isset($_REQUEST['Users']['name'])) ? $_REQUEST['Users']['name'] : "",array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'type'=>'raw',
	       // 'value'=>'CHtml::link($data->username, array("/users/update", "id"=>$data->id))',
	        'name'=>'username',
			'filter'=>CHtml::textField('Users[username]',(isset($_REQUEST['Users']['username'])) ? $_REQUEST['Users']['username'] : "",array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		//'email',
		array( 
			'type'=>'raw',
	       // 'value'=>'CHtml::link($data->username, array("/users/update", "id"=>$data->id))',
	        'name'=>'email',
			'filter'=>CHtml::textField('Users[email]',(isset($_REQUEST['Users']['email'])) ? $_REQUEST['Users']['email'] : "",array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'  => 'usertype',
            'type'  => 'raw',
            'htmlOptions'=>array('style' => 'vertical-align: middle;'),
			'filter'=>CHtml::textField('Users[usertype]',(isset($_REQUEST['Users']['usertype'])) ? $_REQUEST['Users']['usertype'] : "",array('class' => 'form-control')),
			/*'filter'=>CHtml::dropDownList('Users[usertype]',
					(isset($_REQUEST['Users']['usertype'])) ? $_REQUEST['Users']['usertype'] : "",CHtml::listData(Usergroups::model()->findAll("id<>17 and id<>28 and id<>29 and id<>30"), 'name', 'name'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),*/
		),
		array( 
			'name'=>'block',
			'header'=>'Published',
			'type' => 'html',
			'value'=>'CHtml::link("", array("/users/updatestatus", "id"=>$data->id,"status"=>$data->block),array("class" => $data->block ? "unpub" : "pub"));',
			'filter'=>CHtml::activedropDownList($model, 'block',  
                array(''=>'All','0'=>'Published','1'=>'Unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 10%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'lastvisitDate',
			'filter'=>false,
			'htmlOptions' => array('style' => 'width: 15%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		/*
		'password',
		
		'sendEmail',
		'gid',
		'registerDate',
		'lastvisitDate',
		'activation',
		'params',
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
    $.fn.yiiGridView.update('users-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

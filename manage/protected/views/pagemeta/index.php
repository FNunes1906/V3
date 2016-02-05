<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */
$this->setPageTitle(Yii::app()->name.' - Page Metas');
$this->breadcrumbs=array(
	'Manage Page Metas',
);


?>
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

<!-- content starts -->
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
	<div class="row">
			<ul class="nav navbar-nav nav-pills global_menu main-menu">
				<li title="Page Meta" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta'); ?>"><i class="glyphicon glyphicon-cogwheel"></i></a></li>
				<li title="Site Settings" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pageglobal/update/1'); ?>"><i class="glyphicon glyphicon-wrench"></i></a></li>
				<!--<li title="Manage Menus" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>"><i class="glyphicon glyphicon-list-alt"></i></a></li>-->
			</ul>
	</div>
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
	    <div class="box-header well" data-original-title="">
	        <h2><i class="glyphicon glyphicon-cogwheel"></i> Page Meta</h2>

	        <div class="navbar-right event-btn">
			<!--<a href="#" class="btn-setting"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>-->
			<a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
			<!--<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> DELETE</a>-->
	       
	   		 </div>
	    </div>	
	
	
<div class="box-content ">
<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array_merge(CommonController::CGridViewCommonSettings(),array(

	'id'=>'pagemeta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array( 
			'name'=>'id',
			'filter'=>false,
		),
		array( 
			'name'=>'uri',
			'type'=>'raw',
	        'value'=>'CHtml::link($data->uri, array("/pagemeta/update", "id"=>$data->id));',
			'filter'=>CHtml::textField('Pagemeta[uri]',(isset($_REQUEST['Pagemeta']['uri'])) ? $_REQUEST['Pagemeta']['uri'] : "",array('class' => 'form-control')
			),
		),
		array( 
			'name'=>'title',
			'filter'=>CHtml::textField('Pagemeta[title]',(isset($_REQUEST['Pagemeta']['title'])) ? $_REQUEST['Pagemeta']['title'] : "",array('class' => 'form-control')
			),
		),
		array( 
			'name'=>'metadesc',
			'filter'=>false,
			'sortable' => false,
		),
		array( 
			'name'=>'keywords',
			'filter'=>false,
			'sortable' => false,
		),
		array( 
			'name'=>'extra_meta',
			'filter'=>false,
			'sortable' => false,
		),
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
			)	
		),
	),
))); ?>

</div>
</div>
</div>
</div>

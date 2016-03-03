
<?php
/* @var $this MenuController */
/* @var $model Menu */
$this->setPageTitle(Yii::app()->name.' - Menus');
$this->breadcrumbs=array(
	'Manage Menus',
);
function updateLink($link) {
		$length = strlen('index.php');
		if(substr($link, 0, $length) === 'index.php'){
			$newlink = explode('?',$link);
	    	if(isset($newlink[1]) && $newlink[1] != '')
				return $newlink[1];
			else		
				return "type=url";
		}else{
			return "type=url";
		}
}

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
<div class="row">
	<div class="box col-md-12">
		<div class="box-inner">	
		<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
			<div class="box-header well" data-original-title="">
			    <h2><i class="glyphicon glyphicon-list"></i> Menus</h2>

				<div class="navbar-right event-btn">
					<a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_jevents&view=range&task=range.listevents"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
					<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i><?php echo CHtml::ajaxSubmitButton('Delete',array('menu/ajaxupdate','act'=>'doDelete'), array('beforeSend'=>'function() {if($("#menus-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")){return true;} return false;}}','success'=>'reloadGrid')); ?></a>
					<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('menu/ajaxupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#menus-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
					<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('menu/ajaxupdate','act'=>'doInactive'), array('beforeSend'=>'function() {if($("#menus-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
					<!--<a href="#"><i class="glyphicon glyphicon-star icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Default',array('menu/ajaxupdate','act'=>'default'), array('beforeSend'=>'function() {if($("#menus-grid").find("input:checked").length ==0){alert("Please make a selection from the list to make default");return false;}else if($("#menus-grid").find("input:checked").length>1){alert("Please make single selection from the list to make default");return false;}else{return true;}}','success'=>'reloadGrid')); ?></a>-->
					<a href="#" class=""><i class="glyphicon glyphicon-retweet icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Update order',array('menu/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid')); ?></a>
				</div>
			</div>

<div class="box-content ">
<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(
	'id'=>'menus-grid',
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
	        'value'=>'urldecode(CHtml::link($data->name, array("/menu/update", "id"=>$data->id."?".updateLink($data->link))));',
	        'name'=>'name',
	        'header'=>'Title',
			'filter'=>CHtml::activeTextField($model,'name',array('class' => 'form-control')),
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
		),
		array( 
			'name'=>'MenuParent.name',
			'header'=>'Parent Menu',
			'filter'=>CHtml::activedropDownList($model,'parent',CHtml::listData(Menu::model()->findAll('menutype="leftmenu" and parent=0 and published=1 ORDER BY name ASC'), 'id', 'name'),
				array('empty' => "Please Select",'class' => 'form-control')
            ),
			'htmlOptions' => array('style' => 'width: 15%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'type'=>'raw',
	        'value'=>'CHtml::label("","default",array("class" => $data->home ? "glyphicon glyphicon-star yellow" : ""))',
	        'name'=>'home',
	        'header'=>'Front Page',
			'filter'=>FALSE,
			'htmlOptions' => array('style' => 'width: 6%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'published',
			'type' => 'html',
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/menu/updatestatus", "id"=>$data->id,"status"=>$data->published),array("class" => ($data->published == 1) ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'published',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12%;text-align:center;vertical-align: middle;'),
		),
		array(
            'name'=>'ordering',
            'type'=>'raw',
            'value'=>'CHtml::textField("ordering[$data->id]",$data->ordering,array("style"=>"width:60px;text-align: center;display: inline;","class" => "form-control"))',
            'htmlOptions'=>array('style' => 'width: 5%;text-align:center;vertical-align: middle;'),
			'filter'=>false,
        ),
		array( 
			'name'=>'id',
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
					'url'=>'urldecode(CController::createUrl("/menu/update",array("id"=>$data->id."?".updateLink($data->link))))',
					
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

<script type="text/javascript" language="javascript">
function reloadGrid(data) {
	$("#status_msg").html(data);
	$("#status_msg").show();
	$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $.fn.yiiGridView.update('menus-grid');
}
</script>

</div>
<?php $this->endWidget(); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal">×</button>
		    <h3><i class="glyphicon glyphicon-list-alt"></i> Select Menu Item Type</h3>
		</div>
        <div class="modal-body">
            <div class="row">
			  <div class="box col-md-12">
					 <div class="row">
				        <div class="col-md-12">
							<div id="MainMenu">
							  <div class="menu-type list-group panel">
							    <a href="#events" class="list-group-item " data-toggle="collapse" data-parent="#MainMenu"><i class="glyphicon glyphicon-plus"></i><span> Events</span></a>
							    <div class="collapse" id="events">
							       	<ul>
			                            <!--<li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_jevents&view=week&task=week.listevents">List By Week</a></li>-->
			                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_jevents&view=range&task=range.listevents">Create New Event Menu</a></li>
			                       	</ul>
							    </div> 
								<a href="#locations" class="list-group-item " data-toggle="collapse" data-parent="#MainMenu"><i class="glyphicon glyphicon-plus"></i><span> Locations</span></a>
							    <div class="collapse" id="locations">
							      <ul>
			                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_jevlocations&task=locations.locations">Listing based on categories</a></li>
			                      </ul>
							    </div>
								<a href="#articles" class="list-group-item " data-toggle="collapse" data-parent="#MainMenu"><i class="glyphicon glyphicon-plus"></i><span> Articles</span></a>
							    <div class="collapse" id="articles">
							      <ul>
			                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_content&view=frontpage">Home Layout</a></li>
			                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_content&view=category&layout=blog">Blog Layout</a></li>
			                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_content&view=article">Article Layout</a></li>
			                      </ul>
							    </div>
								<a href="#gallery" class="list-group-item " data-toggle="collapse" data-parent="#MainMenu"><i class="glyphicon glyphicon-plus"></i><span> Gallery</span></a>
							    <div class="collapse" id="gallery">
							      <ul>
			                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_phocagallery&view=categories">All Categories Listing Layout</a></li>
									<li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?option=com_phocagallery&view=category">List By Single Category</a></li>
			                      </ul>
							    </div>
								<a href="#external" class="list-group-item " data-toggle="collapse" data-parent="#MainMenu"><i class="glyphicon glyphicon-plus"></i><span> External Link </span></a>
							    <div class="collapse" id="external">
							      <ul>
			                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>/create?type=url">Create menu with external link</a></li>
			                      </ul>
							    </div>
							  </div>
							</div>
							
				        </div>
				   	</div>
			  </div>
		    </div><!--/row-->
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

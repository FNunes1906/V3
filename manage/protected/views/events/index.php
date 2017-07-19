<?php
/* @var $this EventsController */
/* @var $model Events */


$this->breadcrumbs=array(
	'Manage Events',
);

if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
	$cat_condition = 'and (id ='.$_REQUEST['cat_id'].' OR parent_id ='.$_REQUEST['cat_id'].')';
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
		<li title="Events" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('events')."?menu_id=".$m_id."&cat_id=".$c_id; ?>"><i class="glyphicon glyphicon-calendar"></i></a></li>
		<?php if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){ ?>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/events_cat',array('type'=>'com_jevents','cat_id'=>isset($_REQUEST["cat_id"])?$_REQUEST["cat_id"]:'','menu_id'=>isset($_REQUEST["menu_id"])?$_REQUEST["menu_id"]:'')); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
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
    <h2><i class="glyphicon glyphicon-calendar"></i> Events</h2>

    <div class="navbar-right event-btn">
    <?php
    # Yogi: Code for show hide past events
    if(isset($_REQUEST['past']) && $_REQUEST['past'] == 1){
		$past = 0;
		$pastEventTitle = "Hide Past Events";
		$bgcolor = '#ee797b';
	}else{
		$pastEventTitle = "Show Past Events";
		$past = 1;
		$bgcolor = '#428bca';
	}?>
	<a style="background-color:<?php echo $bgcolor ?>;border-radius:5px;color:#ffffff;padding:5px;text-decoration:none;" href="<?php echo Yii::app()->createAbsoluteUrl('events')."?menu_id=".$m_id."&cat_id=".$c_id."&past=".$past; ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-search"></i> &nbsp;<?php echo $pastEventTitle; ?></a>
	<a href="<?php echo Yii::app()->createAbsoluteUrl('eventsDetail/create')."?menu_id=".$m_id."&cat_id=".$c_id; ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
	<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Delete',array('events/ajaxupdate','act'=>'doDelete'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){bootbox.alert("Please make a selection from the list to delete");}else{if(confirm("Are You Sure you want to delete?")) return true; return false;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-ok-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Published',array('events/ajaxupdate','act'=>'doActive'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){alert("Please make a selection from the list to published");}else{return true;}}','success'=>'reloadGrid')); ?></a>
	<a href="#"><i class="glyphicon glyphicon-remove-sign icon-white"></i> <?php echo CHtml::ajaxSubmitButton('Unpublished',array('events/ajaxupdate','act'=>'doInactive'),array('beforeSend'=>'function() {if($("#events-grid").find("input:checked").length ==0){alert("Please make a selection from the list to unpublished");}else{return true;}}','success'=>'reloadGrid')); ?></a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content ">
<?php 
	# CODE FOR SET PAGE SIZE START
	$pageSize = Yii::app()->user->getState( 'pageSizeEvents', Yii::app()->params[ 'defaultPageSize' ] );
	$pageSizeDropDown = CHtml::dropDownList(
		'pageSize',
		$pageSize,
		array( 10 => 10, 25 => 25, 50 => 50, 100 => 100 ),
		array(
			'class'    => 'change-pagesize', 
			'onchange' => "$.fn.yiiGridView.update('events-grid',{data:{pageSize:$(this).val()}});",
		)
	);

?>
<div class="page-size-wrap">
	<span>Display </span><?php echo  $pageSizeDropDown; ?> Records
</div>
<?php Yii::app()->clientScript->registerCss( 'initPageSizeCSS', '.page-size-wrap{text-align: right;}' ); 
	# CODE FOR SET PAGE SIZE END ?>


<?php $this->widget('zii.widgets.grid.CGridView',array_merge(CommonController::CGridViewCommonSettings(),array(

	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50', 
			'htmlOptions' => array('style' => 'vertical-align: middle;text-align:center;'),
        ),
		array( 
	        'name'=>'event_search',
			'type'=>'raw',
	        'value'=>'CHtml::link($data->eventsDetaildata->summary, array("/eventsDetail/update", "id"=>$data->eventsDetaildata->evdet_id))',
	        'header'=>'Name',
			'filter'=>CHtml::activeTextField($model,'event_search',array('class' => 'form-control')),
			'htmlOptions'=>array('style' => 'vertical-align: middle;'),
		),
		array(
            'name'  => 'categoriesCat.title',
			'header'=>'Events Category',
            'type'  => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width: 16%;vertical-align: middle;'),
			'filter'=>CHtml::activedropDownList($model, 'catid',  
                CHtml::listData(Categories::model()->findAll('section="com_jevents" and published=1 '.$cat_condition.' ORDER BY title ASC'), 'id', 'title'),
				array('empty' => "Please Select", 'class' => 'form-control')
            ),
        ),
		array( 
			'name'=>'event_feature',
			'header'=>'Featured',
			'type' => 'raw',
			'value'=>'CHtml::link("", array("/events/featuredstatus", "id"=>$data->detail_id,"status"=>$data->eventfeatured==""?"0":$data->eventfeatured->value,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->eventfeatured==""?"unpub":($data->eventfeatured->value ? "pub" : "unpub") 
			));',
			'filter'=>CHtml::activedropDownList($model, 'event_feature',  
                array(''=>'All','1'=>'Featured','0'=>'Unfeatured'),
				array('class' => 'form-control')
            ),
			'htmlOptions'=>array('style' => 'width:12.4%;vertical-align: middle;text-align:center;'),
		),
		array( 
			'name'=>'state',
			'type' => 'html',
			'header'=>'Published',
			'value'=>'CHtml::link("", array("/events/updatestatus", "id"=>$data->ev_id,"status"=>$data->state,"query_url"=>$_SERVER["QUERY_STRING"]),array("class" => $data->state ? "pub" : "unpub"));',
			'filter'=>CHtml::activedropDownList($model, 'state',  
                array(''=>'All','1'=>'published','0'=>'unpublished'),
				array('class' => 'form-control')
            ),
		 	'htmlOptions' => array('style' => 'width: 12.4%;text-align:center;vertical-align: middle;'),
		),
		array( 
			'name'=>'eventsDetaildata.dtstart',
			'header'=>'Event Date',
			'type' => 'raw',
			//'value'=>'"From: ".date("Y-m-d H:i:s",$data->eventsDetaildata->dtstart)."<br>End: ".date("Y-m-d H:i:s",$data->eventsDetaildata->dtend)',
			//'value'=>'"From: ".checkDateEventDate($data) ."<br/>End: ". checkDateEventDate($data->eventsDetaildata->dtend)',
			'value'=>'checkDateEventDate($data->eventsRuledata,$data->ev_id)',
			'htmlOptions'=>array('style' => 'width: 18%;vertical-align: middle;text-align:left;'),
		),
		array( 
			'name'=>'usersData.name',
			'header'=>'Creator',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'width:5%;vertical-align: middle;text-align:center;'),
		),
		array( 
			'name'=>'ev_id',
			'filter'=>false,
			'htmlOptions'=>array('style' => 'width:5%;vertical-align: middle;text-align:center;'),
		),
		/*
		array( 
			'name'=>'usersData.name',
			'type' => 'html',
		 	'htmlOptions' => array('style' => 'text-align:center;'),
			'header'=>'Event Creator',
		),
		'created_by_alias',
		'uid',
		'icsid',
		'refreshed',
		'created',
		'modified_by',
		'rawdata',
		'recurrence_id',
		'detail_id',
		'access',
		'lockevent',
		'author_notified',
		*/
		array(
			'class'=>'TWButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) $("#status_msg").html(data);$("#status_msg").show();$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");}',
			'template'=>'{update}{delete}',
			'header'=>'Actions',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 10px"></i>',
					'imageUrl' => false,
					'url'=>'CController::createUrl("/eventsDetail/update",array("id"=>$data->eventsDetaildata->evdet_id))',
					
				),
				'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					//'url'=>'CController::createUrl("/events/delete",array("id"=>$data->eventsDetaildata->evdet_id))',
					'csrf'=>true,
				),
			),	
			'htmlOptions'=>array('style' => 'vertical-align: middle;text-align:center;'),
		),
		
	),

))); ?>

<script>
function reloadGrid(data) {
	$("#status_msg").html(data);
	$("#status_msg").show();
	$("#status_msg").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $.fn.yiiGridView.update('events-grid');
}
</script>



<!--<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('events-grid');
}
</script>-->

</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
<?php
/**
* check date time same as old admin
* @param date $date
* 
* @return date
*/

function checkDateEventDate($rule,$eventid){
	// check for show past event or not
	if(isset($_GET['past']) && $_GET['past'] == 1){
		$showPast = TRUE;
	}else{
		$showPast = FALSE;
	}
	
	$sqlProvider = new CSqlDataProvider("SELECT MIN(startrepeat) as startDate, MAX(endrepeat) as endDate FROM jos_jevents_repetition WHERE eventid = $eventid GROUP BY eventid");
	$sqlProvider = $sqlProvider->getData();
	$stdate = $sqlProvider[0]['startDate'];
	$enddate = $sqlProvider[0]['endDate'];
	//SU,MO,TU,WE,TH,FR,SA
	$days = array('SU'=>'sunday','MO'=>'monday','TU'=>'tuesday','WE'=>'wednesday','TH'=>'thursday','FR'=>'friday','SA'=>'saturday',
	'Sun'=>'sunday','Mon'=>'monday','Tue'=>'tuesday','Wed'=>'wednesday','Thu'=>'thursday','Fri'=>'friday','Sat'=>'saturday');
	switch($rule->freq){
		case "DAILY":
			if(date('Y-m-d') < date('Y-m-d',strtotime($stdate))){
				$start_date = date('Y-m-d',strtotime($stdate));
			}elseif($showPast){
				$start_date = date('Y-m-d', strtotime($stdate));
			}else{
				$start_date = date('Y-m-d', strtotime("-1 days"));
			}
			break;
		case "WEEKLY":
			if(date('Y-m-d') < date('Y-m-d',strtotime($stdate))){
				$start_date = date('Y-m-d',strtotime($stdate));
			}elseif($showPast){
				$start_date = date('Y-m-d', strtotime($stdate));
			}else{
				$rule->byday = ($rule->byday)?$rule->byday:date('D', strtotime("-1 days"));
				$startDay = explode(',',$rule->byday);
				$nextDay = strtotime("next ".$days[$startDay[0]]);
				$start_date = date('Y-m-d', $nextDay);
			}
			break;
			
		case "none":
			if(date('Y-m-d') < date('Y-m-d',strtotime($stdate))){
				$start_date = date('Y-m-d',strtotime($stdate));
			}else{
				$start_date = date('Y-m-d', strtotime($stdate));
			}
			break;
		
		default:
			$start_date = $stdate;
			break;
	}
	
	$start_date = date('Y-m-d', strtotime($start_date)) ;
	$stop_date = date('Y-m-d',strtotime($enddate));
	$start_time = date('H:i:s',strtotime($stdate));
	$stop_time = date('H:i:s',strtotime($enddate));
	
	$start_time = ($start_time == '00:00:00')?NULL:$start_time;
	$stop_time = ($stop_time == '23:59:59')?NULL:$stop_time;
	
	echo 'From : ' . $start_date.' '.$start_time . '<br />To : ' . $stop_date.' '.$stop_time . '<br/>';
	
}

 ?>
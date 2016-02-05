<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */

$this->breadcrumbs=array(
	'Update Website Settings',
);

?>
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
<!--BREADCRUMB START-->
<div><ul class="breadcrumb">
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
				<!--<li title="Page Meta" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('pagemeta'); ?>"><i class="glyphicon glyphicon-cogwheel"></i></a></li>-->
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
<div class="row">
    <div class="box col-md-12">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>
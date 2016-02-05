<?php
$this->pageTitle	= 'Change Password';
$this->breadcrumbs	= array('Change Password',);
?>

<!-- MESSAGE ALERT BOX START -->
<div id="status_msg" style="display: none"></div>
 <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="tw_success" style="position:static;left: auto;right: auto;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
		<?php Yii::app()->clientScript->registerScript(
			   'myHideEffect',
			   '$(".tw_success").animate({opacity: 1.0}, 500000).fadeOut("slow");',
			   CClientScript::POS_READY
			);?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('fail')):?>
    <div class="tw_fail" style="position:static;left: auto;right: auto;">
        <?php echo Yii::app()->user->getFlash('fail'); ?>
		<?php Yii::app()->clientScript->registerScript(
			   'myHideEffect',
			   '$(".tw_success").animate({opacity: 1.0}, 500000).fadeOut("slow");',
			   CClientScript::POS_READY
			);?>
    </div>
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->

<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
	    'id'=>'tw-chpass-form',
		'enableAjaxValidation' => true,
	    'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
		'htmlOptions' => array(
	                    'class' => 'tw-form-horizontal margin-top-10px',
						'autocomplete' => 'off',
						)
		)); ?>

<div class="adminform">
	<p class="note" style="color:#777777;text-align: left;">Enter new password</p>
	
	<div class="form-group clearfix">
		<div class="col-md-9">
			<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'New Password','value'=>'')); ?>
			<?php echo $form->hiddenField($model, 'tokenhid',array('value' => $model->token)); ?>
			<?php echo $form->error($model,'password',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<!-- Confirm Password code Start BY YOGI-->
	<div class="form-group clearfix">
		<div class="col-md-9">
			<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'Confirm new password')); ?>
			<?php echo $form->error($model,'verifyPassword',array('style'=>'color:#a94442;')); ?>
		</div>	
	</div>
	<!-- Confirm Password code End BY YOGI-->	
	
	<div class="form-group clearfix">
		<div class="modal-footer" style="text-align: left;">
			<?php echo CHtml::submitButton('Submit',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	 
   <!-- <div class="row">
            New Password : <input name="Ganti[password]" id="ContactForm_email" type="password">
            <input name="Ganti[tokenhid]" id="ContactForm_email" type="hidden" value="<?php echo $model->token?>">
    </div>-->
 
    <!--div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>-->
	</div>
	<?php $this->endWidget(); ?>
</div><!-- form -->
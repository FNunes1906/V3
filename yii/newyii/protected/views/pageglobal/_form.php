<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pageglobal-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'site_name'); ?>
		<?php echo $form->textField($model,'site_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'site_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'googgle_map_api_keys'); ?>
		<?php echo $form->textArea($model,'googgle_map_api_keys',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'googgle_map_api_keys'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_code'); ?>
		<?php echo $form->textField($model,'location_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'beach'); ?>
		<?php echo $form->textField($model,'beach',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'beach'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photo_mini_slider_cat'); ?>
		<?php echo $form->textField($model,'photo_mini_slider_cat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'photo_mini_slider_cat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photo_upload_cat'); ?>
		<?php echo $form->textField($model,'photo_upload_cat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'photo_upload_cat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'facebook'); ?>
		<?php echo $form->textField($model,'facebook',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'facebook'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iphone'); ?>
		<?php echo $form->textField($model,'iphone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'iphone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'android'); ?>
		<?php echo $form->textField($model,'android',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'android'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Header_color'); ?>
		<?php echo $form->textField($model,'Header_color',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Header_color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Footer_Menu_Link'); ?>
		<?php echo $form->textField($model,'Footer_Menu_Link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Footer_Menu_Link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'distance_unit'); ?>
		<?php echo $form->textField($model,'distance_unit',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'distance_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weather_unit'); ?>
		<?php echo $form->textField($model,'weather_unit',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'weather_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<?php echo $form->textField($model,'twitter',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'twitter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'youtube'); ?>
		<?php echo $form->textField($model,'youtube',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'youtube'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_zone'); ?>
		<?php echo $form->textField($model,'time_zone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'time_zone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_format'); ?>
		<?php echo $form->textField($model,'date_format',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'date_format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_format'); ?>
		<?php echo $form->textField($model,'time_format',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'time_format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'homeslidercat'); ?>
		<?php echo $form->textField($model,'homeslidercat'); ?>
		<?php echo $form->error($model,'homeslidercat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'site_name'); ?>
		<?php echo $form->textField($model,'site_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'googgle_map_api_keys'); ?>
		<?php echo $form->textArea($model,'googgle_map_api_keys',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location_code'); ?>
		<?php echo $form->textField($model,'location_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'beach'); ?>
		<?php echo $form->textField($model,'beach',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'photo_mini_slider_cat'); ?>
		<?php echo $form->textField($model,'photo_mini_slider_cat',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'photo_upload_cat'); ?>
		<?php echo $form->textField($model,'photo_upload_cat',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'facebook'); ?>
		<?php echo $form->textField($model,'facebook',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iphone'); ?>
		<?php echo $form->textField($model,'iphone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'android'); ?>
		<?php echo $form->textField($model,'android',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Header_color'); ?>
		<?php echo $form->textField($model,'Header_color',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Footer_Menu_Link'); ?>
		<?php echo $form->textField($model,'Footer_Menu_Link',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'distance_unit'); ?>
		<?php echo $form->textField($model,'distance_unit',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weather_unit'); ?>
		<?php echo $form->textField($model,'weather_unit',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'twitter'); ?>
		<?php echo $form->textField($model,'twitter',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'youtube'); ?>
		<?php echo $form->textField($model,'youtube',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_zone'); ?>
		<?php echo $form->textField($model,'time_zone',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_format'); ?>
		<?php echo $form->textField($model,'date_format',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_format'); ?>
		<?php echo $form->textField($model,'time_format',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'homeslidercat'); ?>
		<?php echo $form->textField($model,'homeslidercat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
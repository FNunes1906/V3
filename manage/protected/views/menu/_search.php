<?php
/* @var $this MenuController */
/* @var $model Menu */
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
		<?php echo $form->label($model,'menutype'); ?>
		<?php echo $form->textField($model,'menutype',array('size'=>60,'maxlength'=>75)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link'); ?>
		<?php echo $form->textArea($model,'link',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent'); ?>
		<?php echo $form->textField($model,'parent',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'componentid'); ?>
		<?php echo $form->textField($model,'componentid',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sublevel'); ?>
		<?php echo $form->textField($model,'sublevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checked_out'); ?>
		<?php echo $form->textField($model,'checked_out',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checked_out_time'); ?>
		<?php echo $form->textField($model,'checked_out_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pollid'); ?>
		<?php echo $form->textField($model,'pollid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'browserNav'); ?>
		<?php echo $form->textField($model,'browserNav'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'access'); ?>
		<?php echo $form->textField($model,'access'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'utaccess'); ?>
		<?php echo $form->textField($model,'utaccess'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lft'); ?>
		<?php echo $form->textField($model,'lft',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rgt'); ?>
		<?php echo $form->textField($model,'rgt',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home'); ?>
		<?php echo $form->textField($model,'home',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
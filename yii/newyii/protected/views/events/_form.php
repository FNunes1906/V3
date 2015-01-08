<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'icsid'); ?>
		<?php echo $form->textField($model,'icsid'); ?>
		<?php echo $form->error($model,'icsid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catid'); ?>
		<?php echo $form->textField($model,'catid'); ?>
		<?php echo $form->error($model,'catid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->textField($model,'uid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'refreshed'); ?>
		<?php echo $form->textField($model,'refreshed'); ?>
		<?php echo $form->error($model,'refreshed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by_alias'); ?>
		<?php echo $form->textField($model,'created_by_alias',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'created_by_alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rawdata'); ?>
		<?php echo $form->textArea($model,'rawdata',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'rawdata'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recurrence_id'); ?>
		<?php echo $form->textField($model,'recurrence_id',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'recurrence_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detail_id'); ?>
		<?php echo $form->textField($model,'detail_id'); ?>
		<?php echo $form->error($model,'detail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state'); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'access'); ?>
		<?php echo $form->textField($model,'access',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'access'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lockevent'); ?>
		<?php echo $form->textField($model,'lockevent'); ?>
		<?php echo $form->error($model,'lockevent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_notified'); ?>
		<?php echo $form->textField($model,'author_notified'); ?>
		<?php echo $form->error($model,'author_notified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
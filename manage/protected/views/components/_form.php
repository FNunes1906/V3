<?php
/* @var $this ComponentsController */
/* @var $model Components */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'components-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuid'); ?>
		<?php echo $form->textField($model,'menuid',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'menuid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php echo $form->textField($model,'parent',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_menu_link'); ?>
		<?php echo $form->textField($model,'admin_menu_link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'admin_menu_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_menu_alt'); ?>
		<?php echo $form->textField($model,'admin_menu_alt',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'admin_menu_alt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option'); ?>
		<?php echo $form->textField($model,'option',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'option'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
		<?php echo $form->error($model,'ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_menu_img'); ?>
		<?php echo $form->textField($model,'admin_menu_img',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'admin_menu_img'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iscore'); ?>
		<?php echo $form->textField($model,'iscore'); ?>
		<?php echo $form->error($model,'iscore'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enabled'); ?>
		<?php echo $form->textField($model,'enabled'); ?>
		<?php echo $form->error($model,'enabled'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
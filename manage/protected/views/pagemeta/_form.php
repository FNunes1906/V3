<?php
/* @var $this PagemetaController */
/* @var $model Pagemeta */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagemeta-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('class' => 'adminform')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group clearfix">
	    <label for="URL" class="col-md-3"><?php echo $form->labelEx($model,'uri',array('style'=>'text-transform: uppercase;')); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'uri',array('class'=>'form-control','placeholder'=>'Enter URL')); ?>
			<?php echo $form->error($model,'uri',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
	    <label for="Title" class="col-md-3"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Title')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
	    <label for="Description" class="col-md-3"><?php echo $form->labelEx($model,'Meta Description'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'metadesc',array('class'=>'form-control','placeholder'=>'Enter Meta Description')); ?>
			<?php echo $form->error($model,'metadesc'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
	    <label for="keywords" class="col-md-3"><?php echo $form->labelEx($model,'Meta Keywords'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'keywords',array('class'=>'form-control','placeholder'=>'Enter keywords')); ?>
			<?php echo $form->error($model,'keywords'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
	    <label for="Extra Meta" class="col-md-3"><?php echo $form->labelEx($model,'Extra Meta'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'extra_meta',array('class'=>'form-control','placeholder'=>'Enter Extra Meta')); ?>
			<?php echo $form->error($model,'extra_meta'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<div class="modal-footer">
			
			<?php echo CHtml::link('Cancel',array('/pagemeta'),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

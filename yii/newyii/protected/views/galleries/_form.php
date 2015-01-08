<?php
/* @var $this GalleriesController */
/* @var $model Galleries */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'galleries-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'catid'); ?>
		<?php echo $form->textField($model,'catid'); ?>
		<?php echo $form->error($model,'catid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sid'); ?>
		<?php echo $form->textField($model,'sid'); ?>
		<?php echo $form->error($model,'sid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hits'); ?>
		<?php echo $form->textField($model,'hits'); ?>
		<?php echo $form->error($model,'hits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'latitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zoom'); ?>
		<?php echo $form->textField($model,'zoom'); ?>
		<?php echo $form->error($model,'zoom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geotitle'); ?>
		<?php echo $form->textField($model,'geotitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'geotitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'videocode'); ?>
		<?php echo $form->textArea($model,'videocode',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'videocode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vmproductid'); ?>
		<?php echo $form->textField($model,'vmproductid'); ?>
		<?php echo $form->error($model,'vmproductid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imgorigsize'); ?>
		<?php echo $form->textField($model,'imgorigsize'); ?>
		<?php echo $form->error($model,'imgorigsize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approved'); ?>
		<?php echo $form->textField($model,'approved'); ?>
		<?php echo $form->error($model,'approved'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked_out'); ?>
		<?php echo $form->textField($model,'checked_out'); ?>
		<?php echo $form->error($model,'checked_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked_out_time'); ?>
		<?php echo $form->textField($model,'checked_out_time'); ?>
		<?php echo $form->error($model,'checked_out_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
		<?php echo $form->error($model,'ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metakey'); ?>
		<?php echo $form->textArea($model,'metakey',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metakey'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metadesc'); ?>
		<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metadesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extlink1'); ?>
		<?php echo $form->textArea($model,'extlink1',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'extlink1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extlink2'); ?>
		<?php echo $form->textArea($model,'extlink2',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'extlink2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extid'); ?>
		<?php echo $form->textField($model,'extid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'extid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extl'); ?>
		<?php echo $form->textField($model,'extl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'extl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extm'); ?>
		<?php echo $form->textField($model,'extm',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'extm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exts'); ?>
		<?php echo $form->textField($model,'exts',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'exts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exto'); ?>
		<?php echo $form->textField($model,'exto',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'exto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extw'); ?>
		<?php echo $form->textField($model,'extw',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'extw'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exth'); ?>
		<?php echo $form->textField($model,'exth',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'exth'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
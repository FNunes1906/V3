<?php
/* @var $this GalleriesController */
/* @var $model Galleries */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'catid'); ?>
		<?php echo $form->textField($model,'catid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sid'); ?>
		<?php echo $form->textField($model,'sid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hits'); ?>
		<?php echo $form->textField($model,'hits'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zoom'); ?>
		<?php echo $form->textField($model,'zoom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'geotitle'); ?>
		<?php echo $form->textField($model,'geotitle',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'videocode'); ?>
		<?php echo $form->textArea($model,'videocode',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vmproductid'); ?>
		<?php echo $form->textField($model,'vmproductid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imgorigsize'); ?>
		<?php echo $form->textField($model,'imgorigsize'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved'); ?>
		<?php echo $form->textField($model,'approved'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checked_out'); ?>
		<?php echo $form->textField($model,'checked_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checked_out_time'); ?>
		<?php echo $form->textField($model,'checked_out_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'metakey'); ?>
		<?php echo $form->textArea($model,'metakey',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'metadesc'); ?>
		<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extlink1'); ?>
		<?php echo $form->textArea($model,'extlink1',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extlink2'); ?>
		<?php echo $form->textArea($model,'extlink2',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extid'); ?>
		<?php echo $form->textField($model,'extid',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extl'); ?>
		<?php echo $form->textField($model,'extl',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extm'); ?>
		<?php echo $form->textField($model,'extm',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exts'); ?>
		<?php echo $form->textField($model,'exts',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exto'); ?>
		<?php echo $form->textField($model,'exto',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extw'); ?>
		<?php echo $form->textField($model,'extw',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exth'); ?>
		<?php echo $form->textField($model,'exth',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
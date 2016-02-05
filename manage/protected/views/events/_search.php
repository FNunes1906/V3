<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ev_id'); ?>
		<?php echo $form->textField($model,'ev_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'icsid'); ?>
		<?php echo $form->textField($model,'icsid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'catid'); ?>
		<?php echo $form->textField($model,'catid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'uid'); ?>
		<?php echo $form->textField($model,'uid',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'refreshed'); ?>
		<?php echo $form->textField($model,'refreshed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by_alias'); ?>
		<?php echo $form->textField($model,'created_by_alias',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rawdata'); ?>
		<?php echo $form->textArea($model,'rawdata',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recurrence_id'); ?>
		<?php echo $form->textField($model,'recurrence_id',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detail_id'); ?>
		<?php echo $form->textField($model,'detail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'state'); ?>
		<?php echo $form->textField($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'access'); ?>
		<?php echo $form->textField($model,'access',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lockevent'); ?>
		<?php echo $form->textField($model,'lockevent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author_notified'); ?>
		<?php echo $form->textField($model,'author_notified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
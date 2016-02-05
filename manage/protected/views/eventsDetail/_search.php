<?php
/* @var $this EventsDetailController */
/* @var $model EventsDetail */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'evdet_id'); ?>
		<?php echo $form->textField($model,'evdet_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rawdata'); ?>
		<?php echo $form->textArea($model,'rawdata',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dtstart'); ?>
		<?php echo $form->textField($model,'dtstart'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dtstartraw'); ?>
		<?php echo $form->textField($model,'dtstartraw',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'duration'); ?>
		<?php echo $form->textField($model,'duration'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'durationraw'); ?>
		<?php echo $form->textField($model,'durationraw',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dtend'); ?>
		<?php echo $form->textField($model,'dtend'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dtendraw'); ?>
		<?php echo $form->textField($model,'dtendraw',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dtstamp'); ?>
		<?php echo $form->textField($model,'dtstamp',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class'); ?>
		<?php echo $form->textField($model,'class',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'categories'); ?>
		<?php echo $form->textField($model,'categories',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'color'); ?>
		<?php echo $form->textField($model,'color',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'geolon'); ?>
		<?php echo $form->textField($model,'geolon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'geolat'); ?>
		<?php echo $form->textField($model,'geolat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'priority'); ?>
		<?php echo $form->textField($model,'priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'summary'); ?>
		<?php echo $form->textArea($model,'summary',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact'); ?>
		<?php echo $form->textField($model,'contact',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'organizer'); ?>
		<?php echo $form->textField($model,'organizer',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textArea($model,'url',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extra_info'); ?>
		<?php echo $form->textField($model,'extra_info',array('size'=>60,'maxlength'=>240)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sequence'); ?>
		<?php echo $form->textField($model,'sequence'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'state'); ?>
		<?php echo $form->textField($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'multiday'); ?>
		<?php echo $form->textField($model,'multiday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hits'); ?>
		<?php echo $form->textField($model,'hits'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'noendtime'); ?>
		<?php echo $form->textField($model,'noendtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
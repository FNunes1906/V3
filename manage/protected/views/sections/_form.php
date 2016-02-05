<?php
/* @var $this SectionsController */
/* @var $model Sections */
/* @var $form CActiveForm */
/*$model_categories = Categories::model()->findAll('id='.$model->id);
echo "<pre>";
print_r($model_categories);
echo "</pre>";*/
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'sections-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('class' => 'adminform')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group clearfix">
		<label for="title" class="col-md-2"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Category name')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="Published" class="col-md-2"><?php echo $form->labelEx($model,'Published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	
	<div class="form-group clearfix">
		<div class="col-md-9">
			<?php echo $form->hiddenField($model,'scope',array('value'=>'content')); ?>
			<?php echo $form->error($model,'scope'); ?>
		</div>
	</div>
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
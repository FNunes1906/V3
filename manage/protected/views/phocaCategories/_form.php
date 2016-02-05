<?php
/* @var $this PhocaCategoriesController */
/* @var $model PhocaCategories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'phoca-categories-form',
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
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Title')); ?> 
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="parent_id" class="col-md-2"><?php echo $form->labelEx($model,'Parent Category'); ?></label>
		<div class="col-md-9">
			<?php
			$catData = CHtml::listData(PhocaCategories::model()->findAll(),'id','title');
			echo $form->dropDownList($model,'parent_id',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="published" class="col-md-2"><?php echo $form->labelEx($model,'Published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
		</div>
	</div>

	<!--<div class="form-group clearfix">
		<label for="approved" class="col-md-2"><?php echo $form->labelEx($model,'Approved :'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'approved',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
		</div>
	</div>-->
	<div>
				<?php echo $form->hiddenField($model,'approved',array('class'=>'form-control','value'=>1)); ?>		
	</div>
	
	<div class="form-group clearfix">
		<label for="hits" class="col-md-2"><?php echo $form->labelEx($model,'Hits :'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'hits',array('class'=>'form-control','readonly'=>'readonly','style'=>'width:90px;text-align: center;')); ?>
			<?php echo $form->error($model,'hits',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<?php 
		if(isset($model->date) AND $model->date!='0000-00-00 00:00:00'){
			$val=$model->date;
		}else{
			$val=date('Y-m-d H:i:s');
		} ?>
	<?php echo $form->hiddenField($model,'date',array('class'=>'form-control col-lg-10','data-format'=>'yyyy/MM/dd hh:mm:ss','value'=>$val)); ?>
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php 
			echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
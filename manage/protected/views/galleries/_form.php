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
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="form-group clearfix">
	<div style="margin-top: -12px;text-align: right;">
		<?php 
		echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));
		?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
	</div>
</div>

<div class="adminform">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

<!-- TW FORM CODE BEGIN -->
	
	<div class="form-group clearfix">
		<label for="event" class="col-md-2"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Image Name')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'catid'); ?></label>
		<div class="col-md-9">
			<?php
			$criteria1 = new CDbCriteria;
			$criteria1->addSearchCondition('published','1', true);
			$criteria1->addSearchCondition('approved','1', true);
			$phocaCatData = CHtml::listData(PhocaCategories::model()->findAll($criteria1),'id','title');
			if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
				$model->catid = $_REQUEST['cat_id'];
			}
			echo $form->dropDownList($model,'catid',$phocaCatData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select Category"));
			echo $form->error($model,'catid',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="photo" class="col-md-2"><?php echo $form->labelEx($model,'filename'); ?></label>
		<div class="col-md-9">
			<?php echo $form->fileField($model,'filename',array('draggable'=>'draggable')); ?>
			<?php echo $form->error($model,'filename'); ?>
			<?php $imageFromDB = Yii::app()->request->hostInfo.'/partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_'.$model->filename; 
			$tmp_url = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_'.$model->filename;
			?> 
			<br><?php if(file_exists($tmp_url)){
				echo CHtml::image($imageFromDB); 
			}?> 
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="custombannercode" class="col-md-2"><?php echo $form->labelEx($model,'videocode'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'videocode',array('style'=>'height:100px;','class'=>'form-control','placeholder'=>'Enter Video Code')); ?> 
			<?php echo $form->error($model,'videocode',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="Published" class="col-md-2"><?php echo $form->labelEx($model,'published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="Published" class="col-md-2"><?php echo $form->labelEx($model,'approved'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'approved',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	<!-- TW FORM CODE END -->
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();')); ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
</div>	
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this BannersController */
/* @var $model Banners */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'banners-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'adminform','name'=>"adminForm")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($form->errorSummary($model)!=''){
		echo "<div class='alert alert-danger'>".$form->errorSummary($model)."</div>";
	}
	 ?>
	<div class="form-group clearfix">
		<label for="name" class="col-md-2"><?php echo $form->labelEx($model,'Banner Name : *'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'Enter Banner name')); ?>
			<?php echo $form->error($model,'name',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="alias" class="col-md-2"><?php echo $form->labelEx($model,'alias'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'alias',array('class'=>'form-control','placeholder'=>'Enter alias name')); ?>
			<?php echo $form->error($model,'alias',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="showBanner" class="col-md-2"><?php echo $form->labelEx($model,'Published :'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'showBanner',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>
		
	<div class="form-group clearfix">
		<label for="catid" class="col-md-2"><?php echo $form->labelEx($model,'Category : *'); ?></label>
		<div class="col-md-9">
			<?php
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('section','com_banner', true);
			$catData = CHtml::listData(Categories::model()->findAll($criteria),'id','title');
			echo $form->dropDownList($model,'catid',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			echo $form->error($model,'catid');
			?>
			<?php echo $form->error($model,'catid',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="client" class="col-md-2"><?php echo $form->labelEx($model,'cid'); ?></label>
		<div class="col-md-9">
			<?php
			$clientData = CHtml::listData(Bannerclient::model()->findAll(),'cid','name');
			echo $form->dropDownList($model,'cid',$clientData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			echo $form->error($model,'cid',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="clickurl" class="col-md-2"><?php echo $form->labelEx($model,'clickurl'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'clickurl',array('class'=>'form-control','placeholder'=>'Enter url')); ?>
			<?php echo $form->error($model,'clickurl',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="clicks" class="col-md-2"><?php echo $form->labelEx($model,'Banner Clicks :'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'clicks',array('readonly'=>'readonly','style'=>'border:none;')); ?>
			<?php echo $form->error($model,'clicks',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="imageurl" class="col-md-2"><?php echo $form->labelEx($model,'imageurl'); ?></label>
		<div class="col-md-9">
			<?php 
				$dir = $_SERVER['DOCUMENT_ROOT'].'/partner/'.Yii::app()->db->tablePrefix.'/images/banners/';
				$files = scandir($dir);
				$list = array_slice(array_combine(array_values($files), $files),2);
				echo $form->dropDownList($model,'imageurl',$list,array('class'=>'form-control','prompt' => "Please Select",'data-rel'=>'chosen','onchange'=>"return changeDisplayImage(this.value);"));
			?>
			<?php if(isset($model->imageurl) AND $model->imageurl!=''){
					$imageFromDB = '/partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$model->imageurl; 
				}else{
					$imageFromDB = '/partner/'.Yii::app()->db->tablePrefix.'/images/banners/blank.png'; 
				}
				echo CHtml::image($imageFromDB,'banner_alt',array('name'=>'imagelib','style'=>'padding-top:10px;'));
			 ?> 
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="custombannercode" class="col-md-2"><?php echo $form->labelEx($model,'custombannercode'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'custombannercode',array('class'=>'form-control','placeholder'=>'Enter custom banner code')); ?> 
			<?php echo $form->error($model,'custombannercode',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="description" class="col-md-2"><?php echo $form->labelEx($model,'description'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'description',array('class'=>'form-control','placeholder'=>'Enter decription')); ?>
			<?php echo $form->error($model,'description',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<?php echo $form->hiddenField($model,'date',array('class'=>'form-control col-lg-10','data-format'=>'yyyy/MM/dd hh:mm:ss')); ?>
				
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php echo CHtml::button('Cancel',array('class' => 'btn btn-default','id' => 'buttonId','onclick'=>'window.history.back()'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript">
		function changeDisplayImage(name) {
			if (name !='') {
				document.adminForm.imagelib.src ='/partner/'.Yii::app()->db->tablePrefix.'/images/banners/' + name;
			}else{
				document.adminForm.imagelib.src = '/partner/'.Yii::app()->db->tablePrefix.'/images/banners/blank.png'; 
			}
		}
		</script>
</div><!-- form -->

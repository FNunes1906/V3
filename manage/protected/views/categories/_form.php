<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
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

	<div class="form-group clearfix required">
		<label for="Category" class="col-md-2"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Category name')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>

	<!--<div class="form-group clearfix">
		<label for="Category" class="col-md-2"><?php echo $form->labelEx($model,'alias'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'alias',array('class'=>'form-control','placeholder'=>'Enter Alias name')); ?>
			<?php echo $form->error($model,'alias',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>-->
	<?php if($_REQUEST['type']=='com_content'){ ?>
		<div class="form-group clearfix">
			<label for="section" class="col-md-2"><?php echo $form->labelEx($model,'section'); ?></label>
			<div class="col-md-9">
				<?php
				$secData = CHtml::listData(Sections::model()->findAll('scope="content" ORDER BY title ASC'), 'id', 'title');
				echo $form->dropDownList($model,'section',$secData,array('class'=>'form-control','data-rel'=>'chosen','data-placeholder'=>'Select Section'));
				echo $form->error($model,'section',array('style'=>'color:#a94442;'));
				?>
			</div>
		</div>
	<?php }else if($_REQUEST['type']=='com_banner'){?>
		<div>
				<?php echo $form->hiddenField($model,'section',array('class'=>'form-control','value'=>$_REQUEST['type'])); ?>		
		</div>
	<?php }else if($_REQUEST['type']=='com_jevlocations2' OR $_REQUEST['type']=='com_jevents'){?>
		<div class="form-group clearfix">
			<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'Parent Category'); ?></label>
			<div class="col-md-9">
				<?php 
				$catData = CHtml::listData(Categories::model()->findAll('section="'.$_REQUEST['type'].'" and published=1 ORDER BY title ASC'), 'id', 'title');
				echo $form->dropDownList($model,'parent_id',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
				echo $form->error($model,'parent_id',array('style'=>'color:#a94442;'));
				?>
			</div>
		</div>
		<div>
				<?php echo $form->hiddenField($model,'section',array('class'=>'form-control','value'=>$_REQUEST['type'])); ?>		
		</div>
	<?php }	?>
	<div class="form-group clearfix">
		<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'Published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php 
			if($_REQUEST['type']=='com_jevents'){
				//echo CHtml::link('Cancel', array("events_cat?type=com_jevents"),array('class' => 'btn btn-default'));
				echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));
			}elseif($_REQUEST['type']=='com_jevlocations2'){
				//echo CHtml::link('Cancel', array("locations_cat?type=com_jevlocations2"),array('class' => 'btn btn-default'));
				echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));
			}elseif($_REQUEST['type']=='com_banner'){
				echo CHtml::link('Cancel', array("banner_cat?type=com_banner"),array('class' => 'btn btn-default'));
			}
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	
	
<?php $this->endWidget(); ?>

</div><!-- form -->
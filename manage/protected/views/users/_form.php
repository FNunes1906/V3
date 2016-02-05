<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array('autocomplete' => 'off'),
)); ?>

<div class="form-group clearfix">
		<div style="margin-top: -12px;text-align: right;">
			<?php 
			echo CHtml::link('Cancel', array("/users"),array('class' => 'btn btn-default'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
<div class="adminform">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group clearfix">
		<label for="name" class="col-md-2"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'Enter Name')); ?>
			<?php echo $form->error($model,'name',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>

	<div class="form-group clearfix">
		<label for="username" class="col-md-2"><?php echo $form->labelEx($model,'username'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'Enter username')); ?>
			<?php echo $form->error($model,'username',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>

	<div class="form-group clearfix">
		<label for="email" class="col-md-2"><?php echo $form->labelEx($model,'email'); ?></label>
		<div class="col-md-9"><?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'Enter Email')); ?>
			<?php echo $form->error($model,'email',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>
		<?php if($model->isNewRecord):?>
			<div class="form-group clearfix">
				<label for="password" class="col-md-2"><?php echo $form->labelEx($model,'password'); ?></label>
				<div class="col-md-9">
					<?php //echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'Input Password')); ?>
					<?php $this->widget('ext.EStrongPassword.EStrongPassword',
								array('form'=>$form, 'model'=>$model, 'attribute'=>'password')); ?>
					<?php echo $form->error($model,'password',array('style'=>'color:#a94442;')); ?>
				</div>
	    	</div>
			
			<!-- Confirm Password code Start BY YOGI-->
			<div class="form-group clearfix">
				<label for="verifyPassword" class="col-md-2"><?php echo $form->labelEx($model,'verifyPassword'); ?></label>
				<div class="col-md-9">
					<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'Input confirm Password')); ?>
					<?php echo $form->error($model,'verifyPassword',array('style'=>'color:#a94442;')); ?>
				</div>	
			</div>
			<!-- Confirm Password code End BY YOGI-->
			
		<?php else:?>
			<div class="form-group clearfix">
				<label for="password" class="col-md-2"></label>
				<div class="col-md-9">
					<button class="btn btn-info" style="font-size:12px;font-weight:bold;padding:3px 10px;" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Change Password</button>
				</div>
	    	</div>
			
			<div class="collapse" id="collapseExample">
			   <!--PASSWORD Section START -->
				<div class="form-group clearfix">
					<label for="password" class="col-md-2"><?php echo $form->labelEx($model,'password'); ?></label>
					<div class="col-md-9">
					<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'New Password','value' => $model->password)); ?>
					<!--<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'New Password','value' => $model->password,'onClick'=>'Clear("clearPass");','id'=>'clearPass')); ?>-->
					<?php echo $form->hiddenField($model, 'hdnPassword',array('value' => $model->password)); ?>
					<?php echo $form->error($model,'password',array('style'=>'color:#a94442;')); ?>
					</div>
			    </div>
				<div class="form-group clearfix">
					<label for="verifyPassword" class="col-md-2"><?php echo $form->labelEx($model,'verifyPassword'); ?></label>
					<div class="col-md-9">
						<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'Input confirm Password','value' => $model->password)); ?>
						<!--<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'Input confirm Password','value' => $model->password,'onClick'=>'Clear("clearVerifyPass");','id'=>'clearVerifyPass')); ?>-->
						<?php echo $form->error($model,'verifyPassword',array('style'=>'color:#a94442;')); ?>
					</div>	
				</div>
				<!--PASSWORD Section END -->
			</div>
	<?php endif;?>

<!--	<div class="form-group clearfix">
		<label for="password" class="col-md-2"><?php echo $form->labelEx($model,'usertype'); ?></label>
		<div class="col-md-9">
			<?php //echo $form->textField($model,'usertype',array('class'=>'form-control'));
			$criteria1 = new CDbCriteria;
			//$criteria1->addCondition('id=18 or id=23 or id=24 or id=25 or id=31');
			$criteria1->addCondition("id<>17 and id<>28 and id<>29 and id<>30");
			$groups = CHtml::listData(Usergroups::model()->findAll($criteria1),'name','name');
			echo $form->dropDownList($model,'usertype',$groups,array('class'=>'form-control','data-rel'=>'chosen'));
			
			 ?>
			<?php echo $form->error($model,'usertype',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>
-->

	<?php
	# Fetch Current login user's information
	$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
	?>
	<?php if($model->id != $currentLoginUser->id): ?>
		<div class="form-group clearfix">
			<label for="block" class="col-md-2"><?php echo $form->labelEx($model,'block'); ?></label>
			<div class="col-md-9">
				<?php echo  $form->radioButtonList($model,'block',array('0'=>'Yes','1'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
				<?php echo $form->error($model,'block',array('style'=>'color:#a94442;')); ?>
			</div>
	    </div>
	<?php endif; ?>
	
	<div class="form-group clearfix">
		<label for="block" class="col-md-2"><?php echo $form->labelEx($model,'registerDate'); ?></label>
		<div class="col-md-9">
			<?php 
			if(isset($model->registerDate) AND $model->registerDate!='0000-00-00 00:00:00'){
				$val=$model->registerDate;
			}else{
				$val=date('Y-m-d H:i:s');
			} 
			echo $form->textField($model,'registerDate',array('class'=>'form-control','readonly'=>'readonly','value'=>$val )); ?>
			<?php echo $form->error($model,'registerDate',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>
	<div class="row">
		<?php echo $form->hiddenField($model,'gid'); ?>
	</div>

	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php 
			echo CHtml::link('Cancel', array("/users"),array('class' => 'btn btn-default'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->


<!--<script type="text/javascript">
function Clear(id){  
	document.getElementById(id).value= "";
}
</script>-->


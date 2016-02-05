<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="ch-container">
	<div class="row">
		<div class="form">
			<?php $form = $this->beginWidget('CActiveForm', array(
				'htmlOptions'=>array(
					'class'=>'form-horizontal',
				),
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

			<!--TW LOGO-->
			<div class="row" style="margin:0px;">
			    <div class="col-md-12 center login-header">
					<a href="http://www.townwizard.com">
						<img alt="Townwizard Logo" src="<?php echo Yii::app()->theme->baseUrl.'/';?>img/Login_screen_new_logo.png" class="img-responsive center-block" style="display:inherit !important"/>
					</a>
				</div>
			</div>

			<div class="row" style="margin-top:60px;margin-left:13px;margin-right:13px;">
				<div class="well col-md-5 center login-box">
					<div class="alert alert-info">Please login with your E-mail and Password.</div>
					<!--
					<?php if($form->errorSummary($model)!=''){
						echo "<div class='alert alert-danger'>".$form->errorSummary($model)."</div>";
					}
					 ?>-->
					<fieldset>
						<!--User Name Text Box-->
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
							<?php echo $form->textField($model,'username', array('class' => 'form-control', 'placeholder' => 'E-mail')); ?>
						</div>	
						<?php echo $form->error($model,'username',array('style'=>'color:#a94442;font-weight: bold;')); ?>
						<div class="clearfix"></div><br>	
						
						<!--Password Text Box-->
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
							<?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
						</div>
						<?php echo $form->error($model,'password',array('style'=>'color:#a94442;font-weight: bold;')); ?>
						<div class="clearfix"></div>
						<br />
						<div class="row rememberMe">
							<?php echo $form->checkBox($model,'rememberMe'); ?>
							<?php echo $form->label($model,'rememberMe'); ?>
							<?php echo $form->error($model,'rememberMe'); ?>
						</div>
						<!-- <a href="#" class="">Forgot your Password?</a> -->
						<h2 style="font-size: 11pt;margin-top:8px;">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('site/forgot'); ?>" data-target="#forgotpassword" data-toggle="ajaxForgotModal">
								Forgot Password?
							</a>
						</h2>
	
						<p class="center col-md-5">
							<!--<button type="submit" class="btn btn-primary">Login</button>-->
							<?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary')); ?>
						</p>
					</fieldset>
				</div>
			</div>
			
			<div id="forgotpassword" class="modal fade"></div>
			
			<script type="text/javascript">
			$('[data-toggle="ajaxForgotModal"]').on('click',
				function(e) {
					$('#ajaxForgotModal').remove();
					e.preventDefault();
					var $this = $(this)
					    , $remote = $this.data('remote') || $this.attr('href')
					    , $modal = $('<div class="modal" id="ajaxForgotModal"><div class="modal-body"></div></div>');
					$('body').append($modal);
					$modal.modal({backdrop: 'static', keyboard: false});
					$modal.load($remote);
				}
			);
			</script>
			
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>	

<div class="modal-dialog modal-sm">
    <div class="modal-content">
	
        <div class="loading-shadow" id="loading-shadow" style="display: none; height:100%; width:100%;">
			<div class="loading" style="top:35%;text-align:center;height:0px;">
				<img src="<?php echo Yii::app()->theme->baseUrl . '/img/ajax-loaders/ajax-loader-9.gif'; ?>" alt="Loading..." />
			</div>
		</div>
        <div class="modal-header tw-modal-header" style="text-align:left;">
            <button type="button" class="btn btn-danger pull-right" onclick="javascript:window.location.reload();" data-dismiss="modal" style="border-radius:2px;padding:5px 10px;">Close
                <tag class="icon-sr-icons-close"></tag>
            </button>
			<span class="glyphicon glyphicon-lock" style="font-size: 3em;"></span>
            <p style="font-size: 12px; text-align: left;">Please enter the email address you used to create your account, and we will send you a link to reset your password.</p>
			<h2 class="modal-title" id="myModalLabel" style="text-align:left;">Forgot Password?</h2>
        </div>
        <div id='messageTxtDiv' class="alert fade in margin-top-5px margin-bottom-5px margin-left-5px margin-right-5px" role="alert" style='display: none;'><button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button><span id='messageTxt'></span></div>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'tw-forgot-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate' => 'js:function(form,data,hasError){
                if(!hasError){
                        $("#loading-shadow").show();
                        $.ajax({
                                "type":"POST",
                                "url":"' . CHtml::normalizeUrl(array("site/forgot")) . '",
                                "data":form.serialize(),
                                "success":function(data){

                                    if(data == 1) {
                                        $("#messageTxtDiv").removeClass("alert-danger");
                                        $("#messageTxtDiv").addClass("alert-success");
                                        $("#messageTxt").html("A link to reset password was sent to your inbox.");
                                        $("#messageTxtDiv").show();
                                        $("#tw-forgot-form")[0].reset();
                                        setTimeout(function(){ $("#messageTxtDiv").hide("slow"); }, 5000);
                                    } else if(data == 2) {
                                        $("#messageTxtDiv").removeClass("alert-success");
                                        $("#messageTxtDiv").addClass("alert-danger");
                                        $("#messageTxt").html("No such user in our database");
                                        $("#messageTxtDiv").show();
                                        setTimeout(function(){ $("#messageTxtDiv").hide("slow"); }, 5000);
                                    } else {
                                        $("#messageTxtDiv").removeClass("alert-success");
                                        $("#messageTxtDiv").addClass("alert-danger");
                                        $("#messageTxt").html("There is some error, please try again later.");
                                        $("#messageTxtDiv").show();
                                        setTimeout(function(){ $("#messageTxtDiv").hide("slow"); }, 5000);
                                    }
                                    $("#loading-shadow").hide();
                                    return false;
                                    },
                                });
                        }
                }'
                ),
                'htmlOptions' => array(
                    'class' => 'tw-form-horizontal margin-top-10px',
                    'role' => 'form',
                ),
            ));
            ?>

            <div class="form-group row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <!--<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sr-control-label" for="inputEmail3">Email</label>-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<br />
                        <?php echo $form->textfield($model, 'email', array('class' => 'form-control input-md', 'placeholder' => 'Enter your email address', 'data-bv-notempty' => 'true', 'data-bv-emailaddress' => 'true','style'=>'font-weight:normal;')); ?>
                        <?php echo $form->error($model, 'email',array('style' => 'text-align:left')); ?>
                    </div>
                </div>
                <div class="container-fluid padding-bottom-15px">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group" style="text-align: left;">
                            <div class="btn-group">
								<br />
                                <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-md btn-primary pull-left margin-top-zero margin-bottom-zero','style'=>'border-radius:2px;padding:5px 10px;')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div> <!-- Form -->
    </div>
</div>

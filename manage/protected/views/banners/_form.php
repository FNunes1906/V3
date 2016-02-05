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
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('name'=>"adminForm",'enctype' => 'multipart/form-data')
)); ?>
	<div class="form-group clearfix">
		<div style="margin-top: -12px;text-align: right;">
			<?php 
			echo CHtml::link('Cancel', array("/banners"),array('class' => 'btn btn-default'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
<div class="adminform">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group clearfix">
		<label for="name" class="col-md-2"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'Enter Banner name')); ?>
			<?php echo $form->error($model,'name',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<!--<div class="form-group clearfix">
		<label for="alias" class="col-md-2"><?php echo $form->labelEx($model,'alias'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'alias',array('class'=>'form-control','placeholder'=>'Enter alias name')); ?>
			<?php echo $form->error($model,'alias',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>-->
	<div class="form-group clearfix">
		<label for="catid" class="col-md-2"><?php echo $form->labelEx($model,'catid'); ?></label>
		<div class="col-md-9">
			<?php
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('section','com_banner', true);
			$catData = CHtml::listData(Categories::model()->findAll($criteria),'id','title');
			echo $form->dropDownList($model,'catid',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			?>
			<?php echo $form->error($model,'catid',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="showBanner" class="col-md-2"><?php echo $form->labelEx($model,'showBanner'); ?></label>
		<div class="col-md-9">
			<?php $model->isNewRecord ? $model->showBanner = 1: $model->showBanner = $model->showBanner ;  ?>
			<?php echo  $form->radioButtonList($model,'showBanner',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
		
	</div>
		
	
	<!--<div class="form-group clearfix">
		<label for="client" class="col-md-2"><?php echo $form->labelEx($model,'cid'); ?></label>
		<div class="col-md-9">
			<?php
			$clientData = CHtml::listData(Bannerclient::model()->findAll(),'cid','name');
			echo $form->dropDownList($model,'cid',$clientData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			?>
		</div>
	</div>-->
	<div>
		<?php echo $form->hiddenField($model,'cid',array('class'=>'form-control','value'=>'2'));  ?>
		<?php echo $form->hiddenField($model,'type',array('class'=>'form-control','value'=>''));  ?>
	</div>
	
	<div class="form-group clearfix">
		<label for="clickurl" class="col-md-2"><?php echo $form->labelEx($model,'clickurl'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'clickurl',array('class'=>'form-control','placeholder'=>'Enter url')); ?>
			<?php echo $form->error($model,'clickurl',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="clicks" class="col-md-2"><?php echo $form->labelEx($model,'clicks'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'clicks',array('class'=>'form-control','readonly'=>'readonly','style'=>'border:none;text-align: center;width: 10%;float:left;margin-right: 1%;')); ?>
			<div class="btn btn-primary" onclick="resetbutton('resetclicks');">Reset Clicks</div>
			<?php echo $form->error($model,'clicks',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="clicks" class="col-md-2"><?php echo $form->labelEx($model,'impmade'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'impmade',array('class'=>'form-control','readonly'=>'readonly','style'=>'border:none;text-align: center;width: 10%;float:left;margin-right: 1%;')); ?>
			<div class="btn btn-primary" onclick="resetbutton('resetimp');">Reset Impressions</div>
			<?php echo $form->error($model,'impmade',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="imageurl" class="col-md-2"><?php echo $form->labelEx($model,'imageurl'); ?></label>
		<div class="col-md-9">
			<?php echo $form->fileField($model,'imageurl',array('draggable'=>'draggable')); ?>
			<?php echo $form->error($model,'imageurl'); ?>
			
			 <div class="banner-msg-box">
			 Top Banner Size Must be 468 x 60
			 <br>Left Banner Size Must be 180 x 150
			 <br>Right Banner Size Must be 300 x 250
			</div>
			
			<?php //echo $form->textField($model,'imageurl',array('class'=>'form-control','placeholder'=>'Enter url','style'=>'width:32%;float:left;margin-right:2%')); ?>
			<!--<div class="btn btn-primary" onclick="openKCFinder(image)">Browse</div>-->
			<div id="image">
				<?php if(isset($model->imageurl) AND $model->imageurl!=''){
					$imageFromDB = '/partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$model->imageurl; 
				}else{
					$imageFromDB = '/images/stories/nav/blank.png'; 
				}
				echo CHtml::image($imageFromDB,'banner_alt',array('id'=>'img','name'=>'imagelib','style'=>'padding-top:10px;'));
			 ?> 
			</div>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="custombannercode" class="col-md-2"><?php echo $form->labelEx($model,'custombannercode'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'custombannercode',array('class'=>'form-control','placeholder'=>'Enter custom banner code')); ?> 
			<?php echo $form->error($model,'custombannercode',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<!--<div class="form-group clearfix">
		<label for="description" class="col-md-2"><?php echo $form->labelEx($model,'description'); ?></label>
		<div class="col-md-9">
			<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'name'=>'Banners[description]',
            'value' => $model->description,
			'filebrowserImageBrowseUrl' => Yii::app()->baseUrl.'/protected/extensions/editMe/vendors/CKEditor/kcfinder/browse.php?opener=ckeditor&type=stories',
			'toolbar'=>
            array(
		        array(
		            'Source', '-','Bold', 'Italic', 'Underline', 'Strike','-', 'RemoveFormat' ,
		        ),
				array(
		            'Image','ReadMore','HorizontalRule','SpecialChar',
		        ),
				array(
		            'Link', 'Unlink',
		        ),
		        array(
		           'Cut', 'Copy', 'Paste','-','Undo', 'Redo',
		        ),
				array(
		            'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
		        ),
		        '/',
		        array(
		            'NumberedList', 'BulletedList','Blockquote', '-', 'Outdent', 'Indent', '-','-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
		        ),
		        array(
		            'Styles', 'Format', 'Font', 'FontSize',
		        ),
		        array(
		            'TextColor', 'BGColor',
		        ),
			)
			) );  ?>
			<?php echo $form->error($model,'description',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>-->
	<?php 
		if(isset($model->date) AND $model->date!='0000-00-00 00:00:00'){
			$val=$model->date;
		}else{
			$val=date('Y-m-d H:i:s');
		} ?>
	<?php echo $form->hiddenField($model,'date',array('class'=>'form-control col-lg-10','data-format'=>'yyyy/MM/dd hh:mm:ss','value'=>$val)); ?>
				
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php 
			echo CHtml::link('Cancel', array("/banners"),array('class' => 'btn btn-default'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<style type="text/css">

#image {
    /*width: 200px;
    height: 200px;
	background: #000;*/
    overflow: hidden;
    color: #fff;
	clear: both;
}
/*#image img {
    visibility: hidden;
}*/

</style>
<script type="text/javascript" language="javascript">
		/*function changeDisplayImage(name) {
			if (name !='') {
				document.adminForm.imagelib.src ='/partner/'.Yii::app()->db->tablePrefix.'/images/banners/' + name;
			}else{
				document.adminForm.imagelib.src = '/partner/'.Yii::app()->db->tablePrefix.'/images/blank.png'; 
			}
		}*/
		
		function resetbutton(name) {
			if (name =='resetclicks') {
				$('#Banners_clicks').val(0);
			}else{
				$('#Banners_impmade').val(0);
			}
		}
		
		function openKCFinder(div) {
    	window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            //div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                //div.innerHTML = '<img id="img" src="' + url + '" />';
                document.adminForm.imagelib.src = url;
				var src1 = url.split('/');
				var file = src1[src1.length - 1];
				document.getElementById("Banners_imageurl").value = file;
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
               // img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
               // img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.marginTop = 12 + 'px';
                img.style.visibility = "visible";
            }
        }
    };
    window.open('/manage/protected/extensions/kcfinder/browse.php?type=banners',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=600, height=500'
    );
}
		</script>
</div><!-- form -->

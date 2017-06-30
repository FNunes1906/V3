<?php
/* @var $this PageglobalController */
/* @var $model Pageglobal */
/* @var $form CActiveForm */
$this->setPageTitle(Yii::app()->name.' - Website Settings');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pageglobal-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<div class="form-group clearfix">
		<div style="margin-top: -42px; text-align: right; width: 500px; float: right;">
			<?php //echo CHtml::link('Cancel',array('/pagemeta'),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
<div class="adminform" style="padding: 0px;">
	<div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-wrench"></i> Global Site Settings</h2>
    </div>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<div class="form-group clearfix">
	    <label for="site_name" class="col-md-3"><?php echo $form->labelEx($model,'site_name'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'site_name',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'site_name',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="Frontpage" class="col-md-3"><?php echo $form->labelEx($model,'Default Frontpage'); ?></label>
		<div class="col-md-9">
			<?php
			$menus = CHtml::listData(Menu::model()->findAll('menutype="leftmenu" and parent="0" and published=1 ORDER BY name ASC'),'id','name');
			$default_menu = Menu::model()->findByAttributes(array('home'=>1));
			if(isset($default_menu) AND $default_menu!=''){
				Menu::model()->home = $default_menu->id;
			}
			echo $form->dropDownList(Menu::model(),'home',$menus,array('class'=>'form-control','data-rel'=>'chosen'));
			echo $form->error(Menu::model(),'home',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="email" class="col-md-3"><?php echo $form->labelEx($model,'email'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'email',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="beach" class="col-md-3"><?php echo $form->labelEx($model,'beach'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'beach',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'beach',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="location_code" class="col-md-3"><?php echo $form->labelEx($model,'location_code'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'location_code',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'location_code',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	
	<div class="form-group clearfix">
		<label for="googgle_map_api_keys" class="col-md-3"><?php echo $form->labelEx($model,'googgle_map_api_keys'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'googgle_map_api_keys',array('class'=>'form-control','placeholder'=>'Enter Only UA code,Example: UA-29293639-3')); ?>
			<?php echo $form->error($model,'googgle_map_api_keys',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="iphone" class="col-md-3"><?php echo $form->labelEx($model,'iphone'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'iphone',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'iphone',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="android" class="col-md-3"><?php echo $form->labelEx($model,'android'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'android',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'android',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="photo_upload_cat" class="col-md-3"><?php echo $form->labelEx($model,'facebook'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'facebook',array('class'=>'form-control','placeholder'=>'Enter URL with http://, Example: http://www.townwizard.com')); ?>
			<?php echo $form->error($model,'facebook',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="twitter" class="col-md-3"><?php echo $form->labelEx($model,'twitter'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'twitter',array('class'=>'form-control','placeholder'=>'Enter URL with http://, Example: http://www.townwizard.com')); ?>
			<?php echo $form->error($model,'twitter',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="youtube" class="col-md-3"><?php echo $form->labelEx($model,'youtube'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'youtube',array('class'=>'form-control','placeholder'=>'Enter URL with http://, Example: http://www.townwizard.com')); ?>
			<?php echo $form->error($model,'youtube',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="Header_color" class="col-md-3"><?php echo $form->labelEx($model,'Header_color'); ?></label>
		<div class="col-md-9">
			<?php echo $form->colorField($model,'Header_color',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'Header_color'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="Footer_Menu_Link" class="col-md-3"><?php echo $form->labelEx($model,'Footer_Menu_Link'); ?></label>
		<div class="col-md-9">
			<?php echo $form->urlField($model,'Footer_Menu_Link',array('class'=>'form-control','placeholder'=>'Enter URL with http://, Example: http://www.townwizard.com')); ?>
			<?php echo $form->error($model,'Footer_Menu_Link',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="photo_upload_cat" class="col-md-3"><?php echo $form->labelEx($model,'photo_upload_cat'); ?></label>
		<div class="col-md-9">
			<?php 
			$phocacat = CHtml::listData(PhocaCategories::model()->findAll('published=1 ORDER BY title ASC'),'id','title');
			echo $form->dropDownList($model,'photo_upload_cat',$phocacat,array('class'=>'form-control','data-rel'=>'chosen')); ?>
			<?php echo $form->error($model,'photo_upload_cat',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="homeslidercat" class="col-md-3"><?php echo $form->labelEx($model,'homeslidercat'); ?></label>
		<div class="col-md-9">
			<?php
			$eventcat = CHtml::listData(Categories::model()->findAll('section="com_jevents" and published=1 ORDER BY title ASC'),'id','title');
			echo $form->dropDownList($model,'homeslidercat',$eventcat,array('class'=>'form-control','data-rel'=>'chosen'));
			echo $form->error($model,'homeslidercat',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="time_zone" class="col-md-3"><?php echo $form->labelEx($model,'time_zone'); ?></label>
		<div class="col-md-9">
			<?php echo $form->dropDownList($model,'time_zone'
			,array('-12:00:00'=>'(GMT -12:00) Eniwetok, Kwajalein',
				   '-11:00:00'=>'(GMT -11:00) Midway Island, Samoa',
				   '-10:00:00'=>'(GMT -10:00) Hawaii',
				   '-9:00:00'=>'(GMT -9:00) Alaska',
				   '-8:00:00'=>'(GMT -8:00) Pacific Time (US & Canada)',
				   '-7:00:00'=>'(GMT -7:00) Mountain Time (US & Canada)',
				   '-6:00:00'=>'(GMT -6:00) Central Time (US & Canada), Mexico City',
				   '-5:00:00'=>'(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima',
				   '-4:00:00'=>'(GMT -3:30) Newfoundland',
				   '-3:30:00'=>'(GMT -3:30) Newfoundland',
				   '-3:00:00'=>'(GMT -3:00) Brazil, Buenos Aires, Georgetown',
				   '-2:00:00'=>'(GMT -2:00) Mid-Atlantic',
				   '-1:00:00'=>'(GMT -1:00 hour) Azores, Cape Verde Islands',
				   '00:00:00'=>'(GMT) Western Europe Time, London, Lisbon, Casablanca',
				   '1:00:00'=>'(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris',
				   '2:00:00'=>'(GMT +2:00) Kaliningrad, South Africa',
				   '3:00:00'=>'(GMT +3:30) Tehran',
				   '4:00:00'=>'(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',
				   '4:30:00'=>'(GMT +4:30) Kabul',
				   '5:00:00'=>'(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
				   '5:30:00'=>'(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',
				   '6:00:00'=>'(GMT +6:00) Almaty, Dhaka, Colombo',
				   '7:00:00'=>'(GMT +7:00) Bangkok, Hanoi, Jakarta',
				   '8:00:00'=>'(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',
				   '9:00:00'=>'(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
				   '9:30:00'=>'(GMT +9:30) Adelaide, Darwin',
				   '10:00:00'=>'(GMT +10:00) Eastern Australia, Guam, Vladivostok',
				   '11:00:00'=>'(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
				   '12:00:00'=>'(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka',
				   )
			,array('class'=>'form-control','data-rel'=>'chosen'));?>
			<?php echo $form->error($model,'time_zone'); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="templates" class="col-md-3"><?php echo $form->labelEx($model,'Templates'); ?></label>
		<div class="col-md-9">
			<?php 
			$path = $_SERVER['DOCUMENT_ROOT'].'/templates/';
			$files = scandir($path);
			$lists = array_slice($files,2);
			$count = 0;
			foreach($lists as $directory){
				$file = $_SERVER['DOCUMENT_ROOT'].'/templates/'.$directory.'/templateDetails.xml';
			    if(is_dir($path . '/' . $directory) AND ($directory=='townwizard_responsive' or $directory=='townwizard') AND file_exists($file)){
					$templates[$directory]= $directory;
				}
			}
			$temp_name = Templates::model()->findByAttributes(array('client_id'=>0));
			if(isset($temp_name) AND $temp_name!=''){
				Templates::model()->template=$temp_name->template;
			}else{
				Templates::model()->template=$temp_name->template;
			}
			echo $form->dropDownList(Templates::model(),'template',$templates,array('class'=>'form-control','data-rel'=>'chosen'));
			echo $form->error(Templates::model(),'template');
			?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="photo" class="col-md-3"><?php echo $form->labelEx($model,'logo'); ?></label>
		<div class="col-md-9">
			<?php //echo CHtml::fileField('logo'); ?>
			<?php echo $form->fileField($model,'logo',array('draggable'=>'draggable')); ?>
			<?php $imageFromDB = Yii::app()->request->hostInfo.'/partner/'.Yii::app()->db->tablePrefix.'/images/logo/logo.png?'.time(); 
			$tmp_url = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/logo/logo.png';
			?> 
			
			<br><?php if(file_exists($tmp_url)){
				echo CHtml::image($imageFromDB); 
			}
			?> 
			<?php echo $form->error($model,'logo',array('style'=>'color:#a94442;')); ?> 
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="distance_unit" class="col-md-3"><?php echo $form->labelEx($model,'distance_unit'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'distance_unit',array('KM'=>'KM','Miles'=>'Miles'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
			<?php echo $form->error($model,'distance_unit'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="weather_unit" class="col-md-3"><?php echo $form->labelEx($model,'weather_unit'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'weather_unit',array('m'=>'C','s'=>'F'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
			<?php echo $form->error($model,'weather_unit'); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="date_format" class="col-md-3"><?php echo $form->labelEx($model,'date_format'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'date_format',array('%m/%d'=>'Month/Date','%d/%m'=>'Date/Month'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>	
			<?php echo $form->error($model,'date_format'); ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="time_format" class="col-md-3"><?php echo $form->labelEx($model,'time_format'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'time_format',array('12'=>'12 Hrs','24'=>'24 Hrs'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>	
			<?php echo $form->error($model,'time_format'); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php //echo CHtml::link('Cancel',array('/pagemeta'),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
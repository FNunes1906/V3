<?php
/* @var $this LocationsController */
/* @var $model Locations */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'locations-form',
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

<!-- TW FORM CODE BEGIN -->
	<div class="form-group clearfix">
		<label for="event" class="col-md-2"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Location name')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'catid_list'); ?></label>
		<div class="col-md-9">
		<?php
		$criteria = new CDbCriteria;
		$criteria->addSearchCondition('section','com_jevlocations2', true);
		$catData = CHtml::listData(Categories::model()->findAll($criteria),'id','title');
		
		if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
			$lc_data = explode('|',$_REQUEST['cat_id']);
		}else{
			$lc_data = explode(',',$model->catid_list);
		}
		
		foreach($lc_data as $value){
			$selected[$value] = array('selected' => 'selected');
		}
		
		if($model->isNewRecord){
			echo $form->dropDownList($model,'catid_list',$catData,array('class'=>'form-control','multiple'=>'multiple','data-rel'=>'chosen','data-placeholder'=>'Select Category'));
		}else{
			echo $form->dropDownList($model,'catid_list',$catData,array('class'=>'form-control','multiple'=>'multiple','options' => $selected,'data-rel'=>'chosen','data-placeholder'=>'Select Category'));
		}
		
		echo $form->error($model,'catid_list',array('style'=>'color:#a94442;'));
		?>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="street" class="col-md-2"><?php echo $form->labelEx($model,'street'); ?></label>
		<div class="col-md-9">    
			<?php echo $form->textField($model,'street',array('class'=>'form-control','placeholder'=>'Enter Street')); ?>
			<?php echo $form->error($model,'street',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="city" class="col-md-2"><?php echo $form->labelEx($model,'city'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'city',array('class'=>'form-control','placeholder'=>'Enter City/Town')); ?>
			<?php echo $form->error($model,'city',array('style'=>'color:#a94442;')); ?>			
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="State" class="col-md-2"><?php echo $form->labelEx($model,'state'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'state',array('class'=>'form-control','placeholder'=>'Enter State/Province')); ?>
			<?php echo $form->error($model,'state',array('style'=>'color:#a94442;')); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="Country" class="col-md-2"><?php echo $form->labelEx($model,'country'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'country',array('class'=>'form-control','placeholder'=>'Enter Country')); ?>
			<?php echo $form->error($model,'country',array('style'=>'color:#a94442;')); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="zip" class="col-md-2"><?php echo $form->labelEx($model,'postcode'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'postcode',array('class'=>'form-control','placeholder'=>'Enter Postcode')); ?>
			<?php echo $form->error($model,'postcode',array('style'=>'color:#a94442;')); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="Phone" class="col-md-2"><?php echo $form->labelEx($model,'Phone'); ?></label>
		 <div class="col-md-9"> 
		<?php echo $form->textField($model,'phone',array('class'=>'form-control','placeholder'=>'Enter Phone')); ?>
		<?php echo $form->error($model,'phone',array('style'=>'color:#a94442;')); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="url" class="col-md-2"><?php echo $form->labelEx($model,'Website URL'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'url',array('class'=>'form-control','placeholder'=>'Enter Website URL')); ?>
			<?php echo $form->error($model,'url',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="photo" class="col-md-2"><?php echo $form->labelEx($model,'Location Image'); ?></label>
		<div class="col-md-9">
			<?php echo $form->fileField($model,'image',array('draggable'=>'draggable')); ?>
			<?php echo $form->error($model,'image'); ?>
			<?php $imageFromDB	= Yii::app()->request->hostInfo.'/partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/thumbnails/thumb_'.$model->image; 
				  $tmp_url		= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/thumbnails/thumb_'.$model->image;
			echo "<br>";
			if(file_exists($tmp_url)){
				echo CHtml::image($imageFromDB); 
			}?> 
			
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="Published" class="col-md-2"><?php echo $form->labelEx($model,'published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="feature" class="col-md-2"><?php echo $form->labelEx($model,'Featured'); ?></label>
		<div class="col-md-9"> 
			<?php 
			 $feature_id = LocationCustomfields::model()->findByAttributes(array('target_id'=>$model->loc_id,'value'=>1));
			if(isset($feature_id) AND $feature_id!=''){
				LocationCustomfields::model()->value='1';
			}else{
				LocationCustomfields::model()->value='0';
			}
			echo  $form->radioButtonList(LocationCustomfields::model(),'value',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); 
			?>
		</div>
	</div>
	<div class="form-group clearfix">
		 <input style="margin-left: 15px;" type="button" class="btn btn-setting btn-primary" name="findaddress" onclick="codeAddress();" value="Find Address" /><br/><br/>
		<div id="map-container" class="col-md-12"></div>
	</div>


	<div class="form-group clearfix">
			<label for="location" class="col-md-2"><?php echo $form->labelEx($model,'Latitude'); ?></label>
				<div class="col-md-9">
					<?php echo $form->textField($model,'geolat',array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'geolat'); ?>			
				</div>
		</div>
				
	<div class="form-group clearfix">
			<label for="location" class="col-md-2"><?php echo $form->labelEx($model,'Longitude'); ?></label>
			<div class="col-md-9">
				<?php echo $form->textField($model,'geolon',array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'geolon'); ?>			
			</div>
		</div>

	<div class="form-group clearfix">
		<label for="description" class="col-md-2"><?php echo $form->labelEx($model,'Description'); ?></label>
		<div class="col-md-9">
			<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'name'=>'Locations[description]',
            'value' => $model->description,
			'filebrowserImageBrowseUrl' => Yii::app()->baseUrl.'/protected/extensions/editMe/vendors/CKEditor/kcfinder/browse.php?opener=ckeditor&type=stories',
			'toolbar'=>
             array(
		        array('Source', '-','Bold', 'Italic', 'Underline', 'Strike','-', 'RemoveFormat' ,),
				array('Image','HorizontalRule','SpecialChar',),
				array('Link', 'Unlink',),
		        array('Cut', 'Copy', 'Paste','-','Undo', 'Redo',),
				array('Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'),'/',
		        array('NumberedList', 'BulletedList','Blockquote', '-', 'Outdent', 'Indent', '-','-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',),
		        array('Styles', 'Format', 'Font', 'FontSize',),
		        array('TextColor', 'BGColor',),
			)
			) ); ?>
			<?php echo $form->error($model,'description'); ?>			
		</div>
	</div>
	<div>
		<?php echo $form->hiddenField($model,'created',array('class'=>'form-control','value'=>date('Y-m-d H:i:s'))); ?>		
	</div>
	<div>
		<?php echo $form->hiddenField($model,'imagetitle',array('class'=>'form-control')); ?>		
	</div>
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	<!-- TW FORM CODE END -->
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php 
			echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
	//Fetching zip code from page global table
    $locationcode = Pageglobal::model()->findAll();
	$zipcode = $locationcode[0]->location_code;
   //Fetching lat and long from zip code of page global table
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
    $details=file_get_contents($url);
    $result = json_decode($details,true);
    $lat = $result['results'][0]['geometry']['location']['lat'];
    $lng = $result['results'][0]['geometry']['location']['lng'];
?>
<!-- Google Map Code START -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
	/*
	//start of modal google map
	$('#mapmodals').on('shown.bs.modal', function () {
		google.maps.event.trigger(var_map, "resize");
		var_map.setCenter(var_location);
	});*/


var geocoder;
var map;
var marker;

function initialize() {
	geocoder = new google.maps.Geocoder();
	var model_lat = <?php echo $model->geolat;?>;
	var model_long = <?php echo $model->geolon;?>;
	if(model_lat!='0' && model_long!='0'){
		var myLatlng = new google.maps.LatLng(model_lat,model_long);
	}else{
		var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
	}
	var myOptions = {zoom:14,center: myLatlng, mapTypeId: google.maps.MapTypeId.ROADMAP}
	map = new google.maps.Map(document.getElementById("map-container"), myOptions); 
	marker = new google.maps.Marker({draggable: true, position: myLatlng,  map: map, title: "Your location" });

	if(model_lat!='0' && model_long!='0'){
		resetLatLngTxtFields(<?php echo $model->geolat;?>,<?php echo $model->geolon;?>);
	}else{
		resetLatLngTxtFields(<?php echo $lat; ?>,<?php echo $lng; ?>);
	}
	google.maps.event.addListener(marker, 'drag', function (event) {
		resetLatLngTxtFields(this.getPosition().lat(), this.getPosition().lng());
	});

}

function resetLatLngTxtFields(lat, lng){
	document.getElementById("Locations_geolat").value = lat;
    document.getElementById("Locations_geolon").value = lng;
}

/*When click on Find address button, this function will be called*/
function codeAddress(){
    street = document.getElementById("Locations_street").value;	
	city = document.getElementById("Locations_city").value;	
	state = document.getElementById("Locations_state").value;	
	country = document.getElementById("Locations_country").value;	
	postcode = document.getElementById("Locations_postcode").value;	
	
	var address = street+","+city+","+state+","+country+","+postcode;

    geocoder.geocode( { 'address': address}, function(results, status) {
      if(status == google.maps.GeocoderStatus.OK){
        map.setCenter(results[0].geometry.location);
    	marker.setPosition(results[0].geometry.location);
		resetLatLngTxtFields(results[0].geometry.location.lat(), results[0].geometry.location.lng());
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

/* Run below code to load initialize map function */
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<!-- Google Map Code END -->

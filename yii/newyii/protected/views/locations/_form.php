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
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

<!-- TW FORM CODE BEGIN -->
	<div class="form-group clearfix">
		<label for="event" class="col-md-3"><?php echo $form->labelEx($model,'Location Name:'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter Location name')); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="category" class="col-md-3">Category:</label>
		<div class="col-md-9">
			<select name="category" data-rel="chosen" class="form-control" multiple data-placeholder="Select Category">					
				<option value="">Select Category</option>
				<option value="">American</option>
				<option value="">Maxican</option>
				<option value="">Chinese</option>
				<option value="">Shopping</option>
				<option value="">Gardens</option>
				<option value="">Happy Hours</option>
			</select>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="street" class="col-md-3"><?php echo $form->labelEx($model,'Street:'); ?></label>
		<div class="col-md-9">    
			<?php echo $form->textField($model,'street',array('class'=>'form-control','placeholder'=>'Enter Street')); ?>
			<?php echo $form->error($model,'street'); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="city" class="col-md-3"><?php echo $form->labelEx($model,'City/Town:'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'city',array('class'=>'form-control','placeholder'=>'Enter City/Town')); ?>
			<?php echo $form->error($model,'city'); ?>			
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="State" class="col-md-3"><?php echo $form->labelEx($model,'State/Province:'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'state',array('class'=>'form-control','placeholder'=>'Enter State/Province')); ?>
			<?php echo $form->error($model,'state'); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="Country" class="col-md-3"><?php echo $form->labelEx($model,'Country:'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'country',array('class'=>'form-control','placeholder'=>'Enter Country')); ?>
			<?php echo $form->error($model,'country'); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="zip" class="col-md-3"><?php echo $form->labelEx($model,'Postcode:'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'postcode',array('class'=>'form-control','placeholder'=>'Enter Postcode')); ?>
			<?php echo $form->error($model,'postcode'); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="Phone" class="col-md-3"><?php echo $form->labelEx($model,'Phone:'); ?></label>
		 <div class="col-md-9"> 
		<?php echo $form->textField($model,'phone',array('class'=>'form-control','placeholder'=>'Enter Phone')); ?>
		<?php echo $form->error($model,'phone'); ?>
		</div>
	</div> 
	<div class="form-group clearfix">
		<label for="url" class="col-md-3"><?php echo $form->labelEx($model,'Website URL:'); ?></label>
		 <div class="col-md-9"> 
			<?php echo $form->textField($model,'url',array('class'=>'form-control','placeholder'=>'Enter Website URL')); ?>
			<?php echo $form->error($model,'url'); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="photo" class="col-md-3"><?php echo $form->labelEx($model,'Image URL:'); ?></label>
		<div class="col-md-9">
			<?php echo $form->fileField($model,'imagetitle',array('draggable'=>'draggable')); ?>
			<?php echo $form->error($model,'imagetitle'); ?>
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="feature" class="col-md-3"><?php echo $form->labelEx($model,'Featured Location:'); ?></label>
		<div class="col-md-9"> 
			<?php echo  $form->radioButtonList($model,'priority',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>	
		</div>
	</div>
	<div class="form-group clearfix">
		 <input type="button" class="btn btn-default" name="findaddress" onclick="findaddress();" value="Find Address" /><br/><br/>
		<div id="map-container" class="col-md-12"></div>
		</div>
		
	<div class="form-group clearfix">
			<label for="location" class="col-md-3"><?php echo $form->labelEx($model,'Longitude:'); ?></label>
			<div class="col-md-9">
				<?php echo $form->textField($model,'geolon'); ?>
				<?php echo $form->error($model,'geolon'); ?>			
			</div>
		</div>
		
	<div class="form-group clearfix">
			<label for="location" class="col-md-3"><?php echo $form->labelEx($model,'Latitude:'); ?></label>
				<div class="col-md-9">
					<?php echo $form->textField($model,'geolat'); ?>
					<?php echo $form->error($model,'geolat'); ?>			
				</div>
		</div>


	<div class="form-group clearfix">
		<label for="location" class="col-md-3"><?php echo $form->labelEx($model,'Description:'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>55)); ?>
			<?php echo $form->error($model,'description'); ?>			
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="Published" class="col-md-3"><?php echo $form->labelEx($model,'Published:'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<!-- TW FORM CODE END -->

	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php echo CHtml::button('Cancel',array('class' => 'btn btn-default','id' => 'buttonId','onclick'=>'window.history.back()'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var var_map;
     var var_location = new google.maps.LatLng(45.430817,12.331516);
     function map_init() {	
            var var_mapoptions = {
              center: var_location,
              zoom: 14
            };
            var_map = new google.maps.Map(document.getElementById("map-container"),
                var_mapoptions);
      
          var contentString =
'<div id="mapInfo">'+
'<p><strong>Peggy Guggenheim Collection</strong><br><br>'+
'Dorsoduro, 701-704<br>' +
'30123<br>Venezia<br>'+
'P: (+39) 041 240 5411</p>'+
'<a href="http://www.guggenheim.org/venice" target="_blank">Plan your visit</a>'+
'</div>';
 
          var var_infowindow = new google.maps.InfoWindow({
            content: contentString
          });
          
          var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title:"Click for information about the Guggenheim museum in Venice",
                  maxWidth: 200,
                  maxHeight: 200
          });
 
          google.maps.event.addListener(var_marker, 'click', function() {
             var_infowindow.open(var_map,var_marker);
          });
      }
 
          google.maps.event.addDomListener(window, 'load', map_init);
      
      //start of modal google map
      $('#mapmodals').on('shown.bs.modal', function () {
          google.maps.event.trigger(var_map, "resize");
          var_map.setCenter(var_location);
      });
</script>


<!--	ORIGINAL YII FORM
<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postcode'); ?>
		<?php echo $form->textField($model,'postcode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'postcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geolon'); ?>
		<?php echo $form->textField($model,'geolon'); ?>
		<?php echo $form->error($model,'geolon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geolat'); ?>
		<?php echo $form->textField($model,'geolat'); ?>
		<?php echo $form->error($model,'geolat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geozoom'); ?>
		<?php echo $form->textField($model,'geozoom'); ?>
		<?php echo $form->error($model,'geozoom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pcode_id'); ?>
		<?php echo $form->textField($model,'pcode_id'); ?>
		<?php echo $form->error($model,'pcode_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loccat'); ?>
		<?php echo $form->textField($model,'loccat'); ?>
		<?php echo $form->error($model,'loccat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catid_list'); ?>
		<?php echo $form->textField($model,'catid_list',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'catid_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catid'); ?>
		<?php echo $form->textField($model,'catid'); ?>
		<?php echo $form->error($model,'catid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'global'); ?>
		<?php echo $form->textField($model,'global'); ?>
		<?php echo $form->error($model,'global'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'priority'); ?>
		<?php echo $form->textField($model,'priority'); ?>
		<?php echo $form->error($model,'priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
		<?php echo $form->error($model,'ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'access'); ?>
		<?php echo $form->textField($model,'access',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'access'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by_alias'); ?>
		<?php echo $form->textField($model,'created_by_alias',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'created_by_alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked_out'); ?>
		<?php echo $form->textField($model,'checked_out',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'checked_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked_out_time'); ?>
		<?php echo $form->textField($model,'checked_out_time'); ?>
		<?php echo $form->error($model,'checked_out_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anonname'); ?>
		<?php echo $form->textField($model,'anonname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'anonname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anonemail'); ?>
		<?php echo $form->textField($model,'anonemail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'anonemail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imagetitle'); ?>
		<?php echo $form->textField($model,'imagetitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'imagetitle'); ?>
	</div>
-->


<?php

/* @var $this EventsDetailController */
/* @var $model EventsDetail */
/* @var $form CActiveForm */
?>
<script type="text/javascript">
		function insertlocationid(id) {
				 $('#location').val(id);
				 $('#location-name').val($('#title_'+id).text());
			     $('#myModal').modal('hide');
		};
		$(document).ready(function(){
			var addLocationFromEvent = "<?php echo Yii::app()->session['addLocationFromEvent']; ?>";
			if(addLocationFromEvent){
				insertlocationid(addLocationFromEvent);
			}
		});
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-detail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="form-group clearfix">
		<div style="margin-top: -12px;text-align: right;">
			<?php $previousCancleURL = explode('?', Yii::app()->request->urlReferrer); ?>
			<?php //echo CHtml::link('Cancel', array("/events"),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::link('Cancel', array('/events?'.$previousCancleURL[1]),array('class' => 'btn btn-default')); ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	
	 <div class="adminform">
	 <p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group clearfix">
		<label for="event-title" class="col-md-2"><?php echo $form->labelEx($model,'summary'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'summary',array('class'=>'form-control','placeholder'=>'Enter Title')); ?>
			<?php echo $form->error($model,'summary',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>
	<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'catid'); ?></label>
		<div class="col-md-9">
			<?php
			$cat_id = Events::model()->findByAttributes(array('detail_id'=>$model->evdet_id));
			if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
				$model->catid = $_REQUEST['cat_id'];
			}else if(isset($cat_id) AND $cat_id!=''){
				$model->catid = $cat_id->catid;
			}
			$catData = CHtml::listData(Categories::model()->findAll('section="com_jevents" and published=1 ORDER BY title ASC'),'id','title');
			echo $form->dropDownList($model,'catid',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			echo $form->error($model,'catid',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="date" class="col-md-2"><?php echo $form->labelEx($model,'dtstart'); ?></label>
		<div class="col-md-6">
			<div id="datetimepicker2" class="input-append date">
				<?php if(isset($model->dtstart) AND $model->dtstart != 0){
						$val = date('Y-m-d H:i:s',$model->dtstart);
					  }else{
						$val = date('Y-m-d H:i:s');
					 } ?>
				<?php echo $form->textField($model,'dtstart',array('class'=>'form-control col-lg-10','data-format'=>'yyyy-MM-dd hh:mm:ss','value'=>$val)); ?>
				<span class="add-on col-lg-2"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $form->error($model,'dtstart',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
	</div>

	<div class="form-group clearfix">
		<label for="date" class="col-md-2"><?php echo $form->labelEx($model,'dtend'); ?></label>
		<div class="col-md-6">
			
			<div id="datetimepicker3" class="input-append date" >
				<?php 
					if(isset($model->dtend) && $model->dtend != 0){
						$val = date('Y-m-d H:i:s',$model->dtend);
					}else{
						$val = date('Y-m-d H:i:s');
					} ?>
				<?php echo $form->textField($model,'dtend',array('class'=>'form-control col-lg-10','data-format'=>'yyyy-MM-dd hh:mm:ss','value'=>$val)); ?>
				<span class="add-on col-lg-2"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $form->error($model,'dtend',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
	</div>
	<?php

		if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
			# Get rrule frequency weekly / monthly / yearly etc
			$model_get_eventID	= Events::model()->findByAttributes(array('detail_id'=>$model->evdet_id));	
			$model_get_rrule 	= EventsRule::model()->findByAttributes(array('eventid'=>$model_get_eventID->ev_id));
			
			# If Frequency is WEEKLY
			if($model_get_rrule->freq == 'WEEKLY'){
				$wkday_array = explode(',',$model_get_rrule->byday);
			}
			
			# If Frequency is MONTHLY
			if($model_get_rrule->freq == 'MONTHLY'){
				$monthday_value = ltrim($model_get_rrule->bymonthday,'+');
			}
		}
	?>
	<div class="form-group clearfix"></div>
	<div class="form-group clearfix">
		<?php //echo  CHtml::radioButtonList('relative',isset($prmsArr['relative'])?$prmsArr['relative']:'week',array('week'=>'Weekly','strtotime'=>'Weekend','rel'=>'Monthly/Yearly'),array("checked"=>"checked",'separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
	 	
		<label for="repeat type" class="col-md-2">Repeat Type </label>
		<div class="col-md-9" style="width: auto;"> 
			<div class="radio_div_css">
				<input value="norepeat" type="radio" name="freq" id="radio1" class="radio" checked/>
				<label for="radio1" class="label_radio_all">No Repeat</label>
			</div>

			<div class="radio_div_css">
				<input value="daily" type="radio" name="freq" id="radio2" class="radio" data-toggle="collapse" data-target="#collapseDaily" aria-expanded="false" aria-controls="collapseDaily"/>
				<label for="radio2" class="label_radio_all" style="margin-right: -25px;">Daily</label>
			</div>

			<div class="radio_div_css">	
				<input value="weekly" type="radio" name="freq" id="radio3" class="radio" data-toggle="collapse" data-target="#collapseWeekly" aria-expanded="false" aria-controls="collapseWeekly"/>
				<label for="radio3" class="label_radio_all">Weekly</label>
			</div>

			<div class="radio_div_css">	
				<input value="monthly" type="radio" name="freq" id="radio4" class="radio" data-toggle="collapse" data-target="#collapseMonthly" aria-expanded="false" aria-controls="collapseMonthly"/>
				<label for="radio4" class="label_radio_all">Monthly</label>
			</div>
			
			<div class="radio_div_css">	
				<input value="yearly" type="radio" name="freq" id="radio5" class="radio" data-toggle="collapse" data-target="#collapseYearly" aria-expanded="false" aria-controls="collapseYearly"/>
				<label for="radio5" class="label_radio_all">Yearly</label>
			</div>
		</div>
	</div>
		<div class="collapse" id="collapseDaily"></div>
		<!-- REPEAT WEEKLY START -->
		<div class="collapse" id="collapseWeekly">

			<div class="form-group clearfix">
				<label for="event-title" class="col-md-2"><?php echo $form->labelEx($model,'collapseWeekly'); ?></label>
				<div class="col-md-9">
					Every <input type="text" value="<?php echo (isset($model_get_rrule->rinterval) &&  $model_get_rrule->rinterval > 0)?$model_get_rrule->rinterval:1;?>" name="rinterval" size="1" style="text-align: center;"> weeks on:
					<div><br>
						<input id="SU" style="margin-left:1%;" type="checkbox" value="7" name="byday[]">&nbsp; S
						<input id="MO" style="margin-left:1%;" type="checkbox" value="1" name="byday[]">&nbsp; M
						<input id="TU" style="margin-left:1%;" type="checkbox" value="2" name="byday[]">&nbsp; T
						<input id="WE" style="margin-left:1%;" type="checkbox" value="3" name="byday[]">&nbsp; W
						<input id="TH" style="margin-left:1%;" type="checkbox" value="4" name="byday[]">&nbsp; T
						<input id="FR" style="margin-left:1%;" type="checkbox" value="5" name="byday[]">&nbsp; F
						<input id="SA" style="margin-left:1%;" type="checkbox" value="6" name="byday[]">&nbsp; S
					</div>
				</div>
				</div>				
			</div>
		<!-- REPEAT WEEKLY END -->
		
		<!-- REPEAT MONTHLY START -->
		<div class="collapse" id="collapseMonthly">
		<?php $repeat_untill = 'display: block;'; ?>
			<div class="form-group clearfix">
				<label for="event-title" class="col-md-2"><?php echo $form->labelEx($model,'collapseMonthly'); ?></label>
				<div class="col-md-9">
					<div class="col-md-4" style="padding:0">
						<input class="form-control" placeholder="Comma separated 1, 10, 30" type="text" value="<?PHP echo (isset($monthday_value) && $monthday_value != '')?$monthday_value:'';?>" name="month_days">
					</div> 	
				</div>
			</div>				
		</div>
		<!-- REPEAT MONTHLY END -->	

		<!-- REPEAT YEARLY START -->	
		<div class="collapse" id="collapseYearly"></div>			
		<!-- REPEAT YEARLY END -->	

		<!-- REPEAT UNTILL START -->	
		<div class="form-group clearfix" id="collapseRepeatUntill">
		  <!--<input type="text" size="12" id="inputField" />-->
			<label for="repeatUntil" class="col-md-2"><?php echo $form->labelEx($model,'repeatUntil'); ?></label>
			<div class="col-md-2">
					<?php if(isset($model_get_rrule->until) && $model_get_rrule->until != 0){
							$val = date('Y-m-d',$model_get_rrule->until);
						  }else{
							$val = date('Y-m-d'); }?>
					<?php echo $form->textField($model,'repeatUntil',array('class'=>'form-control','id'=>'inputField','value'=>$val)); ?>
					<?php echo $form->error($model,'repeatUntil',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
		<!-- REPEAT UNTILL END -->



	<div class="form-group clearfix">
		<label for="introtext" class="col-md-2"><?php echo $form->labelEx($model,'description'); ?></label>
		<div class="col-md-9">
			<?php  
			$this->widget('ext.editMe.widgets.ExtEditMe', array(
			'name'	=>'EventsDetail[description]',
			'value' => $model->description,
			'filebrowserImageBrowseUrl' => Yii::app()->baseUrl.'/protected/extensions/editMe/vendors/CKEditor/kcfinder/browse.php?opener=ckeditor&type=stories',
			//'filebrowserImageBrowseUrl' => Yii::app()->baseUrl.'/protected/extensions/editMe/vendors/CKEditor/kcfinder/browse.php?type=image',
			'toolbar'=>
			array(
			    array('Source', '-','Bold', 'Italic', 'Underline', 'Strike','-', 'RemoveFormat' ,),
				array('Image','ReadMore','HorizontalRule','SpecialChar',),
				array('Link', 'Unlink',),
			    array('Cut', 'Copy', 'Paste','-','Undo', 'Redo',),
				array('Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'),'/',
			    array('NumberedList', 'BulletedList','Blockquote', '-', 'Outdent', 'Indent', '-','-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',),
			    array('Styles', 'Format', 'Font', 'FontSize',),
			    array('TextColor', 'BGColor',),
			)
			) ); 
			?>
		
			<!--NicEdit Code START-->
			<!--<div id="sample">
				
				<textarea style="width: 100%; height: 200px;" id="myArea1" name="EventsDetail[description]"><?php echo $model->description; ?></textarea>
				<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/editor/nicEdit.js"></script>
				<script>
					var area1;	
					bkLib.onDomLoaded(function() { toggleArea1(); });
					function toggleArea1() {
						if(!area1) {
							area1 = new nicEditor({fullPanel : true},{uploadURI : window.location.protocol + "//" + window.location.host + "/nicUpload.php"}).panelInstance('myArea1',{hasPanel : true});
						}else{
							area1.removeInstance('myArea1');
							area1 = null;
						}
					}
				</script>	
			</div>-->
			<!--NicEdit Code END-->
		</div>
	</div>
			
	<div class="form-group clearfix">
		<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'state'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'state',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="feature" class="col-md-2"><?php echo $form->labelEx($model,'Featured'); ?></label>
		<div class="col-md-9"> 
			<?php 
			 $feature_id = Eventcustomfields::model()->findByAttributes(array('evdet_id'=>$model->evdet_id,'value'=>1));
			if(isset($feature_id) AND $feature_id!=''){
				Eventcustomfields::model()->value='1';
			}else{
				Eventcustomfields::model()->value='0';
			}
			echo  $form->radioButtonList(Eventcustomfields::model(),'value',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); 
			?>
		</div>
	</div>

	<div class="form-group clearfix">
		<?php
		# Code to add New Location
		echo "<li style='margin:-1%;padding-top:1%;}' title='Add New Location' data-placement='top' data-toggle='tooltip' class='btn'>".CHtml::link('<span style="color:#69BD69;font-size:16pt;" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new location',Yii::app()->createAbsoluteUrl('locations').'/create?type=com_jevents')."</li>"; 
		?>
		
		<label for="location" class="col-md-2"><?php echo $form->labelEx($model,'location'); ?></label>
		<div class="col-md-5">
			<?php
			echo $form->hiddenField($model,'location',array('id'=>'location','class'=>'form-control'));
			$loc_title = Locations::model()->findByAttributes(array('loc_id'=>$model->location,'published'=>1));
			if(isset($loc_title) AND $loc_title!=''){
				$loc_title->title=$loc_title->title;
			}else{
				$loc_title->title='';
			}
			?>
			<input readonly="readonly" style="margin-bottom: 10px;" type="text" class="form-control" id="location-name" value="<?php echo $loc_title->title;?>"/>
			<?php echo $form->error($model,'location',array('style'=>'color:#a94442;')); ?>
		</div>
		<div class="col-md-2"><a href="#" class="btn btn-setting btn-primary">Choose Location</a></div>
	</div>
	

							
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

   <div class="modal-dialog" style="width: 60%;margin: auto;">
        <div class="modal-content" style="height: 500px; overflow-y: scroll;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 style="margin: 0px;"><i class="glyphicon glyphicon-map-marker"></i>Select Location For Event</h3>
            </div>
            <div class="modal-body" style="overflow: hidden;overflow-x:auto;width:100%;">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
					<thead>
					    <tr>
					        <th>#</th>
					        <th><a href="#">Title</a></th>
					        <th><a href="#">Assign Categories</a></th>
					        <th><a href="#">Address</a></th>
					    </tr>
					 </thead>
					<tbody>
						<?php 
						$all_locations = Locations::model()->findAll('published=1 ORDER BY title ASC');
						foreach($all_locations as $id=>$value){$id++; ?>
						<tr>
							<td><?php echo $id?></td>
							<td width="40%">
								<a id="title_<?php echo $value["loc_id"] ?>" href='#' onclick='insertlocationid(<?php echo $value["loc_id"] ?>);'><?php echo $value['title'];?></a>
							</td>
							<td width="35%">
							<?php
							if($value["catid_list"] != ''){
								$criteria = new CDbCriteria();
					            $criteria->select = 'GROUP_CONCAT(CONCAT_WS(" ",t.title) SEPARATOR ", ") as title';
					            $criteria->condition = 'id IN('.$value["catid_list"].')';
					            $data = Categories::model()->find($criteria);
								echo $data->title;
							}	
							 ?>
							</td>
							<td><?php echo $value['street']."<br>".$value['city'].",".$value['state']."-".$value['postcode']?></td>
						</tr>
						<?php }	?>
					</tbody>
				</table>
            </div>
        </div>
 	</div>
</div>
	
	
	<div>
		<?php echo $form->hiddenField($model,'modified',array('class'=>'form-control','value'=>date('Y-m-d H:i:s'))); ?>		
	</div>
	
	<div>
	<?php echo $form->hiddenField($model,'geolon',array('class'=>'form-control','value'=>0)); ?>	</div>
	<div>
	<?php echo $form->hiddenField($model,'geolat',array('class'=>'form-control','value'=>0)); ?>	</div>
	<div>
	<?php echo $form->hiddenField($model,'priority',array('class'=>'form-control','value'=>0)); ?>		</div>
	<div>
	<?php echo $form->hiddenField($model,'sequence',array('class'=>'form-control','value'=>0)); ?>		</div>
	<div>
	<?php echo $form->hiddenField($model,'multiday',array('class'=>'form-control','value'=>1)); ?>		</div>

	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>


	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php $previousCancleURL = explode('?', Yii::app()->request->urlReferrer); ?>
			<?php //echo CHtml::link('Cancel', array("/events"),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::link('Cancel', array('/events?'.$previousCancleURL[1]),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->


<script>
$(document).ready(function(){
    // Show the Modal on load
    $("#collapseRepeatUntill").hide();
    
    <?php if(isset($model_get_rrule->freq) && $model_get_rrule->freq == 'none'){ ?>
        $("#radio1").prop("checked", true);
    <?php }elseif(isset($model_get_rrule->freq) && $model_get_rrule->freq == 'DAILY'){ ?>
        $("#radio2").prop("checked", true);
        $("#collapseDaily").show(10);
        $("#collapseRepeatUntill").show();
	<?php }elseif(isset($model_get_rrule->freq) && $model_get_rrule->freq == 'WEEKLY'){ ?>
		$("#radio3").prop("checked", true);
		// Week days checkbox calculation
		<?php foreach($wkday_array as $value){?>
			$('#<?php echo $value ?>').prop('checked', true);	
		<?php } ?>
		$("#collapseWeekly").show(10);
		$("#collapseRepeatUntill").show();
		 
	<?php }elseif(isset($model_get_rrule->freq) && $model_get_rrule->freq == 'MONTHLY'){ ?>
		$("#radio4").prop("checked", true);
		$("#collapseMonthly").show(10);
		$("#collapseRepeatUntill").show();
	<?php }elseif(isset($model_get_rrule->freq) && $model_get_rrule->freq == 'YEARLY'){ ?>
		$("#radio5").prop("checked", true);
		$("#collapseYearly").show(10);
		$("#collapseRepeatUntill").show();
	<?php } ?>
	
	    
    // Hide the Modal
    $("#radio1").click(function(){
        $("#collapseDaily").hide(10);
        $("#collapseRepeatUntill").hide(10);
        $("#collapseWeekly").hide(10);
        $("#collapseMonthly").hide(10);
        $("#collapseYearly").hide(10);
        
    });
    $("#radio2").click(function(){
        $("#collapseDaily").show(10);
        $("#collapseRepeatUntill").show(10);
        $("#collapseWeekly").hide(10);
        $("#collapseMonthly").hide(10);
        $("#collapseYearly").hide(10);
        
    });
    $("#radio3").click(function(){
        $("#collapseWeekly").show(10);
        $("#collapseRepeatUntill").show(10);
        $("#collapseDaily").hide(10);
        $("#collapseMonthly").hide(10);
        $("#collapseYearly").hide(10);
    });
    
    $("#radio4").click(function(){
        $("#collapseMonthly").show(10);
        $("#collapseRepeatUntill").show(10);
        $("#collapseDaily").hide(10);
        $("#collapseWeekly").hide(10);
        $("#collapseYearly").hide(10);
    });
    
    $("#radio5").click(function(){
        $("#collapseYearly").show(10);
        $("#collapseRepeatUntill").show(10);
        $("#collapseMonthly").hide(10);
        $("#collapseDaily").hide(10);
        $("#collapseWeekly").hide(10);
    });    
    
});
</script>


<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			cellColorScheme:"peppermint",
			imgPath:"img/dp/img/",
			dateFormat:"%Y-%m-%d"
			/*selectedDate:{ This is an example of what the full configuration offers.
				day:5,		 For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>
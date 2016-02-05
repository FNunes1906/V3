<?php
/* @var $this ContentsController */
/* @var $model Contents */
/* @var $form CActiveForm */
$model->isNewRecord?$this->setPageTitle(Yii::app()->name.' - Create Article'):$this->setPageTitle(Yii::app()->name.' - Update Article');
?>

<div class="form">
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contents-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="form-group clearfix">
		<div style="margin-top: -12px;text-align: right;">
			<?php 
			echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	
	 <div class="adminform">
	 <p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="form-group clearfix">
		<label for="Article" class="col-md-2"><?php echo $form->labelEx($model,'title'); ?></label>
		<div class="col-md-9">
			<?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Enter article name')); ?>
			<?php echo $form->error($model,'title',array('style'=>'color:#a94442;')); ?>
		</div>
    </div>
	<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'sectionid'); ?></label>
		<div class="col-md-9">
			<?php
			$criteria1 = new CDbCriteria;
			$criteria1->addSearchCondition('scope','content', true);
			$criteria1->addSearchCondition('published','1', true);
			$secData = CHtml::listData(Sections::model()->findAll($criteria1),'id','title');
			if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
				$model->sectionid = $_REQUEST['cat_id'];
			}
			echo $form->dropDownList($model,'sectionid',$secData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			echo $form->error($model,'sectionid',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>
	<!--<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'catid'); ?></label>
		<div class="col-md-9">
			<?php
			$criteria1 = new CDbCriteria;
			$criteria1->addSearchCondition('scope','content', true);
			$secData = Sections::model()->findAll($criteria1);
			$criteria2 = new CDbCriteria;
			if(count($secData)>0)
			{	
				foreach($secData as $id=>$value){
					$criteria2->condition .= 'section='.$value['id'];
					if(count($secData)-1!=$id)
					{
						$criteria2->condition .= ' || ';
					}
				}
				$criteria2->condition .= ' and published=1 ORDER BY title ASC';
			}
			$catData = CHtml::listData(Categories::model()->findAll($criteria2),'id','title');
			echo $form->dropDownList($model,'catid',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
			echo $form->error($model,'catid',array('style'=>'color:#a94442;'));
			?>
		</div>
	</div>-->
	<div class="form-group clearfix">
	
		<?php
		# Code to get name of FRONT PAGE MENU by defualt it is home normally
		$dataReader = Yii::app()->db->createCommand('SELECT DISTINCT(NAME) FROM jos_menu WHERE link LIKE "%view=frontpage%" AND published = 1')->queryAll();
		?>
		<label for="feature" class="col-md-2"><?php echo $form->labelEx($model,'Display on '.$dataReader[0]['NAME']); ?></label>
		<div class="col-md-9"> 
			<?php 
			$cid = Frontpage::model()->findByAttributes(array('content_id'=>$model->id));
			if(isset($cid)){
				Frontpage::model()->content_id='1';
			}else{
				Frontpage::model()->content_id='0';
			}
			echo $form->radioButtonList(Frontpage::model(),'content_id',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); 
			?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'Published'); ?></label>
		<div class="col-md-9">
			<?php echo  $form->radioButtonList($model,'state',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>			
		</div>
	</div>	
	<div class="form-group clearfix">
		<label for="introtext" class="col-md-2"><?php echo $form->labelEx($model,'introtext'); ?></label>
		<div class="col-md-9">
		
			<?php  
			
			if(strlen($model->fulltext) > 1){
				$fulltext = $model->introtext."<hr id='system-readmore' />".$model->fulltext;
			}else{
				$fulltext = $model->introtext;
			}
			$this->widget('ext.editMe.widgets.ExtEditMe', array(
            'name'	=>'Contents[introtext]',
            'value' => $fulltext,
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
			) ); 
			?>
			
			<!--NicEdit Code START-->
			<!--<div id="sample">
			<?php
			if(strlen($model->fulltext) > 1){
				$fulltext = $model->introtext."<hr id='system-readmore' />".$model->fulltext;
			}else{
				$fulltext = $model->introtext;
			}?>
				<textarea style="width: 100%; height: 200px;" id="myArea1" name="Contents[introtext]"><?php echo $fulltext; ?></textarea>
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
	    <label for="created" class="col-md-2"><?php echo $form->labelEx($model,'Creation Date'); ?></label>
		<div class="col-md-9">
			<div id="datetimepicker1" class="input-append date">
				<?php 
					if(isset($model->created) AND $model->created!='0000-00-00 00:00:00'){
						$val=$model->created;
					}else{
						$val=date('Y-m-d H:i:s');
					} ?>
				
				<?php echo $form->textField($model,'created',array('class'=>'form-control col-lg-10','data-format'=>'yyyy-MM-dd hh:mm:ss','readonly'=>'readonly','value'=>$val)); ?>
				<span class="add-on col-lg-2"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $form->error($model,'created',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
	    <label for="publish date" class="col-md-2"><?php echo $form->labelEx($model,'publish_up'); ?></label>
		<div class="col-md-9">
			<div id="datetimepicker2" class="input-append date">
				<?php 
					if(isset($model->publish_up) AND $model->publish_up!='0000-00-00 00:00:00'){
						$val=$model->publish_up;
					}else{
						$val=date('Y-m-d H:i:s');
					} ?>
				<?php echo $form->textField($model,'publish_up',array('class'=>'form-control col-lg-10','data-format'=>'yyyy-MM-dd hh:mm:ss','readonly'=>'readonly','value'=>$val)); ?>
				<span class="add-on col-lg-2"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $form->error($model,'publish_up',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
	</div>

	<div class="form-group clearfix">
	    <label for="unpublish date" class="col-md-2"><?php echo $form->labelEx($model,'publish_down'); ?></label>
		<div class="col-md-9">
			<div id="datetimepicker3" class="input-append date">
				<?php
				if(isset($model->publish_down) && $model->publish_down != '0000-00-00 00:00:00'){
					$val = $model->publish_down;
				}else{
					$val = '0000-00-00 00:00:00';
				}?>
				<?php echo $form->textField($model,'publish_down',array('class'=>'form-control col-lg-10','data-format'=>'yyyy-MM-dd hh:mm:ss','readonly'=>'readonly','value'=>$val)); ?>
				<span class="add-on col-lg-2"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $form->error($model,'publish_down',array('style'=>'color:#a94442;')); ?>
			</div>
		</div>
	</div>
	<!--<div class="form-group clearfix">
		<label for="feature" class="col-md-2"><?php echo $form->labelEx($model,'mask'); ?></label>
		<div class="col-md-9"> 
			<?php echo  $form->radioButtonList($model,'mask',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
		</div>
	</div>-->
	<div>
		<?php $pre_url = Yii::app()->request->urlReferrer;
		echo $form->hiddenField($model,'last_url',array('class'=>'form-control','value'=>$pre_url));
		?>		
	</div>
	
	<div class="form-group clearfix">
		<div class="modal-footer">
			<?php echo CHtml::link('Cancel','#',array('class' => 'btn btn-default','onClick'=>'window.history.back();')); ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
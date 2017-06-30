<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */
$params = preg_split('/\s+/', $model->params);

for($i=0; $i < count($params); $i++){
	$temp =	explode('=',$params[$i]);
	
	(!empty($temp[0]) && !empty($temp[1]))?$prmsArr[$temp[0]] = $temp[1]:'';
}
?>
<b style="text-transform: uppercase">Choose Menu Type:</b><br/><br/>
<div class="select-menu-type form-group clearfix">
	<div class="nav-canvas">
			<div class="nav-sm nav nav-stacked"> </div>
			<ul class="nav nav-pills main-menu">
			<?php 
			$menu_url = Yii::app()->createAbsoluteUrl('menu');
			if(isset($_REQUEST['menu_id']) && $_REQUEST['menu_id']!=''){ 
				$parent_menu_id = "&menu_id=".$_REQUEST['menu_id'];
			}else{
				$parent_menu_id = '';
			}
			
			$currentURL = Yii::app()->request->url;
			
			$btnArticle 	= 'btn';
			$btnBlog 		= 'btn';
			$btnEvent 		= 'btn';
			$btnLocation 	= 'btn';
			$btnPage 		= 'btn';
			$btnPhotos 		= 'btn';
			$btnVideo 		= 'btn';
			$btnExternal 	= 'btn';
			
	
			if(strpos($currentURL,'com_content&view=category') !== false){
				$btnBlog = 'btn active';
			}elseif(strpos($currentURL,'com_content&view=article') !== false){
				$btnArticle = 'btn active';
			}elseif(strpos($currentURL,'com_jevlocations') !== false){
				$btnLocation = 'btn active';
			}elseif(strpos($currentURL,'com_content&view=page') !== false){
				$btnPage = 'btn active';
			}elseif(strpos($currentURL,'com_phocagallery&view=categories') !== false){
				$btnPhotos = 'btn active';
			}elseif(strpos($currentURL,'com_jevents') !== false){
				$btnEvent = 'btn active';
			}elseif(strpos($currentURL,'com_phocagallery&view=category') !== false){
				$btnVideo = 'btn active';
			}elseif(strpos($currentURL,'type=url') !== false){
				$btnExternal = 'btn active';
			}
			
			echo "<li title='This button allows you to add an article, that already exists within the CMS, as a menu item (or sub-menu item) in your app. This works well when you have long form content that you would like to make readily available to end-users' data-placement='top' data-toggle='tooltip' class='$btnArticle'>".CHtml::link('Article',$menu_url.'/create?option=com_content&view=article'.$parent_menu_id)."</li>";  
			echo "<li title='Mutliple articles listing page' data-placement='top' data-toggle='tooltip' class='$btnBlog'>".CHtml::link('Blog',$menu_url.'/create?option=com_content&view=category&layout=blog'.$parent_menu_id)."</li>";
			echo "<li title='Events listing page' data-placement='top' data-toggle='tooltip' class='$btnEvent'>".CHtml::link('Events',$menu_url.'/create?option=com_jevents&view=range&task=range.listevents'.$parent_menu_id)."</li>"; 
			echo "<li title='Locations listing page' data-placement='top' data-toggle='tooltip' class='$btnLocation'>".CHtml::link('Locations',$menu_url.'/create?option=com_jevlocations&task=locations.locations'.$parent_menu_id)."</li>";  
			echo "<li title='This button allows you to create a new page as a menu item. The page can be free form with any content type. This work well with shorter form content that is unstructured, unlike an article' data-placement='top' data-toggle='tooltip' class='$btnPage'>".CHtml::link('Page',$menu_url.'/create?option=com_content&view=page'.$parent_menu_id)."</li>";
			echo "<li title='Photos listing page' data-placement='top' data-toggle='tooltip' class='$btnPhotos'>".CHtml::link('Photos',$menu_url.'/create?option=com_phocagallery&view=categories'.$parent_menu_id)."</li>";  
			echo "<li title='Videos listing page' data-placement='top' data-toggle='tooltip' class='$btnVideo'>".CHtml::link('Videos',$menu_url.'/create?option=com_phocagallery&view=category'.$parent_menu_id)."</li>";
			echo "<li title='Create External link' data-placement='top' data-toggle='tooltip' class='$btnExternal'>".CHtml::link('External Link',$menu_url.'/create?type=url'.$parent_menu_id)."</li>"; 
			?>
			</ul>
		</div>
	
</div><br/>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>TRUE,
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
	'htmlOptions' => array('name'=>"adminForm")
)); ?>
	<!--<div class="form-group clearfix">
		<div style="margin-top: -12px;text-align: right;">
			<?php echo CHtml::link('Cancel', array("/menu"),array('class' => 'btn btn-default'));?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
		</div>
	</div>-->
<div class="adminform">
	
<div class="col-md-12">
	<legend>Menu Settings</legend>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="form-group clearfix">
		<label for="menu-title" class="col-md-2"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-md-10">
			<?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'Enter Title')); ?>
			<?php echo $form->error($model,'name',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="menu-title" class="col-md-2"><?php echo $form->labelEx($model,'parent'); ?></label>
		<div class="col-md-10">
			<?php
			$criteria1 = new CDbCriteria;
			
			
			# If Menu Component is Jevent then show all Parent Menus of Jevents
			if(strpos(Yii::app()->request->requestUri,'com_jevents') !== false){
				$criteria1->condition = "menutype = 'leftmenu' AND published = 1 AND parent = 0 AND componentid = 126 ";
			}elseif(strpos(Yii::app()->request->requestUri,'com_jevlocations') !== false){
				$criteria1->condition = "menutype = 'leftmenu' AND published = 1 AND parent = 0 AND componentid = 43 ";
			}elseif(strpos(Yii::app()->request->requestUri,'com_phocagallery') !== false){
				$criteria1->condition = "menutype = 'leftmenu' AND published = 1 AND parent = 0 AND componentid = 50 ";
			}elseif(strpos(Yii::app()->request->requestUri,'com_content') !== false){
				$criteria1->condition = "menutype = 'leftmenu' AND published = 1 AND parent = 0 AND componentid = 20 ";
			}else{
				$criteria1->condition = "menutype = 'leftmenu' AND published = 1 AND parent = 0 AND componentid = 0 ";
			}
			
			if(isset($model->id) || $model->id != ''){
				$criteria1->condition .= " AND id != $model->id";
			}
			$criteria1->condition .= " ORDER BY name ASC";
			$secData = CHtml::listData(Menu::model()->findAll($criteria1),'id','name');
			if(isset($_REQUEST['menu_id']) && $_REQUEST['menu_id']!=''){
				$model->parent = $_REQUEST['menu_id'];
			}
			echo $form->dropDownList($model,'parent',$secData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select",'onchange'=>"return hideMenuicon(this.value);"));
			echo $form->error($model,'parent',array('style'=>'color:#a94442;'));
			?>
		</div>
		
	</div>
	<?php if(isset($_REQUEST['type']) && $_REQUEST['type']=='url'){ ?>
	<div class="form-group clearfix">
		<label for="browser-nav" class="col-md-2"><?php echo $form->labelEx($model,'browserNav'); ?></label>
		<div class="col-md-10">
			<?php
			echo $form->dropDownList($model,'browserNav',array('0'=>'Parent Window','1'=>'New Tab','2'=>'New Window'),array('class'=>'form-control','data-rel'=>'chosen'));
			?>
			<?php echo $form->error($model,'browserNav',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<?php }else{ 
		echo $form->hiddenField($model,'browserNav',array('class'=>'form-control','value'=>'0'));
	} ?>
	<?php if(isset($_REQUEST['type']) && $_REQUEST['type']=='url'){ ?>
	<div class="form-group clearfix">
		<label for="menu-link" class="col-md-2"><?php echo $form->labelEx($model,'link'); ?></label>
		<div class="col-md-10">
			<?php echo $form->textField($model,'link',array('class'=>'form-control','placeholder'=>'Enter Link with http://')); ?>
			<?php echo $form->error($model,'link',array('style'=>'color:#a94442;')); ?>
		</div>
	</div>
	<?php }else{ 
				echo $form->hiddenField($model,'link',array('class'=>'form-control','value'=>'index.php?'.$_SERVER['QUERY_STRING']));
	} ?>
	<div class="form-group clearfix">
		<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'published'); ?></label>
		<div class="col-md-10">
			<?php echo  $form->radioButtonList($model,'published',array('1'=>'Yes','0'=>'No'),array('separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
			<?php echo $form->error($model,'published'); ?>		
		</div>
	</div>
	<div>
			<?php
			if(isset($_REQUEST['type']) && $_REQUEST['type']=='url'){
				echo $form->hiddenField($model,'componentid',array('class'=>'form-control','value'=>0));
			}else{
				$com_id = Components::model()->findByAttributes(array('option'=>$_REQUEST['option']));
				echo $form->hiddenField($model,'componentid',array('class'=>'form-control','value'=>$com_id['id']));
			}
			echo $form->error($model,'componentid',array('style'=>'color:#a94442;'));
			?>
	</div>
	<!-- Menu Paramters seeting -->
	<?php if(isset($_REQUEST['option'])){
		 if($_REQUEST['option']=='com_jevents'){ ?>
				<div class="form-group clearfix">
					<label for="state" class="col-md-2"><?php echo $form->labelEx($model,'Event Type'); ?></label>
					<div class="col-md-10">
						<?php echo  CHtml::radioButtonList('relative',isset($prmsArr['relative'])?$prmsArr['relative']:'week',array('week'=>'Weekly','strtotime'=>'Weekend','rel'=>'Monthly/Yearly'),array("checked"=>"checked",'separator'=>'','labelOptions'=>array('style'=>'margin-right: 10px;'))); ?>
					</div>
				</div>
				<div class="weekend">
					<div class="form-group clearfix">
						<label for="intro" class="col-md-2"><?php echo $form->labelEx($model,'Start Day'); ?></label>
						<div class="col-md-10">
							<?php echo CHtml::textField('strstart','saturday',array('class'=>'form-control','readonly'=>'readonly')); ?>
						</div>
					</div>
					<div class="form-group clearfix">
						<label for="intro" class="col-md-2"><?php echo $form->labelEx($model,'End Day'); ?></label>
						<div class="col-md-10">
							<?php echo CHtml::textField('strend','sunday',array('class'=>'form-control','readonly'=>'readonly')); ?>
						</div>
					</div>
				</div>
				<div class="monthly" style="display: none">
					<div>
						<?php echo CHtml::hiddenField('relstart',0,array('class'=>'form-control')); ?>
					</div>
					<div class="form-group clearfix">
						<label for="intro" class="col-md-2"><?php echo $form->labelEx($model,'Display Event For'); ?></label>
						<div class="col-md-10">
							<?php
							echo CHtml::dropDownList('relend',isset($prmsArr['relend'])?$prmsArr['relend']:'+1m',array('+1m'=>'1 month','+2m'=>'2 month','+3m'=>'3 month','+4m'=>'4 month','+5m'=>'5 month','+1y'=>'1 year','+2y'=>'2 year'),array('class'=>'form-control','data-rel'=>'chosen'));
							?>
						</div>
					</div>
				</div>
		
		<div class="form-group clearfix">
			<label for="category" class="col-md-2"><?php echo CHtml::activeLabel($model,'Select Category', array('required' => true));?></label>
			<div class="col-md-10">
				<?php
				$criteria = new CDbCriteria;
				$criteria->addSearchCondition('section','com_jevents', true);
				$criteria->addSearchCondition('published','1', true);
				$EventcatData = CHtml::listData(Categories::model()->findAll($criteria,array('order'=>'title')),'id','title');
				# Sort Category Name
				natcasesort($EventcatData);
				
				if(Yii::app()->session['addCatFromMenu']){
					$selected[Yii::app()->session['addCatFromMenu']] = array('selected' => 'selected');
				}
				echo CHtml::dropDownList('EventcatData',isset($prmsArr['catid0'])?$prmsArr['catid0']:'',$EventcatData,array('required'=>'required','options' =>isset($selected)?$selected:'','class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select"));
				//echo $form->error($model,'EventcatData',array('style'=>'color:#a94442;'));
				
				# Code to add New Category
				echo "<li style='margin:0% -1%' title='Add New Category' data-placement='top' data-toggle='tooltip' class='$btnArticle'>".CHtml::link('<span style="color:#69BD69;font-size:15pt;" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new category',Yii::app()->createAbsoluteUrl('categories').'/create?type=com_jevents')."</li>";  
				?>
			</div>
		</div>
	<?php }else if($_REQUEST['option']=='com_jevlocations'){ ?>
		<div class="form-group clearfix">
		<label for="category" class="col-md-2">
		<?php echo CHtml::activeLabel($model,'location category', array('required' => true));?></label>
		<div class="col-md-10">
			<?php
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('section','com_jevlocations2', true);
			$criteria->addSearchCondition('published','1', true);
			$catData = CHtml::listData(Categories::model()->findAll($criteria),'id','title');
			# Sort category name alphabaticaly
			natcasesort($catData);
			
			if(isset($prmsArr['catfilter']) && $prmsArr['catfilter']!=''){
				$lc_data = explode('|',$prmsArr['catfilter']);
				foreach($lc_data as $value){
					$selected[$value] = array('selected' => 'selected');
				}
			}
		
			echo CHtml::dropDownList('catid_list','',$catData,array('class'=>'form-control','multiple'=>'multiple','options' =>isset($selected)?$selected:'','data-rel'=>'chosen','data-placeholder'=>'Select Category','required'=>'required'));
			echo $form->error($model,'location category',array('style'=>'color:#a94442;'));
			
			# Code to add New Category
			echo "<li style='margin:0% -1%' title='Add New Category' data-placement='top' data-toggle='tooltip' class='$btnArticle'>".CHtml::link('<span style="color:#69BD69;font-size:15pt;" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new category',Yii::app()->createAbsoluteUrl('categories').'/create?type=com_jevlocations2')."</li>";  
			?>
		</div>
		</div>
	<?php }else if($_REQUEST['option']=='com_phocagallery'){ 
		if($_REQUEST['view']=='categories'){ ?>
		<div class="form-group clearfix">
			<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'Hide Categories',array('data-toggle'=>'tooltip','title'=>"Select category which you don't want to display")); ?></label>
			<div class="col-md-10">
				<?php
				$phocacatData = CHtml::listData(PhocaCategories::model()->findAll('published=1'),'id','title');
				# Sort category name alphabaticaly
				natcasesort($phocacatData);
				
				if(isset($prmsArr['hide_categories']) && $prmsArr['hide_categories']!=''){
					$phoca_cat_data = explode(';',$prmsArr['hide_categories']);
					foreach($phoca_cat_data as $value){
						$selected[$value] = array('selected' => 'selected');
					}
				}
			
				echo CHtml::dropDownList('hide_categories','',$phocacatData,array('class'=>'form-control','multiple'=>'multiple','options' =>isset($selected)?$selected:'','data-rel'=>'chosen','data-placeholder'=>'Select Category'));
				echo $form->error($model,'hide_categories',array('style'=>'color:#a94442;'));
				?>
			</div>
		</div>
		<?php } else { ?>
			<div class="form-group clearfix">
				<label for="category" class="col-md-2">
				<?php echo CHtml::activeLabel($model,'phota category', array('required' => true));?></label>
				<div class="col-md-10">
					<?php
					$phocacatData = CHtml::listData(PhocaCategories::model()->findAll('published=1'),'id','title');
					# Sort category name alphabaticaly
					natcasesort($phocacatData);
					
					parse_str($_SERVER['QUERY_STRING'],$phoca_cat_id);
					echo CHtml::dropDownList('phoca_cat_id',isset($phoca_cat_id['id'])?$phoca_cat_id['id']:'',$phocacatData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select",'onchange'=>"return changephocamenulink(this.value);",'required'=>'required'));
					echo $form->error($model,'phota category',array('style'=>'color:#a94442;'));
					
					# Code to add New Category
					echo "<li style='margin:0% -1%' title='Add New Category' data-placement='top' data-toggle='tooltip' class='$btnArticle'>".CHtml::link('<span style="color:#69BD69;font-size:15pt;" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new category',Yii::app()->createAbsoluteUrl('phocaCategories').'/create')."</li>";  					
					?>
				</div>
			</div>
		<?php } ?>
	<?php } elseif($_REQUEST['view']=='frontpage' || $_REQUEST['view']=='category'){
			if($_REQUEST['view']=='category'){ ?>
				<div class="form-group clearfix">
					<label for="intro" class="col-md-2">
					<?php echo CHtml::activeLabel($model,'section', array('required' => true));?>
					</label>
					<div class="col-md-10">
						<?php
						$criteria1 = new CDbCriteria;
						$criteria1->addSearchCondition('scope','content', true);
						$criteria1->addSearchCondition('published','1', true);
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
						parse_str($_SERVER['QUERY_STRING'],$cat_id);
						
						echo CHtml::dropDownList('category',isset($cat_id['id'])?$cat_id['id']:'',$catData,array('class'=>'form-control','data-rel'=>'chosen','empty' => "Please Select",'onchange'=>"return changemenulink(this.value);",'required'=>'required'));
						echo $form->error($model,'section',array('style'=>'color:#a94442;'));
						
						# Code to add New Category
						echo "<li style='margin:0% -1%' title='Add New Category' data-placement='top' data-toggle='tooltip' class='$btnArticle'>".CHtml::link('<span style="color:#69BD69;font-size:15pt;" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new category',Yii::app()->createAbsoluteUrl('sections').'/create')."</li>";  

						?>
					</div>
				</div>
			<?php } ?>
	<div class="form-group clearfix">
		<label for="intro" class="col-md-2"><?php echo $form->labelEx($model,'Number Of Articles on page'); ?></label>
		<div class="col-md-10">
			<?php echo CHtml::textField('intro',isset($prmsArr['num_intro_articles'])?$prmsArr['num_intro_articles']:4,array('class'=>'form-control')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="category" class="col-md-2"><?php echo $form->labelEx($model,'Article Ordering'); ?></label>
		<div class="col-md-10">
			<?php
			echo CHtml::dropDownList('orderby_sec',isset($prmsArr['orderby_sec'])?$prmsArr['orderby_sec']:'',array(''=>'Default','date'=>'Oldest first','rdate'=>'Most recent first','alpha'=>'Title (Alphabetical)','ralpha'=>'Title (Reverse Alphabetical)','order'=>'Order'),array('class'=>'form-control','data-rel'=>'chosen'));
			?>
		</div>
	</div>
	<?php } else if($_REQUEST['view']=='article'){ ?>
	<div class="form-group clearfix">
		<label for="location" class="col-md-2">
		<?php echo CHtml::activeLabel($model, 'article', array('required' => true));?></label>
		<div class="col-md-8">
			<?php 
			if(isset($_REQUEST['id'])){
				parse_str($_SERVER['QUERY_STRING'],$get_article_id);
				$article_title = Contents::model()->findAll('id='.$get_article_id["id"].' and state=1');
			}
			
			echo CHtml::hiddenField('article_id',isset($get_article_id["id"])?$get_article_id["id"]:'',array('class'=>'form-control','id'=>'article_id','readonly'=>'readonly')); 
			echo CHtml::textField('article',isset($article_title[0]['title'])?$article_title[0]['title']:'',array('class'=>'form-control','id'=>'article-name','readonly'=>'readonly')); 
			echo $form->error($model,'article',array('style'=>'color:#a94442;'));
			?>
		</div>
		<div class="col-md-2"><a href="#" class="btn btn-setting btn-primary">Choose Article</a></div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 60%;margin:2% auto;">
        <div class="modal-content" style="height: 500px; overflow-y: scroll;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 style="margin: 0px;"><i class="glyphicon glyphicon-book"></i> Select Article</h3>
            </div>
            <div class="modal-body" style="overflow: hidden;overflow-x:auto;width:100%;">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
					<thead>
					    <tr>
					        <th>#</th>
					        <th><a href="#">Title</a></th>
					        <th><a href="#">Section</a></th>
					        <th><a href="#">ID</a></th>
					    </tr>
					 </thead>
					<tbody>
						<?php 
						$all_contents = Contents::model()->findAll('state=1 ORDER BY title ASC');
						foreach($all_contents as $num=>$value){ $num++; ?>
						<tr>
							<td width="4%"><?php echo $num;?></td>
							<td width="60%">
								<a id="title_<?php echo $value["id"] ?>" href='#' onclick='insert_article_id(<?php echo $value["id"] ?>);'><?php echo $value['title'];?></a>
							</td>
							<td width="35%">
							<?php
				            $data = Categories::model()->findByAttributes(array('id'=>$value['catid'],'published'=>1));
							echo $data['title'];
							 ?>
							</td>
							<td style="text-align: center"><?php echo $value['id'];?></td>
						</tr>
						<?php }	?>
					</tbody>
				</table>
            </div>
        </div>
 	</div>
	</div>
	<?php } else if($_REQUEST['view']=='page'){ ?> <!--Page START-->
	<div class="form-group clearfix">
		<!--<label for="location" class="col-md-2">
		<?php echo CHtml::activeLabel($model, 'article', array('required' => true));?></label>-->
		<!--<div class="col-md-8">
			<?php 
			if(isset($_REQUEST['id'])){
				parse_str($_SERVER['QUERY_STRING'],$get_article_id);
				$article_title = Contents::model()->findAll('id='.$get_article_id["id"].' and state=1');
			}
			
			echo CHtml::hiddenField('article_id',isset($get_article_id["id"])?$get_article_id["id"]:'',array('class'=>'form-control','id'=>'article_id','readonly'=>'readonly')); 
			echo CHtml::textField('article',isset($article_title[0]['title'])?$article_title[0]['title']:'',array('class'=>'form-control','id'=>'article-name','readonly'=>'readonly')); 
			echo $form->error($model,'article',array('style'=>'color:#a94442;'));
			?>
		</div>-->
		<!--<div class="col-md-2"><a href="#" class="btn btn-setting btn-primary">Choose Article</a></div>-->
		<!--DESCRIPTION START-->
		<div class="form-group clearfix">
		<label for="introtext" class="col-md-2"><?php echo $form->labelEx($model,'pagedescription'); ?></label>
		<div class="col-md-9">
		
			<?php  
			
			if(strlen($model->pagedescription)>1){
				$fulltext = $model->pagedescription."<hr id='system-readmore' />".$model->pagedescription;
			}else{
				$fulltext = $model->pagedescription;
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
			
			
			echo CHtml::hiddenField('article_page','1'); 
			?>
			
		</div>
	</div>	
		
		<!--DESCRIPTION END-->
		
		
	</div>
	<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 60%;margin:2% auto;">
        <div class="modal-content" style="height: 500px; overflow-y: scroll;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 style="margin: 0px;"><i class="glyphicon glyphicon-book"></i> Select Article</h3>
            </div>
            <div class="modal-body" style="overflow: hidden;overflow-x:auto;width:100%;">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
					<thead>
					    <tr>
					        <th>#</th>
					        <th><a href="#">Title</a></th>
					        <th><a href="#">Section</a></th>
					        <th><a href="#">ID</a></th>
					    </tr>
					 </thead>
					<tbody>
						<?php 
						$all_contents = Contents::model()->findAll('state=1 ORDER BY title ASC');
						foreach($all_contents as $num=>$value){ $num++; ?>
						<tr>
							<td width="4%"><?php echo $num;?></td>
							<td width="60%">
								<a id="title_<?php echo $value["id"] ?>" href='#' onclick='insert_article_id(<?php echo $value["id"] ?>);'><?php echo $value['title'];?></a>
							</td>
							<td width="35%">
							<?php
				            $data = Categories::model()->findByAttributes(array('id'=>$value['catid'],'published'=>1));
							echo $data['title'];
							 ?>
							</td>
							<td style="text-align: center"><?php echo $value['id'];?></td>
						</tr>
						<?php }	?>
					</tbody>
				</table>
            </div>
        </div>
 	</div>
	</div>-->
	<?php } // Page end
	
	
	} ?>
	<div class="form-group clearfix" id="menu_icon">
		<label for="menu_icon" class="col-md-2"><?php echo $form->labelEx($model,'Menu Icon'); ?></label>
		<div class="col-md-10">
			<?php 
				$dir = $_SERVER['DOCUMENT_ROOT'].'/images/stories/nav';
				$files = scandir($dir);
				$list = array_slice(array_combine(array_values($files), $files),2);
				
				echo CHtml::dropDownList('menu_icon',isset($prmsArr['menu_image'])?$prmsArr['menu_image']:-1,$list,array('class'=>'form-control menu_img','prompt' => "Please Select",'data-rel'=>'chosen','onchange'=>"return changeDisplayImage(this.value);"));
			?>
			<?php 
				$imageFromDB = '/images/stories/nav/blank.png'; 
				echo CHtml::image($imageFromDB,'nav_alt',array('name'=>'imagelib','class'=>'bg_css','style'=>'padding-top: 10px;margin-top: 10px;'));
			 ?> 
		</div>
	</div>
	<h4 style="font-weight: bold; margin: 0px 13px 26px;">Page Settings : </h4>
	<div class="form-group clearfix">
		<label for="menu_icon" class="col-md-2"><?php echo $form->labelEx($model,'Page Title'); ?></label>
		<div class="col-md-10">
			<?php
			if($model->alias == 'home') {
				$model->alias = 'index.php';
			}
			if($model->parent!='0'){
				$get_parent_name = Menu::model()->findByAttributes(array('id'=>$model->parent));
				if(isset($get_parent_name) AND $get_parent_name!='')
				{
					$parent_name = $get_parent_name->alias;
				}
			}
			if(isset($parent_name) AND $parent_name!=''){
				$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$parent_name.'/'.$model->alias));
			}else{
				$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$model->alias));
			}
			
			if(isset($page_metas) AND $page_metas!=''){
				Pagemeta::model()->title = $page_metas->title;
			}
			echo $form->textField(Pagemeta::model(),'title',array('class'=>'form-control','placeholder'=>'Enter Page Title'));
			//echo CHtml::textField('page_title',isset($prmsArr['page_title'])?$prmsArr['page_title']:'',array('class'=>'form-control'));
			?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="menu_icon" class="col-md-2"><?php echo $form->labelEx($model,'Page Heading'); ?></label>
		<div class="col-md-10">
			<?php 
			
			echo $form->textField($model,'name',array('class'=>'form-control page_heading','placeholder'=>'Enter Heading','readonly'=>'readonly')); ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="meta_description" class="col-md-2"><?php echo $form->labelEx($model,'Meta Description'); ?></label>
		<div class="col-md-10">
			<?php 
			if(isset($page_metas) AND $page_metas!=''){
				Pagemeta::model()->metadesc = $page_metas->metadesc;
			}
			echo $form->textArea(Pagemeta::model(),'metadesc',array('class'=>'form-control','placeholder'=>'Enter Meta Description'));
			 ?>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="meta_keywords" class="col-md-2"><?php echo $form->labelEx($model,'Meta Keywords'); ?></label>
		<div class="col-md-10">
			<?php 
			if(isset($page_metas) AND $page_metas!=''){
				Pagemeta::model()->keywords = $page_metas->keywords;
			}
			echo $form->textArea(Pagemeta::model(),'keywords',array('class'=>'form-control','placeholder'=>'Enter Meta Keywords'));
			 ?>
		</div>
	</div>
</div>

<div class="row">
	<?php echo $form->hiddenField($model,'menutype',array('class'=>'form-control','value'=>'leftmenu')); ?>
</div>
<div class="row">
	<?php if(isset($_REQUEST['type']) && $_REQUEST['type']=='url'){
		echo $form->hiddenField($model,'type',array('class'=>'form-control','value'=>'url')); 
	}else{
		echo $form->hiddenField($model,'type',array('class'=>'form-control','value'=>'component')); 
	} ?>
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'sublevel',array('class'=>'form-control','value'=>0)); ?>
</div>
<div class="row">
	<?php 
	$criteria=new CDbCriteria;
	$criteria->select='max(ordering) as max_order';
	$row = Menu::model()->find($criteria);
	$new_order = $row['max_order']+1;
	echo $form->hiddenField($model,'ordering',array('class'=>'form-control','value'=>$model->ordering?$model->ordering:$new_order)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'checked_out',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'checked_out_time',array('class'=>'form-control','value'=>'0000-00-00 00:00:00')); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'pollid',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'access',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'utaccess',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'lft',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'rgt',array('class'=>'form-control','value'=>0)); ?>	
</div>
<div class="row">
	<?php echo $form->hiddenField($model,'home',array('class'=>'form-control')); ?>	
</div>

<div class="form-group clearfix">
	<div class="modal-footer">
		<?php echo CHtml::link('Cancel', array("/menu"),array('class' => 'btn btn-default'));?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>' btn btn-primary')); ?>
	</div>
</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		
		$("#Menu_name").change(function () {
	   	 $(".page_heading").val($("#Menu_name").val());
	 	})
		
		var radioValue = $('input:radio[name=relative]:checked').val();
		if(radioValue=="week"){
			$('#Menu_link').val('index.php?option=com_jevents&view=week&task=week.listevents');
			$('.weekend').hide();
        	$('.monthly').hide();
		}else if(radioValue=="strtotime"){
			$('#Menu_link').val('index.php?option=com_jevents&view=range&task=range.listevents');
          	$('.weekend').fadeIn();
            $('.monthly').hide();
		}else{
           	$('.monthly').fadeIn();
           	$('.weekend').hide();
		}
		$('#relative_0').click(function () {
			$('#Menu_link').val('index.php?option=com_jevents&view=week&task=week.listevents');
           	$('.weekend').hide();
           	$('.monthly').hide();
 		});
        $('#relative_1').click(function () {
		 	$('#Menu_link').val('index.php?option=com_jevents&view=range&task=range.listevents');
           	$('.weekend').fadeIn();
           	$('.monthly').hide();
 		});
		$('#relative_2').click(function () {
			$('#Menu_link').val('index.php?option=com_jevents&view=range&task=range.listevents');
           	$('.monthly').fadeIn();
           	$('.weekend').hide();
 		});
		if($('#Menu_parent').val()!= "") {
			$('#menu_icon').hide();
		}else{
			$('#menu_icon').show();
		}
		if($('.menu_img').val()!=''){
			document.adminForm.imagelib.src ='/images/stories/nav/' + $('.menu_img').val();
			$('.bg_css').css('background-color', '#d4d4d4'); 
		}
		
	 });
	function hideMenuicon(val){
		if (val != "") {
			$('#menu_icon').hide();
		}else{
			$('#menu_icon').show();
		}
	}
	function changeDisplayImage(name) {
		if (name !='') {
			document.adminForm.imagelib.src ='/images/stories/nav/' + name;
			$('.bg_css').css('background-color', '#d4d4d4'); 
		}else{
			document.adminForm.imagelib.src ='/images/stories/nav/blank.png';
			$('.bg_css').css('background-color', 'transparent');
		}
	}
	
	function insert_article_id(id) {
			 $('#article_id').val(id);
			 $('#Menu_link').val('index.php?option=com_content&view=article&id='+id);
			 $('#article-name').val($('#title_'+id).text());
		     $('#myModal').modal('hide');
	};
	function changemenulink(id) {
			 $('#Menu_link').val('index.php?option=com_content&view=category&layout=blog&id='+id);
	};
	function changephocamenulink(id) {
			 $('#Menu_link').val('index.php?option=com_phocagallery&view=category&id='+id);
	};

</script>
 
</script>
</div><!-- form -->

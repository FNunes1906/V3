<?php echo $this->renderPartial('//layouts/parentmenu'); ?>
<?php 
$URL = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>
<!--Left Sub Menus START-->
<?php if(isset($_REQUEST['menu_id']) && $_REQUEST['menu_id']!=''){ 
	$get_sub_menus = Menu::model()->findAll(array('condition'=>'menutype="leftmenu" and published=1 and parent='.$_REQUEST['menu_id']));
	if(count($get_sub_menus)>0)
	{ 
?>
<div class="col-sm-10 col-lg-10 clearfix">
	<div class="sub-sidebar-nav">
		<nav class="navbar navbar-default" role="navigation">
		   <div class="sub_menu" id="contentcollapse">
		      <ul class="nav navbar-nav main-menu">
			  <?php  
			  			$numItems = count($get_sub_menus);
						$k = 0;
						foreach($get_sub_menus as $sub_menu_name ){
							$params = preg_split('/\s+/', $sub_menu_name['params']);
							for($i=0; $i < count($params); $i++){
								$temp =	explode('=',$params[$i]);

								(!empty($temp[0]) && !empty($temp[1]))?$prmsArr[$temp[0]] = $temp[1]:'';
							} 
							/*echo "<pre>";
							print_r($prmsArr);
							echo "</pre>";*/
							
							if(isset($prmsArr['hide_categories'])){
								$cat_param = "&cat_id=".$prmsArr['hide_categories'];
							}else{
								$cat_param = '';
							}
						 	if($sub_menu_name['link'] == 'index.php?option=com_jevlocations&task=locations.locations'){
							echo "<li><a href=".Yii::app()->createAbsoluteUrl('locations')."?menu_id=$_REQUEST[menu_id]&cat_id=$prmsArr[catfilter]>$sub_menu_name[name]</a></li>";	
							
							}else if($sub_menu_name['link'] == 'index.php?option=com_jevents&view=week&task=week.listevents'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('events')."?menu_id=$_REQUEST[menu_id]&cat_id=$prmsArr[catid0]>$sub_menu_name[name]</a></li>";
							$prmsArr['catid0'] = '';
							}else if($sub_menu_name['link'] == 'index.php?option=com_jevents&view=range&task=range.listevents'){
								$weekend_cat_id = isset($prmsArr['catid0'])?$prmsArr['catid0']:'';
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('events')."?menu_id=$_REQUEST[menu_id]&cat_id=$weekend_cat_id>$sub_menu_name[name]</a></li>";
							}else if($sub_menu_name['link'] == 'index.php?option=com_phocagallery&view=categories'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('galleries')."?menu_id=$_REQUEST[menu_id]".$cat_param.">$sub_menu_name[name]</a></li>";
							}else if($sub_menu_name['link'] == 'index.php?option=com_content&view=frontpage'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."/front?menu_id=$_REQUEST[menu_id]>$sub_menu_name[name]</a></li>";
							}else{
								$menu_link_sep = explode('id=',$sub_menu_name['link']);
								if($menu_link_sep[0] == 'index.php?option=com_phocagallery&view=category&'){
									$cat_name = PhocaCategories::model()->findAll("id=".$menu_link_sep[1]." and published=1");	
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('galleries')."?menu_id=$_REQUEST[menu_id]&cat_id=$menu_link_sep[1]&cat_name=".$cat_name[0]->title.">$sub_menu_name[name]</a></li>";
								}else if($menu_link_sep[0] == 'index.php?option=com_content&view=category&layout=blog&'){
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."?menu_id=$_REQUEST[menu_id]&cat_id=$menu_link_sep[1]>$sub_menu_name[name]</a></li>";
								}else if($menu_link_sep[0] == 'index.php?option=com_content&view=article&'){
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."/update/".$menu_link_sep[1].">$sub_menu_name[name]</a></li>";
								}else{
									echo "<li><a target='_blank' href=".$sub_menu_name['link'].">$sub_menu_name[name]</a></li>";
								}
								
							}
							if(++$k === $numItems) {
								$add_new_submenu = explode('index.php?',$sub_menu_name['link']);
								$add_menu_submenu_sep = explode('&id=',$add_new_submenu[1]);
							    echo "<li><a class='label label-info add-new-btn' href=".Yii::app()->createAbsoluteUrl('menu')."/create?$add_menu_submenu_sep[0]&menu_id=$_REQUEST[menu_id]>Add Submenu</a></li>";
							  }
						 }	
						
						 ?>
			</ul>
		   </div>
		</nav>
	</div>
	
</div>
<?php } } ?>
<!--Left Sub Menus END-->

<div id="content" class="col-lg-10 col-sm-10">
<br/>
<!--Breadcrumnb Start-->
<div>
	<ul class="breadcrumb">
	<?php if(isset($this->breadcrumbs)): 
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'homeLink'=>CHtml::link('Home', array('/site/index')),
				'links'=>$this->breadcrumbs,
			));
		endif;?>
	</ul>
</div>
<!--Breadcrumnb End-->
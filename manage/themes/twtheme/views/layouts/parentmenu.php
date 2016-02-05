<!-- parent menu starts -->
<div class="col-sm-2 col-lg-2 clearfix">
	<div class="sub-sidebar-nav">
		<nav class="nav" role="navigation">
		   <div class="navbar-header">
		      <button type="button" class="navbar-toggle pull-right animated flip" data-toggle="collapse" data-target="#contentcollapse">
		         <span class="sr-only">Toggle navigation</span>
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>
		      </button>
		   </div>
		   
		   <div class="collapse navbar-collapse" id="contentcollapse">
		   	<h5 style="font-weight: bold;text-align: center;text-transform: uppercase;color:#666;">Parent Menus</h5>
			<ul class="nav nav-stacked main-menu">
				<?php 
				$get_parent_menus = Menu::model()->findAll(array('condition'=>'menutype="leftmenu" AND parent=0 AND published=1 ORDER BY ordering'));
	
					if(count($get_parent_menus)>0)
					{ 
						foreach($get_parent_menus as $menu_name ){
							$params = preg_split('/\s+/', $menu_name['params']);
							for($i=0; $i < count($params); $i++){
								$temp =	explode('=',$params[$i]);

								(!empty($temp[0]) && !empty($temp[1]))?$prmsArr[$temp[0]] = $temp[1]:'';
							} 
							if(isset($prmsArr['hide_categories'])){
								$cat_param = "&cat_id=".$prmsArr['hide_categories'];
							}else{
								$cat_param = '';
							}
							if($menu_name['link'] == 'index.php?option=com_jevlocations&task=locations.locations'){
							echo "<li><a href=".Yii::app()->createAbsoluteUrl('locations')."?menu_id=$menu_name[id]&cat_id=$prmsArr[catfilter]>$menu_name[name]</a></li>";	
							}else if($menu_name['link'] == 'index.php?option=com_jevents&view=week&task=week.listevents'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('events')."?menu_id=$menu_name[id]&cat_id=$prmsArr[catid0]>$menu_name[name]</a></li>";
								$prmsArr['catid0'] = '';
							}else if($menu_name['link'] == 'index.php?option=com_jevents&view=range&task=range.listevents'){
								$weekend_cat_id = isset($prmsArr['catid0'])?$prmsArr['catid0']:'';
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('events')."?menu_id=$menu_name[id]&cat_id=$weekend_cat_id>$menu_name[name]</a></li>";
							}else if($menu_name['link'] == 'index.php?option=com_phocagallery&view=categories'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('galleries')."?menu_id=$menu_name[id]".$cat_param.">$menu_name[name]</a></li>";
							}else if($menu_name['link'] == 'index.php?option=com_content&view=frontpage'){
								echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."/front?menu_id=$menu_name[id]>$menu_name[name]</a></li>";
							}else{
								$menu_link_sep = explode('id=',$menu_name['link']);
								if($menu_link_sep[0] == 'index.php?option=com_phocagallery&view=category&'){
									$cat_name = PhocaCategories::model()->findAll("id=".$menu_link_sep[1]." and published=1");	
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('galleries')."?menu_id=$menu_name[id]&cat_id=$menu_link_sep[1]&cat_name=".$cat_name[0]->title.">$menu_name[name]</a></li>";
								}else if($menu_link_sep[0] == 'index.php?option=com_content&view=category&layout=blog&'){
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."?menu_id=$menu_name[id]&cat_id=$menu_link_sep[1]>$menu_name[name]</a></li>";
								}else if($menu_link_sep[0] == 'index.php?option=com_content&view=article&'){
									echo "<li><a href=".Yii::app()->createAbsoluteUrl('contents')."/update/".$menu_link_sep[1].">$menu_name[name]</a></li>";
								}else{
									echo "<li><a target='_blank' href=".$menu_name['link'].">$menu_name[name]</a></li>";
								}
								
							}
						 }	?>
				<?php } 
					echo "<li><a  class='label label-info add-new-btn' href=".Yii::app()->createAbsoluteUrl('menu')."/create?option=com_jevents&view=range&task=range.listevents>Add Menu</a></li>";
				?>
					
			</ul>
		 </div>
		</nav>
	</div>
</div>
<!-- parent menu ends -->

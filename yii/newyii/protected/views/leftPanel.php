<!--Left Sub Menus START-->
<div class="col-sm-2 col-lg-2">
	<div class="sub-sidebar-nav">
		<ul class="nav nav-pills nav-stacked main-menu">
			<li class="nav-header">Manage Content</li>
			
			<li>
				<a class="ajax-link" href="<?php echo Yii::app()->createAbsoluteUrl('events/admin'); ?>"><i class="glyphicon glyphicon-calendar"></i><span> Events</span></a>
			</li>
			
			<li>
				<a class="ajax-link" href="<?php echo Yii::app()->createAbsoluteUrl('locations/admin'); ?>"><i class="glyphicon glyphicon-map-marker"></i><span> Locations</span></a>
			</li>
			
			<li>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/admin'); ?>" class="ajax-link"><i class="glyphicon glyphicon-picture"></i><span> Gallery</span></a>
			</li>
			
			<li>
				<a class="ajax-link" href="<?php echo Yii::app()->createAbsoluteUrl('contents/admin'); ?>"><i class="glyphicon glyphicon-book"></i><span> Articles Manager</span></a>
			</li>
			
			<li>
				<a class="ajax-link" href="<?php echo Yii::app()->createAbsoluteUrl('banners/admin'); ?>"><i class="glyphicon glyphicon-folder-open"></i><span> Manage Banners</span></a>
			</li>
		</ul>
	</div>
</div><br/>
<!--Left Sub Menus END-->

<div id="content" class="col-lg-9 col-sm-9">
<!--Breadcrumnb Start-->
<div>
	<ul class="breadcrumb">
	<?php if(isset($this->breadcrumbs)): 
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));/*breadcrumbs*/
		endif;?>
	</ul>
</div>
<!--Breadcrumnb End-->
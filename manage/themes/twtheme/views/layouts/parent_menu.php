<!-- left menu starts -->
<div class="col-sm-1 col-lg-1">
	<div class="sidebar-nav">
		<div class="nav-canvas">
			<div class="nav-sm nav nav-stacked"> </div>
			<ul class="nav nav-pills nav-stacked main-menu">
				<li>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('site/index'); ?>" title="Dashboard" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-home"></i><br/><span>DashBoard</span>
					</a>
				</li>
				<!--<li>
					<a class="glyphicon glyphicon-ipad" href="#" title="Design your tablet app" data-placement="right" data-toggle="tooltip"></a>
				</li>-->
				<li>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('locations'); ?>" title="Add content to your site" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-book"></i><br/><span>Content</span>
					</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('menu'); ?>" title="Add menus to your site" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-list"></i><br/><span>Menus</span>
					</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('banners'); ?>" title="Add banners to your site" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-folder-open"></i><br/><span>Banners</span>
					</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('pageglobal/update/1'); ?>" title="Manage site settings" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-cogwheel"></i><br/><span>Site Settings</span>
					</a>
				</li>
				<!--<li>
					<a class="glyphicon glyphicon-user" href="<?php echo Yii::app()->createAbsoluteUrl('users'); ?>" title="Manage users" data-placement="right" data-toggle="tooltip">
					<i class="glyphicon glyphicon-list"></i><br/><span>Content</span>
					</a>
				</li>-->
			</ul>
		</div>
	</div>
</div>
<!-- left menu ends -->
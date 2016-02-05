	<!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip togglemenu" data-toggle="collapse" data-target=".nav-canvas">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Yii::app()->createAbsoluteUrl('site/index'); ?>">
			<!--<img alt="Townwizard Logo" src="<?php echo Yii::app()->theme->baseUrl.'/';?>img/Login_screen_new_logo.png" width="100%"/>-->
			<img alt="Townwizard Logo" src="/partner/<?php echo Yii::app()->db->tablePrefix; ?>/images/logo/logo.png" width="65%" height="100%"/></a>
			</a>

            <!-- user dropdown starts -->
			
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span class="hidden-sm hidden-xs"> 
						<?php # Fetch Current login user's information
						$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
						echo $currentLoginUser->name; ?>
					</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('users/update/'.$currentLoginUser->id); ?>">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>">Logout</a></li>
                </ul>
				
            </div>
            <!-- user dropdown ends -->
			<!-- theme selector starts -->
            <!--<div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
					<li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
					<li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
					<li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
					<li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                    
                </ul>
            </div> -->
            <!-- theme selector ends -->
			<?php $site_name = Pageglobal::model()->findall();?>
             <ul class="collapse navbar-collapse nav navbar-nav top-menu"  style="padding-left: 0px;">
                <li>
				<div class="header_sitename" >
					<i class="glyphicon glyphicon-globe" style="color: #428bca"></i> 
					<a data-toggle="tooltip" data-original-title="Preview on website" href="<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>" target="_blank" class='sitename'>  <?php echo $site_name[0]['site_name'];?></a>
				</div>
				</li>
				<li>
					<a href="https://podio.com/webforms/14689862/984508" target="_blank" class='sitename'>
						<button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-edit icon-white"></i> Report an issue</button>
					</a>
				</li>
            </ul>
        </div>
    </div>
    <!-- topbar ends -->
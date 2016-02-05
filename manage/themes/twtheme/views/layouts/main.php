<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<!-- ********** META TAG ************** -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="en">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

		<!-- ********* STYLE CSS ******** -->
	    <link id="bs-css" href="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/charisma-app.css" rel="stylesheet">
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/chosen/chosen.min.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/jquery.noty.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/noty_theme_default.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/elfinder.min.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/elfinder.theme.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/jquery.iphone.toggle.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/uploadify.css' rel='stylesheet'>
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/animate.min.css' rel='stylesheet'>
	    
	    <!--DATE PICKER CSS-->
	    <link href='<?php echo Yii::app()->theme->baseUrl;?>/css/dp/jsDatePick_ltr.min.css' rel='stylesheet'>

	    <!--DATE PICKER JS-->
	    <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/dp/jsDatePick.min.1.3.js"></script>
	    
	    
	    
		
	    <!-- ************** JQUERY ************ -->
	    <script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/jquery/jquery.min.js"></script>	
		<!-- For Date-picker START-->
		<link rel='stylesheet prefetch' href='<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap-datetimepicker.min.css'>
		<!-- For Date-picker END-->

		<!-- ************ PAGE TITLE ************* -->
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>
	
		<?php if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'login') { ?>
			<?php echo $content; ?>
		<?php }else{ ?>
			<?php echo $this->renderPartial('//layouts/header'); ?>
			<div class="ch-container">
		    	<div class="row">
			 		<?php echo $this->renderPartial('//layouts/left'); ?>
					<div id="content" class="col-lg-11 col-sm-11">
						<?php echo $content; ?>
					</div>
				</div>
				<?php echo $this->renderPartial('//layouts/footer');  ?>
			</div>
		<?php } ?>
		
		<!-- ***************** EXTERNAL JAVASCRIPT ***************************** -->
		<!--Bootstrap-->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- For Date-picker Start-->
		<script src='<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datetimepicker.js'></script>
		<script src='<?php echo Yii::app()->theme->baseUrl;?>/js/bootbox.min.js'></script>
		<script type="text/javascript">
			 $(document).ready(function () {
				$(function() {
					/*var d = new Date();
					var month = d.getMonth();
					var day = d.getDate();
					var year = d.getFullYear();
					var hours = d.getHours();
					var min = d.getMinutes();
					var sec = d.getSeconds();*/
					$('#datetimepicker1').datetimepicker({
						 language: 'pt-BR',
					}); 
					//$("#datetimepicker1").data('datetimepicker').setLocalDate(new Date(year, month, day,hours,min,sec));
					$('#datetimepicker2').datetimepicker({
						language: 'pt-BR'
					}); 
					//$("#datetimepicker2").data('datetimepicker').setLocalDate(new Date(year, month, day,hours,min,sec));
					$('#datetimepicker3').datetimepicker({
						language: 'pt-BR'
					});
				});	
		 });
		</script>
		<!-- For Date-picker End-->
		<!-- library for cookie management -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.cookie.js"></script>

		<!-- calender plugin -->
		<script src='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/moment/min/moment.min.js'></script>
		<script src='<?php echo Yii::app()->theme->baseUrl;?>/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>

		<!-- data table plugin -->
		<script src='<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.dataTables.min.js'></script>

		<!-- select or dropdown enhancer -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/chosen/chosen.jquery.min.js"></script>

		<!-- plugin for gallery image view -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/colorbox/jquery.colorbox-min.js"></script>

		<!-- notification plugin -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.noty.js"></script>

		<!-- library for making tables responsive -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/responsive-tables/responsive-tables.js"></script>

		<!-- tour plugin -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>

		<!-- star rating plugin -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.raty.min.js"></script>

		<!-- for iOS style toggle switch -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.iphone.toggle.js"></script>

		<!-- autogrowing textarea plugin -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.autogrow-textarea.js"></script>

		<!-- multiple file upload plugin -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.uploadify-3.1.min.js"></script>

		<!-- history.js for cross-browser state change on ajax -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.history.js"></script>

		<!-- application script for Charisma demo -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/charisma.js"></script>
		
		<script type="text/javascript">
		$('body').on('keyup','.filters > td > input', function() {
			$('.grid-view').yiiGridView('update', {
				data: $(this).serialize()  
			});
			return false; 
		});

		</script>
		 <!-- Editor JS End -->
	</body>
</html>
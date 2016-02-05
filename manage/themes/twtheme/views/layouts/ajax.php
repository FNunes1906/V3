<?php

//$cs = Yii::app()->getClientScript();
//// Add Js Files
//$cs->scriptMap = array(
//    'jquery.js' => false,
//    'jquery.dataTables.js'=>false,
//    'jquery-ui.min.js'=>false,
//    'jquery.fnSetFilteringDelay.js'=>false,
//    'jdatatable.js'=>false
//);

Yii::app()->clientScript->scriptMap = array(
    'jquery.js' => false,
    'jquery.dataTables.js' => false,
    'jquery-ui.min.js' => false,
    'jquery.fnSetFilteringDelay.js' => false,
    'jdatatable.js' => false
);
?>

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
		
	    <!-- ************** JQUERY ************ -->
	    <script src="<?php echo Yii::app()->theme->baseUrl;?>/bower_components/jquery/jquery.min.js"></script>	
		<!-- For Date-picker START-->
		<link rel='stylesheet prefetch' href='<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap-datetimepicker.min.css'>
		<!-- For Date-picker END-->

		<!-- ************ PAGE TITLE ************* -->
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>
		<div class="ch-container" style="margin-top: 30px;">
			<div class="row">
					<div id="content" class="col-lg-4 col-sm-4 center">
						<?php echo $content; ?>
					</div>
			</div>
		</div>
	</body>
</html>		
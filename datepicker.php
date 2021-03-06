<?php 
global $Itemid;

$lang = JFactory::getLanguage();
$cur_language = $lang->getName();

if($cur_language == "Español"){
	$final_lang = "es";
}elseif($cur_language == "Nederlands - nl-NL"){
	$final_lang = "de";	
}elseif($cur_language == "Português (Brasil)"){
	$final_lang = "pt-PT";	
}elseif($cur_language == "Croatian(HR)"){
	$final_lang = "cr";	
}elseif($cur_language == "French (Fr)"){
	$final_lang = "fr";	
}else{
	$final_lang = "";	
}

?>
<link href="templates/townwizard/css/mobiscroll.custom-2.7.2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#demo_default input {background: url("/templates/townwizard/images/header/calBtnLg.png") no-repeat scroll left top transparent;cursor: pointer;display: block;height: 30px;border: medium none;text-indent: -20000px;width: 34px;}
	#demo_default{position: absolute;right: 57px;top: 14px;}	
	/*.dw-in{left:36% !important;top: 290px !important;}*/
	#Find{position: relative;}		
</style>

<script src="templates/townwizard/js/mobiscroll.custom-2.7.2.min.js" type="text/javascript"></script>

<?php 
//Event page calender issue with slider so diffrentiate 
$app = JFactory::getApplication();
if($app->getTemplate() == "townwizard_responsive"){ ?>
	<script type="text/javascript">
	var con = $.noConflict(true);
	</script>
	<script type="text/javascript">

		con(function () {
			var now = new Date();
			var curr = new Date(now.getFullYear(), now.getMonth(), now.getDate())
			var opt = {}
			opt.rangepicker = {preset : 'rangepicker'};
			con('select.changes').bind('change', function() {
				var demo = "rangepicker";
				con(".demos").hide();
				if (!($("#demo_"+demo).length))
				demo = 'default';
				con("#demo_" + demo).show();
				con('#test_'+demo).val('').scroller('destroy').scroller($.extend(opt["rangepicker"], { theme: "ios7", mode: "mixed", display: "bottom", lang: "<?php echo $final_lang;?>", minDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()) }));
			});
	 con('#demo').trigger('change');
	 
		});
	</script>
	
<?php } if($app->getTemplate() == "townwizard"){ ?>
	<script type="text/javascript">
		$(function () {
			var now = new Date();
			var curr = new Date(now.getFullYear(), now.getMonth(), now.getDate())
			var opt = {}
			opt.rangepicker = {preset : 'rangepicker'};
			$('select.changes').bind('change', function() {
				var demo = "rangepicker";
				$(".demos").hide();
				if (!($("#demo_"+demo).length))
				demo = 'default';
				$("#demo_" + demo).show();
				$('#test_'+demo).val('').scroller('destroy').scroller($.extend(opt["rangepicker"], { theme: "ios7", mode: "mixed", display: "bottom", lang: "<?php echo $final_lang;?>", minDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()) }));
			});
	 $('#demo').trigger('change');
	 
		});
	</script>
<?php } ?>



	
<script type="text/javascript">
	function redirecturl(val){
		url="/index.php?option=com_jevents&view=week&task=week.listevents&Itemid=<?php echo $Itemid;?>&searchdate="+val; 
		window.location=url;}
</script>		


<div class="content">

	<div style="display:none;">
		<label for="demo">Demo</label>
		<select name="demo" id="demo" class="changes">
			<option value="date" selected>Date</option>
			<option value="datetime" >Datetime</option>
			<option value="time" >Time</option>
			<option value="rangepicker" >Range Picker</option>
		</select>
	</div>
	<div id="demo_default" class="demos">
		<input type="text" name="test_default" id="test_default" onChange="redirecturl(this.value);" />
	</div>
</div>

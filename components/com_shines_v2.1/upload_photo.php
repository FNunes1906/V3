
<?php
	include("connection.php");
	define(ABS_SRV_PATH,'../../');
	define(DS,'/'); 
?>
<div id="THANKYOU" class="alert success" style="display: none;">
  <span class="closebtn">&times;</span>  
  <?php echo JText::_('THANKYOU'); ?>
</div>

<style>
.alert {padding: 20px;background-color: #f44336;color: white;opacity: 1;transition: opacity 0.6s;margin-bottom: 15px;}

.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;}
.closebtn:hover {color: black;}
</style>
<script type="text/javascript" language="javascript">
	  
	  function form_validation() {
		var filename=document.uploadForm.userphoto.value;
		var ext = filename.substring(filename.lastIndexOf('.') + 1);
		//var iSize = document.getElementById('userphoto').files[0].size;
		if(filename == ""){
			//setAlertMessage('CHOOSE_IMAGE');
			document.getElementById('CHOOSE_IMAGE').style.display  = "block";
			document.getElementById('CHOOSE_IMAGE').style.opacity  = 1;
			//alert ("<?php echo JText::_('CHOOSE_IMAGE') ?>");
			document.uploadForm.userphoto.focus();
			return false;
	 	}else if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "PNG" || ext == "png"){
			return true;
		}else{
			//setAlertMessage('FILE_TYPE');
			document.getElementById('FILE_TYPE').style.display  = "block";
			document.getElementById('FILE_TYPE').style.opacity  = 1;
			//alert ("<?php echo JText::_('FILE_TYPE') ?>");
			document.uploadForm.userphoto.value="";
			document.uploadForm.userphoto.focus();
			return false;
		}
	}
</script>
<?php 
if(isset($_FILES['userphoto'])) {
    if($_FILES['userphoto']['size'] > 2097152) { //2 MB (size is also in bytes) ?> 
		
       <script>
	   	document.getElementById('GREATER_FILE_SIZE').style.display  = "block";
			document.getElementById('GREATER_FILE_SIZE').style.opacity  = 1;
				//alert ("<?php echo JText::_('GREATER_FILE_SIZE') ?>");
		</script>
	  <!-- echo JText::_('GREATER_FILE_SIZE');-->
 <?php  } else {
        function file_upload($param){
		  //var_dump($_FILES);
		  //var_dump($param);
		  //fprint($param);
		  if(isset($_FILES[$param['name']]['name'])) {
		    //$name = _change_file_name($_FILES[$param['name']]['name'], $param['savename']);
		    $name = $param['savename'];
		    //fprint($_FILES[$param['name']]['tmp_name']);
		    //fprint($param['path'].$name);
		    if(@move_uploaded_file($_FILES[$param['name']]['tmp_name'], $param['path'].$name)) {
		      //exit("Yuhoooo!");
		      return $name;
		    }
		  }
		  return false;
		}

		function image_convert($param) {
		  ini_set('max_execution_time', 40);
		  ini_set('memory_limit', "128M");
		  if(!is_file($param['path'].$param['name'])) {
		    return false;
		  }
		  if(false == ($prop = @getimagesize($param['path'].$param['name']))) {
		    return false;
		  }
		  switch($prop[2]) {
		    case 1: //GIF
		      $image = imagecreatefromgif($param['path'].$param['name']);
		    break;
		    case 2: //JPG
		      $image = imagecreatefromjpeg($param['path'].$param['name']);
		    break;
		    case 3: //PNG
		      $image = imagecreatefrompng($param['path'].$param['name']);
		    break;
		    case 15: //WBMP
		      $image = imagecreatefromwbmp($param['path'].$param['name']);
		    break;
		  }
			
		  $name = str_replace('o', '', $param['name']);
		  $src_w = $prop[0];
		  $src_h = $prop[1];
		  $percent = $src_h/$src_w;
		  //fprint($prop); _x('image_convert');
		  foreach($param['size'] as $key => $dst_w) {
		    if($dst_w <= $src_w) {
		      $dst_h = intval($dst_w * $percent);
		    } else {
		      $dst_w = $src_w;
		      $dst_h = $src_h;
		    }
		    $canvas = imagecreatetruecolor($dst_w, $dst_h);
		    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
		    //echo $param['path'].$name;
		    //@unlink($param['path'].$name);
		    $name_arr = explode(DS, $param['path'].$name);
		    $new_name = array_pop($name_arr);
		    $new_name = $key.$new_name;
		    unset($name_arr);
		    //imagejpeg($canvas, preg_replace('/(.*)\.(\w+)$/', '$1'.$key.'.jpg', $param['path'].$name));
		    imagejpeg($canvas, $param['path'].$new_name);
		    imagedestroy($canvas);
		  }
		  return true;
		}

		function _clean($param) {
		  return mysql_real_escape_string(trim($param));
		}

		//////////////////////////////////////////////////////////////////////////////////////////////// Additional function ///////////

		if(($image = file_upload(array(
		  'name'      => 'userphoto',
		  'path'      => ABS_SRV_PATH.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS,
		  'savename'  => $_FILES['userphoto']['name']
		))) != false) {
		  //fprint($image);
		  //echo ABS_SRV_PATH.'images'.DS.'phocagallery'.DS.'thumbs'.DS;
		  image_convert(array(
		    'path'  => ABS_SRV_PATH.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS,
		    'name'  => $image,
		    'size'  => array(
		      'phoca_thumb_l_' => '600px',
		      'phoca_thumb_m_' => '180px',
		      'phoca_thumb_s_' => '60px',
		    ),
		  ));
		  $metadesc = array(
		    'username' => $_POST['username'],
		    'location' => $_POST['useremail']
		  );
			$image1=rand().$image;
		 $sql = "insert into `jos_phocagallery` set 
		      `catid` = 1, 
		      `title` = '"._clean($_POST['caption'] ?: 'No Caption')."', 
		      `alias` = '"._clean(str_replace(' ', '-', strtolower(trim($_POST['caption']))))."', 
		      `filename` = '".$image1."', 
		      `approved` = 0, 
		      `description` = '"._clean($_POST['description'])."', 
		      `metadesc` = '".serialize($metadesc)."'";
		  //fprint($sql);
		  mysql_query($sql);
		  @copy(ABS_SRV_PATH.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image, ABS_SRV_PATH.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.$image1);
		  @unlink(ABS_SRV_PATH.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image);
		  $photo_upload = True;
		 
		}
		if($photo_upload == True){ ?>
			<script type="text/javascript" language="javascript">
				document.getElementById('THANKYOU').style.display  = "block";
				document.getElementById('THANKYOU').style.opacity  = 1;	
				setTimeout(function(){window.location.href = "galleries.php";},3000);
				//alert ("<?php echo JText::_('THANKYOU'); ?>");
			</script>
		<?php } 
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="index,follow" name="robots" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="pics/homescreen.gif" rel="apple-touch-icon" />
<!--<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />-->
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
<title><?php echo JText::_('UP_YR_PT');?></title>

<!--<link href="pics/startup.png" rel="apple-touch-startup-image" /> -->
<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
<style>
	h1 {
	    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
	    font-size: 1.3em;
	    font-weight: bold;
	    padding: 0;
	    text-transform: none;
		padding: 10px;
		margin: 0px;
	}
	#content{
		padding: 10px;
	}
	label{
		cursor: default; 
		font-size: 12px;
	    float: left;
	    width: 118px;
	}
	input,textarea{
		font-size: 12px;
    	margin-bottom: 10px;
		float: left;
	    width: 176px;
	}
	.sub_upload{
			text-align: center;
			text-transform: uppercase; color: #fff !important;
			text-decoration: none; font-weight: bold;
			padding: 4px 7px;
			font-size: 12px;
			text-shadow: 1px 1px 1px rgba(0,0,0,.4);
			border: 1px solid #dbdbdb;
			border-radius: 10px;
			width: 120px;
			box-shadow: 0px 1px 2px rgba(0,0,0,.4) inset;
			background: #6abc43;
			background: -moz-linear-gradient(top,  #6abc43 0%, #4b832f 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6abc43), color-stop(100%,#4b832f));
			background: -webkit-linear-gradient(top,  #6abc43 0%,#4b832f 100%);
			background: -o-linear-gradient(top,  #6abc43 0%,#4b832f 100%);
			background: -ms-linear-gradient(top,  #6abc43 0%,#4b832f 100%);
			background: linear-gradient(to bottom,  #6abc43 0%,#4b832f 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6abc43', endColorstr='#4b832f',GradientType=0 );
		}
		.modal {display: none; position: fixed;z-index: 1;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4); }
.modal-content {background-color: #fefefe;margin: 15% auto;padding: 20px;border: 1px solid #888;width: 80%;}
.close {color: #aaa;float: right;font-size: 28px;font-weight: bold;}
.close:hover,.close:focus {color: black;text-decoration: none;cursor: pointer;}

</style>
</head>
<body>
<div id="GREATER_FILE_SIZE" class="alert info" style="display: none;">
  <span class="closebtn">&times;</span>  
  <?php echo JText::_('GREATER_FILE_SIZE'); ?>
</div>
<div id="FILE_TYPE" class="alert info" style="display: none;">
  <span class="closebtn">&times;</span>  
  <?php echo JText::_('FILE_TYPE') ?>

</div>
<div id="CHOOSE_IMAGE" class="alert warning" style="display: none;">
  <span class="closebtn">&times;</span>  
<?php echo JText::_('CHOOSE_IMAGE') ?>
</div>
			
<h1 class="display upload"><?php echo JText::_('UP_YR_PT');?></h1>
    
<div id="main" role="main">
	<div id="zigzag" style="vertical-align:bottom;"> </div>
	<div id="content">
		<ul class="mainList" id="placesList">
			<form id="uploadForm" name="uploadForm" action="" method="post" enctype='multipart/form-data' onSubmit="return form_validation();">
			  <div id="uploadphoto">
				<!--<input type="hidden" name="MAX_FILE_SIZE" value="2000000">-->
			    <table cellpadding="0" cellspacing="0" width="300">
					<tr>
						<td><label for="name"><?php echo JText::_('YOUR_NAME');?>:</label></td>
						<td><input name="name" id="name" value="" /></td>
					</tr>
					<tr>
						<td><label for="location"><?php echo JText::_('YOUR_HOME');?>:</label></td>
						<td><input name="location" id="location" value="" /></td>
					</tr>
					<tr>
						<td><label for="userfile"><?php echo JText::_('FILE_SIZE');?> :</label></td>
						<td><input type="file" id="userphoto" name="userphoto" size="25" />
						</td>
					</tr>
					<tr>
						<td><label for="caption"><?php echo JText::_('PHOTO_CAP');?>:</label></td>
						<td><input name="caption" id="caption" value="" /></td>
					</tr>
					<tr>
						<td style="vertical-align: top;"><label for="description"><?php echo JText::_('PHOTO_DESCRI');?>:</label></td>
						<td><textarea name="description" id="description" cols="25" rows="6"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><br><input class="sub_upload" type="submit" name="submit" value="<?php echo JText::_('UPLOAD');?>"/></td>
					</tr>
				</table>
			  </div>
			</form>
		</ul>
	</div>
</div>
</body>
</html>
<script>
var close = document.getElementsByClassName("closebtn");
var i;
for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>
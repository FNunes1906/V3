<?php
	global $var;
	include_once(JPATH_BASE .DS.'/inc/var.php');
	include_once(JPATH_BASE .DS.'/inc/base.php');
	include(JPATH_BASE .DS.'/formValidation.php');
	_init();
?>
<script type="text/javascript" language="javascript">
	  
	  function form_validation() {
		var filename=document.uploadForm.image.value;
		var ext = filename.substring(filename.lastIndexOf('.') + 1);
		var iSize = ($("#image")[0].files[0].size / 1024); 
		if (iSize  > 2048) {
			alert ("<?php echo JText::_('GREATER_FILE_SIZE') ?>");
			document.uploadForm.image.focus();
			return false; 
		}
		if(filename == ""){
			alert ("<?php echo JText::_('CHOOSE_IMAGE') ?>");
			document.uploadForm.image.focus();
			return false;
	 	}else if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "PNG" || ext == "png"){
			return true;
		}else{
			alert ("<?php echo JText::_('FILE_TYPE') ?>");
			document.uploadForm.image.value="";
			document.uploadForm.image.focus();
			return false;
		}
	}
</script>

<?php
	global $var;
	global $msg;
	
	function datavalidation(){
	global $msg;
		if(!isvalidchar($_POST['name'])){
			$msg=JText::_('VALID_NAME')."<br/>";
			return false;
		}
		if(!isvalidchar($_POST['location'])){
			$msg=JText::_('VALID_LOCATION')."<br/>";
			return false;
		}
		if(!isvalidchar($_POST['caption'])){
			$msg=JText::_('VALID_CAPTION')."<br/>";
			return false;
		}		
		if(!isvalidchar($_POST['description'])){
			$msg=JText::_('VALID_DESC')."<br/>";
			return false;
		}
		return true;
	}
 
	if(isset($var->post['formname']) && $var->post['formname'] && (datavalidation()==true) == 'upload.event.photo') {
		
		$filename = $_FILES['image']['name'];
		$ext = substr($filename,(strripos($filename,'.') + 1));
		
		if(empty($filename) || $filename == ""){
			$msg=JText::_("CHOOSE_IMAGE");
		}else if($ext == "gif" || $ext == "GIF" || $ext == "JPEG" || $ext == "jpeg" || $ext == "jpg" || $ext == "JPG" || $ext == "PNG" || $ext == "png"){
		
			if(($image = file_upload(array(
				'name'      => 'image',
				'path'      => $var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS,
				'savename'  => $_FILES['image']['name']
		    	))) != false) {
				image_convert(array(
					'path'  => $var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS,
					'name'  => $image,
					'size'  => array(
						'phoca_thumb_l_' => '640px',
						'phoca_thumb_m_' => '180px',
						'phoca_thumb_s_' => '120px',
					),
				));
				$metadesc = array(
					'username' => $var->post['username'],
					'location' => $var->post['location']
				);
				$sql = "insert into `jos_phocagallery` set 
		          `catid` = ".id_from_phoca_cat($var->photo_upload_cat).", 
		          `title` = '"._clean($var->post['caption'])."', 
		          `alias` = '"._clean(str_replace(' ', '-', strtolower(trim($var->post['caption']))))."', 
		          `filename` = '".$image."', 
		          `approved` = 0, 
		          `description` = '"._clean($var->post['description'])."', 
		          `metadesc` = '".serialize($metadesc)."'";

				db_insert($sql);
				@copy($var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image, $var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.$image);
				@unlink($var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image);
				$var->photo_uploaded = true;
			 
		    }
		
		    //#DD#
		    if($var->photo_uploaded==true){
				$rec = mysql_query("SELECT * FROM `jos_users` WHERE `id`=62");
				$pageglobal=mysql_fetch_array($rec);
				$adminEmail = $pageglobal['email'];
				//$adminEmail	= $adminuser->email;
				$sitename =  $pageglobal['site_name'];
				$subject= 'New Photo Uploaded ';
				$message = '
				<table cellpadding="3" cellspacing="3">
				<tr><td colspan="2" align="left"><h2>Photo Details</h2></td></tr>
				<tr><td align="left"><b>Photo</b> </td><td>: '. "http://{$_SERVER['HTTP_HOST']}/partner/{$_SESSION["partner_folder_name"]}/images/phocagallery/$image".'</td></tr>
				<tr><td align="left"><b>Photo Caption</b> </td><td>: '.$var->post['caption'].'</td></tr>
				<tr><td align="left"><b>Photo Description</b> </td><td>: '.$var->post['description'].'</td></tr>
				<tr><td align="left"><b>Name</b> </td><td>: '.$var->post['name'].'</td></tr>
				<tr><td align="left"><b>Hometown</b> </td><td>: '.$var->post['location'].'</td></tr>
				</table>';
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";
				$_SERVER['SERVER_NAME'] = str_replace('www.', '', $_SERVER['SERVER_NAME']);
				$headers .= 'From: NO-REPLY <admin@'.$_SERVER['SERVER_NAME'].'>' . "\r\n";
				$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
				// Email Notification to Administrator
				$sendmail = mail($adminEmail,$subject,$message,$headers);
				//$sendmail = true;
		    }
			
		}else{
			$msg=JText::_("FILE_TYPE");
			$filename="";
		}
		
		
	}
?>

<h1 class="display upload"><?php echo JText::_('UP_YR_PT');?></h1>
    <?php 
	if($msg!=''){
		echo '<div style="color:#FF0000;font-size: 14px;">'.$msg.'</div>';
	}
	if(isset($var->photo_uploaded) && $var->photo_uploaded){
		echo "<div style='color:green;font-size: 14px;'>".JText::_('THANKYOU')."</div><br />"; 
		$_POST = "";
	}
	?>
<div id="jevents" style="font-size: 12px;">
<form id="uploadForm" name="uploadForm" action="" method="post" enctype='multipart/form-data' onSubmit="return form_validation()">
  <div id="uploadphoto">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
    <table cellpadding="0" cellspacing="10">
		<tr>
			<td width="50%"><label for="name"><?php echo JText::_('YOUR_NAME');?>:</label></td>
			<td width="50%"><input name="name" id="name" style="width: 99%;" value="" /></td>
		</tr>
		<tr>
			<td><label for="location"><?php echo JText::_('YOUR_HOME');?>:</label></td>
			<td><input name="location" id="location" style="width: 99%;" value="" /></td>
		</tr>
		<tr>
			<td><label for="userfile"><?php echo JText::_('FILE_SIZE');?> :</label></td>
			<td><input id="image" name="image" type="file" /></td>
		</tr>
		<tr>
			<td><label for="caption"><?php echo JText::_('PHOTO_CAP');?>:</label></td>
			<td><input name="caption" id="caption" style="width:99%;" value="" /></td>
		</tr>
		<tr>
			<td style="vertical-align: top;"><label for="description"><?php echo JText::_('PHOTO_DESCRI');?>:</label></td>
			<td><textarea name="description" id="description" style="width: 99%;" cols="43" rows="6"></textarea></td>
		</tr>
		<tr>
			<td><input type="hidden" name="formname" value="upload.event.photo" />
	    		<input class="button" type="submit" name="submit"  onclick="showHint();" value="<?php echo JText::_('UPLOAD');?>"/></td>
			<td>&nbsp;</td>
		</tr>
	</table>
  </div>
 
</form>
</div>


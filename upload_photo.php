<?php
global $var;
include_once(JPATH_BASE .DS.'/inc/var.php');
include_once(JPATH_BASE .DS.'/inc/base.php');
_init();


?>
<script type="text/javascript" language="javascript">
  document.createElement('header');
  document.createElement('nav');
  document.createElement('section');
  document.createElement('article');
  document.createElement('aside');
  document.createElement('footer');
  
  function form_validation() 
  {
	var filename=document.uploadForm.image.value;
	var ext = filename.substring(filename.lastIndexOf('.') + 1);
	
	if(filename == ""){
	  alert ("Choose image for upload!");
	  document.uploadForm.image.focus();
	  return false;
 	}else if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "PNG" || ext == "png"){
		return true;
	}else{
		alert ("File Type must be GIF or JPG or PNG images only!");
		document.uploadForm.image.value="";
		document.uploadForm.image.focus();
		return false;
	}
}

</script>

<?php
 global $var;
 		 
		
  if(isset($var->post['formname']) && $var->post['formname'] == 'upload.event.photo') {
    //fprint($_FILES); _x();
	
		$filename = $_FILES['image']['name'];
		
		$ext = substr($filename,(strpos($filename,'.') + 1));
			
		if(empty($filename) || $filename == ""){
			
			$msg="Choose image for upload!";
			
		}
		
		else if($ext == "gif" || $ext == "GIF" || $ext == "JPEG" || $ext == "jpeg" || $ext == "jpg" || $ext == "JPG" || $ext == "PNG" || $ext == "png")
		{
			if(($image = file_upload(array(
		      'name'      => 'image',
		      'path'      => $var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS,
		      'savename'  => $_FILES['image']['name']
		    ))) != false) {
		      //fprint($image);
		      //echo $var->abs_srv_path.'images'.DS.'phocagallery'.DS.'thumbs'.DS;
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
		      //fprint($sql);
		      db_insert($sql);
		      @copy($var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image, $var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.$image);
		      @unlink($var->joomla_root.'partner/'.$_SESSION["partner_folder_name"].'/images'.DS.'phocagallery'.DS.'thumbs'.DS.$image);
		      $var->photo_uploaded = true;
			 
		    }
		
		    //#DD#
		    if($var->photo_uploaded==true)
		    {
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
					<tr><td align="left"><b>Name</b> </td><td>: '.$var->post['username'].'</td></tr>
					<tr><td align="left"><b>Hometown</b> </td><td>: '.$var->post['location'].'</td></tr>
					</table>';
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";
					
					$_SERVER['SERVER_NAME'] = str_replace('www.', '', $_SERVER['SERVER_NAME']);
					
					$headers .= 'From: NO-REPLY <admin@'.$_SERVER['SERVER_NAME'].'>' . "\r\n";
					$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
					// Email Notification to Administrator
					mail($adminEmail,$subject,$message,$headers);
		    }
		} 
		else
		{
			$msg="File Type must be GIF or JPG or PNG images only!";
			$filename="";
			//return false;
		}
    
    //#DD#


    //fprint($var->post); _x();
  }
 
?>

<h1 class="display upload"><?php echo JText::_('UP_YR_PT');?></h1>
<div id="jevents" style="font-size: 12px;">
<form id="uploadForm" name="uploadForm" action="" method="post" enctype='multipart/form-data' onSubmit="return form_validation()">
  <div id="uploadphoto">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
    <?php 
	if($msg!='')
	{
		echo '<div style="color:#FF0000;font-size: 14px;">'.$msg.'</div>';
	}
	if(isset($var->photo_uploaded) && $var->photo_uploaded) echo "<h4><?php echo JText::_('THANKYOU')?></h4><br />"; ?>
    
    <label class="no-margin-top" accesskey="f" for="userfile"><?php echo JText::_('FILE_SIZE');?> :</label>
    <input class="no-margin-top" id="image" name="image" value="Vali fail" type="file" />
    <br /><br />
    <label accesskey="t" for="caption"><?php echo JText::_('PHOTO_CAP');?>:</label>
    <input class="no-margin-top" name="caption" id="caption" style="width: 90%;" value="<?php echo $_POST['caption'];?>" />
    <br /><br />
    <label accesskey="c" for="description"><?php echo JText::_('PHOTO_DESCRI');?>:</label>
    <textarea class="no-margin-top" name="description" id="description" style="width: 90%;" cols="43" rows="6"></textarea>
    <br /><br />
    <label accesskey="n" for="username"><?php echo JText::_('YOUR_NAME');?>:</label>
    <input class="no-margin-top" name="username" id="username" style="width: 90%;" value="<?php echo $_POST['username'];?>" />
    <br /><br />
    <label accesskey="h" for="location"><?php echo JText::_('YOUR_HOME');?>:</label>
    <input class="no-margin-top" name="location" id="location" style="width: 90%;" value="<?php echo $_POST['location'];?>" />
    <br /><br />
    <input type="hidden" name="backurl" value="<?php echo $var->http_referer; ?>" />
    <input type="hidden" name="formname" value="upload.event.photo" />
    <input class="button" type="submit" name="submit" value="<?php echo JText::_('UPLOAD');?>"/>
  </div>
 
</form>
</div>


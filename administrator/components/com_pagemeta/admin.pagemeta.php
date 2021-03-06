<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

$task	= JRequest::getCmd('task');

switch ($task) {
	case 'add':
		add( );
		break;
	case 'edit':
		edit( );
		break;
	case 'save':
		save();
		break;
	case 'remove':
		remove();
		break;
	case 'globalseting':
		globalseting();
		break;	
	case 'advanceseting':
		advanceseting();
		break;	
	default:		
		listmeta( );
		break;
}

function listmeta(){
	$db	=& JFactory::getDBO();
	
	$query = "SELECT * FROM #__pagemeta";
	$db->setQuery( $query );
	$row = $db->loadAssocList();		
	
?>
<form method="post" action="" name="adminForm">
<input type="hidden" name="task" value="" />
<input type="hidden" value="0" name="boxchecked">
<table class="adminlist" cellspacing="1">
  <thead>
  <tr>
    <th>#</th>
    <th><input type="checkbox" name="toggle" onclick="checkAll(8);" /></th>
    <th>URL</th>
    <th>Title</th>
    <th>Meta Description</th>
    <th>Keywords</th>  
    <th>Extra Meta</th>    
  </tr>
  </thead>
  <?php for($i=0;$i<sizeof($row);$i++){?>
  <tr>
    <td><?php echo $row[$i]['id'];?></td>
    <td align="center"><input type="checkbox" name="cid" onclick="isChecked(this.checked);" value="<?php echo $row[$i]['id'];?>" /></td>    
    <td><?php echo $row[$i]['uri'];?></td>
    <td><?php echo $row[$i]['title'];?></td>
    <td><?php echo $row[$i]['metadesc'];?></td>
    <td><?php echo $row[$i]['keywords'];?></td>  
    <td><?php echo $row[$i]['extra_meta'];?></td>    
  </tr>
  <?php }?>
</table>
</form>
<?php	
}

function add( ){
?>
<form method="post" action="" name="adminForm">
<input type="hidden" name="task" value="" />
<table class="admintable" cellspacing="1">
  <tr>
    <td width="20%" class="key"><label>URL:</label></td>
    <td width="80%"><input type="text" name="url" class="inputbox" size="50" value="" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Title:</label></td>
    <td width="80%"><input type="text" name="title" class="inputbox" size="50" value="" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Meta Description:</label></td>
    <td width="80%"><textarea name="metadesc" class="inputbox" rows="3" cols="50"></textarea></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Keywords:</label></td>
    <td width="80%"><textarea name="keywords" class="inputbox" rows="3" cols="50"></textarea></td>
  </tr>  
  <tr>
    <td width="20%" class="key"><label>Extra Meta:</label></td>
    <td width="80%"><textarea name="extra_meta" class="inputbox" rows="3" cols="50"></textarea></td>
  </tr>
</table>
</form>
<?php
}
function edit(){
	$db	=& JFactory::getDBO();
	$query = "SELECT * FROM #__pagemeta WHERE id=".$_POST['cid'];
	$db->setQuery( $query );
	$row = $db->loadAssoc();
?>
<form method="post" action="" name="adminForm">
<input type="hidden" name="task" value="" />	
<input type="hidden" name="mid"  value="<?php echo $_POST['cid'];?>" />
<table class="admintable" cellspacing="1">
  <tr>
    <td width="20%" class="key"><label>URL:</label></td>
    <td width="80%"><input type="text" name="url" class="inputbox" size="50" value="<?php echo $row['uri'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Title:</label></td>
    <td width="80%"><input type="text" name="title" class="inputbox" size="50" value="<?php echo $row['title'];?>" /></td>
  </tr>
   <tr>
    <td width="20%" class="key"><label>Meta Description:</label></td>
    <td width="80%"><textarea name="metadesc" class="inputbox" rows="3" cols="50"><?php echo $row['metadesc'];?></textarea></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Keywords:</label></td>
    <td width="80%"><textarea name="keywords" class="inputbox" rows="3" cols="50"><?php echo $row['keywords'];?></textarea></td>
  </tr>  
  <tr>
    <td width="20%" class="key"><label>Extra Meta:</label></td>
    <td width="80%"><textarea name="extra_meta" class="inputbox" rows="3" cols="50"><?php echo $row['extra_meta'];?></textarea></td>
  </tr> 
</table>
</form>
<?php
}

function globalseting(){
	$db	=& JFactory::getDBO();
	$query = "SELECT * FROM #__pageglobal";
	$db->setQuery( $query );
	$row = $db->loadAssoc();
	
	$query2 = "SELECT `id`,`name` FROM `jos_categories` WHERE section = 'com_jevents' AND published=1";
	$db->setQuery( $query2 );
	$row2 = $db->loadAssocList();	
?>
<form method="post" action="" name="adminForm">
<input type="hidden" name="task" value="" />	
<input type="hidden" name="global"  value="1" />
<table class="pagemetatable" cellspacing="1">
  <tr>
    <td width="20%" class="key"><label>site name:</label></td>
    <td width="80%"><input type="text" name="site_name" class="inputbox" size="50" value="<?php echo $row['site_name'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>e-mail:</label></td>
    <td width="80%"><input type="text" name="email" class="inputbox" size="50" value="<?php echo $row['email'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>google analytics code:</label></td>
    <td width="80%"><input  style="vertical-align: top;" type="text" name="googgle_map_api_keys" class="inputbox" size="50" maxlength="25" value="<?php echo $row['googgle_map_api_keys'];?>" />
    <img src="../administrator/templates/khepri/images/tooltip.png" height="18" title="Enter Only UA code in the box, Example: UA-29293639-3" />
    </td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>location code:</label></td>
    <td width="80%"><input type="text" name="location_code" class="inputbox" size="50" value="<?php echo $row['location_code'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>city name:</label></td>
    <td width="80%"><input type="text" name="beach" class="inputbox" size="50" value="<?php echo $row['beach'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>mini photo slider category:</label></td>
    <td width="80%"><input type="text" name="photo_mini_slider_cat" class="inputbox" size="50" value="<?php echo $row['photo_mini_slider_cat'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>photo upload category:</label></td>
    <td width="80%"><input type="text" name="photo_upload_cat" class="inputbox" size="50" value="<?php echo $row['photo_upload_cat'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>facebook link:</label></td>
    <td width="80%"><input type="text" name="facebook" class="inputbox" size="50" value="<?php echo $row['facebook'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>IPhone app download link:</label></td>
    <td width="80%"><input type="text" name="iphone" class="inputbox" size="50" value="<?php echo $row['iphone'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>android app download link:</label></td>
    <td width="80%"><input type="text" name="android" class="inputbox" size="50" value="<?php echo $row['android'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>Twitter Follow up:</label></td>
    <td width="80%"><input type="text" name="twitter" class="inputbox" size="50" value="<?php echo $row['twitter'];?>" /></td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>youtube Follow up:</label></td>
    <td width="80%"><input type="text" name="youtube" class="inputbox" size="50" value="<?php echo $row['youtube'];?>" /></td>
  </tr>
  <tr>
  	<td width="20%" class="key"><label>time zone:</label></td>
	<td width="80%">
<?php 

	$timezoneTable = array(
	"-12:00:00" => "(GMT -12:00) Eniwetok, Kwajalein",
	"-11:00:00" => "(GMT -11:00) Midway Island, Samoa",
	"-10:00:00" => "(GMT -10:00) Hawaii",
	"-9:00:00" => "(GMT -9:00) Alaska",
	"-8:00:00" => "(GMT -8:00) Pacific Time (US &amp; Canada)",
	"-7:00:00" => "(GMT -7:00) Mountain Time (US &amp; Canada)",
	"-6:00:00" => "(GMT -6:00) Central Time (US &amp; Canada), Mexico City",
	"-5:00:00" => "(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima",
	"-4:00:00" => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz",
	"-3:30:00" => "(GMT -3:30) Newfoundland",
	"-3:00:00" => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",
	"-2:00:00" => "(GMT -2:00) Mid-Atlantic",
	"-1:00:00" => "(GMT -1:00 hour) Azores, Cape Verde Islands",
	"00:00:00" => "(GMT) Western Europe Time, London, Lisbon, Casablanca",
	"1:00:00" => "(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris",
	"2:00:00" => "(GMT +2:00) Kaliningrad, South Africa",
	"3:00:00" => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg",
	"3:00:00" => "(GMT +3:30) Tehran",
	"4:00:00" => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi",
	"4:30:00" => "(GMT +4:30) Kabul",
	"5:00:00" => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",
	"5:30:00" => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",
	"6:00:00" => "(GMT +6:00) Almaty, Dhaka, Colombo",
	"7:00:00" => "(GMT +7:00) Bangkok, Hanoi, Jakarta",
	"8:00:00" => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong",
	"9:00:00" => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",
	"9:30:00" => "(GMT +9:30) Adelaide, Darwin",
	"10:00:00" => "(GMT +10:00) Eastern Australia, Guam, Vladivostok",
	"11:00:00" => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia",
	"12:00:00" => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka"
	);
?>
		<select size="1" class="inputbox" id="offset" name="timezone">
			<?php
			foreach($timezoneTable as $key => $value){?>
					 <option <?php echo ($row['time_zone'] == $key)?"selected='selected'":''?> value="<?php echo $key;?>"><?php echo $value;?></option>
			<?php }?>
		</select>
	</td>
  </tr>
	<tr>
    <td width="20%" class="key"><label>Header Color:</label></td>
    <td width="80%"><input type="text" name="Header_color" class="inputbox" size="10" value="<?php echo $row['Header_color'];?>" /></td>
  </tr>
  <tr>
	<td width="20%" class="key"><label>Footer Menu Link:</label></td>
	<td width="80%"><input  style="vertical-align: top;" type="text" name="Footer_Menu_Link" class="inputbox" size="50" value="<?php echo $row['Footer_Menu_Link'];?>" />
	<img src="../administrator/templates/khepri/images/tooltip.png" height="18" title="Enter URL with http://, Example: http://www.townwizard.com" /> </td>
  </tr>
    <tr>
	<td width="20%" class="key"><label>Homepage Slider Events Cat:</label></td>
	<td width="80%"><!--<input type="text" name="homeslidercat" class="inputbox" size="50" value="<?php echo $row['homeslidercat'];?>" />-->
	<?php // print_r($row2); ?>
			<select size="1" class="inputbox" id="offset" name="homeslidercat">
			<?php
			foreach($row2 as $data){?>
					 <option <?php echo ($data['id'] == $row['homeslidercat'])?"selected='selected'":''?> value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
			<?php }?>
		</select>
	</td>
  </tr>
  <tr>
    <td width="20%" class="key"><label>distance unit:</label></td>
    <td width="80%">
      <?php
      if ($row['distance_unit'] == 'KM') { ?>
      <input name="dunit" type="radio" value="KM" checked />KM&nbsp;<input name="dunit" type="radio" value="Miles" />Miles
      <?php } ?> 
      <?php
      if ($row['distance_unit'] == 'Miles') { ?>
      <input name="dunit" type="radio" value="KM"/>KM&nbsp;<input name="dunit" type="radio" value="Miles" checked />Miles
      <?php } ?>
      <?php if ($row['distance_unit'] == '') { ?>
      <input name="dunit" type="radio" value="KM"/>KM&nbsp;<input name="dunit" type="radio" value="Miles" checked />Miles
      <?php } ?>
    </td>
  </tr>
    <tr>
    <td width="20%" class="key"><label>weather unit:</label></td>
    <td width="80%">
      <?php
      if ($row['weather_unit'] == 'm') { ?>
      <input name="wunit" type="radio" value="m" checked />C&nbsp;<input name="wunit" type="radio" value="s" />F
      <?php } ?> 
      <?php
      if ($row['weather_unit'] == 's') { ?>
      <input name="wunit" type="radio" value="m"/>C&nbsp;<input name="wunit" type="radio" value="s" checked />F
      <?php } ?>
      <?php if ($row['weather_unit'] == '') { ?>
      <input name="wunit" type="radio" value="m"/>C&nbsp;<input name="wunit" type="radio" value="s" checked />F
      <?php } ?>
   <td>
  </tr>
  <!--For date format-->
  <tr>
    <td width="20%" class="key"><label>Date Format:</label></td>
    <td width="80%">
      <?php
      if ($row['date_format'] == '%m/%d') { ?>
      <input name="dformat" type="radio" value="%m/%d" checked />Month/Date&nbsp;<input name="dformat" type="radio" value="%d/%m" />Date/Month
      <?php } ?> 
      <?php
      if ($row['date_format'] == '%d/%m') { ?>
      <input name="dformat" type="radio" value="%m/%d"/>Month/Date&nbsp;<input name="dformat" type="radio" value="%d/%m" checked />Date/Month
      <?php } ?>
      <?php if ($row['date_format'] == '') { ?>
      <input name="dformat" type="radio" value="%m/%d"/>Month/Date&nbsp;<input name="dformat" type="radio" value="%d/%m" checked />Date/Month
      <?php } ?>
   </td>
  </tr>
  <!-- CODE FOR TIME FORMAT -->
   <tr>
    <td width="20%" class="key"><label>Time Format:</label></td>
    <td width="80%">
      <?php
      if ($row['time_format'] == '12') { ?>
      <input name="tformat" type="radio" value="12" checked />12 hrs&nbsp;<input name="tformat" type="radio" value="24" />24 hrs
      <?php } ?> 
      <?php
      if ($row['time_format'] == '24') { ?>
      <input name="tformat" type="radio" value="12"/>12 hrs&nbsp;<input name="tformat" type="radio" value="24" checked />24 hrs
      <?php } ?>
      <?php if ($row['time_format'] == '') { ?>
      <input name="tformat" type="radio" value="12"/>12 hrs&nbsp;<input name="tformat" type="radio" value="24" checked />24 hrs
      <?php } ?>
   </td>
  </tr>

  
</table>
</form>
<?php
}


function save(){
	
	global $mainframe;
	
	$db	=& JFactory::getDBO();
	
	if(isset($_POST['mid'])){
		
		$query = "UPDATE #__pagemeta SET uri ='".$_POST['url']."', title ='".$_POST['title']."', metadesc ='".addslashes($_POST['metadesc'])."', keywords ='".addslashes($_POST['keywords'])."', extra_meta ='".addslashes($_POST['extra_meta'])."' WHERE id='".$_POST['mid']."'";
		
		$db->setQuery( $query );
		
		if (! $db->query()) {
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Unable to update Page Meta');
		}else{
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Page Meta updated sucessfully');
		}	
	}
	elseif(isset($_POST['global'])){
		
		$query = "UPDATE #__pageglobal SET site_name ='".$_POST['site_name']."', email ='".$_POST['email']."', googgle_map_api_keys ='".addslashes($_POST['googgle_map_api_keys'])."', location_code ='".$_POST['location_code']."', beach ='".$_POST['beach']."', photo_mini_slider_cat ='".$_POST['photo_mini_slider_cat']."', photo_upload_cat ='".$_POST['photo_upload_cat']."', facebook ='".$_POST['facebook']."', iphone ='".$_POST['iphone']."', android ='".$_POST['android']."', Header_color='".$_POST['Header_color']."',Footer_Menu_Link='".$_POST['Footer_Menu_Link']."', distance_unit ='".$_POST['dunit']."', weather_unit ='".$_POST['wunit']."', twitter ='".$_POST['twitter']."',date_format ='".$_POST['dformat']."',time_format ='".$_POST['tformat']."', youtube ='".$_POST['youtube']."',time_zone ='".$_POST['timezone']."', homeslidercat ='".$_POST['homeslidercat']."' WHERE id='1'";
		
		$db->setQuery( $query );
		
		if (! $db->query()) {
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Unable to update Global Settings');
		}else{
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Global Settings updated sucessfully');
		}	
	}
	elseif(isset($_POST['advance'])){
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		
		/*CODE FOR SITEMAP XML FILE UPLOAD BEGIN */
		if($_FILES["file"]["name"] != ''){
			$allowedExts = array("xml", "XML");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			if(($_FILES["file"]["type"] == "text/xml") && ($_FILES["file"]["size"] < 6000000) && in_array($extension, $allowedExts)){
				
				# Assigning default file name as sitemap.xml
				$xmlFileName = "sitemap.xml";
				
				# If sitemap.xml file is already exists then remove it
				if(file_exists("../partner/".$_SESSION['partner_folder_name']."/images/".$xmlFileName)){
					unlink("../partner/".$_SESSION['partner_folder_name']."/images/".$xmlFileName);
				}
				# Move new uploaded file to partner images folder
				move_uploaded_file($_FILES["file"]["tmp_name"],"../partner/".$_SESSION['partner_folder_name']."/images/".$xmlFileName);
			}else{
				$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Unable to Save, Invalid file type or Upload file size limit exceed. (File size limit: 5 MB)');
			}
		}
			/*CODE FOR SITEMAP XML FILE UPLOAD END */		
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Advance Settings updated sucessfully');
	}
	else{	
		$query = "INSERT INTO #__pagemeta (`id`, `uri`, `title`, `metadesc`, `keywords`, `extra_meta`) VALUES (NULL, '".$_POST['url']."', '".$_POST['title']."', '".addslashes($_POST['metadesc'])."', '".addslashes($_POST['keywords'])."', '".addslashes($_POST['extra_meta'])."')";
		
		$db->setQuery( $query );
		if (! $db->query()) {
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Unable to add Page Meta');
		}else{
			$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Page Meta added sucessfully');
		}	
	}
}

function remove(){
	global $mainframe;
	$db	=& JFactory::getDBO();
	$query = "DELETE FROM #__pagemeta WHERE id=".$_POST['cid'];
	$db->setQuery( $query );
	if (! $db->query()) {
		$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Unable to remove Page Meta');
	}else{
		$mainframe->redirect( 'index.php?option=com_pagemeta' , 'Page Meta remove sucessfully');
	}	
}

function advanceseting(){
	$db	=& JFactory::getDBO();
	$query = "SELECT * FROM #__pageglobal";
	$db->setQuery( $query );
	$row = $db->loadAssoc();
	$query2 = "SELECT `id`,`name` FROM `jos_categories` WHERE section = 'com_jevents' AND published=1";
	$db->setQuery( $query2 );
	$row2 = $db->loadAssocList();?>
	<!--XML Popup setting BEGIN-->
	<!--XML Popup setting END-->

	<form method="post" action="" name="adminForm" enctype="multipart/form-data">
		<input type="hidden" name="task" value="" />	
		<input type="hidden" name="advance"  value="1" />
		<table class="pagemetatable" cellspacing="1">
			<tr>
				<td width="20%" class="key"><label>Sitemap XML:</label></td>
				<td width="80%">
					<?php if(file_exists("../partner/".$_SESSION['partner_folder_name']."/images/sitemap.xml")){
						echo "SITEMAP.XML";
					}?>
					<input style="vertical-align: top;height:auto" type="file" name="file" id="metastyle" class="inputbox" size="50" />
					<img src="../administrator/templates/khepri/images/tooltip.png" height="18" title="You may upload your [sitemap.xml] file here. [File size limit: 5 MB]" />
				</td>
			</tr>
		</table>
	</form>
<?php }?>

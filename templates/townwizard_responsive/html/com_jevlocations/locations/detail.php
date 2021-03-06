<?php 
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
?>

<link rel="stylesheet" type="text/css" href="<?php echo $templateDir?>/css/pirobox/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $templateDir ?>/css/jquery-ui.css" media="screen" />
<script type="text/javascript" src="<?php echo $templateDir ?>/js/popup/pirobox.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
    my_speed: 400, //animation speed
    bg_alpha: 0.8, //background opacity
    slideShow : true, // true == slideshow on, false == slideshow off
    slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
    close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox
	});
});
</script>

<?php  

/* code added by rinkal for map in all languages */
$lang =& JFactory::getLanguage();
$lan = $lang->getName();
if($lan=="Español"){
	$map_lang="es";
}else if($lan=="Croatian(HR)"){
	$map_lang="hr";
}else if($lan=="Nederlands - nl-NL"){
	$map_lang="nl";
}else if($lan=="Português (Brasil)"){
	$map_lang="pt";
}else if($lan=="French (Fr)"){
	$map_lang="fr";
}else{
	$map_lang="en";
}
/* code ended by rinkal for map in all language */
?>
<html>
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=<?php echo $map_lang?>"></script>
<script type="text/javascript">
  var geocoder;
  var map;
  var marker;
  
  function initialize() {
  geocoder = new google.maps.Geocoder();
  var myLatlng = new google.maps.LatLng(<?php echo $this->location->geolat;?>,<?php echo $this->location->geolon;?>);
  var myOptions = {zoom:<?php echo $this->location->geozoom;?>,center: myLatlng, mapTypeId: google.maps.MapTypeId.ROADMAP}
  	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
	marker = new google.maps.Marker({draggable: true, position: myLatlng,  map: map, title: "Your location" });
	resetLatLngTxtFields(<?php echo $this->location->geolat;?>,<?php echo $this->location->geolon;?>);
    google.maps.event.addListener(marker, 'drag', function (event) {
		resetLatLngTxtFields(this.getPosition().lat(), this.getPosition().lng());
	});
}

function resetLatLngTxtFields(lat, lng){
	document.getElementById("latbox").value = lat;
    document.getElementById("lngbox").value = lng;
}

  function codeAddress() {
    street = document.getElementById("street").value;	
	city = document.getElementById("city").value;	
	state = document.getElementById("state").value;	
	country = document.getElementById("country").value;	
	postcode = document.getElementById("postcode").value;	
	var address = street+","+city+","+state+","+country+","+postcode;

    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
    	marker.setPosition(results[0].geometry.location);
		resetLatLngTxtFields(results[0].geometry.location.lat(), results[0].geometry.location.lng());
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
</script> 
</head>
<body onload="initialize()">
	<div id="placeContainer" itemtype="http://schema.org/Organisation" itemscope="">
	<?php 
	//echo "<span>".$this->location->category."</span>";
	echo "<h2 itemprop='name'>".$this->location->title. "</h2>";?>
	
	<span id="gmap">
		<?php 
		$replace = array("#","&");
		$new_lc_street = str_replace($replace, "", $this->location->street);?>
		<a href="https://maps.google.com/maps?q=<?php echo $new_lc_street ?>+<?php echo $this->location->city ?>+<?php echo $this->location->state ?>+<?php echo $this->location->country ?>+<?php echo $this->location->postcode ?>&hl=<?php echo $map_lang;?>" target="_blank">
			<div id="map_canvas" style="width:100%; height:156px;margin:5px 0px 5px 5px;"></div>
		</a>
	</span>
	<?php
	if (strlen($this->location->phone)>0) {
		$phrase = $this->location->phone;
		$remove = array("(","-",")"," ");
		$newphrase = str_replace($remove, "", $phrase);
		 echo "<p>".JText::_("TW_PHONE").":</p><p><a itemprop='telephone' href=tel:".$newphrase.">".$this->location->phone."</a></p>";
	}
		if (strlen($this->location->url)>0) {
			 $pattern = '[a-zA-Z0-9&?_.,=%\-\/]';
			 if (strpos($this->location->url,"http://")===false) 
			 $this->location->url = "http://".trim($this->location->url);?>
			 <p><a href='<?php echo $this->location->url; ?>' target="_blank"><?php echo JText::_("TW_VISIT");?></a></p>
		 <?php } ?>
	
	
	<ul class="address" itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
	<?php
	$compparams = JComponentHelper::getParams("com_jevlocations");
	$usecats = $compparams->get("usecats",0);
	if ($usecats){
		echo $this->location->street."<br/>";
		echo $this->location->category."<br/>";
	}
	else { ?> <a href="https://maps.google.com/maps?q=<?php echo $new_lc_street ?>+<?php echo $this->location->city ?>+<?php echo $this->location->state ?>+<?php echo $this->location->country ?>+<?php echo $this->location->postcode ?>&hl=<?php echo $map_lang;?>" target="_blank">
	<?php	
	    if (strlen($this->location->street)>0) echo $this->location->street."<br/>";
		if (strlen($this->location->city)>0) echo $this->location->city."<br/>";
		if (strlen($this->location->state)>0) echo $this->location->state.", ".$this->location->postcode;
	?> </a> <?php }?> 

	</ul>
	<?php
	echo "<div itemprop='description' class='ven_desc'>".$this->location->description."</div>";
	echo "<div class='likes fl' style='margin-bottom: 10px;'><span>".JText::_("TW_LIKEDBY").":</span><br /><div class='fb-like' data-send='false' data-layout='standard' data-width='245' data-show-faces='true'></div></div>";
	
	if ($this->location->image!=""){
		// Get the media component configuration settings
		$params =& JComponentHelper::getParams('com_media');
		// Set the path definitions
		$mediapath =  JURI::root(true).'/'.$params->get('image_path', 'images/stories');

		// folder relative to media folder
		$locparams = JComponentHelper::getParams("com_jevlocations");
		$folder = "jevents/jevlocations";
		$thimg = '<img src="'.$mediapath.'/'.$folder.'/thumbnails/thumb_'.$this->location->image.'" />' ;
		$img = '<img src="'.$mediapath.'/'.$folder.'/'.$this->location->image.'" />' ;
		$imgbig = $mediapath.'/'.$folder.'/'.$this->location->image ;
		echo "</div><div id='VenuePhotoGallery' class='photoGallerySect sect' style='width: 97%;overflow: hidden;'><h3 class='fl'><a class='heading display' href='/index.php?option=com_phocagallery&view=categories&Itemid=102'>".JText::_('TW_PHOTO_GALLERY')."</a></h3><div class='bc fr'><a href='/index.php?option=com_phocagallery&view=categories&Itemid=102'>".JText::_("LOC_SEND_PHOTO")."</a></div><ul><li>
  
  <a title='Open image in new window' class='pirobox_gall' href='$imgbig'>".$thimg."</a>
  
  </li></ul></div>";

	}

	

	// New custom fields
	JLoader::register('JevCfParameter',JPATH_SITE."/plugins/jevents/customfields/jevcfparameter.php");
	$compparams = JComponentHelper::getParams("com_jevlocations");
	$template = $compparams->get("template","");
	if ($template!=""){
		$html = "";
		$xmlfile = JPATH_SITE."/plugins/jevents/customfields/templates/".$template;
		if (file_exists($xmlfile)){
			$db = JFactory::getDBO();
			$db->setQuery("SELECT * FROM #__jev_customfields3 WHERE target_id=".intval($this->location->loc_id). " AND targettype='com_jevlocations'");
			$customdata = $db->loadObjectList();

			$jcfparams = new JevCfParameter($customdata,$xmlfile,  $this->location);
			$customfields = $jcfparams->renderToBasicArray();
		}
		$templatetop = $compparams->get("templatetop","<table border='0'>");
		$templaterow = $compparams->get("templatebody","<tr><td class='label'>{LABEL}</td><td>{VALUE}</td>");
		$templatebottom = $compparams->get("templatebottom","</table>");

		$row->customfields = $customfields;
		$html = $templatetop;
		$user = JFactory::getUser();
		foreach ($customfields as $customfield) {
			if ($user->aid < intval($customfield["access"])) continue;
			if (!is_null($customfield["hiddenvalue"]) && trim($customfield["value"])==$customfield["hiddenvalue"]) continue;
			$outrow = str_replace("{LABEL}",$customfield["label"],$templaterow);
			$outrow = str_replace("{VALUE}",nl2br($customfield["value"]),$outrow );
			$html .= $outrow ;
		}
		$html .= $templatebottom;

		//echo $html;
	}

	?>



</body>
</html>
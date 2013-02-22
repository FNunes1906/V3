<?php defined('_JEXEC') or die('Restricted access'); 
?>
<html>
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
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
<div id="Feat" class="centerCol fl">

<div id="VenueDetail" class="detailFeature sect" style="width: 412px;">
	<?php 
	echo "<div class='bc bold fr'>".$this->location->category."</div>";
	echo "<h1 class='display'>".$this->location->title. "</h1>";?>
	
	<div class="map fr">
	<div id="map_canvas" style="width:200px; height:156px"></div>
	</div>
	<?php
	if (strlen($this->location->phone)>0) echo "<div class='phone bold'>Phone:".$this->location->phone."</div>";
		if (strlen($this->location->url)>0) {
		$pattern = '[a-zA-Z0-9&?_.,=%\-\/]';
		if (strpos($this->location->url,"http://")===false) $this->location->url = "http://".trim($this->location->url);
		$this->location->url = preg_replace('#(http://)('.$pattern.'*)#i', '<a href="\\1\\2" target="_blank">\\1\\2</a>', $this->location->url);
		echo $this->location->url;
	}
	?>
	
	<div class="address">
	<?php
	$compparams = JComponentHelper::getParams("com_jevlocations");
	$usecats = $compparams->get("usecats",0);
	if ($usecats){
		echo $this->location->street."<br/>";
		echo $this->location->category."<br/>";
	}
	else {
		if (strlen($this->location->street)>0) echo "<div>".$this->location->street."</div>";
		if (strlen($this->location->city)>0) echo "<div>".$this->location->city."</div>";
		if (strlen($this->location->state)>0) echo "<div>".$this->location->state."</div>";
		if (strlen($this->location->postcode)>0) echo "<div>".$this->location->postcode."</div>";
		if (strlen($this->location->country)>0) echo "<div>".$this->location->country."</div>";
	}?>

</div>
	<?php
	echo $this->location->description;
	echo "<br/><br/><div class='likes fl'><span>Liked by:</span>
            <div class='fb-like' data-send='false' data-layout='standard' data-width='45%' data-show-faces='true'></div>
			</div></div></div></div>";
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
		echo "<div id='VenuePhotoGallery' class='photoGallerySect sect' style='width: 412px;overflow: hidden;'><div class='cont'><h3 class='fl'><a class='heading display' href='/index.php?option=com_phocagallery&view=categories&Itemid=102'>PHOTO GALLERY</a></h3><div class='bc fr'><a href='/index.php?option=com_phocagallery&view=categories&Itemid=102'>Send us your photos</a></div><ul><li><a id='pop' href='#'>".$thimg."</a><div id='overlay_form' style='display: none;'><a id='close' href='#'>Close</a>".$img."</div></li></ul></div></div>";
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






<?php
if (JRequest::getInt("se",0)){
?>
<!--<fieldset class="adminform">
	<legend><?php echo JText::_( 'JEV UPCOMING EVENTS' ); ?></legend>
	<?php
	require_once (JPATH_SITE."/modules/mod_jevents_latest/helper.php");

	$jevhelper = new modJeventsLatestHelper();
	$theme = JEV_CommonFunctions::getJEventsViewName();

	JPluginHelper::importPlugin("jevents");
	$viewclass = $jevhelper->getViewClass($theme, 'mod_jevents_latest',$theme.DS."latest", $compparams);

	// record what is running - used by the filters
	$registry	=& JRegistry::getInstance("jevents");
	$registry->setValue("jevents.activeprocess","mod_jevents_latest");
	$registry->setValue("jevents.moduleid", "cb");

	$menuitem = intval($compparams->get("targetmenu",0));
	if ($menuitem>0){
		$compparams->set("target_itemid",$menuitem);
	}
	// ensure we use these settings
	$compparams->set("modlatest_useLocalParam",1);
	// disable link to main component
	$compparams->set("modlatest_LinkToCal",0);

	$registry->setValue("jevents.moduleparams", $compparams);

	$loclkup_fv = JRequest::setVar("loclkup_fv",$this->location->loc_id);
	$modview = new $viewclass($compparams, 0);
	echo $modview->displayLatestEvents();
	JRequest::setVar("loclkup_fv",$loclkup_fv);

	echo "<br style='clear:both'/>";

	$task = $compparams->get("view",",month.calendar");
	$link = JRoute::_("index.php?option=com_jevents&task=$task&loclkup_fv=".$this->location->loc_id."&Itemid=".$menuitem);

	echo "<strong>".JText::sprintf("JEV ALL EVENTS",$link)."</strong>";
	?>
</fieldset> -->

<?php
}
?>
</div>
</body>
</html>
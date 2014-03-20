<?php
# Including Configuration file
include("configuration.php");

# Initialise Class instance 
$jconfig = new JConfig();
$xmlFileName = "sitemap.xml";

# IF Partner folder containt sitemap.xml then read the contnetn and display in XML format
if(file_exists("partner/".$_SESSION['partner_folder_name']."/images/".$xmlFileName)){
	header('Content-type: text/xml');
	$file = "partner/".$_SESSION['partner_folder_name']."/images/".$xmlFileName;
	echo file_get_contents($file);
	
# IF partner folder doesn't contain sitemap.xml then redirect to 404 page
}else{
	header('Location: /index.php?option=com_content&view=article&id=400');
	exit;
}?>
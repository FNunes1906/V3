<?php

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
// Set flag that this is a parent file
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$x = realpath(dirname(__FILE__)."/../../") ;
// SVN version
if (!file_exists($x.DS.'includes'.DS.'defines.php')){
	$x = realpath(dirname(__FILE__)."/../../../") ;

}
define( 'JPATH_BASE', $x );

@ini_set("display_errors",0);

require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
 
global $mainframe;
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

include("connection.php");

function advertise_intro() {
	$db = JFactory::getDBO();
	$db->setQuery("select `introtext` from `jos_content` where `title` = 'App Advertise with Us'");
	$content = $db->query();
	$text=mysql_fetch_row($content);
	echo $text[0];
}
?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<link rel="image_src" href="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png" />  
	<meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png"/>
	<meta property="og:title" content="<?php echo utf8_encode($site_name).' | Advertise';?>"/>
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="index,follow" name="robots" />
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta name="HandheldFriendly" content="True">
   	 <meta name="MobileOptimized" content="320">
   	 <meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=false" />
	<meta http-equiv="cleartype" content="on">
   	 <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/h/apple-touch-icon.png">
  	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/m/apple-touch-icon.png">
  	<link rel="apple-touch-icon-precomposed" href="img/l/apple-touch-icon-precomposed.png">
  	<link rel="shortcut icon" href="img/l/apple-touch-icon.png">
	<link href="pics/homescreen.gif" rel="apple-touch-icon" />
	<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
	<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
	<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
	<title>
	<?php 
		/* code start by rinkal for page title */
		if ($_SESSION['tpl_folder_name'] == 'defaultspanish'){
			$t = 'Anúnciate';
		}elseif($_SESSION['tpl_folder_name'] == 'defaultportuguese'){
			$t = 'Anuncie';
		}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
			$t = 'Adverteer';
		}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
			$t = 'Marketing';
		}elseif($_SESSION['tpl_folder_name'] == 'default'){
			$t = 'About';
		}
		
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == True) { 
			echo $site_name.' ~ '.$t;
		}
		else{
			echo $site_name.' : '.$t;
		}
	?>
	</title>
	<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
	</head>
	<body>
				<div id="main"><ul style="background:url('/partner/<?php echo $_SESSION['partner_folder_name']?>/images/twBg.png') repeat-y scroll 100% 100% !important;" class="mainList"><li><?php advertise_intro(); ?></li></ul></div>
				<!-- AddThis Button END -->
				</body>
</html>
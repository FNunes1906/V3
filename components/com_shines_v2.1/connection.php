<?php
require_once($_SERVER['DOCUMENT_ROOT']."/configuration.php");

// Set flag that this is a parent file
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$x = realpath(dirname(__FILE__)."/../../") ;
// SVN version
if (!file_exists($x.DS.'includes'.DS.'defines.php')){
	$x = realpath(dirname(__FILE__)."/../../../") ;
}

define( 'JPATH_BASE', $x );
require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

$jconfig = new JConfig();
define("DB_HOST",$jconfig->host);
define("DB_USER",$jconfig->user);
define("DB_PASSWORD",$jconfig->password);
define("DB_NAME",$jconfig->db);

$conn		= mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysql_error());
$db			= mysql_select_db(DB_NAME) or die(mysql_error());
$rec		= mysql_query("select * from `jos_pageglobal`");
$pageglobal	= mysql_fetch_array($rec);

if(isset($pagejevent['params']) && $pagejevent['params'] != ''){
	$gmapkeys				= explode('googlemapskey=',$pagejevent['params']);
	$gmapkeys1				= explode("\n",$gmapkeys[1]);
	$googgle_map_api_keys	= $gmapkeys1[0];
}
$site_name 				= $pageglobal['site_name'];
$beach 					= $pageglobal['beach'];
$email 					= $pageglobal['email'];
$location_code			= $pageglobal['location_code'];
$dunit					= $pageglobal['distance_unit'];
$timezone 				= $pageglobal['time_zone'];
$time_format			= $pageglobal['time_format'];
$date_format 			= $pageglobal['date_format'];
$var->googgle_analytics	= $pageglobal['googgle_map_api_keys'];
?>
<?php
/* Code for Joomla menu Begin */
global $topmenu;
global $leftmenu;
global $footermenu;
global $bottommenu1;
global $bottommenu2;

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__));   // should point to joomla root
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
/* Code for Joomla menu End */

/* Assign session varialbe to menu Begin */

jimport( 'joomla.application.module.helper' );

$moduletop = JModuleHelper::getModules('twtopmenu');
$topmenu = JModuleHelper::renderModule($moduletop[0]);
 
$moduleleft = JModuleHelper::getModules('twleftmenu');
$leftmenu = JModuleHelper::renderModule($moduleleft[0]);

$modulefooter = JModuleHelper::getModules('twfootermenu');
$footermenu = JModuleHelper::renderModule($modulefooter[0]);

$modulebottom1 = JModuleHelper::getModules('twbottommenu1');
$bottommenu1 = JModuleHelper::renderModule($modulebottom1[0]);

$modulebottom2 = JModuleHelper::getModules('twbottommenu2');
$bottommenu2 = JModuleHelper::renderModule($modulebottom2[0]);

/* Assign session varialbe to menu End */
?>
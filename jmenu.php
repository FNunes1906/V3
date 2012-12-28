<?php
/* Code for Joomla menu Begin */
global $topMenu;
global $footermenu;
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
$topMenu = JModuleHelper::renderModule($moduletop[0]);

$modulefooter = JModuleHelper::getModules('twfootermenu');
$footermenu = JModuleHelper::renderModule($modulefooter[0]);

/* Assign session varialbe to menu End */
?>
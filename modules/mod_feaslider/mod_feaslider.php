<?php
ini_set("display_errors",0);
/**
* @version		$Id: mod_feaslider.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access

defined('_JEXEC') or die('Restricted access');

$conn			= mysql_connect("localhost",$_SESSION['c_db_user'],$_SESSION['c_db_password']) or die(mysql_error());
$db				= mysql_select_db($_SESSION['c_db_name']) or die(mysql_error());
$rec			= mysql_query("select time_zone from `jos_pageglobal`");
$pageglobal 	= mysql_fetch_array($rec); 
$timezone 	= $pageglobal['time_zone'];

$timeZoneArray 	= explode(':',$timezone);
$totalHours 	= date("H") + $timeZoneArray[0];
$totalMinutes = date("i") + $timeZoneArray[1];
$totalSeconds = date("s") + $timeZoneArray[2];

if (isset($_REQUEST['d']) && $_REQUEST['d']=="")
$today=date('d', mktime($totalHours, $totalMinutes, $totalSeconds));
else
$today= isset($_REQUEST['d']);
if (isset($_REQUEST['m']) && $_REQUEST['m']=="")
$tomonth=date('m',mktime($totalHours, $totalMinutes, $totalSeconds));
else
$tomonth= isset($_REQUEST['m']);
if (isset($_REQUEST['Y']) && $_REQUEST['Y']=="")
$toyear=date('Y',mktime($totalHours, $totalMinutes, $totalSeconds));
else
$toyear= isset($_REQUEST['Y']);

//#DD#
if(isset($_REQUEST['eventdate'])){
	$_REQUEST['eventdate'] = trim($_REQUEST['eventdate']);
}

if(!empty($_REQUEST['eventdate'])){
    $today = date('d',strtotime($_REQUEST['eventdate']));
    $tomonth = date('m',strtotime($_REQUEST['eventdate']));
    $toyear = date('Y',strtotime($_REQUEST['eventdate']));
}


// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$FeaturedSlider = modFeaEventHelper::getFeaturedSlider($toyear,$tomonth,$today);

	// Title link
	/*global $Itemid;
	$rowlink = $event->viewDetailLink($event->yup(),$event->mup(),$event->dup(),false);
	$rowlink = JRoute::_($rowlink.$view->datamodel->getCatidsOutLink());
	ob_start()*/;

require(JModuleHelper::getLayoutPath('mod_feaslider'));
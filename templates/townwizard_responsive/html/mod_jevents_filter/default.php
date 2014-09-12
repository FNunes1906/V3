<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: mod_jevents_filter.php 1057 2008-04-21 18:06:33Z geraint $
 * @package     JEvents
 * @subpackage  Module JEvents Filter
 * @copyright   Copyright (C) 2008 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.gwesystems.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$datamodel	= new JEventsDataModel();
// find appropriate Itemid and setup catids for datamodel
global $Itemid, $option;
if ($option==JEV_COM_COMPONENT){
	$myItemid = $Itemid;
}
else {
	$myItemid = $params->get("target_itemid",0);
}
if ($myItemid ==0){
	$myItemid = $datamodel->setupModuleCatids($params);
}

$form_link = "";
if ($myItemid>0){
	$menu = & JSite::getMenu();
	$menuitem = $menu->getItem($myItemid);
	$form_link = $menuitem->link. "&Itemid=".$myItemid;
}

//$myItemid = JEVHelper::getItemid();
$datamodel->setupComponentCatids();

list($year,$month,$day) = JEVHelper::getYMD();
$evid = JRequest::getVar("evid",false);
$jevtype = JRequest::getVar("jevtype",false);
// FORM for filter submission
$tmpCatids = trim($datamodel->catidsOut);

if ($form_link==""){
	$form_link = 'index.php?option=' . JEV_COM_COMPONENT . '&task=' . JRequest::getVar("jevtask", "cat.listevents"). "&Itemid=".$myItemid;
}

$form_link = JRoute::_($form_link
. ($evid ? '&evid=' . $evid : '')
. ($jevtype ? '&jevtype=' . $jevtype : '')
. ($year ? '&year=' . $year : '')
. ($month ? '&month=' . $month : '')
. ($day ? '&day=' . $day : '')
. ((strlen($tmpCatids)>0)?"&catids=".$tmpCatids:"")
,false);

$filters = $jevhelper->getFilters();
$filterHTML = $filters->getFilterHTML();

require(JModuleHelper::getLayoutPath('mod_jevents_filter', 'default_layout'));

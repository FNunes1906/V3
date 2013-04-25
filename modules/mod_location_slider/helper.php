<?php
/**
* @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
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

//require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modLocationHelper
{

	function getLocationSlider($cate_id){
	$db		  =& JFactory::getDBO();
	$sessions = null;
	$LocationSlider   = array();
	
	$query_location="SELECT loc.description,loc.alias,loc.loc_id,loc.title,loc.image, cate.title as category, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND cate.parent_id = ".$cate_id." AND loc.published = 1 AND loc.loc_id = cf.target_id AND cf.value = 1 ORDER BY `cate`.`title` ASC";
	//echo $query_featuredeve;
	$db->setQuery($query_location);
	if ($db->getErrorNum()) {
		JError::raiseWarning( 500, $db->stderr() );
	}
	$LocationSlider = $db->loadObjectList();
	return $LocationSlider;
	}
}

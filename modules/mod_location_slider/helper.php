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

class modLocationHelper{

	function getLocationSlider(){
		
		global $Itemid;
		$db			=	& JFactory::getDBO();
		$sessions 		=	null;
		$LocSlider		= 	array();
		
		//Getmenu parameter to retrive category list
		$menu 		= 	&JSite::getMenu();
		$temp 		= 	$menu->getItem($Itemid);
		$iParams 		= 	new JParameter($temp->params);
		$categories 	= 	$iParams->get('catfilter');
		
		$query_location = 'SELECT loc.loc_id, loc.title, loc.alias, loc.image, loc.description, loc.created, cf.value FROM  jos_jev_locations as loc, jos_jev_customfields3 as cf WHERE (';
		if (is_array($categories))
		{
			for($p = 0; $p < count($categories) ; $p++)
			{	
				$query_location .= '  FIND_IN_SET('.$categories[$p].',loc.catid_list )';
				if($p < count($categories)-1 ){
					$query_location .=' or';
				}else{
					$query_location .=' )';
				}
			}
		}else{
			$query_location .= '  FIND_IN_SET('.$categories.',loc.catid_list ))';
		}
		$query_location .= ' AND loc.loc_id = cf.target_id AND cf.value = 1 AND loc.published = 1 ORDER BY loc.created DESC';
		//$query_location = "SELECT loc.loc_id, loc.title, loc.alias, loc.image, loc.description, loc.created, cate.title as category, cate.id as cateid, cf.value FROM  jos_jev_locations as loc, jos_categories as cate, jos_jev_customfields3 as cf WHERE loc.loccat = cate.id AND loc.published = 1 AND loc.loc_id = cf.target_id AND cf.value = 1 AND loc.loccat IN (".$modifycat.") ORDER BY cateid ASC";

		$db->setQuery($query_location);
		if ($db->getErrorNum()) {
			JError::raiseWarning( 500, $db->stderr() );
		}
		
		$LocSlider = $db->loadObjectList();
		return $LocSlider;
		
	}
}

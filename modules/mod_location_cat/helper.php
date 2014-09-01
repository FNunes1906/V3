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

class modLocationCatHelper
{
	function getLocationCat($cate_id ){
	$db		  =& JFactory::getDBO();
	$sessions = null;
	$result   = array();
	$compparams = JComponentHelper::getParams("com_jevlocations");
	$catfilters_arr = $compparams->get("catfilter", "");
	
	
	//$query_locationcat="SELECT COUNT(loc.catid) as count, cate.alias, cate.id, cate.title as category FROM  jos_jev_locations as loc, jos_categories as cate WHERE loc.loccat = cate.id AND loc.published = 1 AND cate.published = 1 AND cate.parent_id = ".$cate_id." GROUP BY category ORDER BY `cate`.`title` ASC";
	
	$query_locationcat = 'SELECT COUNT( loc.loc_id ) AS count,cate.id,cate.title as category FROM jos_jev_locations AS loc,jos_categories as cate where (';
	if (is_array($catfilters_arr))
	{
		for($b = 0; $b < count($catfilters_arr) ; $b++)
		{	
			$query_locationcat .= '  (FIND_IN_SET('.$catfilters_arr[$b].',loc.catid_list ) and cate.id='.$catfilters_arr[$b];
			if($b < count($catfilters_arr)-1 ){
				$query_locationcat .=' ) or';
			}else{
				$query_locationcat .=' ))';
			}
		}
	}else{
		$query_locationcat .= '  FIND_IN_SET('.$catfilters_arr.',loc.catid_list ) and cate.id='.$catfilters_arr.')';
	}
	$query_locationcat .= ' and loc.published = 1 AND cate.published = 1 GROUP BY cate.title ORDER BY `cate`.`title` ASC';
	//echo $query_locationcat;
	
	$db->setQuery($query_locationcat);
	if ($db->getErrorNum()) {
			JError::raiseWarning( 500, $db->stderr() );
		}
	$result = $db->loadObjectList();
	return $result;
	}
}

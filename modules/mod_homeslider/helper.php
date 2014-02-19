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

class modHomeEventHelper{
	
	function getHomedSlider($toyear,$tomonth,$today){
	
	$dateformat = mysql_query("SELECT date_format FROM jos_pageglobal LIMIT 1");
 	$format = mysql_fetch_assoc($dateformat);
	
	$LD = Date('d', strtotime("+30 days"));
	$LM = Date('m', strtotime("+30 days"));
	$LY = Date('y', strtotime("+30 days"));
	
	$cat_id = "34";
	
	$res = mysql_query("SELECT c.id , pc.title AS parenttitle FROM jos_categories AS c LEFT JOIN jos_categories AS pc ON c.parent_id = pc.id LEFT JOIN jos_categories AS mc ON pc.parent_id = mc.id LEFT JOIN jos_categories AS gpc ON mc.parent_id = gpc.id WHERE c.section = 'com_jevents' AND (c.id =".$cat_id." OR pc.id =".$cat_id." OR mc.id =".$cat_id." OR gpc.id =".$cat_id.") AND c.published=1") or die(mysql_error());
	
	while($catres = mysql_fetch_array($res)){
		
		$modifycat[] = $catres['id'];
		if(count($modifycat) > 1){
			$modifycatf =	implode(',',$modifycat);
		}else{
			$modifycatf = $modifycat[0];
		}
	}
	
	
	$query_homeeve="SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%Y') as Eyear,DATE_FORMAT(rpt.startrepeat,'%m') as Emonth,DATE_FORMAT(rpt.startrepeat,'%d') as EDate,DATE_FORMAT(rpt.startrepeat,'".$format["date_format"]."') as Date,DATE_FORMAT(rpt.startrepeat,'%h:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%h:%i%p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid IN (".$modifycatf.") AND ev.catid = cat.id AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND cf.value = 1 AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00' AND rpt.startrepeat <= '".$LY."-".$LM."-".$LD." 23:59:59' GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";
	//echo $query_homeeve;
	$HomeSlider = mysql_query($query_homeeve);
	return $HomeSlider;
	}
}

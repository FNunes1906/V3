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

class modFeaEventHelper{
	
	function getFeaturedSlider($toyear,$tomonth,$today){
		
		//Getmenu parameter to retrive category list
		global $current_cat;
		$dateformat = mysql_query("SELECT date_format FROM jos_pageglobal LIMIT 1");
	 	$format = mysql_fetch_assoc($dateformat);	
		
		$params =& JComponentHelper::getParams( JEV_COM_COMPONENT );
		 if ($params->get("relative","rel")=="strtotime"){
			
			$value = $params->get("strstart","");
			$value = new JDate($value);
			$startdate = $value->toFormat("%Y-%m-%d");
			
			$date = DateTime::createFromFormat("Y-m-d", $startdate);
			$WEND_SD = $date->format("d");
			$WEND_SM = $date->format("m");
			$WEND_SY = $date->format("Y");

			$value2 = $params->get("strend","");
			$value2 = new JDate($value2);
			$enddate = $value2->toFormat("%Y-%m-%d");
			
			$date2 = DateTime::createFromFormat("Y-m-d", $enddate);
			$WEND_ED = $date2->format("d");
			$WEND_EM = $date2->format("m");
			$WEND_EY = $date2->format("Y");
		}
		
		$LD = Date('d', strtotime("+30 days"));
		$LM = Date('m', strtotime("+30 days"));
		$LY = Date('Y', strtotime("+30 days"));
			
		$query_featuredeve.= "SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%Y') as Eyear,DATE_FORMAT(rpt.startrepeat,'%m') as Emonth,DATE_FORMAT(rpt.startrepeat,'%d') as EDate,DATE_FORMAT(rpt.startrepeat,'".$format["date_format"]."') as Date,DATE_FORMAT(rpt.startrepeat,'%h:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%h:%i%p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid = cat.id ";
			
			
		if($current_cat != ''){
			$query_featuredeve.= "AND (cat.id=".$current_cat." OR cat.parent_id=".$current_cat.") ";
		}
		
		$query_featuredeve.= "AND cat.published = 1 AND cat.section = 'com_jevents'  AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND cf.value = 1 ";
			
		if(isset($startdate) != '' && isset($enddate) != ''){		
			$query_featuredeve.= "AND rpt.endrepeat >= '".$WEND_SY."-".$WEND_SM."-".$WEND_SD." 00:00:00' AND rpt.startrepeat <= '".$WEND_EY."-".$WEND_EM."-".$WEND_ED." 23:59:59' ";
		}else{
			$query_featuredeve.= "AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00' AND rpt.startrepeat <= '".$LY."-".$LM."-".$LD." 23:59:59' ";
		}
		
		$query_featuredeve.= "GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";
			
		//echo $query_featuredeve;
		$FeaturedSlider = mysql_query($query_featuredeve);
		return $FeaturedSlider;
	}
}

<?php
/**
 * @version		$Id: pagination.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 * 	Input variable $list is an array with offsets:
 * 		$list[limit]		: int
 * 		$list[limitstart]	: int
 * 		$list[total]		: int
 * 		$list[limitfield]	: string
 * 		$list[pagescounter]	: string
 * 		$list[pageslinks]	: string
 *
 * pagination_list_render
 * 	Input variable $list is an array with offsets:
 * 		$list[all]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[start]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[previous]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[next]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[end]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[pages]
 * 			[{PAGE}][data]		: string
 * 			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * pagination_item_inactive
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<del class=\"container\"><div class=\"pagination\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"limit\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div></del>";

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = null;

	if ($list['start']['active']) {
		$html .= "<div class=\"button2-right\"><div class=\"start\">".$list['start']['data']."</div></div>";
	} else {
		$html .= "<div class=\"button2-right off\"><div class=\"start\">".$list['start']['data']."</div></div>";
	}
	if ($list['previous']['active']) {
		$html .= "<div class=\"button2-right\"><div class=\"prev\">".$list['previous']['data']."</div></div>";
	} else {
		$html .= "<div class=\"button2-right off\"><div class=\"prev\">".$list['previous']['data']."</div></div>";
	}

	$html .= "\n<div class=\"button2-left\"><div class=\"page\">";
	foreach( $list['pages'] as $page ) {
		$html .= $page['data'];
	}
	$html .= "\n</div></div>";

	if ($list['next']['active']) {
		$html .= "<div class=\"button2-left\"><div class=\"next\">".$list['next']['data']."</div></div>";
	} else {
		$html .= "<div class=\"button2-left off\"><div class=\"next\">".$list['next']['data']."</div></div>";
	}
	if ($list['end']['active']) {
		$html .= "<div class=\"button2-left\"><div class=\"end\">".$list['end']['data']."</div></div>";
	} else {
		$html .= "<div class=\"button2-left off\"><div class=\"end\">".$list['end']['data']."</div></div>";
	}

	return $html;
}

function pagination_item_active(&$item)
{
	if($item->base>0)
		return "<a href=\"#\" title=\"".$item->text."\" onclick=\"javascript: document.adminForm.limitstart.value=".$item->base."; submitform();return false;\">".$item->text."</a>";
	else
		return "<a href=\"#\" title=\"".$item->text."\" onclick=\"javascript: document.adminForm.limitstart.value=0; submitform();return false;\">".$item->text."</a>";
}

function pagination_item_inactive(&$item)
{
	return "<span>".$item->text."</span>";
}

function get_paginate_links($total_rows,$entries_per_page,$current_page,$link_to)
{
	$total_page=ceil($total_rows/$entries_per_page);
	$str_page=(strpos($link_to,"?")===false)? "?page" : "&amp;page";
	$paginate_links='<div id="menu">';
		if($current_page==1) {
			$paginate_links.="<div class=\"pre\" style='margin:0; padding:0; display:inline; list-style-type:none; width:24px;text-decoration:none;color: #379E1E;'></div>&nbsp;&nbsp;&nbsp;";
		} else {
			$paginate_links.="<div class=\"pre\" style='margin:0; padding:0; display:inline; list-style-type:none; width:24px;text-decoration:none;'><a id=\"calPrev\" href=\"$link_to$str_page=".($current_page-1)."\">Back</a></div>&nbsp;&nbsp;&nbsp;";
			
		}
		if($current_page==$total_page) {
			$paginate_links .="<div class=\"Next\" style='margin:0; padding:0; display:inline; list-style-type:none; width:24px;text-decoration:none;'></div>&nbsp;&nbsp;&nbsp;";
		} else {
			$paginate_links .="<div class=\"Next\" style='margin:0; padding:0; display:inline; list-style-type:none; width:24px;text-decoration:none;'><a id=\"calNext\"  href=\"$link_to$str_page=".($current_page+1)."\">Next</a></div>&nbsp;&nbsp;&nbsp;";
			
		}
	$paginate_links .='</div>';
	echo $paginate_links;
}
?>
<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: range.php 1414 2009-04-14 18:22:45Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

defined( 'JPATH_BASE' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

class RangeController extends JController   {

	function __construct($config = array())
	{
		parent::__construct($config);
		// TODO get this from config
		$this->registerDefaultTask( 'listevents' );
//		$this->registerTask( 'show',  'showContent' );

		// Load abstract "view" class
		$cfg = & JEVConfig::getInstance();
		$theme = JEV_CommonFunctions::getJEventsViewName();
		JLoader::register('JEvents'.ucfirst($theme).'View',JEV_VIEWS."/$theme/abstract/abstract.php");
	}

	function listevents() {

		$pagetitle= $_SERVER['REQUEST_URI'];
		$urlpart = explode("/",$pagetitle);
		if(isset($urlpart[2]) != ""){
			$document = &JFactory::getDocument();
			$document->setTitle(ucfirst ($urlpart[1]).' | '.ucfirst ( $urlpart[2]));
		}
		list($year,$month,$day) = JEVHelper::getYMD();

		// Joomla unhelpfully switched limitstart to start when sef is enabled!  includes/router.php line 390
		$limitstart = intval( JRequest::getVar( 	'start', 	 JRequest::getVar( 	'limitstart', 	0 ) ) );
		global $mainframe;
		$params =& JComponentHelper::getParams( JEV_COM_COMPONENT );
		$limit = intval($mainframe->getUserStateFromRequest( 'jevlistlimit','limit', $params->getValue("com_calEventListRowsPpg",15)));

		$Itemid	= JEVHelper::getItemid();

		// get the view

		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		
		$cfg = & JEVConfig::getInstance();
		$theme = JEV_CommonFunctions::getJEventsViewName();

		$view = "range";
		$this->addViewPath($this->_basePath.DS."views".DS.$theme);
		$this->view = & $this->getView($view,$viewType, $theme, 
			array( 'base_path'=>$this->_basePath, 
				"template_path"=>$this->_basePath.DS."views".DS.$theme.DS.$view.DS.'tmpl',
				"name"=>$theme.DS.$view));

		// Set the layout
		$this->view->setLayout('listevents');

		$this->view->assign("Itemid",$Itemid);
		$this->view->assign("limitstart",$limitstart);
		$this->view->assign("limit",$limit);
		$this->view->assign("month",$month);
		$this->view->assign("day",$day);
		$this->view->assign("year",$year);
		$this->view->assign("task",$this->_task);
		
		// View caching logic -- simple... are we logged in?
		$cfg	 = & JEVConfig::getInstance();
		$useCache = intval($cfg->get('com_cache', 0));
		$user = &JFactory::getUser();
		if ($user->get('id') || !$useCache) {
			$this->view->display();
		} else {
			$cache =& JFactory::getCache(JEV_COM_COMPONENT, 'view');
			$cache->get($this->view, 'display');
		}
	}
	
	
}


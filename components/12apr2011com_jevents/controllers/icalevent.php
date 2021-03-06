<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: icalevent.php 1756 2010-05-05 09:19:47Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

defined( 'JPATH_BASE' ) or die( 'Direct Access to this location is not allowed.' );

include_once(JEV_ADMINPATH."/controllers/icalevent.php");

class ICalEventController extends AdminIcaleventController   {

	function __construct($config = array())
	{
		parent::__construct($config);
		// TODO get this from config
		$this->registerDefaultTask( 'detail' );

		// Load abstract "view" class
		$cfg = & JEVConfig::getInstance();
		$theme = JEV_CommonFunctions::getJEventsViewName();
		JLoader::register('JEvents'.ucfirst($theme).'View',JEV_VIEWS."/$theme/abstract/abstract.php");
	}

	function detail() {

		// Do we have to be logged in to see this event
		$user = &JFactory::getUser();
		if (JRequest::getInt("login",0) && $user->id==0)
		{			
			$uri = JURI::getInstance();
			$link = $uri->toString();
			$link = 'index.php?option=com_user&view=login&return='.base64_encode($link);
			$link = JRoute::_($link);
			$this->setRedirect($link,JText::_('JEV LOGIN TO VIEW EVENT'));
			return;
		}
				
		$evid =JRequest::getInt("rp_id",0);
		if ($evid==0){
			$evid =JRequest::getInt("evid",0);
			// if cancelling from save of copy and edit use the old event id
			if ($evid==0){
				$evid =JRequest::getInt("old_evid",0);
			}
			// In this case I do not have a repeat id so I find the first one that matches
			$datamodel = new JEventsDataModel("JEventsAdminDBModel");
			$vevent = $datamodel->queryModel->getVEventById( $evid);
			$event = new jIcalEventDB($vevent);
			$repeat = $event->getFirstRepeat();
			if ($repeat){
				$evid=$repeat->rp_id();
			}			
		}
		$pop = intval(JRequest::getVar( 'pop', 0 ));
		$uid = urldecode((JRequest::getVar( 'uid', "" )));
		list($year,$month,$day) = JEVHelper::getYMD();
		$Itemid	= JEVHelper::getItemid();

		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		
		$cfg = & JEVConfig::getInstance();
		$theme = JEV_CommonFunctions::getJEventsViewName();

		$view = "icalevent";
		$this->addViewPath($this->_basePath.DS."views".DS.$theme);
		$this->view = & $this->getView($view,$viewType, $theme, 
			array( 'base_path'=>$this->_basePath, 
				"template_path"=>$this->_basePath.DS."views".DS.$theme.DS.$view.DS.'tmpl',
				"name"=>$theme.DS.$view));

		// Set the layout
		$this->view->setLayout("detail");

		$this->view->assign("Itemid",$Itemid);
		$this->view->assign("month",$month);
		$this->view->assign("day",$day);
		$this->view->assign("year",$year);
		$this->view->assign("task",$this->_task);
		$this->view->assign("pop",$pop);
		$this->view->assign("evid",$evid);
		$this->view->assign("jevtype","icaldb");
		$this->view->assign("uid",$uid);
		
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
	
	function edit(){
		// Must be at least an event creator to edit or create events
		$is_event_editor = JEVHelper::isEventCreator();
		if (!$is_event_editor){
			$user = &JFactory::getUser();
			if ($user->id){
				$this->setRedirect(JURI::root(),JText::_('JEV_NOTAUTH_CREATE_EVENT'));
				//JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
			}
			else {
                $uri = JURI::getInstance();
                $link = $uri->toString();
                $this->setRedirect(JRoute::_("index.php?option=com_user&view=login&return=".base64_encode($link)),JText::_('JEV_NOTAUTH_CREATE_EVENT'));
			}
			return;
		}
				
		// attach data model component catids at this point so it will affect the choice of calendars too
		$this->dataModel->setupComponentCatids();

		parent::edit();
	}
		
	function editcopy(){
		// Must be at least an event creator to edit or create events
		$is_event_editor = JEVHelper::isEventCreator();
		if (!$is_event_editor){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}
		$this->editCopy = true;

		// attach data model component catids at this point so it will affect the choice of calendars too
		$this->dataModel->setupComponentCatids();
		
		parent::edit();
	}


	function save(){
		// Must be at least an event creator to save events
		$is_event_editor = JEVHelper::isEventCreator();
		if (!$is_event_editor){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}
		parent::save();
	}
	
	function apply(){
		// Must be at least an event creator to save events
		$is_event_editor = JEVHelper::isEventCreator();
		if (!$is_event_editor){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}
		parent::apply();
	}

	
		
}


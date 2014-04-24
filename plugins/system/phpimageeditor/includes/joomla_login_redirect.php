<?php 
    
	
	    /*
	    Copyright 2008, 2009, 2010, 2011 Patrik Hultgren
	    
	    YOUR PROJECT MUST ALSO BE OPEN SOURCE IN ORDER TO USE THIS VERSION OF PHP IMAGE EDITOR.
	    BUT YOU CAN USE PHP IMAGE EDITOR JOOMLA PRO IF YOUR CODE NOT IS OPEN SOURCE.
	    
	    This file is part of PHP Image Editor Joomla.
	
	    PHP Image Editor Joomla is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.
	
	    PHP Image Editor Joomla is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with PHP Image Editor Joomla. If not, see <http://www.gnu.org/licenses/>.
	    */
	

    define( '_JEXEC', 1 );
	define('DS', DIRECTORY_SEPARATOR);
	define('JPATH_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..");
	require_once( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	
	$is_admin = (isset($_GET['isadmin']) && $_GET['isadmin'] == 'true');
	
	$mainframe =& JFactory::getApplication($is_admin ? 'administrator' : 'site');	
	$mainframe->initialise();
	$mainframe->route();
	
	include_once '../../../plugins/system/phpimageeditor/lite/shared/includes/acl_functions.php';

	$user =& JFactory::getUser();

	if (!PIE_Access($user))
		header('Location: ../../../'.($is_admin ? 'administrator/' : '').'index.php');
?>
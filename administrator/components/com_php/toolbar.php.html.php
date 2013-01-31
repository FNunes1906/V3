<?php

/**
 * @author gabe@fijiwebdesign.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.fijiwebdesign.com/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Toolbar HTML
*/
class admin_php_toolbar_html {
	
	function index() {
	  	JToolBarHelper::title(  JText::_( 'PHP Pages - <small>Manage Pages</small>' ) );
		JToolBarHelper::addNew('new');
		JToolBarHelper::editList('edit', 'Edit');
		JToolBarHelper::deleteList('Deleting this file will remove it completely. Continue?', 'delete', 'Remove');
		JToolBarHelper::spacer();
	}
	
	function edit() {
	  	JToolBarHelper::title(  JText::_( 'PHP Pages - <small>Edit File</small>' ) );
		JToolBarHelper::save('apply', 'apply', 'Apply');
		JToolBarHelper::save('save', 'save', 'Save');
		JToolBarHelper::spacer();
	}
	
	function add() {
	  	JToolBarHelper::title(  JText::_( 'PHP Pages - <small>Add File</small>' ) );
		JToolBarHelper::save('', 'save', 'Save');
		JToolBarHelper::spacer();
	}

	function about() {
    	JToolBarHelper::title(  JText::_( 'PHP Pages - <small>About</small>' ) );
	}
	
	function help() {
    	JToolBarHelper::title(  JText::_( 'PHP Pages - <small>Help</small>' ) );
	}
}




?>

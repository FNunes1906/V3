<?php

/**
 * @author gabe@fijiwebdesign.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.fijiwebdesign.com/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

// index is default if no task
$task = JRequest::getVar('task', 'index');

switch($task) {
	case 'index':
	admin_php_toolbar_html::index();
	break;
	case 'edit':
	admin_php_toolbar_html::edit();
	break;
	case 'add':
	case 'new':
	admin_php_toolbar_html::add();
	break;
	case 'del':
	admin_php_toolbar_html::del();
	break;
	case 'help':
	admin_php_toolbar_html::help();
	break;
	case 'about':
	admin_php_toolbar_html::about();
	break;
}

?>
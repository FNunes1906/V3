<?php

/**
 * PHP Component
 * @author gabe@fijiwebdesign.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.fijiwebdesign.com/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


// load needed HTTP variables
$task = JRequest::getVar('task', 'index');
$act = JRequest::getVar('act', $task );
$Itemid = intval(JRequest::getVar('Itemid', 0 ));

// load required files
require_once( $mainframe->getPath( 'front_html' ) );

// parameters
$menu =& JSite::getMenu();
$item = $menu->getActive();
$Params =& $menu->getParams($item->id);

// parameters
$header = $Params->get('page_header', '');
$title = $Params->get('page_title', '');
$show_title = $Params->get('show_page_title', false);
$show_header = $Params->get('show_page_header', false);
$back_button = $Params->get('back_button', -1);
$show_copy = $Params->get('show_copy', false);

$filename = $Params->get('file', '');
$path = JPATH_ROOT.'/components/com_php/files/'.$filename;

// title
if ($show_title) {
	$mainframe->setPageTitle($title);
}
// header
if ($show_header) {
	echo '<h1 class="componentheading">'.$header.'</h1>';
}

// evaluate the PHP
echo '<div class="php_page">';
if (is_file($path)) {
	include($path);
} else {
	echo '<span class="note">Please choose a File</span>';
}
echo '</div>';

// back button
if ($back_button == '1') {
	echo '<button class="button" onclick="history.go(-1);">Back</button>';
} elseif ($back_button == '-1' && $mainframe->getCfg('back_button')) {
	echo '<button class="button" onclick="history.go(-1);">Back</button>';
}

if ($show_copy) {
	echo '<div class="attribution smallgrey" style="text-align:center;width:100%;">Joomla PHP Component &copy <a href="http://www.fijiwebdesign.com/">Fiji Web Design</a></div>';
}

?>
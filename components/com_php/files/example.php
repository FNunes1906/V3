<?php

/**
* This is an Example php page created with Joomla PHP Component for Joomla 1.5
* @author gabe@fijiwebdesign.com
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// retrieve user instance
$my =& JFactory::getUser();

// check if user is logged in
if ($my->id) {

  echo 'Hello '.$my->username;

} else {

  echo 'Hello Guest';

}

?>
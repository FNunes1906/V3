<?php

defined('_JEXEC') or die();

$module_name = JRequest::getVar('module',null);
$module_id = JRequest::getVar('moduleid',null);

$db		=& JFactory::getDBO();
if (isset($module_name)) {
    $query = "SELECT DISTINCT * from #__modules where title='".$module_name."'";
} else {
    $query = "SELECT DISTINCT * from #__modules where id=".$module_id;
}

$db->setQuery( $query );
$result = $db->loadObject();


if ($result) {

    $document	= &JFactory::getDocument();
    $renderer	= $document->loadRenderer( 'module' );
    $options	 = array( 'style' => "raw" );
    $module	 = JModuleHelper::getModule( $result->module );
    $module->params = $result->params;

    $output = $renderer->render( $module, $options );

    echo $output;
    
}


?>
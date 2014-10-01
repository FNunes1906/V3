<?php
$app = JFactory::getApplication();
/* if($app->getTemplate() == "townwizard_responsive"){ */
 
 $templateDir = JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS.'events_submit.php';
 include($templateDir);
/* }else{
 include(JPATH_BASE .DS.'events_submit.php');
} */
?>
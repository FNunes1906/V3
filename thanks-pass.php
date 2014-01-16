<?php
// no direct access
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php');

define("TOWNWIZARD_TMPL_PATH", "http://".$_SERVER['HTTP_HOST']."/templates/townwizard");
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
_init();

?>
<!DOCTYPE html>
<html>
<head>
<style>
	body{
		margin: 0px;
	}
	h2{
		font-family: 'AllerBold',Arial,sans-serif;
		text-align:center;
		 font-size: 16px;
	}
</style>
</head>

<body>
<div id="TopBar" style="background:url('<?php echo TOWNWIZARD_TMPL_PATH ?>/images/header/whitezig_zag.png') repeat-x scroll left 30px <?php echo $var->Header_color; ?>;height: 36px;"></div>
<h2><?php echo JText::_('PASSWORD_RESET_SUCCESS'); ?></h2>

</body>
</html>
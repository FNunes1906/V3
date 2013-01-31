<?php

/**
 * @author bucabay@gmail.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @package phps
 * @name php
 */

defined('_VALID_MOS') or die('Direct Access to this php is not allowed.');

function com_install() {
	
	global $database;
	
	// modify menu images
	
	//$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_php&act=config'");
	//$database->query();


?>
<!-- begin Fiji Web Design Component Credits //-->
<div style="text-align:center;">
  <table width="100%" border="0">
    <tr>
      <td><img src="components/com_php/images/phplogo.jpg"></td>
      <td>
        <div style="font-weight:bold;">PHP - A Fiji Web Design Component!</div>
        <div class="small">Copyright &copy; 2008 <a href="http://fijiwebdesign.com">Fiji Web Design</a>. All Rights Reserved.</div>
        <div class="small">This component is copyrighted software. Distribution is prohibited.</div>
      </td>
    </tr>
    <tr>
      <td background="#F0F0F0" colspan="2">
        <p style="color:green;font-weight:bold;">Installation completed successfully.</p>
      </td>
    </tr>
  </table>
</div>
<!-- end Fiji Web Design Component Credits //-->
<?php
}
?>

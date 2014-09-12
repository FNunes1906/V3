<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: mod_jevents_filter.php 1057 2008-04-21 18:06:33Z geraint $
 * @package     JEvents
 * @subpackage  Module JEvents Filter
 * @copyright   Copyright (C) 2008 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.gwesystems.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
if (count($filterHTML)>0){
	JHTML::script("mod_jevents_filter.js","modules/mod_jevents_filter/",true);
	?>
	<form action="<?php echo $form_link;?>" id="jeventspost" name="jeventspost" method="post">
		<div>
			<?php	
				foreach ($filterHTML as $filter){
					if (!isset($filter["title"])) continue;
					echo $filter["html"];
				}
				echo '<input class="submit fr" type="submit" value="" />';
			?>
		</div>
	</form>
	<?php 
}
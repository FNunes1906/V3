<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
global $Itemid;
?>
<script type="text/javascript">
function redirecturl(val)
{
	url="index.php?option=com_jevlocations&task=locations.locations&Itemid=<?php echo $Itemid?>&searchcat="+val;
	window.location=url;
}
</script>
<form action="index.php" method="post">
	<div class="search<?php echo $params->get('moduleclass_sfx') ?>">
		<?php
		    $output = '<input name="searchword" id="mod_search_searchword" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="fl locsearch inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
			$db =& JFactory::getDBO();
			$recsubsql="select * from jos_categories where section='com_jevlocations2' and published=1 ORDER BY title ASC";
			$db->setQuery($recsubsql);
			$rows=$db->query();
			?>
			<select id="cat_drop" name="searchcat" onChange="redirecturl(this.value);" >
				<option value="0">Select a Category	</option>
				<option value="0">All</option>
				<?php while($rowsub=mysql_fetch_array($rows))
				{
				?>
				
				<option value="<?php echo $rowsub['id'];?>" <?php if ($_REQUEST['searchcat']==$rowsub['id']) {?> selected="selected" <?php }?>>
					<?php echo $rowsub['title'];?>
				</option>
			<?php
				}
			?>
			</select>
			<?php
				if ($button) :
				    if ($imagebutton) :
				        $button = '<input type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$img.'" onclick="this.form.searchword.focus();"/>';
				    else :
				        $button = '<input type="submit" value="" class="fr submit button'.$moduleclass_sfx.'" onclick="this.form.searchword.focus();"/>';
				    endif;
				endif;

				switch ($button_pos) :
				    case 'top' :
					    $button = $button.'<br />';
					    $output = $button.$output;
					    break;

				    case 'bottom' :
					    $button = '<br />'.$button;
					    $output = $output.$button;
					    break;

				    case 'right' :
					    $output = $output.$button;
					    break;

				    case 'left' :
				    default :
					    $output = $button.$output;
					    break;
				endswitch;

				echo $output;
			?>
			
		
	</div>
	<input type="hidden" name="task"   value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
</form>
<?php defined('_JEXEC') or die('Restricted access');?>

<?php JHTML::_('behavior.tooltip'); 
	$compparams = JComponentHelper::getParams("com_jevlocations");
	$usecats = $compparams->get("usecats",0);

	$params =& JComponentHelper::getParams('com_media');
	$mediabase = JURI::root().$params->get('image_path', 'images/stories');
	// folder relative to media folder
	$locparams = JComponentHelper::getParams("com_jevlocations");
	$folder = "jevents/jevlocations";
	global $Itemid;
	
	$menu = JFactory::getApplication()->getMenu();
	$menuname = $menu->getActive()->name;
	$p_id = $menu->getActive();
	if (isset($p_id->id) && $p_id->parent){
		 $parent = $menu->getItem($menu->getActive()->parent)->name;
	}
	
	
	/* Fetching sitename from Page Global */
	$db =& JFactory::getDBO();
	$pageglobal = "select site_name from `jos_pageglobal`";
	$db->setQuery($pageglobal);
	$sn=$db->query();
	$site_name=mysql_fetch_row($sn);
	
?>
<h2 id="middleColumnHeader">
	<?php $heading = $menuname.' '; $heading .= isset($parent)?$parent.' ':''; $heading .= JText::_( 'IN' ).' '.$site_name[0]; echo $heading; ?>
</h2>
<form action="<?php echo JRoute::_("index.php?option=com_jevlocations&task=locations.locations&Itemid=$Itemid");?>" method="post" name="adminForm">

<?php if ($locparams->get("showfilters",1)) { ?>
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="jevsearch" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('jevsearch').value='';this.form.getElementById('filter_loccat').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php 
			echo $this->lists['loccat'];
			
		?>
		
	</td>
</tr>
</table>
<?php } ?>

<?php if(isset($_REQUEST['searchcat']) && $_REQUEST['searchcat']!='') {
	
		$ser= $_REQUEST['searchcat'];
		if($ser!='0'){
				$db =& JFactory::getDBO();
				$cat_res = "SELECT c . * , pc.title AS parenttitle FROM jos_categories AS c LEFT JOIN jos_categories AS pc ON c.parent_id = pc.id LEFT JOIN jos_categories AS mc ON pc.parent_id = mc.id LEFT JOIN jos_categories AS gpc ON mc.parent_id = gpc.id WHERE c.section = 'com_jevlocations2' AND (c.id =".$ser." OR pc.id =".$ser." OR mc.id =".$ser." OR gpc.id =".$ser.") AND c.published=1 ORDER BY c.title ASC";
				$db->setQuery($cat_res);
				$rows=$db->query();
				while($idsrow=mysql_fetch_assoc($rows)){
						$cat_ids[] = $idsrow['id'];
				}
				
				$sql = 'SELECT loc.*,loc.image as locimg FROM jos_jev_locations AS loc where (';
				for($a = 0; $a < count($cat_ids) ; $a++)
				{	
					$sql .= '  FIND_IN_SET('.$cat_ids[$a].',loc.catid_list )';
					if($a < count($cat_ids)-1 ){
						$sql .=' or';
					}else{
						$sql .=' )';
					}
				}
				$sql .= ' and loc.published = 1 order by loc.title,loc.ordering';
				
		}elseif($ser == '0'){
				$compparams = JComponentHelper::getParams("com_jevlocations");
				$catfilters_arr = $compparams->get("catfilter", "");
				$sql = 'SELECT loc.*,loc.image as locimg FROM jos_jev_locations AS loc where (';
				if (is_array($catfilters_arr))
				{
					for($b = 0; $b < count($catfilters_arr) ; $b++)
					{	
						$sql .= '  FIND_IN_SET('.$catfilters_arr[$b].',loc.catid_list )';
						if($b < count($catfilters_arr)-1 ){
							$sql .=' or';
						}else{
							$sql .=' )';
						}
					}
				}else{
					$sql .= '  FIND_IN_SET('.$catfilters_arr.',loc.catid_list ))';
				}
				$sql .= ' and loc.published = 1 order by loc.title,loc.ordering';
		}
		//echo $sql;
		$db->setQuery($sql);
		$rows=$db->query();
?>		
	<?php if(mysql_num_rows($rows)!='0'){ ?>
			
	
		<?php while($row = mysql_fetch_array($rows)){ ?>
		<div class="placesContainer" itemtype="http://schema.org/Organisation" itemscope="">
			<h3 itemprop="name"><a  href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>"><?php echo $row['title'] ?></a>
			</h3>
						
			<?php if($row['locimg']!='') {?>
				<a href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>">
					<img src="/partner/<?php echo $_SESSION['partner_folder_name']?>/images/stories/jevents/jevlocations/thumbnails/thumb_<?php echo $row['locimg']; ?>">
				</a>
			<?php } ?>
						
			<span class="placesCategorie">
				<?php // echo $row['cat']; 
					//display location multi-category name
					global $cat_assoc_front,$cat_ids_front;
					$cat_name = array();
					$temp = explode(',',$row['catid_list']);
					for($c = 0; $c < count($temp) ; $c++){
						if(in_array($temp[$c],$cat_assoc_front)){
							$cat_name[]= $cat_ids_front[$temp[$c]];
						}
					}
					
					for($k = 0; $k < count($cat_name) ; $k++){
						if($k < count($cat_name)-1){
							echo $cat_name[$k].",<br>";
						}else{
							echo $cat_name[$k];
						}
					}
				?>
			</span>
			
			<ul>
				<li><?php echo $row['street'].","; ?></li>
				<li><?php echo $row['city'].",";?></li>
				<li><?php echo $row['state'].", ".$row['postcode'] ?></li>
			</ul>
			
			<?php if($row['url']!=''){
				if(strpos($row['url'],"http://")===false)
				$row['url'] = "http://".trim($row['url']);
				?>
				<p><a itemprop="sameAs" href="<?php echo $row['url'] ?>" target="_blank"><?php echo JText::_("TW_VISIT");?></a></p>
			<?php }?>
			
			<?php if($row['phone']!=''){
			$phrase = $this->escape($phone);
			$remove = array("(","-",")"," ");
			$newphrase1 = str_replace($remove, "", $phrase);
			?>
				<p><a itemprop="telephone" href="tel:<?php echo $newphrase1;?>"><?php echo $row['phone'] ?></a></p>
			<?php }?>
		</div>
		<?php } ?>
	
			
	<?php }else{ ?>
		<h3 style="clear: both;padding-top: 20px;"><?php echo JText::_("LOC_RES");?></h3>
	<?php }

} else {?>
			
	<?php
	$params = JComponentHelper::getParams("com_jevlocations");
	$targetid = intval($params->get("targetmenu",0));
	if ($targetid>0){
		$menu = & JSite::getMenu();
		$targetmenu = $menu->getItem($targetid);
		if ($targetmenu->component!="com_jevents"){
			$targetid = JEVHelper::getItemid();
		}
		else {
			$targetid = $targetmenu->id;
		}
	}
	else {
		$targetid = JEVHelper::getItemid();
	}
	$task = $params->get("view","month.calendar");


	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];

		$tmpl = "";
		if (JRequest::getString("tmpl","")=="component"){
			$tmpl = "&tmpl=component";
		}

		$link 	= JRoute::_( 'index.php?option=com_jevlocations&task=locations.detail&loc_id='. $row->loc_id . $tmpl ."&se=1"."&title=".JFilterOutput::stringURLSafe($row->title));

		$eventslink = JRoute::_("index.php?option=com_jevents&task=$task&loclkup_fv=".$row->loc_id."&Itemid=".$targetid);

		// global list
		$global	= $this->_globalHTML($row,$i);

		$ordering = ($this->lists['order'] == 'loc.ordering');
		
		if ($this->usecats){
			if(isset($row->c3title)){
				$country = $row->c3title;
				$province = $row->c2title;
				$city = $row->c1title;
			}
			else if(isset($row->c2title)){
				$country = $row->c2title;
				$province = $row->c1title;
				$city = false;
			}
			else {
				$country = $row->c1title;
				$province = false;
				$city = false;
			}
		}
		else {
			$country = $row->country;
			$province = $row->state;
			$city = $row->city;
			$street=$row->street;
			$postcode=$row->postcode;
			$url=$row->url;
			$phone=$row->phone;
			$category=$row->category;
		}
		?>
		
		<div class="placesContainer" itemtype="http://schema.org/Organisation" itemscope="">
			<h3 itemprop="name">
				<a itemprop="url" href="<?php echo $link; ?>"><?php echo $this->escape($row->title); ?></a>
			</h3>
			<?php if ($compparams->get('showimage',1)){
					if ($row->image!=""){
						$thimg = '<img src="'.$mediabase.'/'.$folder.'/thumbnails/thumb_'.$row->image.'" />' ;
			?>
					<a href="<?php echo $link; ?>"><?php	echo $thimg; ?></a>
				
			<?php } } ?>

			<span class="placesCategorie">
				<?php //echo $this->escape($row->category); 
					//display location multi-category name
					global $cat_assoc_front,$cat_ids_front;
					$temp = explode(',',$row->catid_list);
					$cat_name1 = array();
					for($j = 0; $j < count($temp) ; $j++){
						if(in_array($temp[$j],$cat_assoc_front)){
							$cat_name1[]= $cat_ids_front[$temp[$j]];
						}
					}
					
					for($k = 0; $k < count($cat_name1) ; $k++){
						if($k < count($cat_name1)-1){
							echo $cat_name1[$k].",<br>";
						}else{
							echo $cat_name1[$k];
						}
					}
					?>
			</span>
			
				<ul itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
					<li><?php echo $this->escape($street).","; ?></li>
					<li><?php echo $this->escape($city).",";?></li>
					<li><?php echo $this->escape($province).", ". $this->escape($postcode); ?></li>
				</ul>
				<?php if($this->escape($url)!=''){
					if(strpos($url,"http://")===false)
					$url = "http://".trim($url);
				?>
				<p><a itemprop="sameAs" href="<?php echo $this->escape($url) ?>" target="_blank"><?php echo JText::_("TW_VISIT");?></a></p>
				<?php }?>
				<?php if($this->escape($phone)!=''){
					$phrase = $this->escape($phone);
					$remove = array("(","-",")");
					$newphrase = str_replace($remove, "", $phrase);
					//echo $newphrase;
				?>
					<p><a itemprop="telephone" href="tel:<?php echo $newphrase;?>"><?php echo $this->escape($phone);?></a></p>
					<?php }?>	
			
		</div>
		<?php
		$k = 1 - $k;
	}
	?>
<div class="res_page" style="text-align: center;margin: auto;padding-top: 20px;clear: both;">
 <?php echo $this->pagination->getListFooter(); ?>
</div>
<?php }?>

<?php if ($compparams->get("showmap",0)) echo $this->loadTemplate("map");?>

	<input type="hidden" name="option" value="com_jevlocations" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="task" value="locations.locations" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php if (JRequest::getString("tmpl","")=="component"){ ?>
	<input type="hidden" name="tmpl" value="component" />	
	<?php } ?>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

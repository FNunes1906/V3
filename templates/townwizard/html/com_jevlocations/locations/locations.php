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
<h2 class="componentheading">
	<?php $heading = $menuname.' '; $heading .= isset($parent)?$parent.' ':''; $heading .= "in ".$site_name[0]; echo $heading; ?>
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
				//$sql = "select *,jjl.title,jjl.image as locimg,jc.title as cat from `jos_jev_locations` jjl, `jos_categories` jc where (jjl.loccat = jc.id ) and jjl.loccat=".$_REQUEST['searchcat']." and jjl.published=1 order by jjl.title";
				 $sql = "select DISTINCT jc.title AS cat, jc . * , jjl . * , jjl.image AS locimg from `jos_jev_locations` jjl, `jos_categories` jc where (jc.parent_id = ".$_REQUEST['searchcat']." OR jc.id = ".$_REQUEST['searchcat'].")  AND (jjl.loccat = jc.id OR jjl.loccat = jc.parent_id) and jjl.published=1 group by loc_id order by jjl.title";
				$db->setQuery($sql);
				$rows=$db->query();
				
		}
		else{
				$db =& JFactory::getDBO();
				$sql = "select *,jjl.title,jjl.image as locimg,jc.title as cat from `jos_jev_locations` jjl, `jos_categories` jc where jjl.loccat = jc.id and jjl.published=1 order by jjl.title";
				$db->setQuery($sql);
				$rows=$db->query();
		}
?>		
			<?php if(mysql_num_rows($rows)!='0'){ ?>
			
				<ul id="SearchResults">
				<?php while($row = mysql_fetch_array($rows)){ ?>
					
					<li>
						<div class="thumb fr">
							
							<?php if($row['locimg']!='') {?>
							<a href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>"><img src="/partner/<?php echo $_SESSION['partner_folder_name']?>/images/stories/jevents/jevlocations/thumbnails/thumb_<?php echo $row['locimg']; ?>"></a><?php } ?>
						</div>
						<h3 style="margin:0px;"><a class="venueName bold fl" href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>"><?php echo $row['title'] ?></a></h3>
						<div class="bc fr bold">
										<?php echo $row['cat']; ?>
						</div>
						<div class="rating">
										<h3><br/>
										 <?php echo $row['street'].","; ?><br/>
										  <?php echo $row['city'].",";?><br/>
										  <?php echo $row['state'].", ".$row['postcode'] ?>
										</h3>
										<?php if($row['url']!=''){
											if(strpos($row['url'],"http://")===false)
											$row['url'] = "http://".trim($row['url']);
											?>
											<h2><a class="bold" href="<?php echo $row['url'] ?>" target="_blank"><?php echo JText::_("TW_VISIT");?></a></h2>
										<?php }?>
										<?php if($row['phone']!=''){
										$phrase = $this->escape($phone);
										$remove = array("(","-",")"," ");
										$newphrase1 = str_replace($remove, "", $phrase);
										?>
											<h2 class="bold"><a href="tel:<?php echo $newphrase1;?>"><?php echo $row['phone'] ?></a></h2>
										<?php }?>
										
						</div>
				
					 </li>
				
			 <?php } ?>
				 </ul>
			
		<?php }else{ ?>
				<h3 style="clear: both;padding-top: 20px;"><?php echo JText::_("LOC_RES");?></h3>
				<?php }

} else {?>
			
<div id="editcell" >
	<ul id="SearchResults">
	
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
		
		<li class="<?php echo "row$k"; ?>">
		
			<?php if ($compparams->get('showimage',1)){ ?>
			<div class="thumb fr">
				<?php 
				if ($row->image!=""){
					$thimg = '<img src="'.$mediabase.'/'.$folder.'/thumbnails/thumb_'.$row->image.'" />' ;
					?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'JEV view Location' );?>::<?php echo $this->escape($row->title); ?>">
					<a href="<?php echo $link; ?>"><?php	echo $thimg; ?></a>
				</span>
				<?php
				}
				?>
			</div>
			<?php } ?>
			<span class="editlinktip hasTip" title="<?php echo JText::_( 'JEV view Location' );?>::<?php echo $this->escape($row->title); ?>">
				<h3 style="margin:0px;"><a class="venueName bold fl" href="<?php echo $link; ?>"><?php echo $this->escape($row->title); ?></a></h3>
			</span>
			<div class="bc fr bold">
										<?php echo $this->escape($row->category); ?>
			</div>
			<div class="rating">
										<h3><br/>
										 <?php echo $this->escape($street).","; ?><br/>
										  <?php echo $this->escape($city).",";?><br/>
										  <?php echo $this->escape($province).", ". $this->escape($postcode); ?>
										</h3>
										<?php if($this->escape($url)!=''){
											if(strpos($url,"http://")===false)
											$url = "http://".trim($url);
											?>
										<h2><a class="bold" href="<?php echo $this->escape($url) ?>" target="_blank"><?php echo JText::_("TW_VISIT");?></a></h2>
										<?php }?>
										<?php if($this->escape($phone)!=''){
										$phrase = $this->escape($phone);
										$remove = array("(","-",")");
										$newphrase = str_replace($remove, "", $phrase);
										//echo $newphrase;
										?>
										<h2 class="bold"><a href="tel:<?php echo $newphrase;?>"><?php echo $this->escape($phone);?></a></h2>
										<?php }?>
										
										
			</div>
		</li>
		<?php
		$k = 1 - $k;
	}
	?>
	</ul>
	
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

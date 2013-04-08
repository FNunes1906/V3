<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
		$ser= $_REQUEST['searchword'];
				
		if($ser!=''){
				$db =& JFactory::getDBO();
				$sql = "select *,jjl.title,jjl.image as locimg,jc.title as cat from `jos_jev_locations` jjl, `jos_categories` jc where jjl.loccat = jc.id and jjl.published=1 AND (jjl.description LIKE '%$ser%' OR jjl.title LIKE '%$ser%') order by jjl.title";
				$db->setQuery($sql);
				$rows=$db->query();
				
		}
		
		?>
		
		
		<?php if (mysql_num_rows($rows)!= 0){ ?>
				<ul id="SearchResults">
			<?php while($row = mysql_fetch_array($rows)){ 
			
			?>

					<li>
						<div class="thumb fr">
								<?php if($row['locimg']!='') {?>
								<a href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>"><img src="/partner/<?php echo $_SESSION['partner_folder_name']?>/images/stories/jevents/jevlocations/thumbnails/thumb_<?php echo $row['locimg']; ?>"></a><?php }?>
						</div>
						<a class="venueName bold fl" href="index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $row['loc_id'] ?>&title=<?php echo $row['title'] ?>"><?php echo $row['title'] ?></a>
						<div class="bc fr bold">
										<?php echo $row['cat']; ?>
						</div>
						<div class="rating">
										<h3><br/>
											<?php if($row['street']!='')
										 	 		echo $row['street'].","; 
											?><br/>
										  <?php if($row['state']!='' || $row['city']!='')
										  			echo $row['state'].", ".$row['city'];
										  ?><br/>
										  <?php if($row['postcode']!='')
										  	echo "PA ".$row['postcode'] ?>
										</h3>
										<?php if($row['url']!=''){?>
											<h2><a class="bold" href="<?php echo "http://".$row['url'] ?>" target="_blank"><?php echo JText::_("TW_VISIT");?></a></h2>
										<?php }?>
										<?php if($row['phone']!=''){?>
											<h2 class="bold"><?php echo $row['phone'] ?></h2>
										<?php }?>
										
						</div>
				
					 </li>
				
			 <?php } ?>
				 </ul>
			
			<?php }else{ ?>
				<h3 style="clear: both;padding-top: 20px;"><?php echo JText::_("LOC_RES");?></h3>
				<?php }?>
		

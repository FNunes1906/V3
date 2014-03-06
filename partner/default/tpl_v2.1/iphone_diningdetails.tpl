 <div id="main" role="main">
	<ul id="placesList" class="mainList">
		<li>
			<?php while($row = mysql_fetch_array($rec))	{
				$lat2=$row['geolat'];
				$lon2=$row['geolon'];?>
			
				<h1><?php echo $row['title'];?></h1>
				<p>
					<strong> <?php echo JText::_('ADDRESS'); ?>:</strong>&nbsp;&nbsp;<a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $lat2;?>:<?php echo $lon2;?>')"><?php echo $row['street'];?></a>
				</p>
				<?php if(trim($row['phone'] != '')) { ?>
				<p>
					<strong> <?php echo JText::_('PHONE'); ?>:</strong>&nbsp;&nbsp;<a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$row['phone'])?>"><?php echo $row['phone']?></a>
				</p>
				<?php } ?>
				<p><strong> <?php echo JText::_('DISTANCE'); ?>:</strong>&nbsp;&nbsp;<?php echo round(distance($lat1, $lon1, $lat2, $lon2,$dunit),'1');?>&nbsp;<?php echo $dunit;?></p>
				<?php if($row['url'] != ''){ ?>
						<p>
							<strong> <?php echo JText::_('WEBSITE'); ?>:</strong>&nbsp;&nbsp;
							<a href="http://<?php echo str_replace('http://','',$row['url']); ?>" target="_blank">
								<?php echo str_replace('http://','',$row['url']); ?>
							</a>
						</p>
				<?php } ?>
				<?php if($row['description'] != ''){ ?>
						<p>
							<strong> <?php echo JText::_('DISCRIPTION'); ?>:</strong>
							 <?php echo $row['description']; ?>
						</p>
				<?php } ?>
				<ul class="btnList">
					<li>
					<?php if(trim($row['phone'] != '')) { ?>
					<a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$row['phone'])?>" class="button small"> <?php echo JText::_('CALL'); ?></a>
					<?php } ?>
					</li>
					<li><a href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $row['geolat']; ?>:<?php echo $row['geolon']; ?>')" class="button small"> <?php echo JText::_('CHECK_IN'); ?></a></li>
				</ul>
			<?php  } ?>
		</li> <!-- end place -->
	</ul> <!-- end place list -->
</div> <!-- main -->

<div style='display:none;'>
	<?php echo $pageglobal['googgle_map_api_keys']; ?>
</div>
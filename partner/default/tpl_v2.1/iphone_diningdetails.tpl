 <div id="main" role="main">
	<ul id="placesList" class="mainList">
		<li>
			<?php while($row = mysql_fetch_array($rec))	{
				$lat2=$row['geolat'];
				$lon2=$row['geolon'];?>
			
				<h1><?php echo $row['title'];?></h1>
				<p>
					<strong><?php echo JText::_('ADDRESS'); ?>:</strong>&nbsp;&nbsp;<?php echo $row['street'];?>
				</p>
				<p><strong> <?php echo JText::_('DISTANCE'); ?>:</strong>&nbsp;&nbsp;<?php echo round(distance($lat1, $lon1, $lat2, $lon2,$dunit),'1');?>&nbsp;<?php echo $dunit;?></p>
				<?php if($row['description'] != ''){ ?>
				<p>
					<strong> <?php echo JText::_('DISCRIPTION'); ?>:</strong>
					 <?php echo $row['description']; ?>
				</p>
				<?php } ?>
				<ul class="btnList2">
					<?php if(trim($row['phone'] != '')) { ?>
					<li><a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$row['phone'])?>" class="button2 small2"><?php echo $row['phone']?></a></li>
					<?php } ?>
					
					<?php if($row['url'] != ''){ ?>
					<li><a href="http://<?php echo str_replace('http://','',$row['url']); ?>" class="button2 small2" target="_blank"><?php echo JText::_('WEBSITE'); ?></a></li>
					<?php } ?>
					
					<li><a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $lat2;?>:<?php echo $lon2;?>')" class="button2 small2"><?php echo JText::_('TW_MAP'); ?></a></li>
<!--					<li><a href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $row['geolat']; ?>:<?php echo $row['geolon']; ?>')" class="button2 small2"><?php echo JText::_('CHECK_IN');?></a></li>-->
					
					<li>
						<span id="myshare" class="button2 small2"><?php echo JText::_('TW_SHARE');?></span>
						<div id="share-wrapper">
							 <ul class="share-inner-wrp">
								<?php 
								if($cat_name != ""){
									$url = "http://".$_SERVER['SERVER_NAME']."/".$cat_name."/detail/".$row['loc_id']."/".str_replace (" ", "", $row['title']);
								}else{
									$url = "http://".$_SERVER['SERVER_NAME'];
								}
								?>						
								   <!-- Facebook -->
								   <li class="button-wrap"><a  class="addthis_button_facebook" addthis:url="<?php echo $url;?>">Facebook</a></li>
								   <!-- Twitter -->
								   <li class="button-wrap"><a class="addthis_button_twitter" addthis:url="<?php echo $url;?>">Tweet</a></li>
								   <!-- Google -->
								   <li class="button-wrap"><a class="addthis_button_google_plusone_share" addthis:url="<?php echo $url;?>">Google +</a></li>
								   <!-- Email -->
								   <li class="button-wrap"><a class="addthis_button_email" addthis:description="An Example Description" addthis:url="<?php echo $url;?>">Email</a></li>
							
						 	 </ul>
						</div>
					</li>
				</ul>
			<?php  } ?>
		</li> <!-- end place -->
	</ul> <!-- end place list -->
</div> <!-- main -->
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-530f25e212b3622b"></script>
<div style='display:none;'>
	<?php echo $pageglobal['googgle_map_api_keys']; ?>
</div>
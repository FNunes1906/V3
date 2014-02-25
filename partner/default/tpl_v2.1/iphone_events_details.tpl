<div id="main" role="main" ontouchstart="touchStart(event,'list');"  ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
	<ul id="placesList" class="mainList">
		<li>
			<?php 
			while($row = mysql_fetch_array($rec))
			{	
				$rowvevdetail = $objevdetail->fetch_eventdetail_data($row['eventdetail_id']);
				if ((int) ($rowvevdetail['location']))
				{
					$rowlocdetail =	$objevdetail->fetch_location_detail($rowvevdetail['location']);
					$lat2 = $rowlocdetail['geolat'];
					$lon2 = $rowlocdetail['geolon'];
				}
			 ?>
			<h1><?php echo $rowvevdetail['summary'];?></h1>
			<p><strong><?php echo JText::_('DATE'); ?>:</strong> <?php echo $todaestring;?></p>
			<p><strong><?php echo JText::_('EV_DISP_TIME'); ?>:</strong>
			<?php
			/* Coded By Akash */
				$displayTime = '';
				if($time_format == "12"){
					if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59 PM'){   
						$displayTime.=JText::_('ALL_DAY');
					}else{
						$displayTime.= $row['timestart'];
						if ($row['timeend'] != '11:59 PM' ){
							$displayTime.="-".$row['timeend'];
						}
					}
				}else{
					$stime = date("H:i", strtotime($row['timestart']));
					$etime = date("H:i", strtotime($row['timeend']));
					if($stime=='00:00' && $etime=='23:59'){   
						$displayTime.=JText::_('ALL_DAY');
					}else{
						$displayTime.= $stime;
						if ($etime!='23:59' ){
							$displayTime.="-".$etime;
						}
					}
				}
				echo $displayTime;
	   		/* End By Akash */	
			?>
			</p>
			<p><strong><?php echo JText::_('LOCATION'); ?>:</strong> <?php echo $rowlocdetail['title'];?></p>
			<p><strong><?php echo JText::_('ADDRESS'); ?>:</strong><?php echo $rowlocdetail['street'];?></p>
<!--			<p><strong><?php echo JText::_('PHONE'); ?>:</strong> <a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>"><?php echo $rowlocdetail['phone'];?></a></p>-->
			<p><strong><?php echo JText::_('DISTANCE'); ?>:</strong> <?php echo round(distance(($_SESSION['lat_device1']), ($_SESSION['lon_device1']), $lat2, $lon2,$dunit),'1')?>&nbsp;<?php echo $dunit;?></p>
<!--			<?php if(trim($rowlocdetail['url']) != '') { ?>
			<p><strong><?php echo JText::_('WEBSITE'); ?>:</strong> <a href="http://<?php echo str_replace('http://','',$rowlocdetail['url']); ?>" target="_blank"><?php echo str_replace('http://','',$rowlocdetail['url']); ?></a></p>
				<?php } ?>-->
			<p><strong><?php echo JText::_('DISCRIPTION'); ?>:</strong> <?php echo $rowvevdetail['description'];?></p>
	
			
			<ul class="btnList">
			
				<?php if(trim($rowlocdetail['phone']) != '') { ?>
				<li class="setwidth"><a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>" class="button small"><?php echo $rowlocdetail['phone'];?></a></li>
				<?php } ?>
				
				<?php if(trim($rowlocdetail['url']) != '') { ?>
				<li class="setwidth"><a href="http://<?php echo str_replace('http://','',$rowlocdetail['url']); ?>" class="button small" target="_blank"><?php echo JText::_('WEBSITE'); ?></a></li>
				<?php } ?>
				
				<li class="setwidth"><a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $lat2;?>:<?php echo $lon2;?>')" class="button small"><?php echo JText::_('TW_MAP'); ?></a></li>
			</ul>
				
			<?php
				$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
				if(stripos($ua,'android') == true){ ?>
					<div class="iphoneads" style="vertical-align:bottom;">
						<?php m_show_banner('android-events-screen'); ?>
					</div>
				<?php }else{?>
					<div class="iphoneads" style="vertical-align:bottom;">
					<?php m_show_banner('iphone-events-screen'); ?>
					</div>
			<?php } ?>


			<ul class="btnList2">
				<li>
					<a href="#" class="button2 small2">
					
				<!-- code for ical calendar start-->
				<?php 	$cal_date=date('m-d-Y', mktime(0, 0, 0, $tomonth, $today, $toyear)); ?>						
					<div class="addthisevent">
						<?php if($displayTime=='All Day Event'){ ?> 
					 	<span class="_all_day_event">true</span>
					   	<?php } ?>
					 	<span class="_start"><?php echo $cal_date.' '.$row['timestart'] ?></span>
			    			<span class="_end"><?php echo $cal_date.' '.$row['timeend'] ?></span> 
					  	<span class="_summary"><?php echo $rowvevdetail['summary'];?></span>
					   	<span class="_description"><?php echo strip_tags($rowvevdetail['description']);?></span>
					    	<span class="_location"><?php echo $rowlocdetail['title'];?></span>
					  	<span class="_date_format">MM/DD/YYYY</span>
					</div>
			<!-- code for ical calendar end--> 
					</a>
				</li>
				<li><a href="javascript:linkClicked('APP30A:FBCHECKIN:34.13828278:-118.35331726')" class="button2 small2"><?php echo JText::_('CHECK_IN');?></a></li>
				<!--<li><a href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=xa-530314602dbf0b6a" class="button2 small2 addthis_button"><?php echo JText::_('TW_SHARE');?></a></li>-->
				<li>
					<span id="myshare" class="button2 small2"><?php echo JText::_('TW_SHARE');?></span>
									 <div id="share-wrapper">
						    <ul class="share-inner-wrp">
						        <!-- Facebook -->
						        <li class="facebook button-wrap"><a href="#">Facebook</a></li>
						        
						        <!-- Twitter -->
						        <li class="twitter button-wrap"><a href="#">Tweet</a></li>
						        
						        <!-- Google -->
						        <li class="google button-wrap"><a href="#">Google Plus</a></li>
						        
						        <!-- Email -->
						        <li class="email button-wrap"><a href="#">Email</a></li>
						    </ul>
						</div>
				
				</li>
			</ul>
			
			<?php }?>
			
		</li>

	</ul>

</div>


	<!--<div  id="myshare">Share</div>-->
<!-- AddThis Button BEGIN -->
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-530314602dbf0b6a"></script>-->
<!-- AddThis Button END -->
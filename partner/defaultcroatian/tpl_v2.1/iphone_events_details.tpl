<?php 
setlocale(LC_TIME,"croatian");
//$todaestring = ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear)));
$todaestring = $today.'/'.$tomonth;
?>
<div id="main" role="main" ontouchstart="touchStart(event,'list');"  ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
	<ul id="placesList" class="mainList"><li>
		<?php 
		while($row=mysql_fetch_array($rec))
		{
		//#DD#
		$ev=mysql_query("select *  from jos_jevents_vevent where ev_id=".$row['eventid']) or die(mysql_error());
		mysql_set_charset("UTF8");
		$evDetails=mysql_fetch_array($ev);
		$evrawdata = unserialize($evDetails['rawdata']);
		//#DD#	
		//$queryvevdetail="select *  from jos_jevents_vevdetail where evdet_id=".$row['eventid'];
		$queryvevdetail="select *  from jos_jevents_vevdetail where evdet_id=".$row['eventdetail_id'];
		$recvevdetail=mysql_query($queryvevdetail) or die(mysql_error());
		mysql_set_charset("UTF8");
		$rowvevdetail=mysql_fetch_array($recvevdetail);
		if ((int) ($rowvevdetail['location']))
		{
		$querylocdetail="select *  from jos_jev_locations where loc_id=".$rowvevdetail['location'];
		$reclocdetail=mysql_query($querylocdetail) or die(mysql_error());
		mysql_set_charset("UTF8");
		$rowlocdetail=mysql_fetch_array($reclocdetail);
		$lat2=$rowlocdetail['geolat'];
		$lon2=$rowlocdetail['geolon'];
		}
		?>
		<h1><?php echo $rowvevdetail['summary'];?></h1>

		<p><strong>Datum:</strong> <?php echo UTF8_encode($todaestring);?></p>
		<p><strong>Vrijeme:</strong>
		<?php
		/* Coded By Akash */
		
			$displayTime = '';
			
			if($time_format == "12"){
			
				if($row[timestart]=='12:00 AM' && $row[timeend]=='11:59 PM'){   
					$displayTime.='Cijeli dan';
				}		
				else{
					$displayTime.= $row[timestart];
					if ($row[timeend] != '11:59 PM' ){
						$displayTime.="-".$row[timeend];
					}
				}
			
			}else{
			
				$stime = date("H:i", strtotime($row['timestart']));
				$etime = date("H:i", strtotime($row['timeend']));
				
				if($stime=='00:00' && $etime=='23:59'){   
					$displayTime.='Cijeli dan';
				}		
				else{
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
		<p><strong>Lokacija:</strong> <?php echo $rowlocdetail['title'];?></p>
		<p><strong>Adresa:</strong> <a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $lat2;?>:<?php echo $lon2;?>')" ><?php echo $rowlocdetail['street'];?></a></p>
		<p><strong>Telefon:</strong> <a href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>"><?php echo $rowlocdetail['phone'];?></a></p>
		<p><strong>Udaljenost:</strong> <?php echo round(distance($_SESSION['lat_device1'], $_SESSION['lon_device1'], $lat2, $lon2,$dunit),'1');?>&nbsp;<?php echo $dunit?></p>
		<?php if(trim($rowlocdetail['url']) != '') { ?>
		<p><strong>Internet stranica:</strong> <a href="http://<?php echo str_replace('http://','',$rowlocdetail['url']); ?>" target="_blank"><?php echo str_replace('http://','',$rowlocdetail['url']); ?></a></p>
			<?php } ?>
	<p><strong>Opis:</strong> <?php echo $rowvevdetail['description']?></p>
		
		<!-- code for ical calendar start-->
		<?php  	$cal_date=date('m-d-Y', mktime(0, 0, 0, $tomonth, $today, $toyear)); ?>		
				<div class="addthisevent">
					<?php if($displayTime=='All Day Event'){ ?> 
				 	<span class="_all_day_event">true</span>
				   	<?php } ?>
				 	<span class="_start"><?php echo $cal_date.' '.$row[timestart] ?></span>
		    			<span class="_end"><?php echo $cal_date.' '.$row['timeend'] ?></span> 
				  	<span class="_summary"><?php echo $rowvevdetail['summary'] ?></span>
				   	<span class="_description"><?php echo $rowvevdetail['description'];?></span>
				    	<span class="_location"><?php echo $rowlocdetail['title'];?></span>
				  	<span class="_date_format">MM/DD/YYYY</span>
				</div>
		<!-- code for ical calendar end-->
		
		<?php
		//#DD#
		$mailContent.= "
		{$rowvevdetail['summary']} %0D%0A%0D%0A
		Date: {$todaestring} %0D%0A%0D%0A
		Time: " . ltrim($row[timestart], "0"). " %0D%0A%0D%0A
		Location: {$rowlocdetail['title']} %0D%0A%0D%0A
		Address: {$rowlocdetail['street']} %0D%0A%0D%0A
		Phone: {$rowlocdetail['phone']} %0D%0A%0D%0A
		";
		if(trim($rowlocdetail['url']) != '') { 
		$mailContent.="Internet stranica: ". str_replace('http://','',$rowlocdetail['url']) ."%0D%0A%0D%0A";
		} 
		$mailContent.="Description: {$rowvevdetail['description']} %0D%0A%0D%0A";
		$mailContent = str_replace('
		<br/>
			',"%0D%0A", $mailContent);
			$mailContent = str_replace('
				<br>
					',"%0D%0A", $mailContent);
					$mailContent = str_replace('
				<br />
				',"%0D%0A", $mailContent);
				$mailContent = str_replace('"','\"', $mailContent);
				$mailContent = strip_tags($mailContent);
				//#DD#
				}
				?>
				<!-- Added by yogi for Facebook Share feature Begin -->
				<?php 
				//$eddate_array = explode(" ",$rowvevdetail['modified']);
				// $ev_detail_date = $eddate_array[0];
				$ev_detail_date = date('Y-m-d', mktime(0, 0, 0, $tomonth, $today, $toyear));
				$ev_detail_title = $rowvevdetail['summary']; 
				$ev_detail_id = $rowvevdetail['evdet_id'];
				$host = $_SERVER[HTTP_HOST];
				$eurl = utf8_encode("http://$host/event_details.php?event_id=$ev_detail_id%26title=$ev_detail_title%26date=$ev_detail_date%26rp_id=$eid");
				$egurl = str_replace('%20','%2B',$eurl);
				?>
				
				</li></ul>
				<!-- Added by yogi for Facebook Share feature End -->
				<!-- #DD# -->

		<div style='float:left;padding:3px 3px 3px 8px;'>
		<a expr:share_url='data:post.url' href='http://www.facebook.com/sharer.php?u=<?php echo $eurl ?>' name='fb_share' type='box_count'>
				<div class="facebook">	</div>
			</a>
			
		<!--<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>-->
		</div>
		<div style='float:left;padding:3px 3px 3px 8px;'>
			<a href="https://plus.google.com/share?url=<?php echo $egurl;?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
			<div class="google"></div>
			</a>
		</div>
</div>
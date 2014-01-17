<?php setlocale(LC_TIME,"french"); ?>
<div id="featuredEvents">
	<div class="flexslider-container">
		<div class="flexslider">
		    <ul class="slides">
			<?php
			$f=0;
			$imagecount = 0;
			$tempeventid;
			$homeslider1;
			$k=0;

			while($fearow=mysql_fetch_array($featured_filter)){
			
			$finalDescription="";
			##Image Fetched for slide show##
			    $imagesrc= strstr($fearow['description'],'src=');
				$imageurl= strstr($imagesrc,'http');
				$singleimagearray = explode('"',$imageurl);
				if($singleimagearray[0] == ""){
				$singleimagearray[0] = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_image.png"; }
			##end##
			
		/* Coded By Akash */			
			$displayDate ="";
			if($date_format == "%m/%d"){
				$displayDate = $fearow['Date'];
			}else{
				$rawdate = $fearow['EDate'];
				$rawdate1 = $fearow['Emonth'];
				$displayDate= $rawdate."/".$rawdate1;
			}

			$displayTime = '';
			if($time_format == "12"){
				if($fearow[timestart]=='12:00 AM' && $fearow[timeend]=='11:59 PM'){   
					$displayTime.='Todo el día';
				}else{
					$displayTime.= $fearow[timestart];
					if ($fearow[timeend] != '11:59 PM' ){
						$displayTime.="-".$fearow[timeend];
					}
				}
			}else{
				$stime = date("H:i", strtotime($fearow['timestart']));
				$etime = date("H:i", strtotime($fearow['timeend']));
				
				if($stime=='00:00' && $etime=='23:59'){   
					$displayTime.='Todo el día';
				}else{
					$displayTime.= $stime;
					if ($etime!='23:59' ){
						$displayTime.="-".$etime;
					}
				}
			}
		/* End By Akash */	
					
			if(in_array($fearow['ev_id'], $tempeventid)){
			}else{
			if($imagecount<5){
			
			?> 
		    	<li>
				<a href="/components/com_shines_v2.1/events_details.php?eid=<?php echo $fearow['rp_id'];?>&y=<?php echo $fearow['Eyear'];?>&m=<?php echo $fearow['Emonth'];?>&d=<?php echo $fearow['EDate'];?>"><img src="<?php echo $singleimagearray[0];?>" /></a>
		    		<div class="flex-caption">
		    			<h1><?php echo $fearow['summary']?></h1>
		    			<h2><?php echo $fearow['title']?></h2>
		    			<h3><?php echo $displayDate;?> &bull;
						<!--below Varialbe for 24 vs 12 hours time format for HOME SLIDER yogi-->
							<?php echo $displayTime; ?></h3>
		    		</div> <!-- caption -->
		    	</li>
			<?php
			$displayTime = "";			
			++$imagecount;/*5 featured event counter */
			$tempeventid[] = $fearow['ev_id'];
			}}
			++$f;
			++$k;
			}
			?>
			</ul>
		</div>
	</div>
</div> <!-- featured events -->
<div class="section">
	<!--Code for Mobiscroll NEW date picker - Yogi START -->
		<input style="display: none;" type="text" name="test_default" id="test_default" onChange="redirecturl(this.value);"/>
		<label for="test_default" class="ui-btn-hidden">événements par jour</label>
	<!--Code for Mobiscroll NEW date picker - Yogi END -->
	
	<!--Code for Event Category drop down Yogi Start -->
		<form id="event_cat_form" class="cls_event_cat_form" autocomplete="off">
			<select name="category_id" onChange="redirecturlcat(this.value)" class="event_cat_drop">
				<option value="0"><?php echo strtoupper("catégories");?></option>
				<?php while($row_cat = mysql_fetch_array($result_event_cat)){?>
					<option value="<?php echo $row_cat['id'];?>"<?php if($row_cat['id'] == $catId) echo "selected='selected'";?>>
						<?php echo strtoupper($row_cat['name']);?>
					</option>
				<?php }?>
			</select>
		</form>
	<!--Code for Event Category drop down Yogi End -->	
</div>

<?php
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == true) { ?>
  <div class="iphoneads" style="vertical-align:bottom;">
	<?php m_show_banner('android-events-screen'); ?>
  </div>
  <?php }else{?>
  <div class="iphoneads" style="vertical-align:bottom;">
    <?php m_show_banner('iphone-events-screen'); ?>
  </div>
  <?php } ?>


<div id="main" role="main">

<?php
if($todaestring != null){
	$todaestring =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));
	echo "<h1>$todaestring";?><?php echo "</h1>";
}elseif($seachStartFullDate == $searchEndFullDate){
	$seachStartDate =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $fromMonth, $fromDay, $fromYear))));
	$searchEndDate  =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));	
	echo "<h1>$seachStartDate";?><?php echo "</h1>";
}
?>


<ul id="eventList" class="mainList" ontouchstart="touchStart(event,'eventList');" ontouchend="touchEnd(event);" ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">

			<?php 
			$n = 0;
			if($seachStartDate == $searchEndDate || !isset($_REQUEST['eventdate']) || $_REQUEST['eventdate'] == ''){
			while($row = mysql_fetch_array($rec)){

				# Fetch event data from "event" table
				$ev			= mysql_query("select *  from jos_jevents_vevent where ev_id=".$row['eventid']) or die(mysql_error());
				$evDetails 	= mysql_fetch_array($ev);
				$evrawdata 	= unserialize($evDetails['rawdata']);

				# Fetch category name of the event from "category" table
				$event_category	= mysql_query("select title  from jos_categories where id=".$evDetails['catid']) or die(mysql_error());
				$ev_cat 		= mysql_fetch_object($event_category);
				$categoryname[] = $ev_cat->title;

				# Fetch Event detail from "event detail" table
				$queryvevdetail = "select *  from jos_jevents_vevdetail where evdet_id=".$row['eventdetail_id'];
				$recvevdetail	= mysql_query($queryvevdetail) or die(mysql_error());
				$rowvevdetail 	= mysql_fetch_array($recvevdetail);

				# Fetch event location detail from "location" table
				if ((int) ($rowvevdetail['location'])){
					$querylocdetail="select *  from jos_jev_locations where loc_id=".$rowvevdetail['location'];
					$reclocdetail = mysql_query($querylocdetail) or die(mysql_error());
					$rowlocdetail = mysql_fetch_array($reclocdetail);
					$lat2 = $rowlocdetail[geolat];
					$lon2 = $rowlocdetail[geolon];
				}

				// Coded By Akash
				$displayTime2 = '';
				if($time_format == "12"){
					if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59 PM'){   
						$displayTime2.='Todo el día';
					}else{
						$displayTime2.= $row['timestart'];
						if($row['timeend'] != '11:59 PM' ){
							$displayTime2.="-".$row['timeend'];
						}
					}
				}else{
					$stime = date("H:i", strtotime($row['timestart']));
					$etime = date("H:i", strtotime($row['timeend']));
					if($stime == '00:00' && $etime == '23:59'){   
						$displayTime2.='Todo el día';
					}else{
						$displayTime2.= $stime;
						if($etime!='23:59' ){
							$displayTime2.="-".$etime;
						}
					}
				}// End By Akash?>

				<li>	
					<h1><?php echo $rowvevdetail['summary'];?></h1>
					<h2><?php echo $rowlocdetail['title'];?></h2>
					<h3>
						<!--Code for 24 vs 12 hour time format for LISTING Yogi -->
						<?php
						echo $displayTime2.' &bull; ';
						echo $categoryname[$n]; ?>
						<ul class="btnList">
							<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>">Appeller</a</li>
							<?php
							$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
								if(stripos($ua,'android') != true) { ?>
									<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $lat2; ?>:<?php echo $lon2; ?>')">Ajouter un lieu</a></li>
								<?php }
							
							# Code for Moreinfo link Date
							$e_start_rpt	= strstr($row['startrepeat']," ",true);
							$e_end_rpt		= strstr($row['endrepeat']," ",true);
							
							if($e_start_rpt != $e_end_rpt){
								$dateValue = explode('-',$single_day_date);
							}else{
								$dateValue = explode(' ',$row['startrepeat']);
								$dateValue = explode('-',$dateValue[0]);
							}?>
								
							<li><a class="button small" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">Plus d’informations</a></li>
						</ul>
					</h3> 
				</li>
				
				<?php $displayTime2 = ""; $rowlocdetail['title']=""; ++$n; 
			}// End of while loop
	# If search start and end date are different	
	}else{
		for($x=1;$ser_start_date <= $ser_end_date;$x++){
			
			$dateArray		= explode('-',$ser_start_date);
			$ev_toyear		= $dateArray[0];
			$ev_tomonth		= $dateArray[1];
			$ev_today		= $dateArray[2];
			
			unset($ev_arr_rr_id);
			unset($categoryname);
			$n = 0;
			
			$disp_date =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $ev_tomonth, $ev_today, $ev_toyear))));
			/*echo "<h1 id='datezig'>$disp_date</h1>";*/
			if($x == 1){
				echo "<h1 id='datezig'>$disp_date";?><?php echo "</h1>";
			}else{
				echo "<h1 id='datezig'>$disp_date</h1>";
			}
		
			# Event fetch query for given date	
			$ev_query_filter = "SELECT rpt.*, ev.*, rr.*, det.*, ev.state as published , loc.loc_id,loc.title as loc_title, loc.title as location, loc.street as loc_street, loc.description as loc_desc, loc.postcode as loc_postcode, loc.city as loc_city, loc.country as loc_country, loc.state as loc_state, loc.phone as loc_phone , loc.url as loc_url    , loc.geolon as loc_lon , loc.geolat as loc_lat , loc.geozoom as loc_zoom    , YEAR(rpt.startrepeat) as yup, MONTH(rpt.startrepeat ) as mup, DAYOFMONTH(rpt.startrepeat ) as dup , YEAR(rpt.endrepeat ) as ydn, MONTH(rpt.endrepeat ) as mdn, DAYOFMONTH(rpt.endrepeat ) as ddn , HOUR(rpt.startrepeat) as hup, MINUTE(rpt.startrepeat ) as minup, SECOND(rpt.startrepeat ) as sup , HOUR(rpt.endrepeat ) as hdn, MINUTE(rpt.endrepeat ) as mindn, SECOND(rpt.endrepeat ) as sdn FROM jos_jevents_repetition as rpt LEFT JOIN jos_jevents_vevent as ev ON rpt.eventid = ev.ev_id LEFT JOIN jos_jevents_icsfile as icsf ON icsf.ics_id=ev.icsid LEFT JOIN jos_jevents_vevdetail as det ON det.evdet_id = rpt.eventdetail_id LEFT JOIN jos_jevents_rrule as rr ON rr.eventid = rpt.eventid LEFT JOIN jos_jev_locations as loc ON loc.loc_id=det.location LEFT JOIN jos_jev_peopleeventsmap as persmap ON det.evdet_id=persmap.evdet_id LEFT JOIN jos_jev_people as pers ON pers.pers_id=persmap.pers_id WHERE ev.catid IN(".$arrstrcat.") AND rpt.endrepeat >= '".$ev_toyear."-".$ev_tomonth."-".$ev_today." 00:00:00' AND rpt.startrepeat <= '".$ev_toyear."-".$ev_tomonth."-".$ev_today." 23:59:59' AND ev.state=1 AND rpt.endrepeat>='".date('Y',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('m',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('d', mktime($totalHours, $totalMinutes, $totalSeconds))." 00:00:00' AND ev.access <= 0 AND icsf.state=1 AND icsf.access <= 0 and ((YEAR(rpt.startrepeat)=".$ev_toyear." and MONTH(rpt.startrepeat )=".$ev_tomonth." and DAYOFMONTH(rpt.startrepeat )=".$ev_today.") or freq<>'WEEKLY')GROUP BY rpt.rp_id";	
			
			$ev_rec_filter = mysql_query($ev_query_filter);
			mysql_set_charset("UTF8");
			
			while($ev_row_filter = mysql_fetch_array($ev_rec_filter)){
				$ev_arr_rr_id[] = $ev_row_filter['rp_id'];
			}

			if (count($ev_arr_rr_id)){
				$ev_strchk	= implode(',',$ev_arr_rr_id);
			}else{
				$ev_strchk	= 0;
			}	
			
			$ev_query = "select *,DATE_FORMAT(`startrepeat`,'%h:%i %p') as timestart, DATE_FORMAT(`endrepeat`,'%h:%i %p') as timeend from jos_jevents_repetition where rp_id in ($ev_strchk) ORDER BY `startrepeat` ASC ";
			$ev_rec = mysql_query($ev_query) or die(mysql_error());
			
			while($row = mysql_fetch_array($ev_rec)){
				
				# Fetch event data from "event" table
				$ev			= mysql_query("select *  from jos_jevents_vevent where ev_id=".$row['eventid']) or die(mysql_error());
				$evDetails 	= mysql_fetch_array($ev);
				$evrawdata 	= unserialize($evDetails['rawdata']);

				# Fetch category name of the event from "category" table
				$event_category	= mysql_query("select title  from jos_categories where id=".$evDetails['catid']) or die(mysql_error());
				$ev_cat 		= mysql_fetch_object($event_category);
				$categoryname[] = $ev_cat->title;

				# Fetch Event detail from "event detail" table
				$queryvevdetail = "select *  from jos_jevents_vevdetail where evdet_id=".$row['eventdetail_id'];
				$recvevdetail	= mysql_query($queryvevdetail) or die(mysql_error());
				$rowvevdetail 	= mysql_fetch_array($recvevdetail);

				# Fetch event location detail from "location" table
				if ((int) ($rowvevdetail['location'])){
					$querylocdetail="select *  from jos_jev_locations where loc_id=".$rowvevdetail['location'];
					$reclocdetail = mysql_query($querylocdetail) or die(mysql_error());
					$rowlocdetail = mysql_fetch_array($reclocdetail);
					$lat2 = $rowlocdetail[geolat];
					$lon2 = $rowlocdetail[geolon];
				}

				// Coded By Akash
				$displayTime2 = '';
				if($time_format == "12"){
					if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59 PM'){   
						$displayTime2.='Todo el día';
					}else{
						$displayTime2.= $row['timestart'];
						if($row['timeend'] != '11:59 PM' ){
							$displayTime2.="-".$row['timeend'];
						}
					}
				}else{
					$stime = date("H:i", strtotime($row['timestart']));
					$etime = date("H:i", strtotime($row['timeend']));
					if($stime == '00:00' && $etime == '23:59'){   
						$displayTime2.='Todo el día';
					}else{
						$displayTime2.= $stime;
						if($etime!='23:59' ){
							$displayTime2.="-".$etime;
						}
					}
				}// End By Akash	?>

				<li>	
					<h1><?php echo $rowvevdetail['summary'];?></h1>
					<h2><?php echo $rowlocdetail['title'];?></h2>
					<h3>
						<!--Code for 24 vs 12 hour time format for LISTING Yogi -->
						<?php
						echo $displayTime2.' &bull; ';
						echo $categoryname[$n]; ?>
						<ul class="btnList">
							<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>">Appeller</a</li>
							<?php
							$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
								if(stripos($ua,'android') != true) { ?>
									<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $lat2; ?>:<?php echo $lon2; ?>')">Ajouter un lieu</a></li>
								<?php }
							
							# Code for Moreinfo link Date
							$e_start_rpt	= strstr($row['startrepeat']," ",true);
							$e_end_rpt		= strstr($row['endrepeat']," ",true);
							
							if($e_start_rpt != $e_end_rpt){
								$dateValue = explode('-',$ser_start_date);
							}else{
								$dateValue = explode(' ',$row['startrepeat']);
								$dateValue = explode('-',$dateValue[0]);
							}
							
							?>	
							<li><a class="button small" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">Plus d’informations</a></li>
						</ul>
					</h3> 
				</li>
				
				<?php $displayTime2 = ""; $rowlocdetail['title']=""; ++$n; 
			} // End of while loop		
			
			# Date increment for loop , this will add +1 to each date loop	
			$ser_start_date = date('Y-m-d', strtotime( "$ser_start_date + 1 day" ));
		} // End of date for loop
	}// End of IF Condition ?>
</ul>
</div>

<!-- <div id="footer">&copy; <?php echo date('Y');?> <?php echo $site_name;?>, Inc. <!-- | <a href="mailto:<?php echo $email?>?subject=App Feedback">Contact Us</a> </div>  -->

<div style='display:none;'><?php echo $pageglobal['googgle_map_api_keys']; ?></div>

<!-- scripts for sliders -->
	<script type="text/javascript" src="/components/com_shines_v2.1/javascript/sliders.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider({
			  animation: "slide",
			  directionNav: false,
			  controlsContainer: ".flexslider-container"
		  });
		});
	</script>
	<script src="js/helper.js"></script>
	<!--<script src="../../mobiscroll/js/mobiscroll_spanish.js" type="text/javascript"></script>-->
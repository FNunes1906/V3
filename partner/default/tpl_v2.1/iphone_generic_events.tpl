<div id="featuredEvents">
	<div class="flexslider-container">
		<div class="flexslider">
		    <ul class="slides">
				<?php
				$f = 0;
				$imagecount = 0;
				$tempeventid = array();
				$homeslider1;
				$k = 0;

				if(isset($featured_filter))
				while($fearow = mysql_fetch_array($featured_filter)){
				
					$finalDescription="";
					# Image Fetched for slide show
					    $imagesrc			= strstr($fearow['description'],'src=');
						$imageurl			= strstr($imagesrc,'http');
						$singleimagearray	= explode('"',$imageurl);
						if($singleimagearray[0] == ""){
							$singleimagearray[0] = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_image.png";
						}
					# end
					
					# Coded By Akash
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
					
						if($fearow['timestart']=='12:00 AM' && $fearow['timeend']=='11:59 PM'){   
							$displayTime.=JText::_('EV_ALL_DAY');
						}		
						else{
							$displayTime.= $fearow['timestart'];
							if ($fearow['timeend'] != '11:59 PM' ){
								$displayTime.="-".$fearow['timeend'];
							}
						}
					
					}else{
					
						$stime = date("H:i", strtotime($fearow['timestart']));
						$etime = date("H:i", strtotime($fearow['timeend']));
						
						if($stime=='00:00' && $etime=='23:59'){   
							$displayTime.=JText::_('EV_ALL_DAY');
						}		
						else{
							$displayTime.= $stime;
							if ($etime!='23:59' ){
								$displayTime.="-".$etime;
							}
						}
					} # End By Akash
					
					if(in_array($fearow['ev_id'], $tempeventid)){
					}else{
						if($imagecount<5){?> 
					    	<li>
							<a href="/components/com_shines_v2.1/events_details.php?eid=<?php echo $fearow['rp_id'];?>&y=<?php echo $fearow['Eyear'];?>&m=<?php echo $fearow['Emonth'];?>&d=<?php echo $fearow['EDate'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>&catId=<?php echo $cat_id;?>"><img src="<?php echo $singleimagearray[0];?>" /></a>
					    		<div class="flex-caption">
					    			<h1><?php echo $fearow['summary'];?></h1>
					    			<h2><?php echo $fearow['title'];?></h2>
					    			<h3><?php echo $displayDate;?> &bull;
										<!--below Varialbe for 24 vs 12 hours time format for HOME SLIDER yogi-->
										<?php echo $displayTime; ?>
									</h3>
					    		</div> <!-- caption -->
					    	</li>
							<?php
							$displayTime = "";
							++$imagecount;/*5 featured event counter */
							$tempeventid[] = $fearow['ev_id'];
						}
					} ++$f; ++$k;
				}?>
			</ul>
		</div>
	</div>
</div> <!-- featured events -->

<div class="section">
	<!--Code for Mobiscroll NEW date picker - Yogi START -->
	<input style="display: none;" type="text" name="test_default" id="test_default" onChange="redirecturl(this.value);"/>
	<label for="test_default" class="ui-btn-hidden"><?php echo JText::_('DP_EVENT_BY_DAY'); ?></label>
	<!--Code for Mobiscroll NEW date picker - Yogi END -->
	
	<!--Code for Event Category drop down Yogi Start -->
		<form id="event_cat_form" class="cls_event_cat_form" autocomplete="off">
			<select name="category_id" onChange="redirecturlcat(this.value)" class="event_cat_drop">
				<option value="<?php echo $_REQUEST['category_id'];?>"><?php echo (JText::_('DD_CATEGORIES'));?></option>
				<?php while($row_cat = mysql_fetch_array($result_event_cat)){?>
					<option value="<?php echo $row_cat['id'];?>"<?php if(isset($cat_id) && $row_cat['id'] == $cat_id) echo "selected='selected'";?>>
						<?php echo ucfirst($row_cat['name']);?>
					</option>
				<?php }?>
			</select>
			<input type="hidden" name="hdn_subcat_id" id="hdn_subcat_id" value="<?php echo $_REQUEST['subcat_id'];?>"/>
		</form>
	<!--Code for Event Category drop down Yogi End -->	
</div>

<?php
/* 
* Result  : display banner for category
* Request : Fetching Title from category id
*/
if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != ''){
	$bann_cat_name	 = $objEvent->select_category_info($_REQUEST['category_id']);
	$id				 = $bann_cat_name[0];
	$banner_cat_name = $bann_cat_name[1];
	$ua				 = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { ?>
		<div class="iphoneads" style="vertical-align:bottom;"><?php m_show_banner('android-'.$banner_cat_name.'-screen'); ?></div>
	<?php }else {?>
		<div class="iphoneads" style="vertical-align:bottom;"><?php m_show_banner('iphone-'.$banner_cat_name.'-screen');?></div>
	<?php }
}?>	
<!--Code End -->

<div id="main" role="main">
	<?php
	if($lan == "English (United Kingdom)"){
		if($todaestring != null){
			echo "<h1>$todaestring</h1>";
		}elseif($seachStartFullDate == $searchEndFullDate){
			echo "<h1>$seachStartDate</h1>";
		}
	}else{
		if($todaestring != null){
			$todaestring =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));
			echo "<h1>$todaestring";?><?php echo "</h1>";
		}elseif($seachStartFullDate == $searchEndFullDate){
			$seachStartDate =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $fromMonth, $fromDay, $fromYear))));
			$searchEndDate  =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $tomonth, $today, $toyear))));	
			echo "<h1>$seachStartDate";?><?php echo "</h1>";
		}
	}?>

<ul id="eventList" class="mainList" ontouchstart="touchStart(event,'eventList');" ontouchend="touchEnd(event);" ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
	<?php 
	$n = 0;
	if($seachStartDate == $searchEndDate || !isset($_REQUEST['eventdate']) || $_REQUEST['eventdate'] == ''){
		if(isset($rec) && $rec != ''){
			while($row = mysql_fetch_array($rec)){

				# Fetch event data from "event" table
				$evDetails 	= $objEvent->ev_from_id($row['eventid']);
				$evrawdata 	= unserialize($evDetails['rawdata']);

				# Fetch category name of the event from "category" table
				$ev_cat 		= $objEvent->cat_from_id($evDetails['catid']);
				$categoryname[] = $ev_cat->title;

				# Fetch Event detail from "event detail" table
				$rowvevdetail = $objEvent->evdetail_from_id($row['eventdetail_id']);

				# Fetch event location detail from "location" table
				if((int) ($rowvevdetail['location'])){
						$rowlocdetail	= $objEvent->location_from_id($rowvevdetail['location']);
						$lat2			= $rowlocdetail["geolat"];
						$lon2			= $rowlocdetail["geolon"];
						$lon2 = $rowlocdetail['geolon'];
				}

				// Coded By Akash
				$displayTime2 = '';
				if($time_format == "12"){
					if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59 PM'){   
						$displayTime2.=JText::_('EV_ALL_DAY');
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
						$displayTime2.=JText::_('EV_ALL_DAY');
					}else{
						$displayTime2.= $stime;
						if($etime!='23:59' ){
							$displayTime2.="-".$etime;
						}
					}
				}// End By Akash
				
				# Code for Moreinfo link Date
				$e_start_rpt	= strstr($row['startrepeat']," ",true);
				$e_end_rpt		= strstr($row['endrepeat']," ",true);
				
				if($e_start_rpt != $e_end_rpt){
					$dateValue = explode('-',$single_day_date);
				}else{
					$dateValue = explode(' ',$row['startrepeat']);
					$dateValue = explode('-',$dateValue[0]);
				}
				?>

				<li class="block_link">
					<a style="padding-bottom: 10px;" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>&catId=<?php echo $cat_id;?>">	
						<h1><?php echo $rowvevdetail['summary'];?></h1>
						<h2 style="padding: 3px 0px 7px;"><?php echo $rowlocdetail['title'];?></h2>
						<!--Code for 24 vs 12 hour time format for LISTING Yogi -->
						<?php echo $displayTime2.' &bull; ';echo $categoryname[$n]; ?>
					</a>
					<h3>
						<ul class="btnList">
							<?php if(trim($rowlocdetail['phone']) != '') { ?>
								<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>"><?php echo JText::_('CALL'); ?></a</li>
							<?php } ?>
							<?php
							$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
								if(stripos($ua,'android') != true) { ?>
									<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $lat2; ?>:<?php echo $lon2; ?>')"><?php echo JText::_('CHECK_IN'); ?></a></li>
								<?php } ?>
								
							<li><a class="button small" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>&catId=<?php echo $cat_id;?>"><?php echo JText::_('MORE_INFO'); ?></a></li>
						</ul>
					 <a href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>&catId=<?php echo $cat_id;?>"><div style="width: 100%;line-height: 28px;">&nbsp;</div></a></h3> 
				</li>
				
				<?php $displayTime2 = ""; $rowlocdetail['title']=""; ++$n; 
			}// End of while loop
		}else{?>
				<li class="block_link">
					<div style='text-align:center;font-weight:bold;'><br/><?php echo JText::_("LOC_RES");?></div>
				</li>	
		<?php }
	# If search start and end date are different	
	}else{
		$rec_counter = 0;
		for($x=1;$ser_start_date <= $ser_end_date;$x++){
			
			$dateArray		= explode('-',$ser_start_date);
			$ev_toyear		= $dateArray[0];
			$ev_tomonth		= $dateArray[1];
			$ev_today		= $dateArray[2];
			
			unset($ev_arr_rr_id);
			unset($categoryname);
			$n = 0;
			
			if($lan == "English (United Kingdom)"){
				$disp_date = date('l, j M', mktime(0, 0, 0, $ev_tomonth, $ev_today, $ev_toyear));
			}else{
				$disp_date =  iconv('ISO-8859-2', 'UTF-8',ucwords(strftime ('%a, %b %d',mktime(0, 0, 0, $ev_tomonth, $ev_today, $ev_toyear))));	
			}
			
			# Function to fetch Event for given date
			$ev_rec_filter 	= $objEvent->fetch_ev_for_given_date($arrstrcat,$ev_toyear,$ev_tomonth,$ev_today,$totalHours,$totalMinutes,$totalSeconds);
			mysql_set_charset("UTF8");
			
			while($ev_row_filter = mysql_fetch_array($ev_rec_filter)){
				$ev_arr_rr_id[] = $ev_row_filter['rp_id'];
			}

			if (count($ev_arr_rr_id)){
				$ev_strchk	= implode(',',$ev_arr_rr_id);
			}else{
				$ev_strchk	= 0;
			}	
			
			$ev_rec	= $objEvent->select_events_from_rpid($ev_strchk);
			
			if(mysql_num_rows($ev_rec) > 0){
				$rec_counter = 1;
				if($x == 1){
					echo "<h1 id='datezig'>$disp_date</h1>";
				}else{
					echo "<h1 id='datezig'>$disp_date</h1>";
				}
			
				while($row = mysql_fetch_array($ev_rec)){	
					
					# Fetch Event detail from "event detail" table
					$evDetails	= $objEvent->ev_from_id($row['eventid']);
					$evrawdata 	= unserialize($evDetails['rawdata']);

					# Fetch category name of the event from "category" table
					$ev_cat = $objEvent->cat_from_id($evDetails['catid']);
					$categoryname[] = $ev_cat->title;

					# Fetch Event detail from "event detail" table
					$rowvevdetail = $objEvent->evdetail_from_id($row['eventdetail_id']);;

					# Fetch event location detail from "location" table
					if ((int) ($rowvevdetail['location'])){
						$rowlocdetail = $objEvent->location_from_id($rowvevdetail['location']);
						$lat2 = $rowlocdetail["geolat"];
						$lon2 = $rowlocdetail["geolon"];
					}

					// Coded By Akash
					$displayTime2 = '';
					if($time_format == "12"){
						if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59 PM'){   
							$displayTime2.=JText::_('EV_ALL_DAY');
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
							$displayTime2.=JText::_('EV_ALL_DAY');
						}else{
							$displayTime2.= $stime;
							if($etime!='23:59' ){
								$displayTime2.="-".$etime;
							}
						}
					}// End By Akash	
					
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

					<li class="block_link">
						<a style="padding-bottom: 10px;" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">
							<h1><?php echo $rowvevdetail['summary'];?></h1>
							<h2 style="padding: 3px 0px 7px;"><?php echo $rowlocdetail['title'];?></h2>
							<!--Code for 24 vs 12 hour time format for LISTING Yogi -->
							<?php echo $displayTime2.' &bull; '; echo $categoryname[$n]; ?>
						</a>
						<h3>
							<ul class="btnList">
								<?php if(trim($rowlocdetail['phone']) != '') { ?>
								<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '',$rowlocdetail['phone'])?>"><?php echo JText::_('CALL'); ?></a</li>
								<?php } ?>
								<?php
								$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
									if(stripos($ua,'android') != true) { ?>
										<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $lat2; ?>:<?php echo $lon2; ?>')"><?php echo JText::_('CHECK_IN'); ?></a></li>
									<?php }	?>	
								<li><a class="button small" href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>"><?php echo JText::_('MORE_INFO'); ?></a></li>
							</ul>
						<a href="events_details.php?eid=<?php echo $row['rp_id'];?>&d=<?php echo $dateValue[2];?>&m=<?php echo $dateValue[1];?>&Y=<?php echo $dateValue[0];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>"><div style="width: 100%;line-height: 28px;">&nbsp;</div></a></h3> 
					</li>
					
					<?php $displayTime2 = ""; $rowlocdetail['title']=""; ++$n; 
			} // End of while loop
			} // End of IF condition	
			
			# Date increment for loop , this will add +1 to each date loop	
			$ser_start_date = date('Y-m-d', strtotime( "$ser_start_date + 1 day" ));
		} // End of date for loop
		if($rec_counter == 0):?>
			<li class="block_link">
				<div style='text-align:center;font-weight:bold;'><br/><?php echo JText::_("LOC_RES");?></div>
			</li>
		<?php endif;
	}// End of IF Condition ?>
</ul>
</div>

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
	<!--<script src="../../mobiscroll/js/mobiscroll-1.5.1.js" type="text/javascript"></script>-->
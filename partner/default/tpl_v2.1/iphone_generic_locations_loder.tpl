<!-- CODE ADDED BY AKASH FOR SLIDER -->
<div id="featuredEvents">
	<div class="flexslider-container">
		<div class="flexslider">
		    <ul class="slides">
			<?php
			$f=0;
			$imagecount = 0;
			$templocid = array();
			$finalDescription = "";
			while($fealoc=mysql_fetch_array($featured_loc)){

			/*Image FEtched for slide show*/
				if($fealoc['image'] == ""){
				$singleimagearray = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_loc.png"; }
				else{
				$imageurl = "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/".$fealoc['image'];
				$singleimagearray = $imageurl;
				}
			/*end*/
			if(in_array($fealoc['loc_id'], $templocid)){
			}else{
			if($imagecount<5){
			
			?> 
			<!-- creating loop for slider -->
		    	<li>
				<a href="/components/com_shines_v2.1/diningdetails.php?did=<?php echo $fealoc['loc_id'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>"><img  src="<?php echo $singleimagearray;?>" /></a> 
		    		<div class="flex-caption">
		    			<h1><?php echo $fealoc['title'] ;?></h1>
		    			<h2><?php echo $fealoc['category'] ;?></h2>
		    			<h3 style="font-size: 12px;text-transform:none;">
							<?php
							/*Replace images from description */
							$strArray = explode('<img',$fealoc['description']);
							   if(isset($strArray) && $strArray != ''){
							    for($i = 0; $i <= count($strArray); ++$i){
            
	   							# Changed for error log
								$strFound = '';
								
						             if(isset($strArray[$i]) && !empty($strArray[$i])){
							 	   $strFound = strpos($strArray[$i],'" />');
							   	}
						            
						            if(isset($strFound) && $strFound != ''){
							             $s = explode('" />',$strArray[$i]);
							             $strConcat = $s[1];
						            }else{
						             		# put if conditoin for error log
								   	if(!empty($strArray[$i]))
								      		 $strConcat = $strArray[$i];
						            }
						           isset($strConcat)?$finalDescription .= $strConcat:'';
						         	$finalDescription=str_replace("<br />","",$finalDescription);
								$strConcat='';
						           }
								/* lenth of the description count 110 char */
							   if(strlen($finalDescription)>="110"){
									$strProcess12 = substr(strip_tags($finalDescription), 0 , 110);
									$strInput1 = explode(' ',$strProcess12);
									$str12 = array_slice($strInput1, 0, -1);
									//$str12 = strip_tags($str12);
									echo implode(' ',$str12).'...';
								}else{
									$finalDescription = strip_tags($finalDescription);
									echo $finalDescription;
								}
							   }
							?>
						</h3>
		    		</div> <!-- caption -->
		    	</li>
				<!-- End of the loop for slider -->
			<?php
			$finalDescription = "";
			++$imagecount;/*5 featured event counter */
			$templocid[] = $fealoc['loc_id'];
			}
			}
			++$f;
			}
			?>

			</ul>
		</div>
	</div>
</div>  
<!-- featured events -->
<?php
/* 
Code Begin 
Result  : display banner for category
Request : Fetching category title from category id
Developer:Rinkal 
Last update Date:10-02-2014
*/
$loc_cat = $objloclist->fetch_banner_category($category_id);
while($bann_cat_name = mysql_fetch_array($loc_cat))
{
	$banner_cat_name = $bann_cat_name['title'];
}
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == True) { ?>
	<div class="iphoneads" style="vertical-align:bottom;">
		<?php m_show_banner('android-'.$banner_cat_name.'-screen'); ?>
	</div>
	<?php } 
else {
	?>
	<div class="iphoneads" style="vertical-align:bottom;">
		<?php m_show_banner('iphone-'.$banner_cat_name.'-screen');?>
	</div>
	<?php } ?>
<!--Code End -->

<div id="main" role="main">
	<?php # Filter Category list drop down code BEGIN ?>
	<div id="searchBar">
		<form id="placeCatForm" autocomplete="off">
				
			<?php // fetch location categories
			$recsub = $objloclist->fetch_location_categories($category_id); ?>

			<select name="d" onChange="redirecturl(this.value)" >
				<option value="0"><?php echo JText::_('SELECT_A_CAT'); ?></option>
				<option value="0"><?php echo JText::_('SELECT_ALL'); ?></option>
				<option value="alp" <?php if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat'] == 'alp') {?> selected <?php }?>><?php echo JText::_('ALPHABETIC'); ?></option>
				<?php
				while($rowsub = mysql_fetch_array($recsub)){
					$querycount = "SELECT * FROM jos_jev_locations WHERE published=1 and loccat=".$rowsub['id'];
					if($filter_order != "")
						$querycount .= " ORDER BY title ASC ";
					else
						$querycount .= " ORDER BY ordering ASC";
						
					$reccount = mysql_query($querycount) or die(mysql_error());
					if(mysql_num_rows($reccount)){
						if(($_REQUEST['filter_loccat'] != 'alp') || ($_REQUEST['filter_loccat'] != '0')){?>
							<option value="<?php echo $rowsub['id'];?>" <?php if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat']==$rowsub['id']) {?> selected <?php }?>><?php echo $rowsub['title'];?></option>
				<?php }}
				}?>
			</select>
		</form>
	<?php # Filter Category list drop down code END ?>
		
		<?php # Search input box and submit button BEGIN ?>
		<div onclick="divopen('q1')">
			<span id="searchIcon">s</span>
			<form action="" method="post" name="location_form" id="searchForm" autocomplete="off">
				<fieldset>
					<input type="search" name="searchvalue" value="" size="15"/>
					<input type="submit" name="search_rcd" value="<?php echo JText::_('SEARCH'); ?>"/>
				</fieldset>
			</form>
		</div>
		<?php # Search input box and submit button END ?>
	</div>
	
	<ul id="placesList" class="mainList">
		<?php # If search value is NOT entered in search box BEGIN
		if(isset($_POST['search_rcd'])!= JText::_('SEARCH')) { 
			$default_values = array(
			"lat1" => $lat1,
			"lon1" => $lon1,
			"allCatIds" => $allCatIds,
			"subquery" => $subquery,
			"filter_loccat" =>$filter_loccat,
			"start_at" => $start_at,
			"entries_per_page" => $entries_per_page
			);
			// fetch locations list using below function
			$rec = $objloclist->fetchlocationRecord($default_values); 
			$ajaxquery1 = $objloclist->ajax_query1;	
			$ajaxquery2 = $objloclist->ajax_query2;
			$n   = 0;
			if(mysql_num_rows($rec) > 0){
				while($row=mysql_fetch_assoc($rec)){
				
				$distance = distance($lat1, $lon1, $row['geolat'],  $row['geolon'], $dunit);?>
				<li>
					<h1><?php echo $row['title'];?></h1>
					<p><?php echo stripJunk(showBrief($row['description'],30)); ?></p>
					<p class="distance"><?php echo round($distance,1); ?>&nbsp;<?php echo $dunit;?> <?php echo JText::_('AWAY'); ?></p>
					<ul class="btnList">
						<?php if(trim($row['phone'] != '')) {
							  if (isset($_REQUEST['bIPhone'])=='0'){?>
									<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>"><?php echo JText::_('CALL'); ?></a></li>
						<?php } else { ?>
									<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>"><?php echo JText::_('CALL'); ?></a></li>
						<?php } } ?>

						<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $row['geolat']; ?>:<?php echo $row['geolon']; ?>')"><?php echo JText::_('CHECK_IN'); ?></a></li>
						<li><a class="button small" href="diningdetails.php?did=<?php echo $row['loc_id'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>"><?php echo JText::_('MORE_INFO'); ?></a></li>
						<li><a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $row['geolon']; ?>:<?php echo $row['geolat']; ?>')"></a></li>
					</ul>
				</li>
			<?php }	
			if(mysql_num_rows($rec) >= $entries_per_page){	?>
				<!--Infinite Scroller Begin	-->
				<script type="text/javascript">
					$(document).ready(function() { 
						var lpage = 0;

						$(window).scroll(function(e) {
							e.preventDefault();
							if($(window).scrollTop() == $(document).height() - $(window).height()) {
								lpage = lpage + 1;
								//$('div#loadMoreComments').show();
								$.ajax({
									dataType : "html" ,
									contentType : "application/x-www-form-urlencoded" ,
									url: "generic_locations_loder_ajax.php?ajaxquery1=<?php echo $ajaxquery1?>&ajaxquery2=<?php echo $ajaxquery2?>&lat1=<?php echo $lat1?>&lon1=<?php echo $lon1?>&dunit=<?php echo $dunit?>&entries_per_page=<?php echo $entries_per_page?>&lpage="+lpage ,
								//	alert(url);
									success: function(data, textStatus, jqXHR){
										//setTimeout(callAjax, my_delay);
										
										if(data){
											  
											$('#placesList').append('<div id="loadMoreComments"> <center><b><?php echo JText::_("LOADING");?></b></center></div>');
											$("#placesList").append(data);
											$('div#loadMoreComments').fadeOut(300);
										}else{
											$('div#loadMoreComments').hide();
											$('#placesList').append('<div id="loadMoreComments"> <center><br><?php echo JText::_("NO_MORE_RECORDS");?></center></div>');
										}
									},
									error: function(jqXHR, textStatus, exception){
             								if (jqXHR.status === 0) { alert('Not connect.\n Verify Network.'); }
              								else if (jqXHR.status == 404) { alert('Requested page not found. [404]'); } 
              								else if (jqXHR.status == 500) { alert('Internal Server Error [500].'); } 
              								else if (exception === 'parsererror') { alert('Requested JSON parse failed.'); }
              								else if (exception === 'timeout') { alert('Time out error.'); }
             								else if (exception === 'abort') { alert('Ajax request aborted.'); }
             								else { alert('Uncaught Error.\n' + jqXHR.responseText); }
            							}
								});
								
							}
						});
					
						//}
					});
			    </script>
				<!--Infinite Scroller Ends	-->
			<?php } 
			 } else {
					echo "<div style='text-align:center;font-weight:bold;'><br/>".JText::_("LOC_RES")."</div>";
					}
		} 
		# END 
		# If search value is entered BEGIN - [Regular listing]
		if(isset($_POST['search_rcd']) && $_POST['search_rcd']== JText::_('SEARCH')){
			
			$searchdata = addslashes(trim($_POST['searchvalue']));
			$search_values = array(
			"filter_loccat" => $_REQUEST['filter_loccat'],
			"search_rcd" => $_POST['search_rcd'],
			"allCatIds" => $allCatIds,
			"searchdata" => $searchdata,
			"start_at" => $start_at,
			"entries_per_page" => $entries_per_page
			);
			
			$searchResult = $objloclist->fetchSearchRecord($search_values); 
			$ajaxquery1 = $objloclist->ajax_ser_query;
			
			if(mysql_num_rows($searchResult) > 0){
				while($data = mysql_fetch_array($searchResult)) {
					$title=$data['title'];
					$lat2=$data['geolat'];
					$lon2=$data['geolon'];
				
				$dist = distance($lat1, $lon1, $lat2, $lon2, $dunit);?>
				<li>
					<h1><?php echo utf8_encode($data['title'])?></h1>
					<p><?php echo stripJunk(showBrief(strip_tags(utf8_encode($data['description'])),30)); ?></p>
					<p class="distance"><?php echo round($dist,1); ?>&nbsp;<?php echo $dunit?> <?php echo JText::_('AWAY'); ?></p>
					<ul class="btnList">
						<?php if(trim($data['phone'] != '')) {
								if (isset($_REQUEST['bIPhone']) == '0'){?>
							   	<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>"><?php echo JText::_('CALL'); ?></a></li>
						<?php } else { ?>
							   	<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>"><?php echo JText::_('CALL'); ?></a></li>
						<?php } } ?>
						
						<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $data['geolat']; ?>:<?php echo $data['geolon']; ?>')"><?php echo JText::_('CHECK_IN'); ?></a></li>
						<li><a class="button small" href="diningdetails.php?did=<?php echo $data['loc_id']?>&lat=<?php echo $lat1?>&lon=<?php echo $lon1?>"><?php echo JText::_('MORE_INFO'); ?></a></li>
						<li><a  href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $data['geolon']; ?>:<?php echo $data['geolat']; ?>')"></a></li>
					</ul>
				<?php } 
				if(mysql_num_rows($searchResult) >= $entries_per_page){	?>
					
					<!--Infinite Scroller Begin	-->
					<script type="text/javascript">
						$(document).ready(function() { 
							var lpage = 0;
							$(window).scroll(function(e) {
								e.preventDefault();
								if($(window).scrollTop() == $(document).height() - $(window).height()) {
									lpage = lpage + 1;
									$.ajax({
										dataType : "html" ,
										contentType : "application/x-www-form-urlencoded" ,
										url: "generic_locations_loder_search_ajax.php?ajaxquery1=<?php echo addslashes($ajaxquery1)?>&lat1=<?php echo $lat1?>&lon1=<?php echo $lon1?>&dunit=<?php echo $dunit?>&entries_per_page=<?php echo $entries_per_page?>&lpage="+lpage ,
										success: function(data, textStatus, jqXHR){
											if(data){  
												$('#placesList').append('<div id="loadMoreComments"> <center><b>Loading</b></center></div>');
												$("#placesList").append(data);
												$('div#loadMoreComments').fadeOut(300);
											}else{
											$('div#loadMoreComments').hide();
											$('#placesList').append('<div id="loadMoreComments"> <center><br><?php echo JText::_("NO_MORE_RECORDS");?></center></div>');
											}
										},
										error: function(jqXHR, textStatus, exception){
	             								if (jqXHR.status === 0) { alert('Not connect.\n Verify Network.'); }
	              								else if (jqXHR.status == 404) { alert('Requested page not found. [404]'); } 
	              								else if (jqXHR.status == 500) { alert('Internal Server Error [500].'); } 
	              								else if (exception === 'parsererror') { alert('Requested JSON parse failed.'); }
	              								else if (exception === 'timeout') { alert('Time out error.'); }
	             								else if (exception === 'abort') { alert('Ajax request aborted.'); }
	             								else { alert('Uncaught Error.\n' + jqXHR.responseText); }
	            							}
									});
								}
							});
						});
			   		</script>
					<!--Infinite Scroller Ends	-->		
				<?php } 
				 } else {
					echo "<div style='text-align:center;font-weight:bold;'><br/>".JText::_("LOC_RES")."</div>";
					}
				 } ?>
			</li>
	</ul>
	
	<div style='display:none;'>
	<?php echo $pageglobal['googgle_map_api_keys']; ?>
	</div>
</div>
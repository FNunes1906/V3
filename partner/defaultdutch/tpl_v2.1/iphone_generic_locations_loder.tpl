<div id="main" role="main">
	<?php # Filter Category list drop down code BEGIN ?>
	<div id="searchBar">
		<form id="placeCatForm" autocomplete="off">
			<?php	
			$recsubsql = "SELECT c . * , pc.title AS parenttitle FROM jos_categories AS c LEFT JOIN jos_categories AS pc ON c.parent_id = pc.id LEFT JOIN jos_categories AS mc ON pc.parent_id = mc.id LEFT JOIN jos_categories AS gpc ON mc.parent_id = gpc.id WHERE c.section = 'com_jevlocations2' AND (c.id =".$category_id." OR pc.id =".$category_id." OR mc.id =".$category_id." OR gpc.id =".$category_id.") AND c.published=1 ORDER BY c.title";
			$recsub    = mysql_query($recsubsql) or die(mysql_error());	
			?>

			<select name="d" onChange="redirecturl(this.value)" >
				<option value="0">Kies een categorie</option>
				<option value="0">Alle</option>
				<option value="alp" <?php if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat'] == 'alp') {?> selected <?php }?>>Alfab&#233;tico</option>
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
			<a id="searchIcon" href="#">s</a>
			<form action="" method="post" name="location_form" id="searchForm" autocomplete="off">
				<fieldset>
					<input type="search" name="searchvalue" value="" size="15"/>
					<input type="submit" name="search_rcd" value="Zoeken"/>
				</fieldset>
			</form>
		</div>
		<?php # Search input box and submit button END ?>
	</div>
	
	<ul id="placesList" class="mainList">
		<?php # If search value is NOT entered in serch box BEGIN ?>
		<?php
		if(isset($_POST['search_rcd'])!="Zoeken") { 
				$query  = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".$subquery;
				$query1 = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180))";
				$query2 = "cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".$subquery;
			
			if($filter_loccat == 'Featured'){
				$query  .= " AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ";
				$query2 .= " AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ";
			}elseif($filter_loccat != 0 && $_REQUEST['filter_loccat'] != 'alp'){
				$query  .= " AND loccat = $filter_loccat ";
				$query2 .= " AND loccat = $filter_loccat ";
			}
			
			if(($filter_order != "") || ($_REQUEST['filter_loccat'] == 'alp')){
				$query  .= " ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$query2 .= " ORDER BY title ASC LIMIT ";
			}else{
				$query  .= " ORDER BY dist ASC LIMIT " .$start_at.','.$entries_per_page;
				$query2 .= " ORDER BY dist ASC LIMIT ";
			}
			$ajaxquery1 = $query1;	
			$ajaxquery2 = $query2;
			
			$rec = mysql_query($query) or die(mysql_error());
			$n   = 0;
			
			while($row=mysql_fetch_assoc($rec)){
				$distance = distance($lat1, $lon1, $row['geolat'],  $row['geolon'], $dunit);?>
				<li>
					<h1><?php echo $row['title'];?></h1>
					<p><?php echo stripJunk(showBrief($row['description'],30)); ?></p>
					<p class="distance"><?php echo round($distance,1); ?>&nbsp;<?php echo $dunit;?> weg</p>
					<ul class="btnList">
						<?php if (isset($_REQUEST['bIPhone'])=='0'){?>
									<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>">Bel</a></li>
						<?php } else { ?>
									<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>">Bel</a></li>
						<?php } ?>

						<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $row['geolat']; ?>:<?php echo $row['geolon']; ?>')">Inchecken</a></li>
						<li><a class="button small" href="diningdetails.php?did=<?php echo $row['loc_id'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">Meer informatie</a></li>
						<li><a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $row['geolon']; ?>:<?php echo $row['geolat']; ?>')"></a></li>
					</ul>
				</li>
			<?php ++$n;
			}?>
				<!--Infinite Scroller Begin	-->
				<div id="loadMoreComments" style="display:none;" > <center>Loading...</center></div>	
				<script type="text/javascript">
					 $(document).ready(function() { 
					 var lpage = 0;
						$(window).scroll(function() {
						   	if($(window).scrollTop() == $(document).height() - $(window).height()) {
								lpage = lpage + 1;
								$('div#loadMoreComments').show();
								$.ajax({
									dataType : "html" ,
									contentType : "application/x-www-form-urlencoded" ,
									url: "generic_locations_loder_ajax.php?ajaxquery1=<?php echo $ajaxquery1?>&ajaxquery2=<?php echo $ajaxquery2?>&lat1=<?php echo $lat1?>&lon1=<?php echo $lon1?>&dunit=<?php echo $dunit?>&entries_per_page=<?php echo $entries_per_page?>&lpage="+lpage ,
									success: function(html) {
										if(html){		
											$("#placesList").append(html);
											$('div#loadMoreComments').hide();
										}else{		
											$('div#loadMoreComments').replaceWith("<center><h1 style='color:red'>End of Record.</h1></center>");
										}
									}
								});
							}
						});
					});
				</script>
				<!--Infinite Scroller Ends	-->
		<?php }
		# END 
		
		# If search value is entered BEGIN - [Regular listing]
		if(isset($_POST['search_rcd'])=="Zoeken"){
			$searchdata = $_POST['searchvalue'];
		
			if((isset($filter_loccat)==0) || ($_REQUEST['filter_loccat']=='alp') && ($_POST['search_rcd']=="Zoeken")){
				$search_query1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%' ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%' ORDER BY title ASC LIMIT ";
			}elseif($filter_loccat == 'Featured' && $_POST['search_rcd'] == "Zoeken" ){
				$search_query1 = "select * from `jos_jev_locations` $customfields3_table where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%'  AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
				$ajaxquery1 = "select * from `jos_jev_locations` $customfields3_table where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%'  AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ORDER BY title ASC LIMIT ";
			}elseif($_POST['search_rcd'] == "Zoeken"){
				$search_query1="select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%'  or description like '%$searchdata%' ORDER BY title ASC";
				$ajaxquery1 = "select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and loccat=$filter_loccat and title like '%$searchdata%' or description like '%$searchdata%' ORDER BY title ASC LIMIT ";
			}
				
			$search_query = mysql_query($search_query1) or die(mysql_error());
			
			while($data = mysql_fetch_array($search_query)) {
				$title=$data['title'];
				$lat2=$data['geolat'];
				$lon2=$data['geolon'];
				
				$dist = distance($lat1, $lon1, $lat2, $lon2, $dunit);?>
				<li>
					<h1><?php echo utf8_encode($data['title'])?></h1>
					<p><?php echo stripJunk(showBrief(strip_tags(utf8_encode($data['description'])),30)); ?></p>
					<p class="distance"><?php echo round($dist,1); ?>&nbsp;<?php echo $dunit?> weg</p>
					<ul class="btnList">
						<?php if (isset($_REQUEST['bIPhone']) == '0'){?>
							   	<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>">Bel</a></li>
						<?php } else { ?>
							   	<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>">Bel</a></li>
						<?php } ?>
						
						<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $data['geolat']; ?>:<?php echo $data['geolon']; ?>')">Inchecken</a></li>
						<li><a class="button small" href="diningdetails.php?did=<?php echo $data['loc_id']?>&lat=<?php echo $lat1?>&lon=<?php echo $lon1?>">Meer informatie</a></li>
						<li><a  href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $data['geolon']; ?>:<?php echo $data['geolat']; ?>')"></a></li>
					</ul>
				<?php } ?>
					<!--Infinite Scroller Begin	-->
					<div id="loadMoreComments" style="display:none;" > <center>Dimitrios</center></div>	
					<script type="text/javascript">
						 $(document).ready(function() { 
						 var lpage = 0;
							$(window).scroll(function() {
							   	if($(window).scrollTop() == $(document).height() - $(window).height()) {
									lpage = lpage + 1;
									$('div#loadMoreComments').show();
									$.ajax({
										dataType : "html" ,
										contentType : "application/x-www-form-urlencoded" ,
										url: "generic_locations_loder_search_ajax.php?ajaxquery1=<?php echo $ajaxquery1?>&lat1=<?php echo $lat1?>&lon1=<?php echo $lon1?>&dunit=<?php echo $dunit?>&entries_per_page=<?php echo $entries_per_page?>&lpage="+lpage ,
										success: function(html) {
											if(html){		
												$("#placesList").append(html);
												$('div#loadMoreComments').hide();
											}else{		
												$('div#loadMoreComments').replaceWith("<center><h1 style='color:red'>End of Record.</h1></center>");
											}
										}
									});
								}
							});
						});
					</script>
					<!--Infinite Scroller Ends	-->				
				<?php }
				# END
					//include("connection.php");?>
			</li>
	</ul>
	<!--Added for infinte scroll-->

	
		<?php /*if($n =='20') {
			//echo "Totoal row:".$total_rows,"entries per page:",$entries_per_page,"current page:",$current_page,"link:",$link_to;
			echo get_paginate_links($total_rows,$entries_per_page,$current_page,$link_to);
			}*/?>
		<div style='display:none;'>
		<?php echo $pageglobal['googgle_map_api_keys']; ?>
		</div>
</div>
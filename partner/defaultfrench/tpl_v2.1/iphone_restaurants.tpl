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
</div>  <!-- featured events -->

<?php
/*Device testing for banner*/
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == true) { ?>
	<div class="iphoneads" style="vertical-align:bottom;">
		<?php m_show_banner('android-restaurants-screen'); ?>
	</div>
	<?php } 
else {
	?>
	<div class="iphoneads" style="vertical-align:bottom;">
	<?php m_show_banner('iphone-restaurants-screen'); ?>
	</div>
	<?php } ?>
	
<!-- CODE END AKASH FOR SLIDER -->	

<div id="main" role="main">
	<div id="searchBar">
		<form id="placeCatForm" autocomplete="off">
			<?php	
				$recsubsql="SELECT c . * , pc.title AS parenttitle FROM jos_categories AS c LEFT JOIN jos_categories AS pc ON c.parent_id = pc.id LEFT JOIN jos_categories AS mc ON pc.parent_id = mc.id LEFT JOIN jos_categories AS gpc ON mc.parent_id = gpc.id WHERE c.section = 'com_jevlocations2' AND (c.id =152 OR pc.id =152 OR mc.id =152 OR gpc.id =152) AND c.published=1 ORDER BY c.title";
				$recsub=mysql_query($recsubsql) or die(mysql_error());	?>
			<select name="d" onChange="redirecturl(this.value)" >
			<option value="0">Recherche par catégorie</option>
			<option value="0">Tout</option>
			<option value="alp" <?php if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat'] == 'alp') {?> selected <?php }?>>
			Alphabétique
			</option>
			<?php	while($rowsub=mysql_fetch_array($recsub))
			{
				$querycount = "SELECT * FROM jos_jev_locations WHERE published=1 and loccat=".$rowsub['id'];
				if($filter_order != "")
					$querycount .= " ORDER BY title ASC ";
				else
				$querycount .= " ORDER BY ordering ASC";
				$reccount=mysql_query($querycount) or die(mysql_error());
				if(mysql_num_rows($reccount)){
					if(($_REQUEST['filter_loccat'] != 'alp') || ($_REQUEST['filter_loccat'] != '0')){?>
						<option value="<?php echo $rowsub['id'];?>" <?php if (isset($_REQUEST['filter_loccat']) && $_REQUEST['filter_loccat']==$rowsub['id']) {?> selected <?php }?>><?php echo $rowsub['title'];?></option>
							<?php }}
					}?>
			</select>
		</form>
		
		<div onclick="divopen('q1')">
		<!-- <img width="37px" height="31px" src="/components/com_shines/images/searchIcon.png"> -->
		<a id="searchIcon" href="#">s</a>
		<form action="" method="post" name="location_form" id="searchForm" autocomplete="off">
			<fieldset>
				<input type="search" name="searchvalue" value="" size="15"/>
				<input type="submit" name="search_rcd" value="Recherche"/>
			</fieldset>
		</form>
		</div>
		</div>

		<ul id="placesList" class="mainList">
		
		<?php if(isset($_POST['search_rcd'])!="Recherche") { ?>
			<?php
			$query = "SELECT *,(((acos(sin(($lat1 * pi() / 180)) * sin((geolat * pi() / 180)) + cos(($lat1 * pi() / 180)) * cos((geolat * pi() / 180)) * cos((($lon1 - geolon) * pi() / 180)))) * 180 / pi()) * 60 * 1.1515) as dist FROM jos_jev_locations $customfields3_table WHERE loccat IN (".implode(',',$allCatIds).") AND published=1 ".isset($subquery);
			if(isset($filter_loccat)){
				if($filter_loccat == 'Featured')
					$query .= " AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ";
				elseif($filter_loccat != 0 && $_REQUEST['filter_loccat'] != 'alp')
					$query .= " AND loccat = $filter_loccat ";
			}
			if(($filter_order != "") || (isset($_REQUEST['filter_loccat'])=='alp'))
				$query .= " ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;
			else 
			$query .= " ORDER BY dist ASC LIMIT " .$start_at.','.$entries_per_page;
			$rec=mysql_query($query) or die(mysql_error());
			$n=0;
			while($row=mysql_fetch_assoc($rec))
			{
				$distance = distance($lat1, $lon1, $row['geolat'],  $row['geolon'], $dunit);
				?>
				<li>
				<h1><?php echo $row['title'];?></h1>
				<p><?php echo showBrief($row['description'],30) ;?></p>
				<p class="distance"><?php echo round($distance,1); ?>&nbsp;<?php echo $dunit;?> Loin</p>
				<ul class="btnList">
				<?php if (isset($_REQUEST['bIPhone'])=='0'){?>
					<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>">Appeller</a></li>
					<?php } else { ?>
					<li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $row['phone']); ?>">Appeller</a></li>
					<?php } ?>
				
				<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $row['geolat']; ?>:<?php echo $row['geolon']; ?>')">Ajouter un lieu</a></li>
				<li><a class="button small" href="diningdetails.php?did=<?php echo $row['loc_id'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">Plus d’informations</a></li>
				<li><a href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $row['geolon']; ?>:<?php echo $row['geolat']; ?>')"></a></li>
				</ul>
				</li>
		
				<?php
				++$n;
			}
			?>
			<?php } ?>
		
		
		<?php
		if(isset($_POST['search_rcd'])=="Recherche") {$searchdata = addslashes($_POST['searchvalue']);
			?>
			<?php
		if((isset($filter_loccat)==0) || ($_REQUEST['filter_loccat']=='alp') && ($_POST['search_rcd']=="Recherche")) {$search_query1="select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%' ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;}
			
		else if($filter_loccat == 'Featured' && $_POST['search_rcd']=="Recherche" ) {$search_query1="select * from `jos_jev_locations` $customfields3_table where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%' or description like '%$searchdata%'  AND (jos_jev_locations.loc_id = jos_jev_customfields3.target_id AND jos_jev_customfields3.value = 1 ) ORDER BY title ASC LIMIT " .$start_at.','.$entries_per_page;}
			
		else if($_POST['search_rcd']=="Recherche"){
			$search_query1="select * from `jos_jev_locations` where loccat IN (".implode(',',$allCatIds).") AND published=1 and title like '%$searchdata%'  or description like '%$searchdata%' ORDER BY title ASC";}
			
			$search_query=mysql_query($search_query1) or die(mysql_error());
			
			while($data = mysql_fetch_array($search_query)) {
				$title=$data['title'];
				$lat2=$data['geolat'];
				$lon2=$data['geolon'];
				
				$dist = distance($lat1, $lon1, $lat2, $lon2, $dunit);
				?>
				<li>
				<h1><?php echo $data['title'];?></h1>
				<p><?php echo showBrief($data['description'],30); ?></p>
				<p class="distance"><?php echo round($dist,1); ?>&nbsp;<?php echo $dunit;?> Loin</p>
				<ul class="btnList">
				<?php if (isset($_REQUEST['bIPhone'])=='0'){?>
				   <li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>">Appeller</a></li>
					<?php } else { ?>
				   <li><a class="button small" href="tel:<?php echo str_replace(array(' ','(',')','-','.'), '', $data['phone']); ?>">Appeller</a></li>
					<?php } ?>
				<?php
				$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
				if(stripos($ua,'android') == true) { ?>
					<?php } else { ?>
					<li><a class="button small" href="javascript:linkClicked('APP30A:FBCHECKIN:<?php echo $data['geolat']; ?>:<?php echo $data['geolon']; ?>')">Ajouter un lieu</a></li>
					<?php } ?>
					<li><a class="button small" href="diningdetails.php?did=<?php echo $data['loc_id'];?>&lat=<?php echo $lat1;?>&lon=<?php echo $lon1;?>">Plus d’informations</a></li>
					<li><a  href="javascript:linkClicked('APP30A:SHOWMAP:<?php echo $data['geolon']; ?>:<?php echo $data['geolat']; ?>')"></a></li>
				</ul></li>
				<?php } ?>
		<?php }
		//include("connection.php");
		?>
		
		</ul>
		<?php 
		if(($n) =='50') {
			echo get_paginate_links($total_rows,$entries_per_page,$current_page,$link_to);
			}?>
		<div style='display:none;'>
		<?php echo $pageglobal['googgle_map_api_keys']; ?>
		</div>
</div>
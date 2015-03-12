<?php
//echo $catid;
if (count($LocationSlider) != 0){

defined('_JEXEC') or die('Restricted access');
global $var;
//include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
?>
<!-- Featured Events Slider -->	
<div class="other_slider">
	<span id="leftArrow" style="background:<?php echo $var->Header_color; ?>">
		<img alt="prev" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowLt.png" />
	</span>
	<span id="rightArrow" style="background:<?php echo $var->Header_color; ?>">
		<img alt="next" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowRt.png" />
	</span>
			<?php
			
			$f=0;
			$imagecount = 0;
			$tempeventid = array();

			foreach($LocationSlider as $fearow) :

			##Image FEtched for slide show##
				if($fearow->image == ""){
				$singleimagearray = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_loc.png"; }
				else{
				$imageurl = "http://".$_SERVER['HTTP_HOST']."/partner/".$_SESSION['partner_folder_name']."/images/stories/jevents/jevlocations/".$fearow->image;
				$singleimagearray = $imageurl;
				}
			##end##
			if(in_array($fearow->loc_id, $tempeventid)){
			}else{
			if($imagecount<10){
				if($imagecount==0){
			?> 
				<a class="selected" href="index.php?option=com_jevlocations&task=locations.detail&Itemid=<?php if(isset($_REQUEST['Itemid'])) echo $_REQUEST['Itemid'];?>&loc_id=<?php echo $fearow->loc_id;?>&se=1&title=<?php echo $fearow->alias;?>">
			<?php } else { ?>
				<!--This code is for slider part-->
				<a href="index.php?option=com_jevlocations&task=locations.detail&Itemid=<?php if(isset($_REQUEST['Itemid'])) echo $_REQUEST['Itemid'];?>&loc_id=<?php echo $fearow->loc_id;?>&se=1&title=<?php echo $fearow->alias;?>">
				<?php } ?>
				<img src="<?php echo $singleimagearray;?>" />
		    	<h3>
					<?php
					if(strlen($fearow->title)>="90"){
						$strProcess1 = substr($fearow->title, 0 , 90);
						$strInput1 = explode(' ',$strProcess1);
						$str1 = array_slice($strInput1, 1, -1);
						echo implode(' ',$str1).' ...'; 
					}else{
						echo $fearow->title;
					}						
					?>
				</h3>
		    			<!-- <p><?php echo substr($fearow->description, 0, 75);?></p> -->
		    	<p class="description">
					<?php 
					$strArray = explode('<img',$fearow->description);
					
					if(isset($strArray) && $strArray != ''){
						for($i = 0; $i <= count($strArray); ++$i){

							 # Changed for error log
							 $strFound = '';
							 
							 # put if conditoin for error log
							 if(isset($strArray[$i]) && !empty($strArray[$i])){
							  $strFound = strpos($strArray[$i],'" />');
							 }         
						   
							 if(isset($strFound) && $strFound != ''){
							  $s = explode('" />',$strArray[$i]);
							  $strConcat = strip_tags($s[1]);
							 }else{
							  # put if conditoin for error log
							  if(!empty($strArray[$i]))
							   $strConcat = $strArray[$i]; 
							 }
							 
							 isset($strConcat)?$finalDescription .= $strConcat:'';
							 //$finalDescription = strip_tags($strConcat);
							 $finalDescription=str_replace("<br />","",$finalDescription);$strConcat='';
							 
						 }
						if(strlen($finalDescription)>="140"){
							$strProcess12 = substr(strip_tags($finalDescription), 0 , 140);
							$strInput1 = explode(' ',$strProcess12);
							$str12 = array_slice($strInput1, 0, -1);
							echo implode(' ',$str12).' ...';
						}else{
							$finalDescription = strip_tags($finalDescription);
							echo $finalDescription;
						}
					}
					?>					  
				</p>
			</a>
			<?php
			$finalDescription = "";
			++$imagecount;/*5 featured event counter */
			$tempeventid[] = $fearow->loc_id;
			}
			}
			++$f;
			endforeach;
			?>
	<div id="bottomPager"></div>
</div>
<!-- Featured Events Slider End-->
<?php } ?>

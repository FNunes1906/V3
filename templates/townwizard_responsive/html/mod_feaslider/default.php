<?php
if (mysql_num_rows($FeaturedSlider) != 0){

defined('_JEXEC') or die('Restricted access');
global $var;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
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
			$tempeventid = Array();

			while($fearow = mysql_fetch_array($FeaturedSlider)){

			##Image FEtched for slide show##
				
			    $imagesrc= strstr($fearow['description'],'src=');
				$imageurl= strstr($imagesrc,'http');
				$singleimagearray = explode('"',$imageurl);
				if($singleimagearray[0] == ""){
				$singleimagearray[0] = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_image.png"; }
			##end##
			$displayTime = '';

			if($fearow['timestart']=='12:00 AM' && $fearow['timeend']=='11:59PM'){
				$displayTime.='All Day Event';
			}
			else{
			$displayTime.= $fearow['timestart'];
			if ($fearow['timeend'] != '11:59PM'){
				$displayTime.="-".$fearow['timeend'];
			}
			}
		
			if(in_array($fearow['ev_id'], $tempeventid)){
			}else{
			if($imagecount<10){
				if($imagecount==0){
			?> 
			<a class="selected" href="index.php?option=com_jevents&task=icalrepeat.detail&evid=<?php echo $fearow['rp_id'];?>&Itemid=<?php echo $_REQUEST['Itemid'];?>&year=<?php echo $fearow['Eyear'];?>&month=<?php echo $fearow['Emonth'];?>&day=<?php echo $fearow['EDate'];?>">
			<?php } else { ?>
			<!--This code is for slider part-->
			<a href="index.php?option=com_jevents&task=icalrepeat.detail&evid=<?php echo $fearow['rp_id'];?>&Itemid=<?php echo $_REQUEST['Itemid'];?>&year=<?php echo $fearow['Eyear'];?>&month=<?php echo $fearow['Emonth'];?>&day=<?php echo $fearow['EDate'];?>">
			<?php } ?>
			<img src="<?php echo $singleimagearray[0];?>" />
		    <h3>
				<?php 
				if(strlen($fearow['summary'])>="90"){
					$strProcess1 = substr($fearow['summary'], 0 , 90);
					$strInput1 = explode(' ',$strProcess1);
					$str1 = array_slice($strInput1, 1, -1);
					echo implode(' ',$str1).' ...'; 
				}else{
					echo $fearow['summary'];
				}
				?>
			</h3>
		    <p class="timePlace">
				<span><?php echo $fearow['title'];?></span>
				<time><?php echo $fearow['Date'];?> &bull; </time>
				<?php
					if($var->timeformat == "12"){
						echo $displayTime;
				   }else{
					$starttime = date("H:i", strtotime($fearow['timestart']));
					$endtime = date("H:i", strtotime($fearow['timeend']));
					$displayTime2 = '';
					 if($starttime=='00:00' && $endtime=='23:59'){   
						$displayTime2.='All Day Event';
					}
					else{
						$displayTime2.= $starttime;
						if ($endtime != '23:59'){
							$displayTime2.=" - ".$endtime;
						}
					}	
					echo $displayTime2;	
						//echo date("H:i", strtotime($fearow['timestart']))." - ".date("H:i", strtotime($fearow['timeend']));
				   }
				?>
			</p>
			<p class="description">
					  	<?php 
						   	$strArray = explode('<img',$fearow['description']);
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
									$finalDescription=str_replace("<br />","",$finalDescription);
									$finalDescription = strip_tags($finalDescription);
									$strConcat = "";
								}
							   if(strlen($finalDescription)>="140"){
									$strProcess12 = substr($finalDescription, 0 , 140);
									$strInput1 = explode(' ',$strProcess12);
									$str12 = array_slice($strInput1, 0, -1);
									echo implode(' ',$str12).' ...';
								}else{
									echo $finalDescription;
								}
								$finalDescription = "";
							}
						?>					  
			</p>
		</a>
			<?php
			++$imagecount;/*5 featured event counter */
			$tempeventid[] = $fearow['ev_id'];
			}}
			//++$datacount;
			++$f;
			}
			?>
<div id="bottomPager"></div>
</div>
<!-- Featured Events Slider End-->
<?php } ?>

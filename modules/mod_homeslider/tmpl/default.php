<?php
if (mysql_num_rows($HomeSlider) != 0){

defined('_JEXEC') or die('Restricted access');
global $var;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
?>

<!-- Featured Events Slider -->

    <div class="gallery fl">
            <a class="prev nav" style="background:<?php echo $var->Header_color; ?>"><img alt="prev" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowLt.png" /></a>
            <a class="next nav" style="background:<?php echo $var->Header_color; ?>"><img alt="next" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowRt.png" /></a>
        <ul>
			<?php
			
			$f=0;
			$imagecount = 0;
			$tempeventid = Array();
			$homeslider1;
			$k=0;
			
			while($fearow = mysql_fetch_array($HomeSlider)){
			$finalDescription="";
			##Image Fetched for slide show##
				
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
			$homeslider1[$k]['eve_id'] = $fearow['ev_id'];
			$homeslider1[$k]['summary'] = $fearow['summary'];
			$homeslider1[$k]['Date'] = $fearow['Date'];
			$homeslider1[$k]['title'] = $fearow['title'];
			$homeslider1[$k]['time'] = $displayTime;
			$homeslider1[$k]['timestart'] = $fearow['timestart'];
   			$homeslider1[$k]['timeend'] = $fearow['timeend'];

			if(!in_array($fearow['ev_id'], $tempeventid)){
			//}else{
			if($imagecount<3){
			
			?> 
				<!--This code is for slider part-->
		<li id="item<?php echo $imagecount;?>" class="<?php echo $imagecount;?>">
					<div class="event">
					<a href="index.php?option=com_jevents&task=icalrepeat.detail&evid=<?php echo $fearow['rp_id'];?>&Itemid=97&year=<?php echo $fearow['Eyear'];?>&month=<?php echo $fearow['Emonth'];?>&day=<?php echo $fearow['EDate'];?>"><img src="<?php echo $singleimagearray[0];?>" /></a>
					<div class="infoCont">
					<strong class="bold">
					  	<?php 
						if(strlen($fearow['summary'])>="90"){
							$strProcess1 = substr($fearow['summary'], 0 , 90);
							$strInput1 = explode(' ',$strProcess1);
							$str1 = array_slice($strInput1, 0, -1);
							echo implode(' ',$str1).' ...'; 
						}else{
							echo $fearow['summary'];
						}
						?>
					  </strong>
					<p>
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
							}
						?>					  
					  </p>
					<div class="cl"></div>
				</div>
				</div>
			</li>
			<?php
			++$imagecount;/*3 featured event counter */
			$tempeventid[] = $fearow['ev_id'];
			}}
			++$f;
			++$k;
			}
			?>
			</ul>
		<div class="pag"></div>
        <div class="cb"></div>
	</div>
	<div class="galleryNav rightCol fr">
        <!--<a class="full bold" href="/index.php?option=com_jevents&view=range&task=range.listevents&Itemid=97"><?php echo JText::_("TW_FULL_CALENDAR"); ?></a>-->
        <!--<a class="full bold" href="/index.php?option=com_jevents&view=week&task=week.listevents&Itemid=97"><?php echo JText::_("TW_FULL_CALENDAR"); ?></a>-->
          <strong class="display"><?php echo JText::_("TW_TOP_EVENT"); ?></strong>
          <ul>
		  <?php 
		  $i = 0;
		  $tempeventid2 = Array();
		  $d=0;
		  while($i<count($homeslider1)){
		  if(!in_array($homeslider1[$i]['eve_id'],$tempeventid2)){
		  if($d<3){
		  ?>
            <?php if($i==0){?>
				<li class="<?php echo $d ;?> active">
			<?php }else{?>
				<li class="<?php echo $d ;?>">
			<?php }?>
              <a class="caroufredsel" href="#item<?php echo $d ;?>">
                <strong class="bold">
				<?php 
				if(strlen($homeslider1[$i]['summary'])>="72"){
					$strProcess = substr($homeslider1[$i]['summary'], 0 , 72);
					$strInput = explode(' ',$strProcess);
					$str = array_slice($strInput, 0, -1);
					echo implode(' ',$str).'...'; 
				}else{
					echo $homeslider1[$i]['summary'];
				}
				?>
				</strong>	
                <?php echo $homeslider1[$i]['title'];?> &bull; 
				<?php echo $homeslider1[$i]['Date'];?> &bull; 
				<?php
					/*condition for hour format*/ 
				    if($var->timeformat == "12"){
				     echo $homeslider1[$i]['time'];
				    }else{
				     echo date("H:i", strtotime($homeslider1[$i]['timestart']))." - ".date("H:i", strtotime($homeslider1[$i]['timeend']));
				    }
				?>
              </a>
            </li>
			<?php 
			$tempeventid2[] = $homeslider1[$i]['eve_id'];
			++$d;
			} }
			$i++;
			}
			?>
			
          </ul>
          <!--a class="saved bold" href="#"><span class="bold">3</span> saved events</a-->
        </div>
	

	
      <script type="text/javascript">
        
        $(document).ready(function() {

          $("#EvtRot .gallery ul").carouFredSel({
              responsive          : true,
              auto                : true, 
              items : {
                  visible     : 1,
                  width       : 420, 
                  height      : 268
              }, 
              circular            : true, 
              infinite            : true,
              direction           : "left", 
              scroll : {
                  fx              : "crossfade", 
                  items           : 1,
                  duration        : 1000, 
                  pauseOnHover    : true, 
                  easing          : "linear", 
                  onAfter : function( data ) {
                    $('#EvtRot .galleryNav ul li').each(function () {
                      if ($(this).hasClass(data.items.visible.attr('class'))) {
                        $(this).addClass('active');
                      }
                      else {
                        $(this).removeClass('active');
                      }
                    });
                  }
              }, 
              prev : "#EvtRot .prev",
              next : "#EvtRot .next",
			  pagination : {
                  container       : "#EvtRot .pag"
              }, 
              swipe : {
                  onTouch         : true, 
                  onMouse         : true
              }
          });

        });
        //$("#EvtRot .gallery ul").trigger("linkAnchors", [".galleryNav"]);

      </script>
<!-- Featured Events Slider End-->
<?php } ?>
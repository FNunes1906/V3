<?php
if (mysql_num_rows($FeaturedSlider) != 0){

defined('_JEXEC') or die('Restricted access');
global $var;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
?>
<!-- Featured Events Slider -->	

<div id="Events" class="rotator carousel fl">
    <div class="gallery centerCol fl">
            <a class="prev nav" style="background:<?php echo $var->Header_color; ?>"><img alt="prev" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowLt.png" /></a>
            <a class="next nav" style="background:<?php echo $var->Header_color; ?>"><img alt="next" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/marquee/marqueeArrowRt.png" /></a>
        <ul>
			<?php
			
			$f=0;
			$imagecount = 0;
			$tempeventid;

			while($fearow = mysql_fetch_array($FeaturedSlider)){

			##Image FEtched for slide show##
			    $imagesrc= strstr($fearow['description'],'src=');
				$imageurl= strstr($imagesrc,'http');
				$singleimagearray = explode('"',$imageurl);
				if($singleimagearray[0] == ""){
				$singleimagearray[0] = "/partner/".$_SESSION['partner_folder_name']."/images/stories/nofe_image.png"; }
			##end##
			$displayTime = '';

			if($fearow[timestart]=='12:00 AM' && $fearow[timeend]=='11:59PM')
            {    $displayTime.='All Day Event';
			}
			else{
			$displayTime.= $fearow[timestart];
			if ($fearow[timeend] != '11:59PM'){
				$displayTime.="-".$fearow[timeend];
			}
			}
		
			if(in_array($fearow['ev_id'], $tempeventid)){
			}else{
			if($imagecount<5){
			
			?> 
				<!--This code is for slider part-->
		    	<li id="item<?php echo $imagecount;?>" class="<?php echo $imagecount;?>">
					<div class="event">
					<a href="index.php?option=com_jevents&task=icalrepeat.detail&evid=<?php echo $fearow['rp_id'];?>&Itemid=<?php echo $_REQUEST[Itemid];?>&year=<?php echo $fearow['Eyear'];?>&month=<?php echo $fearow['Emonth'];?>&day=<?php echo $fearow['EDate'];?>"><img src="<?php echo $singleimagearray[0];?>" /></a>
		    		<div class="infoCont">
		    			<strong class="bold">
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
						</strong>
		    			<p><?php echo $fearow['title'];?> &bull; 
						<?php echo $fearow['Date'];?> &bull; 
						<?php
					        if($var->timeformat == "12"){
					        echo $displayTime;
					       }else{
					        echo date("H:i", strtotime($fearow['timestart']))." - ".date("H:i", strtotime($fearow['timeend']));
					       }
      					?>
						</p>
						<div class="cl"></div>
		    		</div>
					</div>
		    	</li>
			<?php
			++$imagecount;/*5 featured event counter */
			$tempeventid[] = $fearow['ev_id'];
			}}
			//++$datacount;
			++$f;
			}
			?>
			</ul>
		<div class="pag"></div>
        <div class="cb"></div>
	</div>
</div> 
        <script type="text/javascript">
          
          $(document).ready(function() {

            $("#Events .gallery ul").carouFredSel({
                responsive          : true,
                auto                : true, 
                items : {
                    visible     : 1,
                    width       : 420
                }, 
                circular            : true, 
                infinite            : true,
                direction           : "left", 
                scroll : {
                    fx              : "crossfade", 
                    items           : 1,
                    duration        : 1000, 
                    pauseOnHover    : true, 
                    easing          : "linear"
                }, 
                prev : "#Events .prev",
                next : "#Events .next", 
                pagination : {
                    container       : "#Events .pag"
                }, 
                swipe : {
                    onTouch         : true, 
                    onMouse         : true
                }
            });

          });

        </script>

<!-- Featured Events Slider End-->
<?php } ?>

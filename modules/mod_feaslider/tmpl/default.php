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
            <a class="prev nav" style="background:<?php echo $var->Header_color; ?>"><img alt="prev" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/marquee/marqueeArrowLt.png" /></a>
            <a class="next nav" style="background:<?php echo $var->Header_color; ?>"><img alt="next" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/marquee/marqueeArrowRt.png" /></a>
        <ul>
			<?php
			
			$f=0;
			$imagecount = 0;
			$tempeventid;

			while($fearow = mysql_fetch_array($FeaturedSlider)){

			##Image FEtched for slide show##
				$imageurl= strstr($fearow['description'],'http');
				$singleimagearray = explode('"',$imageurl);
				if($singleimagearray[0] == ""){
				$singleimagearray[0] = "/components/com_shines_v2.1/images/nofe_image.png"; }
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
		    	<li id="item<?=$imagecount?>" class="<?=$imagecount?>">
					<div class="event">
					<a href="/events/icalrepeat.detail/<?=$fearow['Eyear']?>/<?=$fearow['Emonth']?>/<?=$fearow['EDate']?>/<?=$fearow['rp_id']?>"><img style="height:268px; width: 100%;" src="<?=$singleimagearray[0]?>" /></a>
					<!-- <a href="/index.php?option=com_jevents&task=icalrepeat.detail&evid=<?=$fearow['rp_id']?>&Itemid=97&year=<?=$fearow['Eyear']?>&month=<?=$fearow['Emonth']?>&day=<?=$fearow['EDate']?>"><img style="height: 268px;width: 420px;" src="<?=$singleimagearray[0]?>" /></a> -->
		    		<div class="infoCont">
		    			<h2 class="bold"><?=$fearow['summary']?></h2>
		    			<p><?=$fearow['title']?> &bull; <?=$fearow['Date']?> &bull; <?=$displayTime?> </p>
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

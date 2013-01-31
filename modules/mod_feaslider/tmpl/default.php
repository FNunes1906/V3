<?php
defined('_JEXEC') or die('Restricted access');

//include_once (JPATH_BASE.DS.'model'.DS.'event_class.php');
//echo $_SERVER['HTTP_HOST']."/model/event.class.php";
//include("model/event_class.php");
/* Creating object for Event class */
//$eventObj = new modFeaEventHelper();
/* Fetch Featured event for slider */
//$FeaturedSlider = $eventObj->getFeaturedSlider();

	//$query_featuredeve="SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%d/%m') as Date,DATE_FORMAT(rpt.startrepeat,'%h:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%h:%i%p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid = cat.id AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND cf.value = 1 AND rpt.endrepeat >= '2013-02-28 00:00:00' GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";
	//echo $query_featuredeve;
	//$FeaturedSlider = mysql_query($query_featuredeve);
	//return $FeaturedSlider;
?>
<!-- Featured Events Slider -->	

<div id="Events" class="rotator carousel fl">
    <div class="gallery centerCol fl">
            <a class="prev nav"><img alt="prev" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/marquee/marqueeArrowLt.png" /></a>
            <a class="next nav"><img alt="next" src="common/<?php echo $_SESSION['style_folder_name'];?>/images/marquee/marqueeArrowRt.png" /></a>
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
					<a href="event-info.html"><img style="height: 268px;width: 420px;" src="<?=$singleimagearray[0]?>" /></a>
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
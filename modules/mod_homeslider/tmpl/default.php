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
			$tempeventid;
			$homeslider1;
			$k=0;
			while($fearow = mysql_fetch_array($HomeSlider)){

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
			
			$homeslider1[$k]['summary'] = $fearow['summary'];
			$homeslider1[$k]['Date'] = $fearow['Date'];
			$homeslider1[$k]['title'] = $fearow['title'];
			$homeslider1[$k]['time'] = $displayTime;

			if(in_array($fearow['ev_id'], $tempeventid)){
			}else{
			if($imagecount<3){
			
			?> 
				<!--This code is for slider part-->
		    	<li id="item<?php echo $imagecount;?>" class="<?php echo $imagecount;?>">
					<div class="event">
					<a href="index.php?option=com_jevents&task=icalrepeat.detail&evid=<?php echo $fearow['rp_id'];?>&Itemid=<?php echo $_REQUEST[Itemid];?>&year=<?php echo $fearow['Eyear'];?>&month=<?php echo $fearow['Emonth'];?>&day=<?php echo $fearow['EDate'];?>"><div class="imgalign"><img src="<?php echo $singleimagearray[0];?>" /></div></a>
					</div>
		    	</li>
			<?php
			++$imagecount;/*3 featured event counter */
			$tempeventid[] = $fearow['ev_id'];
			}}
			//++$datacount;
			++$f;
			++$k;
			}
			?>
			</ul>
        <div class="cb"></div>
	</div>
	<div class="galleryNav rightCol fr">
        <!--<a class="full bold" href="#">Full Calendar</a>-->
          <h1 class="display"><!--span class="bold">This Week's</span-->Top Events</h1>
          <ul>
		  <?php 
		  $i = 0;
		  for($i=0;$i<3;$i++){
		  ?>
            <li class="<?php echo $i ;?> active">
              <a class="caroufredsel" href="#item2">
                <span class="bold"><?php echo $homeslider1[$i]['summary'];?></span>
                <?php echo $homeslider1[$i]['title'];?> &bull; <?php echo $homeslider1[$i]['Date'];?> &bull; <?php echo $homeslider1[$i]['time'];?>
              </a>
            </li>
			<?php } ?>
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
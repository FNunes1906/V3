<?php
//echo $catid;
//if (mysql_num_rows($LocationSlider) != 0){

defined('_JEXEC') or die('Restricted access');
global $var;
//include_once($_SERVER['DOCUMENT_ROOT'].'/inc/var.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/inc/base.php');
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
			if($imagecount<5){
			
			?> 
				<!--This code is for slider part-->
		    	<li id="item<?php echo $imagecount;?>" class="<?php echo $imagecount;?>">
					<div class="event">
					<a href="/index.php?option=com_jevlocations&task=locations.detail&loc_id=<?php echo $fearow->loc_id;?>&se=1&title=<?php echo $fearow->alias;?>&Itemid=<?php echo $_REQUEST[Itemid];?>"><img style="height:150px;" src="<?php echo $singleimagearray;?>" /></a>
		    		<div class="infoCont">
		    			<h2 class="bold">
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
						</h2>
		    			<p><?php echo substr($fearow->description, 0, 75);?></p>
						<div class="cl"></div>
		    		</div>
					</div>
		    	</li>
			<?php
			++$imagecount;/*5 featured event counter */
			$tempeventid[] = $fearow->loc_id;
			}
			}
			++$f;
			endforeach;
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
<?php// } ?>

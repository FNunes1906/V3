<?php

//if ($LocationCates != ""){

defined('_JEXEC') or die('Restricted access');
global $var;


?>
<!-- Featured Events Slider -->	

<div id="Cuisine" class="sect grid" style="width: 420px;">
    <div class="cont">
		<h3 class="fl"><a href="#" class="heading display"><?php echo $_SESSION['partner_folder_name']?> Cuisine</a></h3>
        <ul>
			<?php
			foreach($LocationCate as $fearow) :
			//while($fearow = mysql_fetch_array($LocationCate)){
			?> 
		    	<li>
					<a href=<?php echo "/restaurants/".$fearow->alias;?>><?php echo $fearow->category;?></a>(<?php echo $fearow->count;?>)
		    	</li>
			<?php
			//}
			endforeach;
			?>
			</ul>
	</div>
</div> 

<!-- Featured Events Slider End-->
<?php //} ?>

<?php
/**
* Purpose: Joomla menu code for header
* last Updated Date : 27-12-2012
* Global Variable: $_SESSION['topmenu'] (Joomla menu code)
**/
global $footermenu;
global $bottommenu1;
global $bottommenu2;

function m_footer_intro() {
  global $var;
  $header = "About ".$var->site_name;
  $intro = db_fetch("select introtext from `jos_content` where `title` = 'Footer Page Introduction'");
  echo "<h3>".$header."</h3>";
  echo $intro;
  
 }

?>
<ul id="bottom_mod">
	 <li class="about">
          <div class="pad">
		  	<?php m_footer_intro(); ?>
            
          </div>
        </li>
        <li class="site">
          <div class="pad">
            <h3 class="display"><?php echo $var->site_name." is a TownWizard Site" ?></h3>
            <span>Other TownWizard sites near this area include:</span>
            <?=$bottommenu1;?> 
            <a class="all" href="http://www.townwizard.com/locations/" target="_blank">See All Partner Sites &gt;</a>
          </div>
        </li>
        <li class="community">
          <div class="pad">
            <h3 class="display">TownWizard Brings Communities Alive</h3>
            <?=$bottommenu2;?> 
          </div>
        </li>
</ul>
 
<div class="footer_tag">
	<div class="legal bold">
	       <?=$footermenu;?> 
	</div>
  	<div class="twlogo bold">| &copy;&nbsp;<?PHP $time = time () ; $year= date("Y",$time); echo $year . "&nbsp;" . $var->site_name; ?> TownWizard</div>
</div>
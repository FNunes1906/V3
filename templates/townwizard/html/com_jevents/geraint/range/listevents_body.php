<?php 
defined('_JEXEC') or die('Restricted access');
 
 /* Fetching sitename from Page Global */
 $db1 =& JFactory::getDBO();
 $pageglobal = "select site_name from `jos_pageglobal`";
 $db1->setQuery($pageglobal);
 $df=$db1->query();
 $d=mysql_fetch_row($df);


$cfg  = & JEVConfig::getInstance();
$data2 = $this->data;
if(JRequest::getVar('Itemid') == 98){
 echo "<h2 class='fl heading display'>".JText::_('JEV_VIEWBYWEEK')." ".JText::_('EVENTS_IN')." ".$d[0]."</h2><br/>";
}else{
 echo "<h2 class='fl heading display'>".JText::_('TW_THISMONTH')." ".JText::_('EVENTS_IN')." ".$d[0]."</h2><br/>";
}

?>


<table align="center" width="90%" cellspacing="0" cellpadding="5" class="ev_table">

    <?php
  
   $num_events = count($data2);
   $chdate ="";
   if( $num_events > 0 ){
   echo "<tr>\n";
 		echo '<td width="100%">' . "\n";
		echo "<ul class='ev_ul'>\n";
		
		$counter =  $_SESSION['totaldays'];
		$_SESSION['totaldays'] = "";
		
		for( $d = 0; $d < $counter; $d++ ){

			$day_link = '<div class="date fl">'. JEventsHTML::getDateFormat( $data2['days'][$d]['week_year'], $data2['days'][$d]['week_month'], $data2['days'][$d]['week_day'], 5 ).'</div>'."\n";

			if( $data2['days'][$d]['today'])	$bg = 'class="ev_td_today"';
			else $bg = 'class="ev_td_left"';

			$num_events	= count($data2['days'][$d]['rows']);
			if ($num_events>0) {
				
				echo "<div class='ev_td_right'>";
				for( $r = 0; $r < $num_events; $r++ ){
					$row = $data2['days'][$d]['rows'][$r];
					echo "<li class='ev_td_li' $listyle><div class='date fl'>$day_link </div><div class='details'>\n";
					if (!$this->loadedFromTemplate('icalevent.list_row', $row, 5)){
						$this->viewEventRowNew($row);
						echo "&nbsp;::&nbsp;";
						$this->viewEventCatRowNew($row);
					}
					echo "</div></li>\n";
				}
				echo "</div>";
			}
		} 
		
    	echo "</ul></td></tr>\n";
    } else {
    	echo '<tr>';
    	echo '<td align="left" valign="top" class="ev_td_right">' . "\n";

   		echo JText::_('JEV_NO_EVENTS') .'</td>';
    }
		echo "</tr>\n";
?>
   </table><br />
  <br /><br />

<?php
    // Create the pagination object
    if ($data2["total"]>$data2["limit"]){
    	$this->paginationForm($data2["total"], $data2["limitstart"], $data2["limit"]);
    }
  ?>


<?php 
//echo "<pre>";
//print_r($_POST);
defined('_JEXEC') or die('Restricted access');

$cfg	 = & JEVConfig::getInstance();

$data = $this->datamodel->getWeekData($this->year, $this->month, $this->day);

$option = JEV_COM_COMPONENT;
$Itemid = JEVHelper::getItemid();

?>
<div class="bc fr" ><span class="bold"><?php echo JText::_("TW_EVENT_TYPE") ?>:</span><?php $this->viewNavCatText( $this->catids, JEV_COM_COMPONENT, 'cat.listevents', $this->Itemid );?></div>
<?php 
if ( JRequest::getVar('task') === 'week.listevents' AND JRequest::getVar('view') === 'week' ){
	echo "<h3 class='fl heading display'>". JText::_('TW_THIS_WEEK'). "</h3>";
}
else
{
	echo "<h3 class='fl heading display'>". JText::_('TW_LIST_OF_EVENTS'). "</h3>";
}
?>
<!-- Code Start by Rinkal -->
<?php if($_REQUEST['searchdate']!='')
{
	$ser_date=date("Y-m-d",strtotime($_REQUEST['searchdate']));
	/* Fetching Date Format from Page Global */
	$db1 =& JFactory::getDBO();
  	$pageglobal = "select date_format from `jos_pageglobal`";
  	$db1->setQuery($pageglobal);
  	$df=$db1->query();
 	while($d = mysql_fetch_array($df)){
 		$a=$d['date_format'];
	}
	/* Fetching events from events table */
	$db =& JFactory::getDBO();
 	$query_datelist1="SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%Y') as Eyear,DATE_FORMAT(rpt.startrepeat,'%m') as Emonth,DATE_FORMAT(rpt.startrepeat,'%d') as EDate,DATE_FORMAT(rpt.startrepeat,'%m/%d') as Date,DATE_FORMAT(rpt.startrepeat,'%l:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%l:%i%p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid = cat.id AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND rpt.endrepeat >= '".$ser_date." 00:00:00' AND rpt.startrepeat <='".$ser_date." 23:59:59' GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";

 $db->setQuery($query_datelist1);
 $rows=$db->query();
if (mysql_num_rows($rows)!= 0){
		echo "<ul class='ev_ul'>\n";
		echo "<div class='ev_td_right'>";
		
		while($row = mysql_fetch_array($rows)){
		
		if($a=="%m/%d"){
			echo "<li class='ev_td_li'><div class='date fl'>".$row[Emonth]."/".$row[EDate]."</div>";
		}
		else{
			echo "<li class='ev_td_li'><div class='date fl'>".$row[EDate]."/".$row[Emonth]."</div>";
		}
		echo "<div class='details'>\n<a class='ev_link_row' style='font-weight:bold;' href='/index.php?option=com_jevents&task=icalrepeat.detail&evid=".$row[rp_id]."&Itemid=".$_REQUEST[Itemid]."&year=".$row[Eyear]."&month=".$row[Emonth]."&day=".$row[EDate]."'>".$row['summary']."</a>";
		
		if($row['timestart']=='12:00 AM' && $row['timeend']=='11:59PM'){
			$displayTime='All Day Event';
			echo '<br/>'.$row['category'].' • '.$displayTime.' • '.$row['title'];
		}
		else{
			echo "<br/>".$row['category'].' • '.$row['timestart'].'-'.$row['timeend'].' • '.$row['title'];
		}
		
		echo "</div></li>";
		}
		echo "</div>";
		echo "</ul>";
	 }
} 
/* Code End by Rinkal */
else{
	 if (count($data['catids'])==1 && $data['catids'][0]!=0 && strlen($data['catdesc'])>0){
	echo "<div class='jev_catdesc'>".$data['catdesc']."</div>";
	}
echo "<ul class='ev_ul'>\n";

for( $d = 0; $d < 7; $d++ ){

	$day_link = '<div class="date fl">'

	. JEventsHTML::getDateFormat( $data['days'][$d]['week_year'], $data['days'][$d]['week_month'], $data['days'][$d]['week_day'], 5 ).'</div>'."\n";

	if( $data['days'][$d]['today'])	$bg = 'class="ev_td_today"';
	else $bg = 'class="ev_td_left"';

//	echo '<tr><td ' . $bg . '>' . $day_link . '</td>' . "\n";
//	echo '<td class="ev_td_right">' . "\n";

	$num_events	= count($data['days'][$d]['rows']);
	if ($num_events>0) {
		
echo "<div class='ev_td_right'>";
		for( $r = 0; $r < $num_events; $r++ ){
			$row = $data['days'][$d]['rows'][$r];
			
			/*$listyle = 'style="border-color:'.$row->bgcolor().';"';*/
			echo "<li class='ev_td_li' $listyle><div class='date fl'>$day_link </div><div class='details'>\n";
			if (!$this->loadedFromTemplate('icalevent.list_row', $row, 5)){
				$this->viewEventRowNew ( $row);
				echo "&nbsp;::&nbsp;";
				$this->viewEventCatRowNew($row);
			}
			echo "</div></li>\n";
		}
		//echo "</ul>\n";
		echo "</div>";
	}
	//echo '</td></tr>' . "\n";
} // end for days

echo "</ul>\n";//echo '</table><br />' . "\n";
}//echo '<br /><br />' . "\n";
